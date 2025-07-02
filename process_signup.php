<?php
// DB connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "nacos_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $conn->real_escape_string($_POST['name']);
    $regno    = $conn->real_escape_string($_POST['regno']);
    $course   = $conn->real_escape_string($_POST['course']);
    $year     = intval($_POST['year']);
    $level    = intval($_POST['level']);

    // Handle image
    $img_name  = $_FILES['photo']['name'];
    $img_size  = $_FILES['photo']['size'];
    $img_tmp   = $_FILES['photo']['tmp_name'];
    $img_ext   = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
    $allowed   = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($img_ext, $allowed)) {
        die("Only JPG, JPEG, PNG, and GIF files are allowed.");
    }

    if ($img_size > 1048576) {
        die("Image must not be more than 1MB.");
    }

    $new_name = uniqid() . "." . $img_ext;
    $upload_dir = "uploads/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    move_uploaded_file($img_tmp, $upload_dir . $new_name);

    // Insert into DB
    $sql = "INSERT INTO students (name, regno, course, year_of_admission, level, photo) 
            VALUES ('$name', '$regno', '$course', $year, $level, '$new_name')";

    if ($conn->query($sql)) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>