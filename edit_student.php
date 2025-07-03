<?php
// edit_student.php
include '../db_connect.php';

if (!isset($_GET['id'])) {
  header("Location: dashboard.php");
  exit();
}

$id = intval($_GET['id']);

// Fetch student record
$student = $conn->query("SELECT * FROM students WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $regno = $_POST['regno'];
  $course = $_POST['course'];
  $year = $_POST['year'];
  $level = $_POST['level'];

  $conn->query("UPDATE students SET name='$name', regno='$regno', course='$course', year_of_admission='$year', level='$level' WHERE id=$id");
  header("Location: dashboard.php");
  exit();
}
?><!DOCTYPE html><html>
<head>
  <title>Edit Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h4>Edit Student Record</h4>
  <form method="POST">
    <div class="mb-3">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Registration No.</label>
      <input type="text" name="regno" class="form-control" value="<?= htmlspecialchars($student['regno']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Course</label>
      <select name="course" class="form-control" required>
        <?php
        $courses = ['Computer Science', 'Software Engineering', 'Cyber Security', 'Artificial Intelligence', 'Information Technician', 'Information Science'];
        foreach ($courses as $c) {
          $selected = $student['course'] == $c ? 'selected' : '';
          echo "<option value='$c' $selected>$c</option>";
        }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Year of Admission</label>
      <input type="number" name="year" class="form-control" value="<?= htmlspecialchars($student['year_of_admission']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Level</label>
      <select name="level" class="form-control" required>
        <?php
        $levels = [100, 200, 300, 400, 500];
        foreach ($levels as $lvl) {
          $selected = $student['level'] == $lvl ? 'selected' : '';
          echo "<option value='$lvl' $selected>$lvl Level</option>";
        }
        ?>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>