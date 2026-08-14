<?php

require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username and password are required.';
    } else {

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("
                INSERT INTO users (username, password)
                VALUES (?, ?)
            ");

            $stmt->execute([$username, $passwordHash]);

            header('Location: ../frontend/index.html?registered=1');
            exit;

        } catch (PDOException $e) {

            if ($e->getCode() === '23000') {
                $error = 'The username is already taken.';
            } else {
                $error = 'An error occurred while creating the user.';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register new user</title>

    <link rel="stylesheet" href="../frontend/style.css">
</head>

<body>

    <div class="login-container">

        <h1>Register new user</h1>

        <?php if ($error !== ''): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="reg_new_user.php" method="post" class="login-form">

            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                    required
                >
            </div>

            <button type="submit" class="login-button">
                Register
            </button>

        </form>

    </div>

</body>
</html>