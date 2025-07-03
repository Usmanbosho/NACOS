<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit();
}

include '../db_connect.php';

// Get total students
$totalQuery = $conn->query("SELECT COUNT(*) as total FROM students");
$total = $totalQuery->fetch_assoc()['total'];

// Get students per level
$levels = [100, 200, 300, 400, 500];
$counts = [];
foreach ($levels as $lvl) {
  $count = $conn->query("SELECT COUNT(*) as count FROM students WHERE level = '$lvl'")->fetch_assoc()['count'];
  $counts[$lvl] = $count;
}

// Get all students
$students = $conn->query("SELECT * FROM students ORDER BY year_of_admission DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NACOS Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f1f2f6;
    }
    .navbar {
      background-color: green;
    }
    .navbar-brand {
      color: white !important;
    }
    .card {
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .table img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }
    .btn-danger, .btn-warning {
      font-size: 12px;
      padding: 4px 8px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">NACOS Admin Panel</a>
    <a href="logout.php" class="btn btn-light">Logout</a>
  </div>
</nav>

<div class="container mt-4">
  <h4>Welcome Admin</h4>

  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card text-white bg-success">
        <div class="card-body">
          <h5>Total Students</h5>
          <p class="display-6"><?= $total ?></p>
        </div>
      </div>
    </div>
    <?php foreach ($levels as $lvl): ?>
    <div class="col-md-2">
      <div class="card bg-light">
        <div class="card-body text-center">
          <h6><?= $lvl ?> Level</h6>
          <p><strong><?= $counts[$lvl] ?></strong></p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="card">
    <div class="card-header bg-dark text-white">
      All Registered Students
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Reg No</th>
            <th>Course</th>
            <th>Year</th>
            <th>Level</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $students->fetch_assoc()): ?>
          <tr>
            <td><img src="../uploads/<?= htmlspecialchars($row['profile_pic']) ?>" alt=""></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['regno']) ?></td>
            <td><?= htmlspecialchars($row['course']) ?></td>
            <td><?= htmlspecialchars($row['year_of_admission']) ?></td>
            <td><?= htmlspecialchars($row['level']) ?></td>
            <td>
              <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this record?');">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>