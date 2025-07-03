<?php
require('fpdf/fpdf.php');
require_once '../db.php';

// Create PDF instance
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Header
$pdf->Cell(190, 10, 'NACOS ATBU - Registered Students List', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(40, 10, 'Name', 1);
$pdf->Cell(30, 10, 'Reg No.', 1);
$pdf->Cell(30, 10, 'Course', 1);
$pdf->Cell(20, 10, 'Level', 1);
$pdf->Cell(30, 10, 'Admission', 1);
$pdf->Cell(30, 10, 'Photo', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

$query = $conn->query("SELECT * FROM students ORDER BY id DESC");
$id = 1;
while ($row = $query->fetch_assoc()) {
    $pdf->Cell(10, 10, $id++, 1);
    $pdf->Cell(40, 10, $row['name'], 1);
    $pdf->Cell(30, 10, $row['reg_number'], 1);
    $pdf->Cell(30, 10, $row['course'], 1);
    $pdf->Cell(20, 10, $row['level'], 1);
    $pdf->Cell(30, 10, $row['year'], 1);
    $pdf->Cell(30, 10, $row['image'], 1); // Just showing filename
    $pdf->Ln();
}

$pdf->Output();