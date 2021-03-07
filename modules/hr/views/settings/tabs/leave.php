
    	 <?php $this->load->view('settings/modals/leave_type_modal') ?>
				<?php if (has_permission('hr_settings', '', 'create')){ ?><a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_leave_type"><?php echo _l('add_leave_type'); ?></a>
<?php } ?>
				<div class="clearfix"></div>
				<hr class="hr-panel-heading" />
				<div class="clearfix"></div>
       			 <?php render_datatable(array(
			    _l('name'),
			    _l('number_of_days'),
			    _l('control'),
			    ),'leave'); ?>
        	