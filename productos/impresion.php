<?php

require '../assets/fpdf17/fpdf.php';

$a = new FPDF('L', 'mm', array(90, 38));
//$a->AddFont('IDAutomationSC128S');
$a->AddFont('IDAutomationSC128S','','IDAutomationSC128S.php');
$a->SetFont('IDAutomationSC128S');
$a->SetFontSize(20);
$a->AddPage();
$a->Ln(5);
$a->Cell(0, 0, utf8_decode($_POST['barra']), 0, 0, 'C');

$a->Output('plantillaPFD.pdf', 'I');
