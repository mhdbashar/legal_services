<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php include_once(APPPATH . '../modules/disputes/views/invoices/invoices_top_stats.php'); ?>
<div class="project_invoices">
    <?php include_once(APPPATH.'../modules/disputes/views/invoices/filter_params.php'); ?>
    <?php $this->load->view('disputes/invoices/list_template'); ?>
</div>