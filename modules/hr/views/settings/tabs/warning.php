
    	 <?php $this->load->view('settings/modals/warning_type_modal') ?>
				<a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_relation_type"><?php echo _l('add_warning_type'); ?></a>

				<div class="clearfix"></div>
				<hr class="hr-panel-heading" />
				<div class="clearfix"></div>
       			 <?php render_datatable(array(
			    _l('option'),
			    _l('control'),
			    ),'warning'); ?>
        	