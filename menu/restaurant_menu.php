<?php
session_start();
include __DIR__ . '/../db/db_connect.php';

$restaurant_name = $_GET['name'] ?? '';
$query = "SELECT f.* FROM food_items f
          JOIN restaurants r ON f.restaurant_id = r.id
          WHERE r.name = '$restaurant_name'";
$result = mysqli_query($conn, $query);
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Menu - <?php echo htmlspecialchars($restaurant); ?></title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

<nav class="navbar">
  <div class="logo">
    <img src="../assets/images/logo.png" alt="EatOpia Logo">
    <span>EatOpia</span>
  </div>
  <div class="nav-buttons">
    <a href="../index.php"><button class="cart-btn">Home</button></a>
    <a href="../user/cart.php"><button class="cart-btn">Cart</button></a>
  </div>
</nav>

<section class="customizable-meals">
  <h2>Menu - <?php echo htmlspecialchars($restaurant); ?></h2>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="food-card">
        <?php if (!empty($row['image_path'])): ?>
          <img src="../<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>" style="width:100%; border-radius:10px;">
        <?php endif; ?>
        <h4><?php echo htmlspecialchars($row['name']); ?></h4>
        <p>Price: <?php echo $row['price']; ?> BDT</p>

        <form action="../user/add_to_cart.php" method="POST">
          <input type="hidden" name="food_id" value="<?php echo $row['id']; ?>">

          <label>Toppings:</label><br>
          <input type="text" name="toppings" placeholder="Optional toppings"><br>

          <label>Spice:</label><br>
          <select name="spice">
            <option value="mild">Mild</option>
            <option value="medium" selected>Medium</option>
            <option value="hot">Hot</option>
          </select><br>

          <label>Portion:</label><br>
          <select name="portion">
            <option value="small">Small</option>
            <option value="regular" selected>Regular</option>
            <option value="large">Large</option>
          </select><br>

          <button type="submit" class="order-btn">Add to Cart</button>
        </form>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No menu items found for this restaurant.</p>
  <?php endif; ?>
</section>

<footer class="footer">
  <p>&copy; 2025 EatOpia. All rights reserved.</p>
</footer>

</body>
</html>
