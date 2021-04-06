
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style>
    .h5-color {
        color: #d8341b;
    }
    .hr-color {
        margin-top: 10px;
        border-bottom: 0.5px solid;
        color: #d8341b;
    }
</style>
<div id="wrapper">
    <div class="content">
        <div class="row">
        	
			   	<div class="col-md-12">
	        		<div class="panel_s">
	            		<div class="panel-body">
	            			<?php echo form_open_multipart($this->uri->uri_string());
										?>
	            			<?php
	            				foreach($settings as $setting){ ?>
	            					<div class="form-group">
									        <label for="0" class="control-label clearfix">
									            <?php echo _l($setting['name']) ?>        </label>
									        <div class="radio radio-primary radio-inline">
									            <input type="radio" id="y_opt_2_<?php echo $setting['name'] ?>" name="<?php echo $setting['name'] ?>" value="1" <?php if($setting['active'] == '1')echo 'checked' ?>>
									            <label for="y_opt_2_<?php echo $setting['name'] ?>">
									                <?php echo _l('settings_yes') ?>           </label>
									        </div>
									        <div class="radio radio-primary radio-inline">
									                <input type="radio" id="y_opt_2_<?php echo $setting['name'] ?>" name="<?php echo $setting['name'] ?>" value="0" <?php if($setting['active'] == '0')echo 'checked' ?>>
									                <label for="y_opt_2_sub_department">
									                    <?php echo _l('settings_no') ?>                </label>
									        </div>
									    	</div>

	            			<?php	} ?>
                            <h5 class="h5-color"><?php echo _l('hr_contract_prefix'); ?></h5>
                            <hr class="hr-color">
                            <?php echo render_input('hr_contract_prefix','hr_contract_prefix',get_option('hr_contract_prefix')); ?>
                            <?php echo render_input('next_hr_contract_number','next_hr_contract_number',get_option('next_hr_contract_number')); ?>

                            <h5 class="h5-color"><?php echo _l('hr_staff_prefix'); ?></h5>
                            <hr class="hr-color">
                            <?php echo render_input('hr_staff_prefix','hr_staff_prefix',get_option('hr_staff_prefix')); ?>
                            <?php echo render_input('next_hr_staff_number','next_hr_staff_number',get_option('next_hr_staff_number')); ?>


                            <h5 class="h5-color"><?php echo _l('hr_designation_prefix'); ?></h5>
                            <hr class="hr-color">
                            <?php echo render_input('hr_designation_prefix','hr_designation_prefix',get_option('hr_designation_prefix')); ?>
                            <?php echo render_input('next_hr_designation_number','next_hr_designation_number',get_option('next_hr_designation_number')); ?>

                            <div class="btn-bottom-toolbar text-right">
						          <button type="submit" class="btn btn-info">
						            <?php echo _l('settings_save'); ?>
						          </button>
						        </div>
	            			</form>
					   			</div>
							</div>
			   	</div>
            
        </div>
    </div>
</div>
<?php init_tail() ?>


</body>
</html>