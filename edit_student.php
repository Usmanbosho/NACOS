<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update_student'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $reg_number = $_POST['reg_number'];
    $course = $_POST['course'];
    $admission_year = $_POST['admission_year'];
    $level = $_POST['level'];

    $stmt = $conn->prepare("UPDATE students SET name = ?, reg_number = ?, course = ?, admission_year = ?, level = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $reg_number, $course, $admission_year, $level, $id);
    $stmt->execute();

    header("Location: dashboard.php?updated=1");
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>