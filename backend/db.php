<?php

/*
 * Database configuration
 *
 * NOTE:
 * The database credentials are stored directly in this file
 * for simplicity in this learning project.
 *
 * In a production environment, credentials should be stored
 * securely outside the repository, e.g. using environment
 * variables or a separate configuration file.
 */

$host = 'localhost';
$dbname = 'login_service';
$dbUser = 'root';
$dbPassword = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $dbUser,
        $dbPassword
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    error_log($e->getMessage());
    die('Database connection failed.');
}

