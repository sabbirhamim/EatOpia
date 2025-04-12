<?php
session_start();
include __DIR__ . '/../db/db_connect.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: ../auth/login.html");
    exit();
}

// Fetch cart items from the session
$cart_items = $_SESSION['cart'] ?? [];

// If there are no cart items, display a message
if (empty($cart_items)) {
    $empty_cart = true; // Mark the cart as empty
} else {
    $empty_cart = false; // Cart is not empty
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Cart - EatOpia</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
  <style>
    /* Style for the empty cart message */
    .empty-cart-message {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: #888;
        margin-top: 50px;
    }
    .empty-cart-message a {
        color: #f44336; /* Red color for link */
        text-decoration: none;
        font-weight: bold;
    }
    .empty-cart-message a:hover {
        text-decoration: underline;
    }
  </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="../assets/images/logo.png" alt="EatOpia Logo">
            <span>EatOpia</span>
        </div>
        <div class="nav-buttons">
            <a href="../index.php"><button class="cart-btn">Home</button></a>
            <a href="place_order.php"><button class="cart-btn">Checkout</button></a>
        </div>
    </nav>

    <!-- Cart Section -->
    <section class="customizable-meals">
        <h2>Your Cart</h2>

        <!-- Flash Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div style="background: #d4edda; padding: 10px; border-radius: 6px; color: #155724; margin-bottom: 20px;">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <!-- If cart is empty, display message -->
        <?php if ($empty_cart): ?>
            <p class="empty-cart-message">Your cart is empty. <a href="../index.php">Go back</a></p>
        <?php else: ?>
            <?php $total = 0; ?>
            <?php foreach ($cart_items as $item): ?>
                <div class="food-card">
                    <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                    <p>Price: <?php echo $item['price']; ?> BDT</p>
                    <p>Spice: <?php echo ucfirst($item['spice']); ?> | Portion: <?php echo ucfirst($item['food_portion']); ?></p>
                    <p>Toppings: <?php echo htmlspecialchars($item['toppings']); ?></p>
                    <!-- Remove Button -->
                    <a href="remove_from_cart.php?id=<?php echo $item['id']; ?>">
                    <button class="order-btn remove-btn">Remove</button>
                    </a>
                </div>
                <?php $total += $item['price']; ?>
            <?php endforeach; ?>

            <h3>Total: <?php echo $total; ?> BDT</h3>
            <a href="place_order.php"><button class="order-btn">Place Order</button></a>
        <?php endif; ?>

    </section>
 

  <footer class="footer">
    <p>&copy; 2025 EatOpia. All rights reserved.</p>
  </footer>

</body>
</html>
