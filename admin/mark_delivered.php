<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../auth/login.html");
    exit();
}
include '../db/db_connect.php';

$id = intval($_GET['id']);
mysqli_query($conn, "UPDATE orders SET delivered = 1 WHERE id = $id");

header("Location: view_orders.php");
exit();
?>
