<?php
session_start();

// You can change these credentials
$admin_username = "Admin";
$admin_password = "Admin@123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  if ($username === $admin_username && $password === $admin_password) {
    $_SESSION["admin_logged_in"] = true;
    header("Location: dashboard.php");
    exit();
  } else {
    header("Location: admin_login.php?error=Invalid credentials");
    exit();
  }
}
?>