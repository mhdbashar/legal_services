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
                ' . _l('رقم الدعوى') . ' : ' . $file_number_court . '<br />
                ' . _l('claimant') . ' ' . $client . '<br />
                ' . _l('accused') . ' ' . $opponent . '<br />
                ' . _l('Court') . ' : ' . $court . '
            <h3 style="background-color: silver;text-align: center">معلومات الجلسة</h3>
                <br />
                ' . _l('موضوع الجلسة') . ' : ' . $name . '<br />
                ' . _l('نوع الجلسة') . ' : ' . _l('نوع الجلسة') . '<br />
                ' . _l('تاريخ الجلسة') . ' : ' . $duedate . '<br />
                ' . _l('وقت الجلسة') . ' : ' . $time . '<br />
                ' .  _l('وقائع الجلسة') . ' :  ' . $session_information . '<br />
                ' . _l('قرار المحكمة') . ' :  ' . $court_decision . '
            <h3 style="background-color: silver;text-align: center">معلومات الجلسة القادمة</h3>
                <br /> 
                ' . _l('تاريخ الجلسة القادمة') . ' : ' . $next_session_date . '<br />
                ' . _l('وقت الجلسة القادمة') . ' : ' . $next_session_time . '<br />
    </div>
';
// Theese lines should aways at the end of the document left side. Dont indent these lines
$html = <<<EOF
<div>
$export_candidate
</div>
EOF;
$pdf->writeHTML($html, true, false, true, false, 'L');

//$tbltotal ='
//<div>
//<div class="mtop15 preview-top-wrapper">
//    <div class="row">
//        <div class="col-md-4">
//            <div class="mbot30">
//                <h3 class="text-center">'.get_option("companyname").'</h3>
//            </div>
//        </div>
//        <div class="col-md-4">
//            <div class="mbot30">
//                <div class="" style="margin: 0px 155px 0px 0px">
//                    '.get_dark_company_logo().'
//                </div>
//                <div class="mbot30">
//                    <h3 class="text-center">'. _l("session_report").'
//                    </h3>
//                </div>
//            </div>
//        </div>
//        <div class="col-md-4">
//            <div class="mbot30">
//                <h3 class="text-center">'.get_option("invoice_company_name").'</h3>
//            </div>
//        </div>
//        <div class="clearfix"></div>
//    </div>
//</div>
//<div class="clearfix"></div>
//<div class="panel_s mtop20">
//    <div class="panel-body">
//        <div class="col-md-10 col-md-offset-1">
//            <h3 class="text-center" style="background-color: silver">معلومات القضية</h3>
//            <div class="col-md-12">
//                <div class="col-md-6">
//                </div>
//            </div>
//        </div>
//    </div>
//</div>
//</div>
//';
//
//
//// Theese lines should aways at the end of the document left side. Dont indent these lines
//$html = <<<EOF
//<div style="width:680px !important">
//$tbltotal
//</div>
//EOF;
//$pdf->writeHTML($html, true, false, true, false, $align);





