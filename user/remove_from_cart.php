<?php
session_start();
include __DIR__ . '/../db/db_connect.php';

$item_id = $_GET['id'] ?? null;

if (!$item_id) {
    $_SESSION['message'] = "No item selected to remove!";
    header("Location: ../user/cart.php");
    exit();
}

// Remove the cart item from the session
foreach ($_SESSION['cart'] as $index => $item) {
    if ($item['id'] == $item_id) {
        unset($_SESSION['cart'][$index]);  // Remove from session
        break;
    }
}

// Optionally, remove the cart item from the database (if persistent cart items are stored)
$query = "DELETE FROM cart_items WHERE id = '$item_id' AND user_id = '{$_SESSION['user_id']}'";
mysqli_query($conn, $query);

$_SESSION['message'] = "Item removed from cart!";
header("Location: ../user/cart.php");
exit();
