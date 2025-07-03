<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header('Location: login.php');
  exit();
}
include '../config.php';

// Count total students
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM students");
$total = mysqli_fetch_assoc($totalQuery)['total'];

// Count students per level
$levels = [100, 200, 300, 400, 500];
$levelCounts = [];
foreach ($levels as $level) {
  $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM students WHERE level = '$level'");
  $levelCounts[$level] = mysqli_fetch_assoc($query)['total'];
}

// Fetch student list
$students = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
?><!DOCTYPE html><html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-5">
  <h3 class="mb-4 text-center">Welcome, Admin</h3>  <div class="row text-center mb-4">
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <h5>Total Students</h5>
          <p class="display-4"><?php echo $total; ?></p>
        </div>
      </div>
    </div>
    <?php foreach ($levelCounts as $lvl => $count): ?>
    <div class="col-md-2">
      <div class="card">
        <div class="card-body">
          <h6><?php echo $lvl; ?> Level</h6>
          <p class="h4"><?php echo $count; ?></p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>  <div class="mb-3">
    <a href="search_student.php" class="btn btn-outline-primary">Search Student</a>
    <a href="export_excel.php" class="btn btn-outline-success">Export to Excel</a>
    <a href="print_pdf.php" class="btn btn-outline-danger">Print PDF</a>
    <a href="logout.php" class="btn btn-outline-secondary float-right">Logout</a>
  </div>  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Picture</th>
          <th>Name</th>
          <th>Reg No</th>
          <th>Course</th>
          <th>Level</th>
          <th>Year</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($students)): ?>
        <tr>
          <td><img src="../uploads/<?php echo $row['picture']; ?>" width="50" height="50" style="border-radius: 50px;"></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['reg_number']; ?></td>
          <td><?php echo $row['course']; ?></td>
          <td><?php echo $row['level']; ?></td>
          <td><?php echo $row['admission_year']; ?></td>
          <td>
            <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Edit</a>
            <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger delete-btn">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div><script>
  // SweetAlert for delete action
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const href = this.getAttribute('href');
      Swal.fire({
        title: 'Are you sure?',
        text: "This record will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = href;
        }
      });
    });
  });
</script></body>
</html>