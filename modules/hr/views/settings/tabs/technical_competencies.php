
    	 <?php $this->load->view('settings/modals/technical_competencies_type_modal') ?>
				<?php if (has_permission('hr', '', 'create')){ ?><a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_technical_competencies_type"><?php echo _l('add_technical_competencie_type'); ?></a>
<?php } ?>
				<div class="clearfix"></div>
				<hr class="hr-panel-heading" />
				<div class="clearfix"></div>
       			 <?php render_datatable(array(
			    _l('option'),
			    _l('control'),
			    ),'technical_competencies'); ?>
        	