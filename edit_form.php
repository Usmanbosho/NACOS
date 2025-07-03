<?php
// edit_form.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit();
}

require_once '../includes/db.php';

if (!isset($_GET['id'])) {
  echo "No student selected.";
  exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
  echo "Student not found.";
  exit();
}
?><!DOCTYPE html><html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Student</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3>Edit Student Info</h3>
    <form action="update_student.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $student['id'] ?>"><div class="form-group">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="<?= $student['name'] ?>" required>
  </div>

  <div class="form-group">
    <label>Registration Number</label>
    <input type="text" name="reg_no" class="form-control" value="<?= $student['reg_no'] ?>" required>
  </div>

  <div class="form-group">
    <label>Course</label>
    <select name="course" class="form-control" required>
      <option <?= $student['course'] == 'Computer Science' ? 'selected' : '' ?>>Computer Science</option>
      <option <?= $student['course'] == 'Software Engineering' ? 'selected' : '' ?>>Software Engineering</option>
      <option <?= $student['course'] == 'Cyber Security' ? 'selected' : '' ?>>Cyber Security</option>
      <option <?= $student['course'] == 'Artificial Intelligence' ? 'selected' : '' ?>>Artificial Intelligence</option>
      <option <?= $student['course'] == 'Information Technician' ? 'selected' : '' ?>>Information Technician</option>
      <option <?= $student['course'] == 'Information Science' ? 'selected' : '' ?>>Information Science</option>
    </select>
  </div>

  <div class="form-group">
    <label>Year of Admission</label>
    <input type="number" name="admission_year" class="form-control" value="<?= $student['admission_year'] ?>" required>
  </div>

  <div class="form-group">
    <label>Level</label>
    <select name="level" class="form-control" required>
      <option <?= $student['level'] == '100 Level' ? 'selected' : '' ?>>100 Level</option>
      <option <?= $student['level'] == '200 Level' ? 'selected' : '' ?>>200 Level</option>
      <option <?= $student['level'] == '300 Level' ? 'selected' : '' ?>>300 Level</option>
      <option <?= $student['level'] == '400 Level' ? 'selected' : '' ?>>400 Level</option>
      <option <?= $student['level'] == '500 Level' ? 'selected' : '' ?>>500 Level</option>
    </select>
  </div>

  <div class="form-group">
    <label>Update Profile Picture (optional)</label><br>
    <input type="file" name="picture" class="form-control-file">
  </div>

  <button type="submit" class="btn btn-primary">Update Student</button>
</form>

  </div>
</body>
</html>