
    	 <?php $this->load->view('settings/modals/relation_type_modal') ?>
				<a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_relation_type"><?php echo 'Add relation type'; ?></a>

				<div class="clearfix"></div>
				<hr class="hr-panel-heading" />
				<div class="clearfix"></div>
       			 <?php render_datatable(array(
			    'option',
			    'Actions',
			    ),'relation'); ?>
        	