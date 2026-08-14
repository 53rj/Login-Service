<?php
session_start();
require '../backend/auth.php';
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
$username = $_SESSION['username'] ?? '';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registered Area</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="card">
        <h2>Welcome to the registered area, <?php echo htmlspecialchars($username); ?>!</h2>
        <p>You're logged in.</p>
    </section>
    <form action="logout.php" method="post">
        <button type="submit" class="logout-button">
            Logout
        </button>
    </form>
</body>
</html>