<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
    	 <?php $this->load->view('settings/modals/deduction_type_modal') ?>
    	<div class="panel_s">
            <div class="panel-body">

				<a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_deduction_type"><?php echo 'Add deduction type'; ?></a>

				<div class="clearfix"></div>
				<hr class="hr-panel-heading" />
				<div class="clearfix"></div>
       			 <?php render_datatable(array(
			    'option',
			    'Actions',
			    ),'options'); ?>
        	</div>
    	</div>
    </div>
</div>
<?php init_tail() ?>
<script>
   $(function(){
        initDataTable('.table-options', window.location.href);
   });
</script>