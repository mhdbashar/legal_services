<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel_s">
					<div class="panel-body">
					<h4 class="no-margin">
					<?php echo $title; ?>
					</h4>

                        
                 
					<hr class="hr-panel-heading" />
					
						<?php echo form_open_multipart($this->uri->uri_string()); ?>
                        <input type="hidden"  name="from_user_id" value="<?php echo get_staff_user_id()?>">
						
		إختر الموظف
                           <!-- <php   echo form_dropdown("to_user_id", $users_dropdown, array(), "class='form-control select2 validate-hidden' id='to_user_id' data-rule-required='true', data-msg-required='" . 'field_required' . "'"); >-->
					



							<select class='form-control' name="to_user_id" required>
							<option></option>
			<?php
			  foreach($staffs as $staff){
				
				if($staff->staffid == get_staff_user_id()){
					continue;
				}
						   ?>
						  
						  <option value="<?php  echo $staff->staffid.'_staff'; ?>">
							  <?php

echo $staff->firstname.' ';
echo $staff->lastname.' ';
						 

							  ?>
						  </option>
						  <?php

			  }
			?>

		  </select>





						<?php $subject = (isset($Message) ? $Message->subject : ''); ?>
                        <?php echo render_input('subject',_l('الموضوع'),$subject,"textbox"); ?> 

                        <?php $message = (isset($Message) ? $Message->message : ''); ?>
                    
						<?php echo render_textarea('message', _l('الرسالة'), '', array(), array(), '', 'tinymce'); ?>
                        <!-- for testing -->
                        
						<div class="form-group" >
                        <label for="profile_image" class="profile-image"><?php echo _l('attachment'); ?></label>
                        <input type="file" name="files" class="form-control" id="profile_image">
                    </div>
					
						<button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
						<?php echo form_close(); ?>
				
						

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script>
	$(function(){
		_validate_form($('form'),{name:'required'});
		$('Textarea').prop('required',true);
		$("input[name='subject']").attr("required", "true");

	});
</script>
</body>
</html>
