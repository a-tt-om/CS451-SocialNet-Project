<?php
/**
 * Authentication Helper
 * Manages session state and provides login/logout/check functions.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if the user is currently logged in.
 */
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get the currently logged-in user's ID.
 */
function getCurrentUserId(): ?int {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get the currently logged-in user's username.
 */
function getCurrentUsername(): ?string {
    return $_SESSION['username'] ?? null;
}

/**
 * Require the user to be logged in. Redirects to signin page if not.
 */
function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: /socialnet/signin.php');
        exit;
    }
}

/**
 * Log in a user by setting session variables.
 */
function loginUser(int $id, string $username, string $fullname): void {
    $_SESSION['user_id']  = $id;
    $_SESSION['username'] = $username;
    $_SESSION['fullname'] = $fullname;
}

/**
 * Log out the current user.
 */
function logoutUser(): void {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
