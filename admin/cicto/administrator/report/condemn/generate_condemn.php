<?php
require_once('../tcpdf/tcpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from POST
    $date_today = $_POST['date_today'];
    $serial_number = $_POST['serial_number'];
    $unit = $_POST['unit'];
    $category = $_POST['category'];
    $office = $_POST['office'];
    $ticket_count = $_POST['ticket_count'];
    $unit_description = $_POST['unit_description'];
    $requested_by = $_POST['requested_by'];
    $condition_status = $_POST['condition_status'];
    $reason_condemnation = $_POST['reason_condemnation'];
    $comment_text = $_POST['comment_text'];

    // Create new PDF
    $pdf = new TCPDF();
    $pdf->AddPage();

    
// Set font
$pdf->SetFont('helvetica', '', 12);

$pdf->Image('../../images/cicto_logo.png', 10,18, 25, '', 'PNG');


// Set document information

$pdf->SetAuthor('City Information and Communications Technology');
$pdf->SetTitle('Certificate of Condemn');

// Set the position for the title text
$pdf->SetXY(40, 28);  // Set the position for the text (X = 40, Y = 28)
$pdf->SetFont('helvetica', 'B', 14);  // Bold font for the header
$pdf->SetXY(40, 20);
$pdf->MultiCell(0, 10, 'City Information and Communications Technology', 0, 'L');
$pdf->SetFont('helvetica', '', 12);

$html = <<<EOD
<h2 style="text-align: center;">Certificate of Condemnation</h2><br>
<p style="text-align: right; margin-top:50px">Date Issued: <strong>{$date_today}</strong></p>

<p style="text-indent: 20px;">This is to certify that the following equipment has been inspected and evaluated by the City Information and Communications Technology Office (CICTO) and found to be beyond economical repair. The said device is deemed unserviceable and is therefore recommended for condemnation and disposal.</p>

<p>Details of the condemned unit are as follows:</p>

<ul>
    <li>Serial Number: <strong>{$serial_number}</strong></li><br>
    <li>Device Type: <strong>{$unit}</strong></li><br>
    <li>Category: <strong>{$category}</strong></li><br>
    <li>Office/Location: <strong>{$office}</strong></li><br>
    <li>Number of Repairs/Tickets: <strong>{$ticket_count}</strong></li><br>
    <li>Device Description: <strong>{$unit_description}</strong></li><br>
    <li>Condition/Status: <strong>{$condition_status}</strong></li><br>
    <li>Reason for Condemnation: <strong>{$reason_condemnation}</strong></li><br>
    <li>Comment: <strong>{$comment_text}</strong></li>
</ul>

<p style="text-indent: 20px;">This certificate is issued upon the request of <strong><u>{$requested_by}</u></strong> for proper documentation and compliance with asset disposal protocols.</p>

<br><br><br>
<p style="display: inline-block; width: 45%;">_________________<br>
<strong><u>{$requested_by}</u></strong><br>
Requested By</p>

<p style="display: inline-block; width: 45%; text-align: right;"><br>
<strong><u>ERWIN G. MANADAO</u></strong><br>
CICTO Department Head</p>

<p style="text-align: center; font-size: 10px; margin-top: 50px;">
City Information and Communications Technology Office – City Government of Tabuk City
</p>
EOD;


    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output('certificate_of_condemn.pdf', 'I'); // 'I' to open in new tab
}
?>
