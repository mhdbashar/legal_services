<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (is_rtl()) {
    $align = 'R'; //Right align
    $attr_align = 'right';
    $table_td = "left";
    $text_align = 'right';
} else {
    $align = 'L'; //Left align
    $attr_align = 'right';
    $table_td = "right";
    $text_align = 'left';
}

$text = '<h4  align="center">بسم اللّه الرحمن الرحيم</h4>';
$pdf->writeHTML($text, true, false, true, false);

$image_file = get_option('custom_pdf_header_image_url');
if ($image_file !== '') {
    $pdf->SetMargins(10, 60, 10, true);
}

$image_file_footer = get_option('custom_pdf_footer_image_url');
if ($image_file_footer !== '') {
    $pdf->SetMargins(10, 60, 10, true);
    $pdf->SetAutoPageBreak(TRUE, 60);
}
$dimensions = $pdf->getPageDimensions();

$info_left_column = '<div>';
$info_left_column .= '<h2 style="font-weight:bold;font-size:20px;">' . get_option("invoice_company_name") . '</h2>';
$info_left_column .= '<br />';
$info_left_column .= '<h3 style="font-weight:bold;font-size:16px;">' . _l("session_report") . '</h3>';
$info_left_column .= '</div>';
$info_right_column = pdf_logo_url();
pdf_multi_row($info_right_column, $info_left_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$text = '<h3 style="background-color: silver; text-align: center">معلومات القضية</h3>';
$pdf->writeHTML($text, true, false, true, false);

$info_left_column = '<div align="right">';
$info_left_column .= _l('CaseTitle') . ' : ' . $case_name . '<br />';
$info_left_column .= _l('city') . ' : ' . $city . '<br />';
$info_left_column .= _l('opponent_name') . ' : ' . $opponent . '<br />';
$info_left_column .= '</div>';

$info_right_column = '<div align="right">';
$info_right_column .= _l('file_number_in_court') . ' : ' . $file_number_court . '<br />';
$info_right_column .= _l('customer_name') . ' : ' . $client . '<br />';
$info_right_column .= _l('customer_description') . ' : ' . $representative . '<br />';
$info_right_column .= '</div>';

pdf_multi_row($info_left_column,$info_right_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$text = '<h3 style="background-color: silver; text-align: center">معلومات المحكمة</h3>';
$pdf->writeHTML($text, true, false, true, false);

$info_left_column = '<div align="right">';
$info_left_column .= _l('NumJudicialDept') . ' : ' . $dept . '<br />';
$info_left_column .= _l('SubCategories') . ' : ' . $subcat_id . '<br />';
$info_left_column .= '</div>';

$info_right_column = '<div align="right">';
$info_right_column .= _l('Court') . ' : ' . $court . '<br />';
$info_right_column .= _l('Categories') . ' : ' . $cat_id . '<br />';
$info_right_column .= _l('child_sub_categories') . ' : ' . $childsubcat_id . '<br />';
$info_right_column .= '</div>';
pdf_multi_row($info_left_column,$info_right_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$text = '<h3 style="background-color: silver; text-align: center">معلومات الجلسة</h3>';
$pdf->writeHTML($text, true, false, true, false);

$info_left_column = '<div align="right">';
$info_left_column .= _l('session_date') . ' : ' . $duedate . '<br />';
$info_left_column .= _l('session_time') . ' : ' . $time . '<br />';
$info_left_column .= '</div>';

$info_right_column = '<div align="right">';
$info_right_column .= _l('subject') . ' : ' . $name . '<br />';
$info_right_column .= _l('session_type') . ' : ' . $type . '<br /><br />';
$info_right_column .= '</div>';
pdf_multi_row($info_left_column,$info_right_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$text = '<div align="right">';
$text .= _l('session_info') . ' : ' . $session_information . '<br /><br />';
$text .= _l('court_decision') . ' : ' . $court_decision . '<br />';
$text .= '</div>';
$pdf->writeHTML($text, true, false, true, false);

if (count($checklist_items) > 0) {
    $export_candidate = '<h3 style="background-color: silver;text-align: center">' . _l('add_checklist_item') . '</h3><br /><br />';
    $i = 1;
    foreach ($checklist_items as $list) {
        $export_candidate .= $i . ' - ' . $list['description'];
        $export_candidate .= '<br />';
        $i++;
    }
    $pdf->writeHTML($export_candidate, true, false, true, false,'R');
}

$text = '<h3 style="background-color: silver; text-align: center">معلومات الجلسة القادمة</h3>';
$pdf->writeHTML($text, true, false, true, false);

$info_left_column = '<div align="right">';
$info_left_column .= _l('next_session_time') . ' : ' . $next_session_time . '<br />';
$info_left_column .= '</div>';

$info_right_column = '<div align="right">';
$info_right_column .= _l('next_session_date') . ' : ' . $next_session_date . '<br />';
$info_right_column .= '</div>';
pdf_multi_row($info_left_column,$info_right_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

// Theese lines should aways at the end of the document left side. Dont indent these lines
$html = <<<EOF
<div>
</div>
EOF;
$pdf->writeHTML($html, true, false, true, false, 'R');





