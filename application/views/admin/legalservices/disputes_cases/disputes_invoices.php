<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php include_once(APPPATH . '../application/views/admin/legalservices/disputes_cases/invoices/invoices_top_stats.php'); ?>
<div class="project_invoices">
    <?php include_once(APPPATH.'../application/views/admin/legalservices/disputes_cases/invoices/filter_params.php'); ?>
    <?php $this->load->view('admin/legalservices/disputes_cases/invoices/list_template'); ?>
</div>