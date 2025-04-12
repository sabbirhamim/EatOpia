<?php
session_start();
include __DIR__ . '/../db/db_connect.php';

// Sanitize inputs
$food_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$spice = $_GET['spice'] ?? 'medium';
$portion = $_GET['food_portion'] ?? 'regular';
$toppings = $_GET['toppings'] ?? '';

if (!$food_id) {
    echo "<p>Invalid request. <a href='order_history.php'>Back to orders</a></p>";
    exit();
}

// Fetch food item from DB
$query = "SELECT * FROM food_items WHERE id = '$food_id'";
$result = mysqli_query($conn, $query);

if ($food = mysqli_fetch_assoc($result)) {
    // Add custom options to cart item
    $food['spice'] = $spice;
    $food['food_portion'] = $food_portion;
    $food['toppings'] = $toppings;

    // Add to session cart
    $_SESSION['cart'][] = $food;

    // Redirect to cart
    header("Location: cart.php");
    exit();
} else {
    echo "<p>Invalid food ID. <a href='order_history.php'>Back to orders</a></p>";
}
?>
