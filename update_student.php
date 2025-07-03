<?php
// update_student.php

include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name']);
    $reg_number = htmlspecialchars($_POST['reg_number']);
    $course = htmlspecialchars($_POST['course']);
    $admission_year = htmlspecialchars($_POST['admission_year']);
    $level = htmlspecialchars($_POST['level']);

    $stmt = $conn->prepare("UPDATE students SET name=?, reg_number=?, course=?, admission_year=?, level=? WHERE id=?");
    $stmt->bind_param("sssssi", $name, $reg_number, $course, $admission_year, $level, $id);

    if ($stmt->execute()) {
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Student updated successfully!'];
    } else {
        $_SESSION['toast'] = ['type' => 'danger', 'message' => 'Error updating student!'];
    }
    header('Location: dashboard.php');
    exit();
} else {
    header('Location: dashboard.php');
    exit();
}