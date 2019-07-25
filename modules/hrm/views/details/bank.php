<?php
	
	if($this->input->is_ajax_request())
        $this->hrmapp->get_table_data('my_bank_table');

?>

<div class="col-md-9">
	<div class="panel_s">
        <div class="panel-body">
	        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_bank">
	            Add New Bank
	        </button>
	        <div class="clearfix"></div>
	        <hr class="hr-panel-heading" />
	        <div class="clearfix"></div>
			<?php render_datatable(array(
	            'Bank Name',
	            'Account Name',
	            'Routing Number',
	            'Account Number',
	            'Options',
	        ),'bank'); 
			$this->load->view('modals/bank', ['staff_id' => $user_id]);
	        ?>
		</div>
	</div>
</div>