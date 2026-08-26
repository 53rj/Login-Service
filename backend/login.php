<?php

session_start();

$maxAttempts = 5;
$lockoutTime = 300; // 5 Minuten

$_SESSION['login_attempts'] ??= 0;
$_SESSION['lockout_until'] ??= 0;

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../frontend/index.html');
    exit;
}

if ($_SESSION['lockout_until'] > time()) {

    $remainingTime = $_SESSION['lockout_until'] - time();

    header(
        'Location: ../frontend/index.html?locked=1&time=' . $remainingTime
    );
    exit;
}

if ($_SESSION['lockout_until'] !== 0) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_until'] = 0;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {

    header(
        'Location: ../frontend/index.html?error=1&attempts='
        . ($maxAttempts - $_SESSION['login_attempts'])
    );
    exit;
}

$stmt = $pdo->prepare("
    SELECT id, username, password
    FROM users
    WHERE username = ?
");

$stmt->execute([$username]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_until'] = 0;

    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    header('Location: ../frontend/dashboard.php');
    exit;
}

$_SESSION['login_attempts']++;

$attemptsLeft = $maxAttempts - $_SESSION['login_attempts'];

if ($attemptsLeft <= 0) {

    $_SESSION['lockout_until'] = time() + $lockoutTime;

    header(
        'Location: ../frontend/index.html?locked=1&time=' . $lockoutTime
    );
    exit;
}

header(
    'Location: ../frontend/index.html?error=1&attempts=' . $attemptsLeft
);
exit;