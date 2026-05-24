<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
$pdo = getDB();
$userId = getCurrentUserId();
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'] ?? '';
    $host = getenv('DB_HOST') ?: 'mysql';
    $db = getenv('DB_NAME') ?: 'socialnet';
    $dbuser = getenv('DB_USER') ?: 'socialnet_user';
    $dbpass = getenv('DB_PASS') ?: 'socialnet_pass';
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = new mysqli($host, $dbuser, $dbpass, $db);
    $query = "UPDATE account SET description = '$description' WHERE id = $userId";
    $result = $conn->query($query);
    if ($result) {
        $message = 'Profile updated successfully!';
        $messageType = 'success';
    } else {
        $message = 'SQL Error: ' . $conn->error;
        $messageType = 'error';
    }
}
$stmt = $pdo->prepare("SELECT description FROM account WHERE id = ?");
$stmt->execute([$userId]);
$row = $stmt->fetch();
$description = $row['description'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | SocialNet</title>
    <link rel="stylesheet" href="/assets/style.css?v=2">
</head>

<body>
    <?php include __DIR__ . '/../includes/menubar.php'; ?>
    <div class="main-content">
        <div class="page-header">
            <h1>Settings</h1>
            <p>Edit your profile page content</p>
        </div>
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <div class="card">
            <div class="card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                Profile Description
            </div>
            <form method="POST">
                <div class="form-group">
                    <label for="description">Your Bio / Description</label>
                    <textarea id="description" name="description" class="form-control" rows="6"
                        placeholder="Tell the world about yourself..."><?= htmlspecialchars($description) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</body>

</html>