<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php include_once(APPPATH . 'views/admin/legalservices/disputes_cases/invoices/invoices_top_stats.php'); ?>
<div class="project_invoices">
    <?php include_once(APPPATH.'views/admin/legalservices/disputes_cases/invoices/filter_params.php'); ?>
    <?php $this->load->view('admin/legalservices/disputes_cases/invoices/list_template'); ?>
</div>

<?php //init_head(); ?>
<!--<div id="wrapper">-->
<!--	<div class="content">-->
<!--		<div class="row">-->
<!--			--><?php
//			include_once(APPPATH.'../modules/disputes/views/invoices/filter_params.php');
//			$this->load->view('disputes/invoices/list_template');
//			?>
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
<?php //$this->load->view('admin/includes/modals/sales_attach_file'); ?>
<script>var hidden_columns = [2,6,7,8];</script>
<?php //init_tail(); ?>
<script>
    // $(function(){
    //
    //     init_invoice_disputes();
    //
    // });
    // $(function(){
    //     init_invoice();
    //     init_invoice_case();
    //     init_invoice_oservice();
    //     init_invoice_disputes();
    //
    // });

	function record_payment_disputes(id) {
    	if (typeof(id) == 'undefined' || id === '') { return; }
    	$('#invoice').load(admin_url + 'legalservices/disputes_invoices/record_invoice_payment_ajax/' + id);
	}


	// Init single invoice

</script>
</body>
</html>
