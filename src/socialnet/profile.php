<?php
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
    <link rel="stylesheet" href="/assets/style.css?v=2">
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
            <h3>Profile Page Content</h3>
            <?php
            function parseMarkdown($text)
            {
                $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
                $text = preg_replace('/\[([^\]]+)\]\((https?:\/\/[^\)]+)\)/', '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>', $text);
                $text = preg_replace('/(?<!href=")(?<!>)(https?:\/\/[^\s<]+)/', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $text);
                $text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);
                $text = preg_replace('/\_(.+?)\_/s', '<em>$1</em>', $text);
                return nl2br($text);
            }
            ?>
            <?php if (!empty($profile['description'])): ?>
                <div class="description-content"><?= parseMarkdown($profile['description']) ?></div>
            <?php else: ?>
                <div class="no-description">This user hasn't written anything yet.</div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>