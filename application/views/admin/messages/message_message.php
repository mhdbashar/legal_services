<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


                        
                 
					<hr class="hr-panel-heading" />
					
										<?php echo form_open_multipart($this->uri->uri_string()); ?>
                        <input type="hidden"  name="from_user_id" value="<?php echo get_staff_user_id()?>">
						
	
                        
	
						<?php echo render_textarea('message', _l('الرسالة'), '', array(), array(), '', 'tinymce'); ?>
                        <!-- for testing -->
                        
						<div class="form-group" >
                        <label for="profile_image" class="profile-image"><?php echo _l('attachment'); ?></label>
                        <input type="file" name="files" class="form-control" id="profile_image">
                    </div>
					
						<button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
						<?php echo form_close(); ?>
						

