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
						
	
إختر الزبون

		  <select class='form-control' name="to_user_id" required>
		  <option></option>
			<?php
			  foreach($contacts as $contact){
				if($contact->id == get_contact_user_id()){
					continue;
				}
						   ?>
						   
						  <option value="<?php  echo $contact->id.'_client'; ?>">
							  <?php

echo $contact->firstname.' ';
echo $contact->lastname.' ';
						 

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
