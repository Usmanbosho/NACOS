<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
  header("Location: dashboard.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - NACOS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .login-box {
      padding: 30px;
      background: white;
      box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
      border-radius: 8px;
      width: 100%;
      max-width: 400px;
    }
    .login-box img {
      width: 80px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="login-box text-center">
    <img src="../img/ictunitskillbuilderpayment.png" alt="NACOS Logo">
    <h4 class="mb-4">Admin Login</h4>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form action="process_login.php" method="POST">
      <div class="form-group mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
      </div>
      <div class="form-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-success w-100">Login</button>
    </form>
  </div>
</body>
</html>