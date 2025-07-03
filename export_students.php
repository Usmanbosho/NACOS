<?php
include 'db.php';

// Set headers to force download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="students_list.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Write column headers
fputcsv($output, ['ID', 'Name', 'Reg Number', 'Course', 'Year of Admission', 'Level']);

// Fetch students from DB
$query = "SELECT id, name, reg_number, course, admission_year, level FROM students";
$result = mysqli_query($conn, $query);

// Write each student row
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

fclose($output);
exit;
?>