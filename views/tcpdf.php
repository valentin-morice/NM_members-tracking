<?php

// Get Member Details
$entity = [];

foreach($_SESSION['members'] as $member) {
    if ($_SESSION['member_id']->id == $member['info']['id']) {
        $entity['name'] = $member['info']['donor']['name'];
        $entity['id'] = $member['info']['id'];
        $entity['amount'] = $member['info']['recurring_amount'];
        $entity['currency'] = $member['info']['currency'];
    }
}


// Create New PDF Document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set Document Information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('New Mayapur');
$pdf->SetTitle('');

// Remove Default Header/Footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

$pdf->setFontSubsetting(true);
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
$pdf->AddPage();

// Set Content to Print
$html = <<<EOD
<table>
    <thead>
        <tr>
            <th colspan="2">Membership Card - Association ARGM</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>RNA W362002611</td>
            <td rowspan="4"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/New_Mayapur_-_03.jpg/280px-New_Mayapur_-_03.jpg"></td>
        </tr>
        <tr>
            <td>{$entity['name']}</td>
        </tr>
        <tr>
            <td>Membership n.{$entity['id']}</td>
        </tr>
        <tr>
            <td>Monthly Donation:<br>{$entity['currency']} {$entity['amount']}</td>
        </tr>
    </tbody>
</table>

<style>
table,
td {
    border: 1px solid #333;
    padding: 12px;
    background-color: #faedcd;
}
</style>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(140, 50, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($entity['name'] . '_Card');
