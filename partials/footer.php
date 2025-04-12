<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
include '../db/db_connect.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT o.*, f.name, f.price FROM orders o JOIN food_items f ON o.food_id = f.id WHERE o.user_id = $user_id ORDER BY o.created_at DESC";
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
  <?php include '../partials/navbar.php'; ?>

  <section class="customizable-meals">
    <h2>Your Order History</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="food-card">
                <h4><?php echo $row['name']; ?> (<?php echo $row['portion']; ?>)</h4>
                <p>Spice: <?php echo ucfirst($row['spice']); ?> | Toppings: <?php echo $row['toppings']; ?></p>
                <p>Ordered at: <?php echo $row['created_at']; ?></p>
                <a href="reorder.php?id=<?php echo $row['food_id']; ?>&spice=<?php echo $row['spice']; ?>&portion=<?php echo $row['portion']; ?>&toppings=<?php echo urlencode($row['toppings']); ?>">
                    <button>Reorder</button>
                </a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>You haven't placed any orders yet.</p>
    <?php endif; ?>

  </section>

  <?php include '../partials/footer.php'; ?>
</body>
</html>
