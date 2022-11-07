<?php

defined('BASEPATH') or exit('No direct script access allowed');

trait PDF_Signature
{








    public function process_signature()
    {

        if(is_rtl() &&  ($this->type() == 'contract' && get_option('show_pdf_signature_contract') == 1)){
            $this->setRTL(true);
            $align = 'R';
        }
        elseif (is_rtl()) {
            $this->setRTL(false);
            $align = 'L'; //Right align
        }
        else{
            $this->setRTL(false);
            $align = 'L'; //Left align
        }

        $dimensions       = $this->getPageDimensions();
        $leftColumnExists = false;

        if (($this->type() == 'invoice' && get_option('show_pdf_signature_invoice') == 1)
            || ($this->type() == 'estimate' && get_option('show_pdf_signature_estimate') == 1)
            || ($this->type() == 'contract' && get_option('show_pdf_signature_contract') == 1)
            || ($this->type() == 'credit_note') && get_option('show_pdf_signature_credit_note') == 1) {
            $signatureImage = get_option('signature_image');

            $signaturePath   = FCPATH . 'uploads/company/' . $signatureImage;
            $signatureExists = file_exists($signaturePath);

            $blankSignatureLine = hooks()->apply_filters('blank_signature_line', '_________________________');

            if ($signatureImage != '' && $signatureExists) {
                $blankSignatureLine = '';
            }

            $this->ln(8);

            if ($signatureImage != '' && $signatureExists) {
                $imageData = base64_encode(file_get_contents($signaturePath));
                $blankSignatureLine .= str_repeat('<br />', hooks()->apply_filters('pdf_signature_break_lines', 1)) . '<img style="width:130px !important; " src="@' . $imageData . '"  >';

            }


            if(is_rtl() &&  ($this->type() == 'contract' && get_option('show_pdf_signature_contract') == 1)){
                $this->SetX(($dimensions['wk'] / 6) - $dimensions['lm']);
                $this->MultiCell(($dimensions['wk'] / 2) - $dimensions['lm'], 0, $blankSignatureLine  , 0, 'R', 0, 0, '', '', true, 0, true, true, 0);

                $this->SetAlpha(0.5);


                $this->SetDrawColor(0,255,48);
                // $this->Rect(($dimensions['wk'] / 10) - $dimensions['lm'], 0, 16, 8);
                //$this->Rotate(20,0,0);

                $this->SetX(($dimensions['wk'] / 10) - $dimensions['lm']);
                $this->Rotate(15);
                $this->MultiCell(($dimensions['wk'] / 2) - $dimensions['lm'], 0,'<div style="font-size:40px;color: #00ff30;opacity:2;" >'. _l('معتمد').'</div>', 0, 'R', 0, 0, '', '', true, 0, true, true, 0);



            }

            else {


                $this->MultiCell(($dimensions['wk'] / 2) - $dimensions['lm'], 0, $blankSignatureLine  , 0, 'L', 0, 0, '', '', true, 0, true, true, 0);
                $this->SetAlpha(0.5);


                $this->SetDrawColor(0,255,48);
                // $this->Rect(($dimensions['wk'] / 10) - $dimensions['lm'], 0, 16, 8);

                $this->SetX(14);
                $this->Rotate(15);
                $this->MultiCell(($dimensions['wk'] / 2) - $dimensions['lm'], 0,'<div style="font-size:45px;color: #00ff30;opacity:2;" >'. _l('معتمد').'</div>', 0, 'L', 0, 0, '', '', true, 0, true, true, 0);


            }

            $leftColumnExists = true;






        }

        $customerSignaturePath = '';

        if (isset($GLOBALS['estimate_pdf']) && !empty($GLOBALS['estimate_pdf']->signature)) {
            $estimate              = $GLOBALS['estimate_pdf'];
            $customerSignaturePath = get_upload_path_by_type('estimate') . $estimate->id . '/' . $estimate->signature;
        } elseif (isset($GLOBALS['proposal_pdf']) && !empty($GLOBALS['proposal_pdf']->signature)) {
            $proposal              = $GLOBALS['proposal_pdf'];
            $customerSignaturePath = get_upload_path_by_type('proposal') . $proposal->id . '/' . $proposal->signature;
        } elseif (isset($GLOBALS['contract_pdf']) && !empty($GLOBALS['contract_pdf']->signature)) {
            $contract              = $GLOBALS['contract_pdf'];
            $customerSignaturePath = get_upload_path_by_type('contract') . $contract->id . '/' . $contract->signature;
        }

        $customerSignaturePath = hooks()->apply_filters(
            'pdf_customer_signature_image_path',
            $customerSignaturePath,
            $this->type()
        );






















        if (!empty($customerSignaturePath) && file_exists($customerSignaturePath)) {
            $customerSignature = _l('document_customer_signature_text');

            $imageData = base64_encode(file_get_contents($customerSignaturePath));

            $customerSignature .= str_repeat('<br />', hooks()->apply_filters('pdf_signature_break_lines', 1)) . '<img src="@' . $imageData . '">';
            $width = ($dimensions['wk'] / 2) - $dimensions['rm'];

            if (!$leftColumnExists) {
                $width = $dimensions['wk'] - ($dimensions['rm'] + $dimensions['lm']);
                $this->ln(13);
            }

            $hookData = ['pdf_instance' => $this, 'type' => $this->type(), 'signatureCellWidth' => $width];

            hooks()->do_action('before_customer_pdf_signature', $hookData);
            $this->MultiCell($width, 0, $customerSignature, 0, 'R', 0, 1, '', '', true, 0, true, false, 0);
            hooks()->do_action('after_customer_pdf_signature', $hookData);
        }
    }



















}
