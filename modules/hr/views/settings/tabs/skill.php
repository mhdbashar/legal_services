
    	 <?php $this->load->view('settings/modals/skill_type_modal') ?>
				<a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_skill_type"><?php echo 'Add skill type'; ?></a>

				<div class="clearfix"></div>
				<hr class="hr-panel-heading" />
				<div class="clearfix"></div>
       			 <?php render_datatable(array(
			    'option',
			    'Actions',
			    ),'skill'); ?>
        	

				<div class="clearfix"></div>
				<hr class="hr-panel-heading" />
				<div class="clearfix"></div>

<div class="row">
	<div class="col-md-4">
		<a href="?group=education_level" class="btn btn-info pull-left"><?php echo 'ducation level type'; ?></a>
	</div>
	<div class="col-md-4">
		<a href="?group=education" class="btn btn-info pull-left"><?php echo 'education type'; ?></a>
	</div>
	<div class="col-md-4">
		<a href="?group=skill" class="btn btn-success pull-left"><?php echo 'skill type'; ?></a>
	</div>
</div>