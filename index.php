<?php
session_start();
include 'db/db_connect.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$cart = $_SESSION['cart'];

$query = "SELECT f.*, r.name AS restaurant_name, r.image_path AS restaurant_image 
          FROM food_items f
          JOIN restaurants r ON f.restaurant_id = r.id
          ORDER BY f.id DESC LIMIT 6";
$foods = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EatOpia - Home</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="icon" href="assets/images/logo.png" />
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <img src="assets/images/logo.png" alt="EatOpia Logo" />
            <span>EatOpia</span>
        </div>

        <form action="search.php" method="GET" class="navbar-search">
            <input type="text" name="query" placeholder="🔍 Search food or restaurant" />
            <select name="cuisine">
                <option value="">🍛 Cuisine</option>
                <option value="Bangladeshi">Bangladeshi</option>
                <option value="Chinese">Chinese</option>
            </select>
            <select name="price">
                <option value="">💰 Price</option>
                <option value="low">Low to High</option>
                <option value="high">High to Low</option>
            </select>
            <button type="submit">Search</button>
        </form>

        <div class="nav-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="user/cart.php"><button class="cart-btn">Cart</button></a>
                <a href="user/order_history.php"><button class="cart-btn">My Orders</button></a>
                <a href="auth/logout.php"><button class="cart-btn">Logout</button></a>
            <?php else: ?>
                <a href="auth/login.html"><button class="login-btn">Login</button></a>
                <a href="auth/register.html"><button class="cart-btn">Register</button></a>
            <?php endif; ?>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1>Delicious Meals, Delivered to Your Doorstep</h1>
            <a href="menu/restaurant_menu.php?name=Top%20Picks">
                <button class="order-btn">Order Now</button>
            </a>
        </div>
    </header>

    <section class="restaurants">
        <h2>Popular Dishes</h2>
        <div class="restaurant-grid">
            <?php while ($row = mysqli_fetch_assoc($foods)): ?>
                <div class="restaurant-card">
                    <?php if (!empty($row['restaurant_image'])): ?>
                        <img src="../<?php echo $row['restaurant_image']; ?>" alt="<?php echo $row['restaurant_name']; ?>" style="width:100%; border-radius: 10px;">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p><?php echo htmlspecialchars($row['restaurant_name']); ?></p>
                    <p><?php echo $row['price']; ?> BDT</p>

                    <!-- Add to Cart Form -->
                    <form action="user/add_to_cart.php" method="POST">
                        <input type="hidden" name="food_id" value="<?php echo $row['id']; ?>">
                        <select name="spice">
                            <option value="mild">Mild</option>
                            <option value="medium">Medium</option>
                            <option value="spicy">Spicy</option>
                        </select>
                        <select name="food_portion">
                            <option value="small">Small</option>
                            <option value="regular" selected>Regular</option>
                            <option value="large">Large</option>
                        </select>
                        <input type="text" name="toppings" placeholder="Toppings (e.g. Olives)" />
                        <button type="submit" class="order-btn">Add to Cart</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2025 EatOpia. All rights reserved.</p>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>
