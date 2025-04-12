<?php
session_start();
include '../db/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<p style='color:red;text-align:center;'>Email already exists. Please <a href='login.html'>login</a> or use a different email.</p>";
        exit();
    }

    // Register user
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;

        // Optional: Admin auto-detect
        if ($email === 'admin@eatopia.com') {
            $_SESSION['admin'] = true;
            header("Location: ../admin/admin_dashboard.php");
            exit();
        }

        // Redirect to index
        header("Location: ../index.php");
        exit();
    } else {
        echo "<p style='color:red;text-align:center;'>Registration failed. Please try again.</p>";
    }
}
?>
