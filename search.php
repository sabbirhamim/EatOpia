<?php
include __DIR__ . '/db/db_connect.php';

$query = $_GET['query'] ?? '';
$cuisine = $_GET['cuisine'] ?? '';
$price_order = $_GET['price'] ?? '';

$sql = "SELECT * FROM food_items WHERE 1";

if (!empty($query)) {
    $safe_query = mysqli_real_escape_string($conn, $query);
    $sql .= " AND name LIKE '%$safe_query%'";
}
if (!empty($cuisine)) {
    $safe_cuisine = mysqli_real_escape_string($conn, $cuisine);
    $sql .= " AND restaurant_name LIKE '%$safe_cuisine%'";
}
if ($price_order == 'low') {
    $sql .= " ORDER BY price ASC";
} elseif ($price_order == 'high') {
    $sql .= " ORDER BY price DESC";
}

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Search Results - EatOpia</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="assets/images/logo.png" alt="EatOpia Logo">
            <span>EatOpia</span>
        </div>
        <div class="nav-buttons">
            <a href="index.php"><button class="cart-btn">Home</button></a>
        </div>
    </nav>

    <section class="customizable-meals">
        <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="food-card">
                    <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                    <p>Price: <?php echo $row['price']; ?> BDT</p>
                    <p>From: <?php echo htmlspecialchars($row['restaurant_name']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No food items found matching your criteria.</p>
        <?php endif; ?>
    </section>

    <footer class="footer">
        <p>&copy; 2025 EatOpia. All rights reserved.</p>
    </footer>
</body>
</html>
