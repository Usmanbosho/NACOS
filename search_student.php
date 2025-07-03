<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header('Location: login.php');
  exit();
}
include '../config.php';

$searchResults = [];
if (isset($_POST['search'])) {
  $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
  $query = "SELECT * FROM students 
            WHERE name LIKE '%$keyword%' 
            OR reg_number LIKE '%$keyword%' 
            OR course LIKE '%$keyword%'";
  $result = mysqli_query($conn, $query);
  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $searchResults[] = $row;
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Search Students</title>
  <link rel="stylesheet" href="../assets/bootstrap.min.css">
  <style>
    body {
      background: #f1f1f1;
    }
    .container {
      margin-top: 50px;
    }
    .card {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="container">
  <h4 class="mb-4 text-center">Search Student Records</h4>
  <form method="POST" action="search_student.php" class="form-inline justify-content-center mb-4">
    <input type="text" name="keyword" class="form-control mr-2" placeholder="Enter name, reg number or course" required style="width: 300px;">
    <button type="submit" name="search" class="btn btn-primary">Search</button>
  </form>

  <?php if (isset($_POST['search'])): ?>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Search Results:</h5>
        <?php if (count($searchResults) > 0): ?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
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
                <?php foreach ($searchResults as $student): ?>
                <tr>
                  <td><img src="../uploads/<?= $student['picture']; ?>" width="50" height="50" style="border-radius: 50px;"></td>
                  <td><?= $student['name']; ?></td>
                  <td><?= $student['reg_number']; ?></td>
                  <td><?= $student['course']; ?></td>
                  <td><?= $student['level']; ?></td>
                  <td><?= $student['admission_year']; ?></td>
                  <td>
                    <a href="edit_student.php?id=<?= $student['id']; ?>" class="btn btn-sm btn-success">Edit</a>
                    <a href="delete_student.php?id=<?= $student['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete?')">Delete</a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="text-danger">No matching records found.</p>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
</div>

</body>
</html>