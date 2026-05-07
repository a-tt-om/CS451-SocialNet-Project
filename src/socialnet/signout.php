<?php
/**
 * Sign Out Page
 * URL: /socialnet/signout.php
 * Destroys the session and redirects to the Sign In page.
 */
require_once __DIR__ . '/../includes/auth.php';

logoutUser();
header('Location: /socialnet/signin.php');
exit;
