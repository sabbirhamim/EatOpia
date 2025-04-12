<?php
session_start();
include __DIR__ . '/../db/db_connect.php';

// Input Validation
$food_id = $_POST['food_id'] ?? null;
$spice = $_POST['spice'] ?? 'medium';
$food_portion = $_POST['food_portion'] ?? 'regular';
$toppings = $_POST['toppings'] ?? '';

if (!$food_id) {
    $_SESSION['message'] = "Invalid food item!";
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null; // Get the logged-in user's ID
if (!$user_id) {
    $_SESSION['message'] = "You need to be logged in to add items to the cart!";
    header("Location: ../auth/login.html");
    exit();
}

// Fetch the food item from the DB
$query = "SELECT * FROM food_items WHERE id = '$food_id'";
$result = mysqli_query($conn, $query);

if ($food = mysqli_fetch_assoc($result)) {
    // Store the food item with selected toppings, spice, and portion in the session cart
    $_SESSION['cart'][] = [
        'id' => $food['id'],
        'name' => $food['name'],
        'price' => $food['price'],
        'toppings' => $toppings,
        'spice' => $spice,
        'food_portion' => $food_portion
    ];

    // Save cart to database if needed (optional for cart persistence)
    $query = "INSERT INTO cart_items (user_id, food_id, toppings, spice, food_portion)
              VALUES ('$user_id', '$food_id', '$toppings', '$spice', '$food_portion')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "✅ {$food['name']} added to cart!";
    } else {
        $_SESSION['message'] = "Error adding to cart!";
    }
    header("Location: ../user/cart.php");
    exit();
} else {
    $_SESSION['message'] = "Item not found!";
    header("Location: ../index.php");
    exit();
}
