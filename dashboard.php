<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include('../config/db.php');

// Fetch all students
$students = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");

// Count by level
$level_counts = [];
$levels = ['100 Level', '200 Level', '300 Level', '400 Level', '500 Level'];
foreach ($levels as $level) {
    $query = mysqli_query($conn, "SELECT COUNT(*) as count FROM students WHERE level = '$level'");
    $row = mysqli_fetch_assoc($query);
    $level_counts[$level] = $row['count'];
}

$total = array_sum($level_counts);
?><!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NACOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">NACOS Admin Dashboard</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div><!-- Toasts -->
<?php if (isset($_SESSION['message'])): ?>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <?= $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <h5>Total Students</h5>
                <h2><?= $total ?></h2>
            </div>
        </div>
    </div>
    <?php foreach ($level_counts as $lvl => $count): ?>
    <div class="col-md-2">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h6><?= $lvl ?></h6>
                <h4><?= $count ?></h4>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="mb-3">
    <a href="search.php" class="btn btn-outline-secondary"><i class="fas fa-search"></i> Search Student</a>
    <a href="export_excel.php" class="btn btn-outline-success"><i class="fas fa-file-excel"></i> Export to Excel</a>
    <a href="export_pdf.php" class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i> Export to PDF</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-success">
            <tr>
                <th>Picture</th>
                <th>Name</th>
                <th>Reg No</th>
                <th>Course</th>
                <th>Year of Admission</th>
                <th>Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($students)): ?>
            <tr>
                <td><img src="../uploads/<?= $row['photo'] ?>" width="50" height="50" style="border-radius: 50%;"></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['reg_number'] ?></td>
                <td><?= $row['course'] ?></td>
                <td><?= $row['year_admission'] ?></td>
                <td><?= $row['level'] ?></td>
                <td>
                    <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script></body>
</html>