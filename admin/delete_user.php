<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../auth/login.html");
    exit();
}
include '../db/db_connect.php';

$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM users WHERE id = $id");

header("Location: manage_users.php");
exit();
?>
