<?php
// delete_student.php
include('db.php');

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = intval($_GET['id']);
$query = "DELETE FROM students WHERE id = $id";

if (mysqli_query($conn, $query)) {
    header("Location: dashboard.php?message=Student+deleted+successfully");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>