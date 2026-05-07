<?php
/**
 * Profile Page
 * URL: /socialnet/profile.php?owner=some_user
 * Shows the profile of a user. Defaults to the logged-in user if no owner specified.
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

$pdo = getDB();
$ownerUsername = $_GET['owner'] ?? getCurrentUsername();

$stmt = $pdo->prepare("SELECT username, fullname, description FROM account WHERE username = ?");
$stmt->execute([$ownerUsername]);
$profile = $stmt->fetch();

if (!$profile) {
    $profile = ['username' => 'unknown', 'fullname' => 'User Not Found', 'description' => ''];
    $notFound = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($profile['fullname']) ?> — Profile | SocialNet</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/menubar.php'; ?>
<div class="main-content">
    <div class="profile-header">
        <div class="profile-avatar"><?= strtoupper(substr($profile['fullname'], 0, 1)) ?></div>
        <h2><?= htmlspecialchars($profile['fullname']) ?></h2>
        <div class="profile-username">@<?= htmlspecialchars($profile['username']) ?></div>
    </div>
    <div class="profile-description">
        <h3>About</h3>
        <?php if (!empty($profile['description'])): ?>
            <div class="description-content"><?= nl2br(htmlspecialchars($profile['description'])) ?></div>
        <?php else: ?>
            <div class="no-description">This user hasn't written anything yet.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
