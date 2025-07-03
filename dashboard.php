<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
require_once 'db.php';

// Fetch students
$stmt = $conn->prepare("SELECT * FROM students ORDER BY id DESC");
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?><!DOCTYPE html><html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - NACOS</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" href="../img/ictunitskillbuilderpayment.png">
  <style>
    body {
      padding: 30px;
    }
    .toast {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Admin Dashboard - NACOS</h2>
      <a href="logout.php" class="btn btn-danger">Logout</a>
    </div><?php if (isset($_SESSION['toast_message'])): ?>
  <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        <?= $_SESSION['toast_message'] ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
  <?php unset($_SESSION['toast_message']); ?>
<?php endif; ?>

<div class="mb-3">
  <a href="search.php" class="btn btn-info"><i class="fas fa-search"></i> Search Student</a>
  <a href="export_excel.php" class="btn btn-success"><i class="fas fa-file-excel"></i> Export to Excel</a>
  <a href="export_pdf.php" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export to PDF</a>
</div>

<h4>Total Students: <?= count($students) ?></h4>
<div class="row mb-4">
  <?php
    $levels = ['100', '200', '300', '400', '500'];
    foreach ($levels as $lvl) {
      $count = array_filter($students, fn($s) => $s['level'] == $lvl);
      echo "<div class='col-md-2'><div class='card text-center'><div class='card-body'><strong>{$lvl} Level</strong><br>" . count($count) . "</div></div></div>";
    }
  ?>
</div>

<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>Picture</th>
        <th>Name</th>
        <th>Reg No</th>
        <th>Course</th>
        <th>Year</th>
        <th>Level</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($students as $student): ?>
        <tr>
          <td><img src="../uploads/<?= htmlspecialchars($student['photo']) ?>" width="60" height="60" style="border-radius:50px"></td>
          <td><?= htmlspecialchars($student['name']) ?></td>
          <td><?= htmlspecialchars($student['regno']) ?></td>
          <td><?= htmlspecialchars($student['course']) ?></td>
          <td><?= htmlspecialchars($student['admission_year']) ?></td>
          <td><?= htmlspecialchars($student['level']) ?></td>
          <td>
            <a href="edit_student.php?id=<?= $student['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
            <a href="delete_student.php?id=<?= $student['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

  </div>  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script></body>
</html>