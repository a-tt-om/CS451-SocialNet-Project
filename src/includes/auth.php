<?php
ini_set('session.cookie_httponly', '0');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}
function getCurrentUserId(): ?int
{
    return $_SESSION['user_id'] ?? null;
}
function getCurrentUsername(): ?string
{
    return $_SESSION['username'] ?? null;
}
function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: /socialnet/signin.php');
        exit;
    }
}
function isUserAdmin(): bool
{
    return $_SESSION['is_admin'] ?? false;
}
function requireAdmin(): void
{
    requireLogin();
    if (!isUserAdmin()) {
        header('Location: /socialnet/index.php');
        exit;
    }
}
function loginUser(int $id, string $username, string $fullname, bool $isAdmin = false): void
{
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;
    $_SESSION['fullname'] = $fullname;
    $_SESSION['is_admin'] = $isAdmin;
}
function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function verifyCsrfToken(?string $token): bool
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}
function logoutUser(): void
{
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
}
