<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

require '../config.php';

// Get all students
$students = $conn->query("SELECT * FROM students ORDER BY created_at DESC");

// Count totals
$total = $conn->query("SELECT COUNT(*) FROM students")->fetch_row()[0];
$levelCounts = [];
foreach ([100, 200, 300, 400, 500] as $level) {
    $levelCounts[$level] = $conn->query("SELECT COUNT(*) FROM students WHERE level = $level")->fetch_row()[0];
}
?><!DOCTYPE html><html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - NACOS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
  <h2 class="mb-4 text-success">Admin Dashboard - NACOS</h2>  <div class="row mb-4">
    <div class="col-md">
      <div class="card text-white bg-success">
        <div class="card-body">
          <h5 class="card-title">Total Students</h5>
          <p class="card-text fs-4"><?php echo $total; ?></p>
        </div>
      </div>
    </div>
    <?php foreach ($levelCounts as $level => $count): ?>
      <div class="col-md">
        <div class="card text-white bg-dark">
          <div class="card-body">
            <h6 class="card-title"><?php echo $level; ?> Level</h6>
            <p class="card-text fs-5"><?php echo $count; ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>  <!-- Search and Export -->  <div class="d-flex justify-content-between align-items-center mb-3">
    <form class="d-flex" method="get">
      <input class="form-control me-2" type="search" name="q" placeholder="Search by name or reg no...">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    <div>
      <a href="export_excel.php" class="btn btn-primary me-2">Export to Excel</a>
      <a href="export_pdf.php" class="btn btn-danger">Export to PDF</a>
    </div>
  </div>  <!-- Student Table -->  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead class="table-success">
        <tr>
          <th>Picture</th>
          <th>Name</th>
          <th>Reg No</th>
          <th>Course</th>
          <th>Level</th>
          <th>Year of Admission</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $students->fetch_assoc()): ?>
        <tr>
          <td><img src="../uploads/<?php echo $row['picture']; ?>" width="50" class="rounded-circle"></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['reg_number']); ?></td>
          <td><?php echo htmlspecialchars($row['course']); ?></td>
          <td><?php echo $row['level']; ?></td>
          <td><?php echo $row['year_of_admission']; ?></td>
          <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
          <td>
            <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
            <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>  <!-- Toast -->  <?php if (isset($_SESSION['message'])): ?><div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div class="toast show text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">Success</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
    </div>
    <div class="toast-body">
      <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
  </div>
</div>

  <?php endif; ?></div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script></body>
</html>