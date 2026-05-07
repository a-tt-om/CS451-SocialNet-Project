<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
if (isLoggedIn()) {
    header('Location: /socialnet/index.php');
    exit;
}
$pdo = getDB();
$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$error = '';
$lockoutTimeRemaining = 0;
$stmt = $pdo->prepare("SELECT attempts, UNIX_TIMESTAMP(last_attempt) as last_ts FROM login_attempts WHERE ip_address = ?");
$stmt->execute([$ip]);
$attemptRecord = $stmt->fetch();
if ($attemptRecord && $attemptRecord['attempts'] >= 5) {
    $timePassed = time() - $attemptRecord['last_ts'];
    if ($timePassed < 60) {
        $lockoutTimeRemaining = 60 - $timePassed;
        $error = 'Too many failed login attempts. Please try again after <strong id="countdown">' . $lockoutTimeRemaining . '</strong> seconds.';
    } else {
        $pdo->prepare("UPDATE login_attempts SET attempts = 0 WHERE ip_address = ?")->execute([$ip]);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $lockoutTimeRemaining === 0) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $stmt = $pdo->prepare("SELECT id, username, fullname, password, is_admin FROM account WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $pdo->prepare("DELETE FROM login_attempts WHERE ip_address = ?")->execute([$ip]);
            loginUser($user['id'], $user['username'], $user['fullname'], (bool) $user['is_admin']);
            header('Location: /socialnet/index.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
            $time = time();
            $pdo->prepare("INSERT INTO login_attempts (ip_address, attempts, last_attempt) VALUES (?, 1, FROM_UNIXTIME(?)) ON DUPLICATE KEY UPDATE attempts = attempts + 1, last_attempt = FROM_UNIXTIME(?)")->execute([$ip, $time, $time]);
            $stmt = $pdo->prepare("SELECT attempts FROM login_attempts WHERE ip_address = ?");
            $stmt->execute([$ip]);
            if ($stmt->fetchColumn() >= 5) {
                $lockoutTimeRemaining = 60;
                $error = 'Too many failed login attempts. Please try again after <strong id="countdown">60</strong> seconds.';
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
    <title>Sign In | SocialNet</title>
    <link rel="stylesheet" href="/assets/style.css?v=2">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                </div>
                <h1>Welcome Back</h1>
                <p>Sign in to your SocialNet account</p>
            </div>
            <?php if ($error): ?>
                <div class="alert alert-error"><span><?= $error ?></span></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control"
                        placeholder="Enter your username" required value="<?= htmlspecialchars($username ?? '') ?>"
                        <?= $lockoutTimeRemaining > 0 ? 'disabled' : '' ?>>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter your password" required <?= $lockoutTimeRemaining > 0 ? 'disabled' : '' ?>>
                </div>
                <button type="submit" class="btn btn-primary btn-block" <?= $lockoutTimeRemaining > 0 ? 'disabled' : '' ?>>Sign In</button>
            </form>
        </div>
    </div>
    <?php if ($lockoutTimeRemaining > 0): ?>
        <script>
            let timeLeft = <?= $lockoutTimeRemaining ?>;
            const countdownEl = document.getElementById('countdown');
            const timer = setInterval(() => {
                timeLeft--;
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    window.location.reload();
                } else if (countdownEl) {
                    countdownEl.textContent = timeLeft;
                }
            }, 1000);
        </script>
    <?php endif; ?>
</body>
</html>