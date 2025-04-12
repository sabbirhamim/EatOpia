<?php
session_start();
include '../db/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];

            // Optional: Admin redirect
            if ($email === 'admin@eatopia.com') {
                $_SESSION['admin'] = true;
                header("Location: ../admin/admin_dashboard.php");
                exit();
            }

            // Regular user
            header("Location: ../index.php");
            exit();
        }
    }

    echo "<p style='color:red;text-align:center;'>Invalid email or password.</p>";
    echo "<p style='text-align:center;'><a href='login.html'>Try Again</a></p>";
}
?>
