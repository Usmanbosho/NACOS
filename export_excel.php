<?php
// export_excel.php
include('includes/db.php');

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=students_list.xls");

echo "Name\tReg Number\tCourse\tYear of Admission\tLevel\n";

$query = "SELECT * FROM students ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo $row['name'] . "\t" . $row['reg_number'] . "\t" . $row['course'] . "\t" . $row['admission_year'] . "\t" . $row['level'] . "\n";
}