<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (is_rtl()) {
    $align = 'R'; //Right align
    $attr_align = 'right';
    $table_td = "left";
    $text_align = 'right';
}else{
    $align = 'L'; //Left align
    $attr_align = 'right';
    $table_td = "right";
    $text_align = 'left';
}

$dimensions = $pdf->getPageDimensions();

$info_right_column = '';
$info_left_column  = '';


$info_left_column .= '<div>';
$info_left_column .= '<h2 style="font-weight:bold;font-size:20px;">' .get_option("invoice_company_name"). '</h2>';
$info_left_column .= '<br />';
$info_left_column .= '<h3 style="font-weight:bold;font-size:16px;">' ._l("session_report"). '</h3>';
$info_left_column .= '</div>';
$info_right_column .= pdf_logo_url();

pdf_multi_row($info_right_column, $info_left_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$export_candidate='
    <div align="right">
            <h3 style="background-color: silver; text-align: center">معلومات القضية</h3>
                <br />
                ' . _l('file_number_in_court') . ' : ' . $file_number_court . '<br />
                ' . _l('claimant') . ' ' . $client . '<br />
                ' . _l('accused') . ' ' . $opponent . '<br />
                ' . _l('Court') . ' : ' . $court . '
            <h3 style="background-color: silver;text-align: center">معلومات الجلسة</h3>
                <br />
                ' . _l('subject') . ' : ' . $name . '<br />
                ' . _l('session_type') . ' : ' . $type . '<br />
                ' . _l('session_date') . ' : ' . $duedate . '<br />
                ' . _l('session_time') . ' : ' . $time . '<br />
                ' .  _l('session_info') . ' :  ' . $session_information . '<br />
                ' . _l('court_decision') . ' :  ' . $court_decision . '
            <h3 style="background-color: silver;text-align: center">معلومات الجلسة القادمة</h3>
                <br /> 
                ' . _l('next_session_date') . ' : ' . $next_session_date . '<br />
                ' . _l('next_session_time') . ' : ' . $next_session_time . '<br />
    </div>
';
// Theese lines should aways at the end of the document left side. Dont indent these lines
$html = <<<EOF
<div>
$export_candidate
</div>
EOF;
$pdf->writeHTML($html, true, false, true, false, 'L');





