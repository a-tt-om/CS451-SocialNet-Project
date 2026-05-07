<?php
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | SocialNet</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>

<body>
    <?php include __DIR__ . '/../includes/menubar.php'; ?>
    <div class="main-content">
        <div class="page-header">
            <h1>About</h1>
            <p>Information about the developer</p>
        </div>
        <div class="card about-card">
            <div class="about-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="16" x2="12" y2="12" />
                    <line x1="12" y1="8" x2="12.01" y2="8" />
                </svg>
            </div>
            <h2>Nguyen Ngoc Toan Thang</h2>
            <div class="student-id">Student ID: 1701830</div>
            <p class="about-desc">
                SocialNet — A simple social network application built with PHP, MySQL, Nginx, and Docker Compose for
                CS451 Web Application course.
            </p>
        </div>
    </div>
</body>

</html>