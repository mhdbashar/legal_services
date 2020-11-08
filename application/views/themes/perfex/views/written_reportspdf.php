<?php defined('BASEPATH') or exit('No direct script access allowed');
if (is_rtl()) {
    $align = 'R';
    $text_align = 'right';
}else{
    $align = 'L';
    $text_align = 'left';
}
$dimensions = $pdf->getPageDimensions();

$info_right_column = '';
$info_left_column  = '';

$info_right_column .= '<span style="font-weight:bold;font-size:27px;">' . _l('written_reports') . '</span><br />';
//$info_right_column .= '<b style="color:#4e4e4e;"># ' . //$report->report . '</b>';

// Add logo
$info_left_column .= pdf_logo_url();

// Write top left logo and right column info/text
pdf_multi_row($info_left_column, $info_right_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$pdf->ln(10);

$organization_info = '<div style="color:#424242;">';

$organization_info .= format_organization_info();

$organization_info .= '</div>';


// The Table
$pdf->Ln(hooks()->apply_filters('pdf_info_and_table_separator', 6));

$pdf->Ln(8);

$tbltotal = '';
$tbltotal .= '<table cellpadding="6" style="font-size:' . ($font_size + 4) . 'px">';


$tbltotal .= '</table>';
$pdf->writeHTML($tbltotal, true, false, false, false, $align);

$pdf->Ln(4);
$border = 'border-bottom-color:#000000;border-bottom-width:1px;border-bottom-style:solid; 1px solid black;';
$pdf->SetFont($font_name, 'B', $font_size);
//$pdf->Cell(0, 0, _l('report'), 0, 1, $align, 0, '', 0);
$pdf->SetFont($font_name, '', $font_size);
$pdf->Ln(4);
$tblhtml = '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="5" border="0" style="text-align: '.$text_align.'">
        <tr height="20"  style="color:#000;border:1px solid #000;">
        <th width="20%;" style="' . $border . '">' ._l('added_from').' '._l('staff_member_lowercase') . '</th>
        <th width="20%;" style="' . $border . '">' . _l('date_created') . '</th>
        <th width="20%;" style="' . $border . '">' . _l('updated_by_staff') . '</th>
        <th width="20%;" style="' . $border . '">' . _l('date_updated') . '</th>     
    </tr>';
$tblhtml .= '<tbody>';

$tblhtml .= '
            <tr>
            <td>' . get_staff_full_name($report->addedfrom). '</td>
            <td>' . _dt($report->created_at). '</td>
            <td>' . get_staff_full_name($report->updatedfrom) . '</td>
            <td>' . _dt($report->updated_at). '</td>  
            </tr>
        ';
$tblhtml .= '</tbody>';
$tblhtml .= '</table>';
$pdf->writeHTML($tblhtml, true, false, false, false, '');

$report_info = '';

$left_info  = $swap == '1' ? $report_info : $organization_info;
$right_info = $swap == '1' ? $organization_info : $report_info;

pdf_multi_row($left_info, $right_info, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$pdf->Ln(4);
$pdf->SetFont($font_name, 'B', $font_size);
$pdf->Cell(0, 0, _l('report'), 0, 1, $align, 0, '', 0);
$pdf->SetFont($font_name, '', $font_size);
$pdf->Ln(2);
$pdf->writeHTMLCell('', '', '', '', $report->report, 0, 1, false, true, $align, true);
