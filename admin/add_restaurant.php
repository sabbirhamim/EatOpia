<?php
session_start();
if (!isset($_SESSION['admin'])) exit();
include '../db/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $image_path = '';

    if ($_FILES['restaurant_image']['error'] === 0) {
        $image_path = 'uploads/' . time() . '_' . basename($_FILES['restaurant_image']['name']);
        move_uploaded_file($_FILES['restaurant_image']['tmp_name'], '../' . $image_path);
    }

    $query = "INSERT INTO restaurants (name, image_path) VALUES ('$name', '$image_path')";
    $message = mysqli_query($conn, $query) ? "Restaurant added!" : "Failed: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Restaurant</title>
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
  <h2>Add Restaurant</h2>
  <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Restaurant Name" required><br>
    <label>Image:</label><br>
    <input type="file" name="restaurant_image" required><br>
    <button type="submit" class="order-btn">Add Restaurant</button>
  </form>
</section>
</body>
</html>
