<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header('Location: login.php');
  exit();
}

include '../config.php';

if (!isset($_GET['id'])) {
  echo "No student ID provided.";
  exit();
}

$id = intval($_GET['id']);
$query = "SELECT * FROM students WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) != 1) {
  echo "Student not found.";
  exit();
}

$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Student</title>
  <link rel="stylesheet" href="../assets/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/toastr.min.css">
  <style>
    body {
      background: #f8f9fa;
    }
    .container {
      max-width: 600px;
      margin-top: 50px;
    }
    .form-section {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px #ccc;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="form-section">
    <h4 class="mb-4 text-center">Edit Student Info</h4>
    <form action="update_student.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $student['id']; ?>">
      <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="<?= $student['name']; ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Registration Number</label>
        <input type="text" name="reg_number" value="<?= $student['reg_number']; ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Course</label>
        <select name="course" class="form-control" required>
          <?php
            $courses = ['Computer Science', 'Software Engineering', 'Cyber Security', 'Artificial Intelligence', 'Information Technician', 'Information Science'];
            foreach ($courses as $course) {
              $selected = ($student['course'] === $course) ? 'selected' : '';
              echo "<option value='$course' $selected>$course</option>";
            }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label>Year of Admission</label>
        <input type="number" name="admission_year" value="<?= $student['admission_year']; ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Level</label>
        <select name="level" class="form-control" required>
          <?php
            $levels = ['100 Level', '200 Level', '300 Level', '400 Level', '500 Level'];
            foreach ($levels as $level) {
              $selected = ($student['level'] === $level) ? 'selected' : '';
              echo "<option value='$level' $selected>$level</option>";
            }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label>Update Picture (optional)</label>
        <input type="file" name="picture" class="form-control-file" accept="image/*">
      </div>
      <button type="submit" class="btn btn-success btn-block">Update Student</button>
    </form>
  </div>
</div>

<script src="../assets/jquery.min.js"></script>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/toastr.min.js"></script>

<?php if (isset($_SESSION['toast'])): ?>
<script>
  toastr.options = { "closeButton": true, "progressBar": true };
  toastr.success("<?= $_SESSION['toast'] ?>");
</script>
<?php unset($_SESSION['toast']); endif; ?>

</body>
</html>