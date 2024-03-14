<?php

session_start();

header('Content-Type: text/html; charset=utf-8');

require_once('fpdf/fpdf.php');
require_once('db.php'); 

class PDF extends FPDF {
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Mouvement de sortie en caisse'), 0, 1, 'C');
        $this->Ln(10); 
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function TableHeader()
    {
        $centerX = ($this->GetPageWidth() - 50 - 60 - 40) / 2;

        $this->SetFont('Arial', 'B', 10);
        $this->SetX($centerX);
        $this->Cell(50, 10, 'Date', 1, 0, 'C'); 
        $this->Cell(60, 10, 'Motif', 1, 0, 'C'); 
        $this->Cell(40, 10, 'Montant', 1, 1, 'C'); 
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

if(isset($_SESSION['filtered_data'])) {
    $filtered_data = $_SESSION['filtered_data'];

    $pdf->TableHeader();

    $pdf->SetFont('Arial', '', 10);
    foreach ($filtered_data as $row) {
        $centerX = ($pdf->GetPageWidth() - 50 - 60 - 40) / 2;
        $pdf->SetX($centerX);

        $pdf->Cell(50, 10, utf8_decode($row['datesortie']), 1, 0, 'C'); 
        $pdf->Cell(60, 10, utf8_decode($row['motifsortie']), 1, 0, 'C'); 
        $pdf->Cell(40, 10, utf8_decode($row['montantsortie'] . ' Ar'), 1, 1, 'C'); 
    }
} else {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, utf8_decode('Aucune donnée filtrée disponible'), 0, 1, 'C');
}

if(isset($_SESSION['total_amount'])) {
    $total_amount = $_SESSION['total_amount'];

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10,utf8_decode('Somme totale des montants en sortie : ' . $total_amount . ' Ar'), 0, 1, 'L');
    $pdf->Ln(10); 
} else {
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, utf8_decode('Somme totale des montants en sortie : N/A'), 0, 1, 'L');
    $pdf->Ln(10); 
}

$pdf->Output();

?>
