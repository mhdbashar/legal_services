<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
				include_once(APPPATH.'views/admin/invoices/recurring/filter_params.php');
				$this->load->view('admin/invoices/recurring/list_template');
			?>
		</div>
	</div>
</div>
<?php $this->load->view('admin/includes/modals/sales_attach_file'); ?>
<script>var hidden_columns = [5, 7, 8, 9];</script>
<?php init_tail(); ?>
<script>
	$(function(){
		init_invoice();
		init_invoice_case();
		init_invoice_oservice();
	});
</script>
</body>
</html>
