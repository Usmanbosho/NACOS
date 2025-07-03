<?php
include 'db.php';
include 'auth.php';
?><!DOCTYPE html><html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .toast {
      position: fixed;
      top: 1rem;
      right: 1rem;
      z-index: 9999;
    }
    .avatar {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <h2 class="mb-4">Admin Dashboard</h2><div class="d-flex justify-content-between align-items-center mb-3">
  <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
  <a href="export_students.php" class="btn btn-success">
    <i class="fas fa-file-excel"></i> Download Excel
  </a>
</div>

<?php if (isset($_GET['success'])): ?>
<div class="toast show align-items-center text-bg-success border-0" role="alert">
  <div class="d-flex">
    <div class="toast-body">
      <?= htmlspecialchars($_GET['success']) ?>
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
  </div>
</div>
<?php endif; ?>

<table class="table table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Photo</th>
      <th>Name</th>
      <th>Reg No</th>
      <th>Course</th>
      <th>Year of Admission</th>
      <th>Level</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $query = "SELECT * FROM students ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)):
    ?>
    <tr>
      <td><img src="uploads/<?= htmlspecialchars($row['photo']) ?>" class="avatar"></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['reg_number']) ?></td>
      <td><?= htmlspecialchars($row['course']) ?></td>
      <td><?= htmlspecialchars($row['admission_year']) ?></td>
      <td><?= htmlspecialchars($row['level']) ?></td>
      <td>
        <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
        <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

  </div>  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script></body>
</html>