<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (is_rtl()) {
    $align = 'R'; //Right align
    $attr_align = 'right';
    $table_td = "left";
}else{
    $align = 'L'; //Left align
    $attr_align = 'right';
    $table_td = "right";
}   
$image_file = get_option('custom_pdf_header_image_url');
if($image_file !== ''){
$pdf->SetMargins(10, 60, 10, true);
  
    
}

 $image_file_footer = get_option('custom_pdf_footer_image_url');
if($image_file_footer !== ''){
$pdf->SetMargins(10, 60, 10, true);
$pdf->SetAutoPageBreak(TRUE, 60);
  
    
}

$dimensions = $pdf->getPageDimensions();

$company_info = '<div style="color:#424242;">';
$company_info .= format_organization_info();
$company_info .= '</div>';

// Bill to
$client_details = '<div align="'.$attr_align.'">';
$client_details .= format_customer_info($payment->invoice_data, 'payment', 'billing');
$client_details .= '</div>';

$info_left_column  = '';

$info_right_column = '';

$info_left_column .= pdf_logo_url();
if (is_rtl()) {
    pdf_multi_row($info_right_column, $info_left_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);
}else{
    pdf_multi_row($info_left_column, $info_right_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);
}

if (is_rtl()) {
    $left_info = $client_details;
    $right_info = $company_info;
}else{
    $left_info = $company_info;
    $right_info = $client_details;
}
pdf_multi_row($left_info, $right_info, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);
if (is_rtl()) {
    $this->setRTL(true);
}
$pdf->SetFontSize(15);

$receit_heading = '<div style="text-align:center">' . mb_strtoupper(_l('payment_receipt'), 'UTF-8') . '</div>';
$pdf->Ln(20);
$pdf->writeHTMLCell(0, '', '', '', $receit_heading, 0, 1, false, true, $align, true);
$pdf->SetFontSize($font_size);
$pdf->Ln(20);
$pdf->Cell(0, 0, _l('payment_date') . ' ' . _d($payment->date), 0, 1, $align, 0, '', 0);
$pdf->Ln(2);
$pdf->writeHTMLCell(80, '', '', '', '<hr/>', 0, 1, false, true, $align, true);
$payment_name = $payment->name;
if (!empty($payment->paymentmethod)) {
    $payment_name .= ' - ' . $payment->paymentmethod;
}
$pdf->Cell(0, 0, _l('payment_view_mode') . ' ' . $payment_name, 0, 1, $align, 0, '', 0);
if (!empty($payment->transactionid)) {
    $pdf->Ln(2);
    $pdf->writeHTMLCell(80, '', '', '', '<hr/>', 0, 1, false, true, $align, true);
    $pdf->Cell(0, 0, _l('payment_transaction_id') . ': ' . $payment->transactionid, 0, 1, $align, 0, '', 0);
}
$pdf->Ln(2);
$pdf->writeHTMLCell(80, '', '', '', '<hr />', 0, 1, false, true, $align, true);
$pdf->SetFillColor(132, 197, 41);
$pdf->SetTextColor(255);
$pdf->SetFontSize(12);
$pdf->Ln(3);
$pdf->Cell(80, 10, _l('payment_total_amount'), 0, 1, 'C', '1');
$pdf->SetFontSize(11);
$pdf->Cell(80, 10, app_format_money($payment->amount, $payment->invoice_data->currency_name), 0, 1, 'C', '1');

$pdf->Ln(10);
$pdf->SetTextColor(0);
$pdf->SetFont($font_name, 'B', 14);
$pdf->Cell(0, 0, _l('payment_for_string'), 0, 1, $align, 0, '', 0);
$pdf->SetFont($font_name, '', $font_size);
$pdf->Ln(5);

// Header
$tblhtml = '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="5" border="0">
<tr height="30" style="color:#fff;" bgcolor="#3A4656">
    <th width="' . ($amountDue ? 20 : 25) . '%;">' . _l('payment_table_invoice_number') . '</th>
    <th width="' . ($amountDue ? 20 : 25) . '%;">' . _l('payment_table_invoice_date') . '</th>
    <th width="' . ($amountDue ? 20 : 25) . '%;">' . _l('payment_table_invoice_amount_total') . '</th>
    <th width="' . ($amountDue ? 20 : 25) . '%;">' . _l('payment_table_payment_amount_total') . '</th>';
    if ($amountDue) {
        $tblhtml .= '<th width="20%">' . _l('invoice_amount_due') . '</th>';
    }

$tblhtml .= '</tr>';

$tblhtml .= '<tbody>';
$tblhtml .= '<tr>';
$tblhtml .= '<td>' . format_invoice_number($payment->invoice_data->id) . '</td>';
$tblhtml .= '<td>' . _d($payment->invoice_data->date) . '</td>';
$tblhtml .= '<td>' . app_format_money($payment->invoice_data->total, $payment->invoice_data->currency_name) . '</td>';
$tblhtml .= '<td>' . app_format_money($payment->amount, $payment->invoice_data->currency_name) . '</td>';
if ($amountDue) {
    $tblhtml .= '<td style="color:#fc2d42">' . app_format_money($payment->invoice_data->total_left_to_pay, $payment->invoice_data->currency_name) . '</td>';
}
$tblhtml .= '</tr>';
$tblhtml .= '</tbody>';
$tblhtml .= '</table>';
$pdf->writeHTML($tblhtml, true, false, false, false, $align);




