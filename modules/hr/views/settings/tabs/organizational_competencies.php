
    	 <?php $this->load->view('settings/modals/organizational_competencies_type_modal') ?>
				<a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_organizational_competencies_type"><?php echo _l('add_organizational_competencie_type'); ?></a>

				<div class="clearfix"></div>
				<hr class="hr-panel-heading" />
				<div class="clearfix"></div>
       			 <?php render_datatable(array(
			    _l('option'),
			    _l('control'),
			    ),'organizational_competencies'); ?>
        	