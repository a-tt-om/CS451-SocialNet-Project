<?php
/**
 * Database Connection Helper
 * Uses PDO with MySQL driver.
 * Connection parameters are read from environment variables set in docker-compose.yml
 */

function getDB(): PDO
{
    $host = getenv('DB_HOST') ?: 'mysql';
    $db = getenv('DB_NAME') ?: 'socialnet';
    $user = getenv('DB_USER') ?: 'socialnet_user';
    $pass = getenv('DB_PASS') ?: 'socialnet_pass';

    $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}
