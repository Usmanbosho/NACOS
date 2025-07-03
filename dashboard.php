<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$updateSuccess = isset($_GET['updated']) && $_GET['updated'] == 1;
$deleteSuccess = isset($_GET['deleted']) && $_GET['deleted'] == 1;

$result = $conn->query("SELECT * FROM students");
?><!DOCTYPE html><html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">Student Records</h2>
    <table class="table table-bordered">
      <thead class="table-success">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Reg Number</th>
          <th>Course</th>
          <th>Admission Year</th>
          <th>Level</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['reg_number']) ?></td>
          <td><?= htmlspecialchars($row['course']) ?></td>
          <td><?= $row['admission_year'] ?></td>
          <td><?= $row['level'] ?></td>
          <td><img src="uploads/<?= $row['image'] ?>" width="50"></td>
          <td>
            <a href="edit_form.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>  <!-- Toast Container -->  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <!-- Update Toast -->
    <div id="updateToast" class="toast align-items-center text-bg-success border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          ✅ Student record updated successfully!
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div><!-- Delete Toast -->
<div id="deleteToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      🗑️ Student deleted successfully!
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
  </div>
</div>

  </div>  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  <script>
    <?php if ($updateSuccess): ?>
      new bootstrap.Toast(document.getElementById('updateToast')).show();
    <?php endif; ?>

    <?php if ($deleteSuccess): ?>
      new bootstrap.Toast(document.getElementById('deleteToast')).show();
    <?php endif; ?>
  </script></body>
</html>