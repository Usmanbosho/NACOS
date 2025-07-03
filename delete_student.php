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

// Delete photo file
$stmt = $conn->prepare("SELECT photo FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($photo);
$stmt->fetch();
$stmt->close();

if ($photo && file_exists("../uploads/$photo")) {
    unlink("../uploads/$photo");
}

// Delete student record
$stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: dashboard.php");
exit();