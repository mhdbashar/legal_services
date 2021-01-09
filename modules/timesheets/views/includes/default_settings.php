<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" rel="stylesheet">

<div>
	<?php echo form_open(admin_url('timesheets/default_settings'),array('id'=>'default_settings-form')); ?>
	<div class="col-md-12">
		<?php 
		$data_attendance_notice_recipient = [];
		$data_attendance = get_timesheets_option('attendance_notice_recipient');
		if($data_attendance){
			$data_attendance_notice_recipient = explode(',', $data_attendance);
		}

		$allows_updating_check_in_time = 0;
		$data_allows_updating = get_timesheets_option('allows_updating_check_in_time');
		if($data_allows_updating){
			$allows_updating_check_in_time = $data_allows_updating;
		}

		$allows_to_choose_an_older_date = 0;
		$data_older_date = get_timesheets_option('allows_to_choose_an_older_date');
		if($data_older_date){
			$allows_to_choose_an_older_date = $data_older_date;
		}
		?>
		<div class="row">
			<div class="col-md-12">
				<?php echo render_select('attendance_notice_recipient[]', $staff, array('staffid', array('firstname', 'lastname')),'attendance_notice_recipient', $data_attendance_notice_recipient, array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
				?>   	  	
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="checkbox">							
					<input type="checkbox" class="capability" name="allows_updating_check_in_time" value="1" <?php if($allows_updating_check_in_time == 1){ echo "checked"; } ?>>
					<label><?php echo _l('allows_updating_check_in_time'); ?></label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="checkbox">							
					<input type="checkbox" class="capability" name="allows_to_choose_an_older_date" value="1" <?php if($allows_to_choose_an_older_date == 1){ echo "checked"; } ?>>
					<label><?php echo _l('allows_to_choose_an_older_date'); ?></label>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<br>
	<div class="clearfix"></div>

	<div class="col-md-12">
		<?php if(is_admin() || has_permission('timesheets_default_settings','','edit')){ ?>
			<button class="btn btn-info pull-right save_time_sheet"><?php echo _l('submit'); ?></button>
		<?php } ?>
	</div>
	<?php echo form_close(); ?>

</body>
</html>
