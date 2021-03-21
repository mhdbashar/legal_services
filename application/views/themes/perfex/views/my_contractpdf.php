<?php defined('BASEPATH') or exit('No direct script access allowed');
if (is_rtl()) {
    $this->setRTL(true);
    $align = 'R'; //Right align
}else{
    $this->setRTL(false);
    $align = 'L'; //Left align
}
// Theese lines should aways at the end of the document left side. Dont indent these lines
$html = <<<EOF
<div style="width:680px !important">
$contract->content
</div>
EOF;
$pdf->writeHTML($html, true, false, true, false, $align);