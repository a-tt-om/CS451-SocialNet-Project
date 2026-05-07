<?php
require_once __DIR__ . '/../includes/auth.php';
logoutUser();
header('Location: /socialnet/signin.php');
exit;
