<?php
// export_excel.php

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=students_list.xls");

include("../includes/db.php");

$output = "<table border='1'>
<tr>
  <th>Name</th>
  <th>Reg Number</th>
  <th>Course</th>
  <th>Year of Admission</th>
  <th>Level</th>
</tr>";

$query = mysqli_query($conn, "SELECT * FROM students ORDER BY name ASC");
while ($row = mysqli_fetch_assoc($query)) {
  $output .= "<tr>
    <td>{$row['name']}</td>
    <td>{$row['reg_number']}</td>
    <td>{$row['course']}</td>
    <td>{$row['year_of_admission']}</td>
    <td>{$row['level']}</td>
  </tr>";
}

$output .= "</table>";
echo $output;