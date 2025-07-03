<?php
session_start();
require_once '../db.php';

// Fetch total users
$total_sql = "SELECT COUNT(*) as total FROM students";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_students = $total_row['total'];

// Fetch users per level
$levels = [100, 200, 300, 400, 500];
$level_counts = [];

foreach ($levels as $lvl) {
  $sql = "SELECT COUNT(*) as count FROM students WHERE level = '$lvl'";
  $res = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($res);
  $level_counts[$lvl] = $row['count'];
}

// Fetch all users
$students_sql = "SELECT * FROM students ORDER BY year_of_admission DESC";
$students_result = mysqli_query($conn, $students_sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard - NACOS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f9f9f9; }
    .container { padding-top: 40px; }
    .card { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    img.avatar { width: 50px; height: 50px; border-radius: 50%; }
  </style>
</head>
<body>
<div class="container">
  <h2 class="text-center mb-4">Admin Panel - NACOS</h2>

  <!-- Statistics -->
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card text-white bg-primary mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Students</h5>
          <p class="card-text fs-4"><?= $total_students ?></p>
        </div>
      </div>
    </div>
    <?php foreach ($level_counts as $level => $count): ?>
      <div class="col-md-2">
        <div class="card bg-success text-white mb-3">
          <div class="card-body">
            <h6 class="card-title"><?= $level ?> Level</h6>
            <p class="card-text fs-5"><?= $count ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Student Table -->
  <div class="card">
    <div class="card-header bg-dark text-white">
      Registered Students
    </div>
    <div class="card-body p-0">
      <table class="table table-bordered table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Avatar</th>
            <th>Name</th>
            <th>Reg. No</th>
            <th>Course</th>
            <th>Level</th>
            <th>Year</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $sn = 1;
        while($row = mysqli_fetch_assoc($students_result)): ?>
          <tr>
            <td><?= $sn++ ?></td>
            <td><img src="../uploads/<?= $row['profile_picture'] ?>" class="avatar"></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['reg_number'] ?></td>
            <td><?= $row['course'] ?></td>
            <td><?= $row['level'] ?></td>
            <td><?= $row['year_of_admission'] ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>