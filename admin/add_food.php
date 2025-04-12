<?php
session_start();
if (!isset($_SESSION['admin'])) exit();
include '../db/db_connect.php';

// Fetch restaurants
$restaurants = mysqli_query($conn, "SELECT id, name FROM restaurants");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $restaurant_id = intval($_POST['restaurant_id']);
    $image_path = '';

    if ($_FILES['food_image']['error'] === 0) {
        $image_path = 'uploads/' . time() . '_' . basename($_FILES['food_image']['name']);
        move_uploaded_file($_FILES['food_image']['tmp_name'], '../' . $image_path);
    }

    $query = "INSERT INTO food_items (name, price, restaurant_id, image_path)
              VALUES ('$name', '$price', '$restaurant_id', '$image_path')";

    $message = mysqli_query($conn, $query) ? "Food item added!" : "Failed: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Food</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<nav class="navbar">
  <div class="logo"><img src="../assets/images/logo.png"><span>EatOpia Admin</span></div>
  <div class="nav-buttons">
    <a href="admin_dashboard.php"><button class="cart-btn">Dashboard</button></a>
    <a href="../auth/logout.php"><button class="cart-btn">Logout</button></a>
  </div>
</nav>

<section class="customizable-meals">
  <h2>Add Food Item</h2>
  <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Food Name" required><br>
    <input type="number" step="0.01" name="price" placeholder="Price (BDT)" required><br>
    
    <label>Select Restaurant:</label><br>
    <select name="restaurant_id" required>
      <option value="">-- Choose Restaurant --</option>
      <?php while ($r = mysqli_fetch_assoc($restaurants)): ?>
        <option value="<?php echo $r['id']; ?>"><?php echo $r['name']; ?></option>
      <?php endwhile; ?>
    </select><br>

    <label>Food Image:</label><br>
    <input type="file" name="food_image" required><br>

    <button type="submit" class="order-btn">Add Food</button>
  </form>
</section>
</body>
</html>
