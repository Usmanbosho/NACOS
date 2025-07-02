<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "nacos_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $conn->real_escape_string($_POST['name']);
  $reg_number = $conn->real_escape_string($_POST['reg_number']);
  $course = $conn->real_escape_string($_POST['course']);
  $year_of_admission = (int)$_POST['year_of_admission'];
  $level = $conn->real_escape_string($_POST['level']);

  // Handle image upload
  $img_name = $_FILES['profile_picture']['name'];
  $img_tmp = $_FILES['profile_picture']['tmp_name'];
  $img_size = $_FILES['profile_picture']['size'];
  $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
  $allowed_ext = ['jpg', 'jpeg', 'png'];

  if (!in_array($img_ext, $allowed_ext)) {
    die("Invalid image type. Only JPG, JPEG, PNG allowed.");
  }
  if ($img_size > 1048576) { // 1MB
    die("Image is too large. Maximum size is 1MB.");
  }

  $new_img_name = uniqid("avatar_", true) . "." . $img_ext;
  $upload_path = "uploads/" . $new_img_name;
  move_uploaded_file($img_tmp, $upload_path);

  // Save to database
  $stmt = $conn->prepare("INSERT INTO students (name, reg_number, course, year_of_admission, level, profile_picture) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssiss", $name, $reg_number, $course, $year_of_admission, $level, $new_img_name);
  $stmt->execute();
  $stmt->close();

  // Redirect back with success message
  header("Location: signup.php?success=1");
  exit();
} else {
  echo "Invalid request.";
}
?>