<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
$message = '';
$messageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $message = 'Invalid CSRF token. Please try again.';
        $messageType = 'error';
    } else {
        $username = trim($_POST['username'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        if (empty($username) || empty($fullname) || empty($password)) {
            $message = 'All fields are required.';
            $messageType = 'error';
        } elseif ($password !== $confirm) {
            $message = 'Passwords do not match.';
            $messageType = 'error';
        } else {
            $pdo = getDB();
            $stmt = $pdo->prepare("SELECT id FROM account WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $message = 'Username already exists.';
                $messageType = 'error';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO account (username, fullname, password, description) VALUES (?, ?, ?, '')");
                $stmt->execute([$username, $fullname, $hash]);
                $message = "User \"{$username}\" created successfully!";
                $messageType = 'success';
                $username = $fullname = '';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Create User | SocialNet</title>
    <link rel="stylesheet" href="/assets/style.css?v=2">
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" y1="8" x2="20" y2="14" />
                        <line x1="23" y1="11" x2="17" y2="11" />
                    </svg>
                </div>
                <h1>Create New User</h1>
                <p>Admin panel — add a new user to SocialNet</p>
            </div>
            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter username"
                        required value="<?= htmlspecialchars($username ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter full name"
                        required value="<?= htmlspecialchars($fullname ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                        placeholder="Confirm password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Create User</button>
            </form>
            <div class="auth-footer"><a href="/socialnet/signin.php">← Go to Sign In</a></div>
        </div>
    </div>
</body>

</html>