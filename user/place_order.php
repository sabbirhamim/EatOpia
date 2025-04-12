<?php
session_start();
include '../db/db_connect.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: ../auth/login.html");
    exit();
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['message'] = "Your cart is empty. Please add items to your cart before proceeding.";
    header("Location: ../user/cart.php");
    exit();
}

$cart = $_SESSION['cart'];
foreach ($cart as $item) {
    $food_id = $item['id'];
    $toppings = mysqli_real_escape_string($conn, $item['toppings']);
    $spice = mysqli_real_escape_string($conn, $item['spice']);
    $food_portion = mysqli_real_escape_string($conn, $item['food_portion']);
    
    // Insert the order into the `orders` table
    $query = "INSERT INTO orders (user_id, food_id, toppings, spice, food_portion) 
              VALUES ('$user_id', '$food_id', '$toppings', '$spice', '$food_portion')";
    if (!mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Error: Unable to place order. " . mysqli_error($conn);
        header("Location: ../index.php");
        exit();
    }
}

// Clear the cart after the order is placed
$_SESSION['cart'] = [];

$_SESSION['message'] = "✅ Your order has been placed successfully!";
header("Location: ../user/order_history.php");
exit();
