<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../auth/login.html");
    exit();
}
include '../db/db_connect.php';

$query = "SELECT id, username, email FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Manage Users - Admin | EatOpia</title>
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
    <h2>Manage Registered Users</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($user = mysqli_fetch_assoc($result)): ?>
            <div class='food-card'>
                <h4><?php echo htmlspecialchars($user['username']); ?></h4>
                <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                <a href='delete_user.php?id=<?php echo $user['id']; ?>'>
                    <button class='order-btn remove-btn'>Delete</button>
                </a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No registered users found.</p>
    <?php endif; ?>
</section>

<footer class='footer'>
  <p>&copy; 2025 EatOpia. All rights reserved.</p>
</footer>
</body>
</html>
