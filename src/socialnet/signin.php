<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
if (isLoggedIn()) {
    header('Location: /socialnet/index.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $host = getenv('DB_HOST') ?: 'mysql';
        $db = getenv('DB_NAME') ?: 'socialnet';
        $dbuser = getenv('DB_USER') ?: 'socialnet_user';
        $dbpass = getenv('DB_PASS') ?: 'socialnet_pass';
        mysqli_report(MYSQLI_REPORT_OFF);
        $conn = new mysqli($host, $dbuser, $dbpass, $db);
        $query = "SELECT id, username, fullname, password, is_admin FROM account WHERE username = '$username'";
        $result = $conn->query($query);
        if ($result && $user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                loginUser((int)$user['id'], $user['username'], $user['fullname'], (bool) $user['is_admin']);
                header('Location: /socialnet/index.php');
                exit;
            } else {
                $error = 'Invalid username or password.';
            }
        } else {
            if ($conn->error) {
                $error = 'SQL Error: ' . $conn->error;
            } else {
                $error = 'Invalid username or password.';
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
                        placeholder="Enter your username" required value="<?= htmlspecialchars($username ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>