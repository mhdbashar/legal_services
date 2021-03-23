
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php

?>
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

	            					
	            					<br>
	            			<?php	} ?>
                            <hr />
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