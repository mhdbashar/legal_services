
    	 <?php $this->load->view('settings/modals/deduction_type_modal') ?>
				<a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_deduction_type"><?php echo 'Add deduction type'; ?></a>

				<div class="clearfix"></div>
				<hr class="hr-panel-heading" />
				<div class="clearfix"></div>
       			 <?php render_datatable(array(
			    'option',
			    'Actions',
			    ),'deduction'); ?>
        	