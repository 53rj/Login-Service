<?php

require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    if ($username === '' || $password === '' || $passwordConfirm === '') {

    $error = 'All fields are required.';

    } elseif ($password !== $passwordConfirm) {

        $error = 'The passwords do not match.';

    } elseif (strlen($password) < 8) {

        $error = 'The password must contain at least 8 characters.';

    } else {

        // Registrierung erfolgt
    }

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

                <div class="password-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        data-target="password"
                        aria-label="Passwort anzeigen"
                    >
                        Show
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirm">Repeat Password</label>

                <div class="password-wrapper">
                    <input
                        type="password"
                        id="password_confirm"
                        name="password_confirm"
                        placeholder="Repeat Password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        data-target="password_confirm"
                        aria-label="Passwort anzeigen"
                    >
                        Show
                    </button>
                </div>
            </div>

            <button type="submit" class="login-button">
                Register
            </button>

        </form>

    </div>

    <script>
        const passwordToggles = document.querySelectorAll(".password-toggle");

        passwordToggles.forEach(toggle => {
            toggle.addEventListener("click", () => {
                const targetId = toggle.dataset.target;
                const passwordInput = document.getElementById(targetId);

                const isHidden = passwordInput.type === "password";

                passwordInput.type = isHidden ? "text" : "password";

                toggle.textContent = isHidden ? "Hide" : "Show";

                toggle.setAttribute(
                    "aria-label",
                    isHidden ? "Passwort verbergen" : "Passwort anzeigen"
                );
            });
        });
    </script>

</body>
</html>