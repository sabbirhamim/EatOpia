<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../auth/login.html");
    exit();
}
include '../db/db_connect.php';

$query = "SELECT o.*, f.name AS food_name, u.username, u.email 
          FROM orders o 
          JOIN food_items f ON o.food_id = f.id 
          JOIN users u ON o.user_id = u.id 
          ORDER BY o.created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>All Orders - Admin | EatOpia</title>
  <link rel='stylesheet' href='../assets/css/styles.css'>
</head>
<body>
<nav class='navbar'>
    <div class='logo'>
        <img src='../assets/images/logo.png' alt='EatOpia Logo'>
        <span>EatOpia Admin</span>
    </div>
    <div class='nav-buttons'>
        <a href='admin_dashboard.php'><button class='cart-btn'>Dashboard</button></a>
        <a href='../auth/logout.php'><button class='cart-btn'>Logout</button></a>
    </div>
</nav>

<section class='customizable-meals'>
    <h2>All Orders</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class='food-card'>
                <h4><?php echo htmlspecialchars($row['food_name']); ?> (<?php echo ucfirst($row['food_portion']); ?>)</h4>
                <p>User: <?php echo htmlspecialchars($row['username']); ?> | <?php echo $row['email']; ?></p>
                <p>Spice: <?php echo ucfirst($row['spice']); ?> | Toppings: <?php echo htmlspecialchars($row['toppings']); ?></p>
                <p>Ordered at: <?php echo $row['created_at']; ?></p>

                <?php if (!$row['delivered']): ?>
                    <a href='mark_delivered.php?id=<?php echo $row['id']; ?>'>
                        <button class='order-btn'>Mark as Delivered</button>
                    </a>
                <?php else: ?>
                    <p style='color: green;'>✔ Delivered</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</section>

<footer class='footer'>
  <p>&copy; 2025 EatOpia. All rights reserved.</p>
</footer>
</body>
</html>
