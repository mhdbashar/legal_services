<?php defined('BASEPATH') or exit('No direct script access allowed');
if (is_rtl()) {
    $this->setRTL(true);
    $align = 'R'; //Right align
}else{
    $this->setRTL(false);
    $align = 'L'; //Left align
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

if ($contract->signed == 1) {
    $contract->content .= '<div style="font-weight:bold;text-align: right;">';
    $contract->content .= '<p>' . _l('contract_signed_by') . ": {$contract->acceptance_firstname} {$contract->acceptance_lastname}</p>";
    $contract->content .= '<p>' . _l('contract_signed_date') . ': ' . _dt($contract->acceptance_date) . '</p>';
    $contract->content .= '<p>' . _l('contract_signed_ip') . ": {$contract->acceptance_ip}</p>";
    $contract->content .= '</div>';
}

// Theese lines should aways at the end of the document left side. Dont indent these lines
$html = <<<EOF
<div style="width:680px !important">
$contract->content
</div>
EOF;
$pdf->writeHTML($html, true, false, true, false, $align);