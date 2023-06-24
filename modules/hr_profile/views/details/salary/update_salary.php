<div class="bold h4"><?php echo _l('update_salary') ?></div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php echo form_open(admin_url('hr_profile/update_salary'),array('id'=>'form_transout')); ?>
 	<?php echo form_hidden('staff_id', $staff_id); ?>

	<div class="row">
		<div class="col-md-6">
			<div class="select-placeholder form-group">
				<label for="type" class="control-label"><?php echo _l('payslip_type') ?></label><br>
				<select id="type" name="type" class="selectpicker">
		          	<option <?php if($staff->type == 1) echo 'selected="selected"' ?> value="1"><?php echo _l('monthly_payslip') ?></option> 
		          	<option <?php if($staff->type == 2) echo 'selected="selected"' ?> value="2"><?php echo _l('hourly_payslip') ?></option>  		                    
			    </select>
		    </div>
		</div>
		<div class="col-md-6">
			<?php echo render_input('amount', 'amount', $staff->amount) ?>
		</div>
	</div>
	<button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
</form>
		<?php ?>