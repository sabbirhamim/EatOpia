<?php
session_start();
include __DIR__ . '/../db/db_connect.php';

$user_id = $_SESSION['user_id'] ?? 1; // Use actual user ID from session
$query = "SELECT o.*, f.name, f.price, f.image_path 
          FROM orders o 
          JOIN food_items f ON o.food_id = f.id 
          WHERE o.user_id = '$user_id' 
          ORDER BY o.created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order History - EatOpia</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
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
      <a href="cart.php"><button class="cart-btn">Cart</button></a>
    </div>
  </nav>

  <!-- Orders Section -->
  <section class="customizable-meals">
    <h2>Your Order History</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="food-card">
                <h4><?php echo htmlspecialchars($row['name']); ?> (<?php echo ucfirst($row['food_portion']); ?>)</h4>
                <p>Spice: <?php echo ucfirst($row['spice']); ?> | Toppings: <?php echo htmlspecialchars($row['toppings']); ?></p>
                <p>Ordered at: <?php echo $row['created_at']; ?></p>
                <a href="reorder.php?id=<?php echo $row['food_id']; ?>&spice=<?php echo $row['spice']; ?>&portion=<?php echo $row['food_portion']; ?>&toppings=<?php echo urlencode($row['toppings']); ?>">
                    <button class="order-btn">Reorder</button>
                </a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>You haven't placed any orders yet.</p>
    <?php endif; ?>

  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; 2025 EatOpia. All rights reserved.</p>
  </footer>
</body>
</html>
