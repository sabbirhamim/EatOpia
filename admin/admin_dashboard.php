<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../auth/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - EatOpia</title>
  <link rel="stylesheet" href="../assets/css/styles.css" />
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="logo">
        <img src="../assets/images/logo.png" alt="EatOpia Logo">
        <span>EatOpia Admin</span>
    </div>
    <div class="nav-buttons">
        <a href="../index.php"><button class="cart-btn">Back to Site</button></a>
        <a href="../auth/logout.php"><button class="cart-btn">Logout</button></a>
    </div>
</nav>

<!-- Admin Dashboard Content -->
<section class="customizable-meals">
    <h2>Welcome, Admin!</h2>

    <div style="display: flex; flex-direction: column; gap: 20px;">
    <a href="add_restaurant.php"><button class="order-btn">🏢 Add New Restaurant</button></a>
        <a href="add_food.php"><button class="order-btn">➕ Add New Food Item</button></a>
        <a href="view_orders.php"><button class="order-btn">📦 View All Orders</button></a>
        <a href="manage_users.php"><button class="order-btn">👤 Manage Users</button></a>
    </div>
</section>

<footer class="footer">
    <p>&copy; 2025 EatOpia. All rights reserved.</p>
</footer>
</body>
</html>
