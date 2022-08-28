<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Include the main TCPDF library (search for installation path).
require_once('vendor/autoload.php');

$entity = [];

foreach($_SESSION['members'] as $member) {
    if ($_SESSION['member_id']->id == $member['info']['id']) {
        $entity['name'] = $member['info']['donor']['name'];
        $entity['id'] = $member['info']['id'];
        $entity['amount'] = $member['info']['recurring_amount'];
        $entity['currency'] = $member['info']['currency'];
    }
}


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
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

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// Set some content to print
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
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

$html1 = <<<EOD
<div style="background-color: #F5E8C7; border: 12px solid #F5E8C7">
<h1><span style="text-decoration:none;background-color:#ECCCB2;color:black;">&nbsp;<span style="color:black;">Membership</span><span style="color:black;"> Card</span>&nbsp;</span></h1>
<p>Association  ARGM, RNA W362002611</p>
<p><b>Name:</b> {$entity['name']}</p>
<p><b>Membership Number:</b> {$entity['id']}</p>
<p><b>Monthly Donation:</b> {$entity['currency']} {$entity['amount']}</p>
</div>
EOD;