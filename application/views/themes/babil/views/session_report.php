<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$CI = &get_instance();
$CI->load->library('app_modules');
$session->startdate = $CI->app_modules->is_active('hijri') ? _d($session->startdate) . _l('correspond') . to_hijri_date(_d($session->startdate)) : _d($session->startdate);
$session->next_session_date = $CI->app_modules->is_active('hijri') ? _d($session->next_session_date) . _l('correspond') . to_hijri_date(_d($session->next_session_date)) : _d($session->next_session_date);

$time_format = get_option('time_format');
$session->time = $time_format === '24' ? date('h:i', strtotime($session->time)) : date('h:i a', strtotime($session->time));
$session->next_session_time = $time_format === '24' ? date('h:i', strtotime($session->next_session_time)) : date('h:i a', strtotime($session->next_session_time));
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Reem+Kufi">
<div class="mtop15 preview-top-wrapper">
    <?php echo form_open($this->uri->uri_string()); ?>
    <button type="submit" name="invoicepdf" value="invoicepdf"
            class="btn btn-default pull-right action-button mtop5">
        <i class='fa fa-file-pdf-o'></i>
        <?php echo _l('clients_invoice_html_btn_download'); ?>
    </button>
    <?php echo form_close(); ?>
</div>
<div class="clearfix"></div>
<div class="panel_s mtop20">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="mbot30">
                    <div class="mbot30">
                        <h4 class="text-center" style="font-family: 'Reem Kufi'">بسم اللّه الرحمن الرحيم</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mbot30">
                    <h2 class="text-center"><?php echo get_option('invoice_company_name'); ?></h2>
                    <br>
                    <div class="mbot30">
                        <h4 class="text-center"><?php echo _l('session_report'); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mbot30">
                    <div class="" style="margin: 0px 200px 0px 0px">
                        <?php echo get_dark_company_logo(); ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <h3 class="text-center" style="background-color: silver"><?php echo '' ?>معلومات القضية</h3>
            <div class="col-md-12">
                <div class="col-md-6">
                    <p style="font-weight: bold"> <?php echo _l('file_number_in_court') . ' : '; ?>
                        <b><?php echo isset($session->file_number_court)?$session->file_number_court:''; ?></b></p>
                    <p style="font-weight: bold"> <?php echo _l('customer_name') . ' : '; ?>
                        <b><?php echo isset($session->clientid) ? get_customer_by_id($session->clientid)->company : ''; ?></b>
                    </p>
                    <p style="font-weight: bold"> <?php echo _l('customer_description') . ' : '; ?>
                        <b><?php echo isset($session->representative) ? get_representative_by_id($session->representative) : ''; ?></b>
                    </p>
                </div>
                <div class="col-md-6">
                    <p style="font-weight: bold"> <?php echo _l('CaseTitle') . ' : '; ?>
                        <b><?php echo isset($session->case_name) && $session->case_name != '' ? $session->case_name : '' ?> </b>
                    </p>
                    <p style="font-weight: bold"> <?php echo _l('city') . ' : '; ?>
                        <b><?php echo isset($session->city) && $session->city != '' ? $session->city : ''; ?> </b>
                    </p>
                    <p style="font-weight: bold"> <?php echo _l('opponent_name') . ' : '; ?>
                        <b><?php echo isset($session->opponent_id) && $session->opponent_id != 0 ? get_customer_by_id($session->opponent_id)->company : ''; ?> </b>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <h3 class="text-center" style="background-color: silver"><?php echo '' ?>معلومات المحكمة</h3>
            <div class="col-md-12">
                <div class="col-md-6">
                    <p style="font-weight: bold"> <?php echo _l('Court') . ' : '; ?>
                        <b><?php echo isset($session->court_id) && $session->court_id != 0 ? get_court_by_id($session->court_id)->court_name : '' ?> </b>
                    </p>
                    <p style="font-weight: bold"> <?php echo _l('Categories') . ' : '; ?>
                        <b><?php echo isset($session->cat_id) && $session->cat_id != 0 ? get_cat_name_by_id($session->cat_id) : '' ?> </b>
                    </p>
                    <p style="font-weight: bold"> <?php echo _l('child_sub_categories') . ' : '; ?>
                        <b><?php echo isset($session->childsubcat_id) && $session->childsubcat_id != 0 ? get_cat_name_by_id($session->childsubcat_id) : '' ?> </b>
                    </p>
                </div>
                <div class="col-md-6">
                    <p style="font-weight: bold"> <?php echo _l('NumJudicialDept') . ' : '; ?>
                        <b><?php echo isset($session->dept) && $session->dept != '' ? get_judicialdept_by_id($session->dept)->Jud_number : ''; ?> </b>
                    </p>
                    <p style="font-weight: bold"> <?php echo _l('SubCategories') . ' : '; ?>
                        <b><?php echo isset($session->subcat_id) && $session->subcat_id != 0 ? get_cat_name_by_id($session->subcat_id) : '' ?> </b>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-10 col-md-offset-1">
            <h3 class="text-center" style="background-color: silver"><?php echo '' ?>معلومات الجلسة</h3>
            <div class="col-md-12">
                <div class="col-md-6">
                    <p style="font-weight: bold"> <?php echo _l('subject') . ' :'; ?>
                        <b><?php echo $session->name; ?></b></p>
                    <p style="font-weight: bold"> <?php echo _l('session_type') . ' :'; ?>
                        <b><?php echo $session->session_type; ?></b></p>
                </div>
                <div class="col-md-6">
                    <p style="font-weight: bold"> <?php echo _l('session_date') . ' :'; ?>
                        <b><?php echo $session->startdate; ?></b></p>
                    <p style="font-weight: bold"> <?php echo _l('session_time') . ' :'; ?>
                        <b><?php echo $session->time; ?></b></p>
                </div>
                <div class="col-md-12">
                    <hr class="hr-panel-heading"/>
                    <p style="font-weight: bold"> <?php echo _l('session_info') . ' :'; ?>
                    <div class="hr-panel-heading"></div>
                    <b><?php echo $session->session_information; ?></b></p>
                </div>
                <div class="col-md-12">
                    <hr class="hr-panel-heading"/>
                    <p style="font-weight: bold"> <?php echo _l('court_decision') . ' :'; ?>
                    <div class="hr-panel-heading"></div>
                    <b><?php echo $session->court_decision; ?></b></p>
                </div>
            </div>
        </div>
        <?php if (count($session->checklist_items) > 0) {
            $i = 1; ?>
            <div class="col-md-10 col-md-offset-1">
                <h3 class="text-center" style="background-color: silver"><?php echo _l('add_checklist_item') ?></h3>
                <div class="col-md-12">
                    <?php foreach ($session->checklist_items as $list) { ?>
                        <p style="font-weight: bold"> <?= $i . ' - ' . $list['description'] ?></p>
                        <?php $i++;
                    } ?>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-10 col-md-offset-1">
            <h3 class="text-center" style="background-color: silver"><?php echo '' ?>معلومات الجلسة القادمة</h3>
            <div class="col-md-12">
                <div class="col-md-6">
                    <p style="font-weight: bold"> <?php echo _l('next_session_date') . ' :'; ?>
                        <b><?php echo $session->next_session_date; ?></b></p>
                </div>
                <div class="col-md-6">
                    <p style="font-weight: bold"> <?php echo _l('next_session_time') . ' :'; ?>
                        <b><?php echo $session->next_session_time; ?></b></p>
                </div>
            </div>
        </div>
    </div>
</div>
