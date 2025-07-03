<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once '../config.php';

// Total students
$total = $conn->query("SELECT COUNT(*) FROM students")->fetch_row()[0];

// Count per level
$levels = ['100 Level', '200 Level', '300 Level', '400 Level', '500 Level'];
$levelCounts = [];
foreach ($levels as $level) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM students WHERE level = ?");
    $stmt->bind_param("s", $level);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $levelCounts[$level] = $count;
    $stmt->close();
}

// Fetch all students
$students = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - NACOS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f0f2f5;
    }
    .container {
      margin-top: 40px;
    }
    .card {
      border-radius: 10px;
    }
    .table img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }
  </style>
</head>
<body>

<div class="container">
  <h3 class="mb-4 text-center">NACOS Admin Dashboard</h3>

  <div class="row text-white mb-4">
    <div class="col-md-3">
      <div class="card bg-primary p-3">
        <h5>Total Students</h5>
        <h3><?= $total ?></h3>
      </div>
    </div>
    <?php foreach ($levelCounts as $level => $count): ?>
    <div class="col-md-3 mt-2">
      <div class="card bg-success p-3">
        <h6><?= $level ?></h6>
        <h4><?= $count ?></h4>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="card p-4">
    <h4>All Students</h4>
    <table class="table table-bordered table-striped mt-3">
      <thead class="table-dark">
        <tr>
          <th>Picture</th>
          <th>Name</th>
          <th>Reg. Number</th>
          <th>Course</th>
          <th>Year of Admission</th>
          <th>Level</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $students->fetch_assoc()): ?>
        <tr>
          <td><img src="../uploads/<?= htmlspecialchars($row['photo']) ?>" alt="Photo"></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['reg_number']) ?></td>
          <td><?= htmlspecialchars($row['course']) ?></td>
          <td><?= htmlspecialchars($row['admission_year']) ?></td>
          <td><?= htmlspecialchars($row['level']) ?></td>
          <td>
            <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $row['id'] ?>)">Delete</button>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this student? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="#" id="deleteConfirmBtn" class="btn btn-danger">Yes, Delete</a>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmDelete(id) {
  const deleteBtn = document.getElementById("deleteConfirmBtn");
  deleteBtn.href = "delete_student.php?id=" + id;
  new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

</body>
</html>