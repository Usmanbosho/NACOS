<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once '../config.php';

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "Student not found.";
    exit();
}
$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $reg_number = $_POST['reg_number'];
    $course = $_POST['course'];
    $admission_year = $_POST['admission_year'];
    $level = $_POST['level'];
    
    // Handle optional image update
    $photo = $student['photo'];
    if ($_FILES['photo']['size'] > 0) {
        if ($_FILES['photo']['size'] > 1048576) {
            $error = "Image must be less than 1MB.";
        } else {
            $photo = uniqid() . '_' . $_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'], '../uploads/' . $photo);
        }
    }

    $stmt = $conn->prepare("UPDATE students SET name=?, reg_number=?, course=?, admission_year=?, level=?, photo=? WHERE id=?");
    $stmt->bind_param("ssssssi", $name, $reg_number, $course, $admission_year, $level, $photo, $id);
    $stmt->execute();
    
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Student - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3>Edit Student Info</h3>
  <form method="POST" enctype="multipart/form-data">
    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <div class="mb-3">
      <label>Name</label>
      <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($student['name']) ?>">
    </div>
    <div class="mb-3">
      <label>Registration Number</label>
      <input type="text" name="reg_number" class="form-control" required value="<?= htmlspecialchars($student['reg_number']) ?>">
    </div>
    <div class="mb-3">
      <label>Course</label>
      <select name="course" class="form-select" required>
        <?php
        $courses = ['Computer Science', 'Software Engineering', 'Cyber Security', 'Artificial Intelligence', 'Information Technician', 'Information Science'];
        foreach ($courses as $course) {
          echo '<option value="' . $course . '"'. ($student['course'] == $course ? ' selected' : '') .'>' . $course . '</option>';
        }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Year of Admission</label>
      <input type="number" name="admission_year" class="form-control" required value="<?= $student['admission_year'] ?>">
    </div>
    <div class="mb-3">
      <label>Level</label>
      <select name="level" class="form-select" required>
        <?php
        $levels = ['100 Level', '200 Level', '300 Level', '400 Level', '500 Level'];
        foreach ($levels as $lvl) {
          echo '<option value="' . $lvl . '"'. ($student['level'] == $lvl ? ' selected' : '') .'>' . $lvl . '</option>';
        }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Change Picture (optional, max 1MB)</label><br>
      <img src="../uploads/<?= $student['photo'] ?>" width="80" class="mb-2 rounded"><br>
      <input type="file" name="photo" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="dashboard.php" class="btn btn-secondary">Back</a>
  </form>
</div>
</body>
</html>