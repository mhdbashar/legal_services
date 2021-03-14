<?php

defined('BASEPATH') or exit('No direct script access allowed');
if (is_rtl()) {
    $pdf->setRTL(true);
    $align = 'R';
    $text_align = 'right';
}else{
    $pdf->setRTL(false);
    $align = 'L';
    $text_align = 'left';
}
$dimensions = $pdf->getPageDimensions();

$info_right_column = '';
$info_left_column  = '';

$info_left_column .= '<p cellpadding="6" style="font-size:' . ($font_size + 10) . 'px;"> '._l("procuration_number").' :     ' . $NO .'</p>';
$info_left_column .= '<p cellpadding="6" style="font-size:' . ($font_size + 10) . 'px;"> '._l("date").' :     ' . $start_date .'</p>';
$info_left_column .= '<p cellpadding="6" style="font-size:' . ($font_size + 10) . 'px;"> '._l("end_date").' :     ' . $end_date .'</p>';

$info_right_column .= '<span style="font-weight:bold;font-size:27px;">' . $name . '</span><br />';
$info_right_column .= '<b style="color:#4e4e4e;"># ' . $NO . '</b>';

// Add logo
$info_left_column .= pdf_logo_url();

// Write top left logo and right column info/text
pdf_multi_row($info_left_column, $info_right_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);


$organization_info = '<div style="color:#424242;">';

$organization_info .= format_organization_info();

$organization_info .= '</div>';


// $irac_info = '<br />' . _l('date_time') . ' ' . _d($irac->datecreated) . '<br />';

// $left_info  = $swap == '1' ? $irac_info : $organization_info;
// $right_info = $swap == '1' ? $organization_info : $irac_info;

// pdf_multi_row($left_info, $right_info, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

// The Table
// $pdf->Ln(hooks()->apply_filters('pdf_info_and_table_separator', 6));



// $principal = '';
// $principal .= '<p cellpadding="6" style="font-size:' . ($font_size + 10) . 'px; text-align: center"> '._l("principalId").':<br />' . $principalId .'</p>';

// $pdf->writeHTML($principal, true, false, false, false, $align);

// $pdf->Ln(3);


// $agent = '';
// $agent .= '<p cellpadding="6" style="font-size:' . ($font_size + 10) . 'px; text-align: center"> '._l("agentId").':<br />' . $agentId .'</p>';

// $pdf->writeHTML($agent, true, false, false, false, $align);

// $pdf->Ln(8);


// $_start_date = '';
// $_start_date .= '<p cellpadding="6" style="font-size:' . ($font_size + 10) . 'px; text-align: center"> '._l("start_date").':<br />' . $start_date .'</p>';

// $pdf->writeHTML($_start_date, true, false, false, false, $align);

// $pdf->Ln(8);


// $_end_date = '';
// $_end_date .= '<p cellpadding="6" style="font-size:' . ($font_size + 10) . 'px; text-align: center"> '._l("end_date").':<br />' . $end_date .'</p>';

// $pdf->writeHTML($_end_date, true, false, false, false, $align);


$desc = '';
$desc .= '<div><span style="font-size:' . ($font_size + 10) . 'px; text-align: center">'._l("procuration").'</span></div><div style="font-size:' . ($font_size + 7) . 'px;">' . $description .'</div>';

$pdf->writeHTML($desc, true, false, false, false, $align);

// $tbltotal .= '</table>';
// $pdf->writeHTML($tbltotal, true, false, false, false, $align);

//     $pdf->Ln(4);
//     $border = 'border-bottom-color:#000000;border-bottom-width:1px;border-bottom-style:solid; 1px solid black;';
//     $pdf->SetFont($font_name, 'B', $font_size);
//     $pdf->Cell(0, 0, _l('case_info'), 0, 1, $align, 0, '', 0);
//     $pdf->SetFont($font_name, '', $font_size);
//     $pdf->Ln(4);
//     $tblhtml = '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="5" border="0" style="text-align: '.$text_align.'">
//         <tr height="20"  style="color:#000;border:1px solid #000;">
//         <th width="20%;" style="' . $border . '">' . _l('view_date') . '</th>
//         <th width="20%;" style="' . $border . '">' . _l('file_number_in_court') . '</th>
//         <th width="20%;" style="' . $border . '">' . _l('Court') . '</th>
//         <th width="20%;" style="' . $border . '">' . _l('client') . '</th>
//         <th width="20%;" style="' . $border . '">' . _l('staff_members') . '</th>
//     </tr>';
//     $tblhtml .= '<tbody>';
// $member_name = '';
// foreach ($members as $member):
//    $member_name .= get_staff_full_name($member['staff_id']).'<br>';
// endforeach;

//         $tblhtml .= '
//             <tr>
//             <td>' . _d($case_info->start_date) . '</td>
//             <td>' . $case_info->file_number_court . '</td>
//             <td>' . maybe_translate(_l('nothing_was_specified'), $court) . '</td>
//             <td>' . get_company_name($case_info->clientid) . '</td>
//             <td>' . $member_name . '</td>
//             </tr>
//         ';
//     $tblhtml .= '</tbody>';
//     $tblhtml .= '</table>';
//     $pdf->writeHTML($tblhtml, true, false, false, false, '');

// if (!empty($irac->facts)) {
//     $pdf->Ln(4);
//     $pdf->SetFont($font_name, 'B', $font_size);
//     $pdf->Cell(0, 0, _l('facts'), 0, 1, $align, 0, '', 0);
//     $pdf->SetFont($font_name, '', $font_size);
//     $pdf->Ln(2);
//     $pdf->writeHTMLCell('', '', '', '', $irac->facts, 0, 1, false, true, $align, true);
// }

// if (!empty($irac->legal_authority)) {
//     $pdf->Ln(4);
//     $pdf->SetFont($font_name, 'B', $font_size);
//     $pdf->Cell(0, 0, _l('legal_authority'), 0, 1, $align, 0, '', 0);
//     $pdf->SetFont($font_name, '', $font_size);
//     $pdf->Ln(2);
//     $pdf->writeHTMLCell('', '', '', '', $irac->legal_authority, 0, 1, false, true, $align, true);
// }

// if (!empty($irac->analysis)) {
//     $pdf->Ln(4);
//     $pdf->SetFont($font_name, 'B', $font_size);
//     $pdf->Cell(0, 0, _l('analysis'), 0, 1, $align, 0, '', 0);
//     $pdf->SetFont($font_name, '', $font_size);
//     $pdf->Ln(2);
//     $pdf->writeHTMLCell('', '', '', '', $irac->analysis, 0, 1, false, true, $align, true);
// }

// if (!empty($irac->result)) {
//     $pdf->Ln(4);
//     $pdf->SetFont($font_name, 'B', $font_size);
//     $pdf->Cell(0, 0, _l('IRAC_result'), 0, 1, $align, 0, '', 0);
//     $pdf->SetFont($font_name, '', $font_size);
//     $pdf->Ln(2);
//     $pdf->writeHTMLCell('', '', '', '', $irac->result, 0, 1, false, true, $align, true);
// }
