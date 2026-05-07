<?php
/**
 * Home Page
 * URL: /socialnet/index.php
 * Shows current user info and list of all other users.
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

$pdo = getDB();
$currentUserId = getCurrentUserId();

// Get current user info
$stmt = $pdo->prepare("SELECT username, fullname FROM account WHERE id = ?");
$stmt->execute([$currentUserId]);
$currentUser = $stmt->fetch();

// Get all other users
$stmt = $pdo->prepare("SELECT id, username, fullname FROM account WHERE id != ? ORDER BY fullname ASC");
$stmt->execute([$currentUserId]);
$otherUsers = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | SocialNet</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/menubar.php'; ?>
<div class="main-content">
    <div class="user-info-card">
        <div class="user-info-avatar"><?= strtoupper(substr($currentUser['fullname'], 0, 1)) ?></div>
        <div class="user-info-details">
            <h2><?= htmlspecialchars($currentUser['fullname']) ?></h2>
            <span class="username-tag">@<?= htmlspecialchars($currentUser['username']) ?></span>
        </div>
    </div>

    <div class="card">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Other Users
        </div>
        <?php if (empty($otherUsers)): ?>
            <p class="text-muted">No other users in the system yet.</p>
        <?php else: ?>
            <ul class="user-list">
            <?php foreach ($otherUsers as $user): ?>
                <li class="user-list-item">
                    <div class="item-avatar"><?= strtoupper(substr($user['fullname'], 0, 1)) ?></div>
                    <div class="item-info">
                        <div class="item-fullname"><?= htmlspecialchars($user['fullname']) ?></div>
                        <div class="item-username">@<?= htmlspecialchars($user['username']) ?></div>
                    </div>
                    <a href="/socialnet/profile.php?owner=<?= urlencode($user['username']) ?>" class="item-action">View Profile</a>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
