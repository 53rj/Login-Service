<?php
require '../backend/auth.php';
session_start();
session_destroy();
header('Location: ../frontend/index.html');
exit(); 
?>