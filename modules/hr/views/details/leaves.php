<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
    	<?php $this->load->view('hr/details/hr_tabs') ?>
    	<div class="panel_s">
            <div class="panel-body">
				<div class="clearfix"></div>
       			 <?php render_datatable(array(
      			            _l('leave_type'),
                        _l('branch'),
                        _l('staff_name'),
                        _l('request_duration'),
                        _l('applied_on'),
                        _l('control'),
			    ),'leaves'); ?>
        	</div>
    	</div>
    </div>
</div>
<?php $this->load->view('timesheet/leaves/modals/leave_modal'); ?>
<?php init_tail() ?>
<script>
   $(function(){
        initDataTable('.table-leaves', window.location.href);
   });
</script>