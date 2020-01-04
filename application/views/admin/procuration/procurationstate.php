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
					<?php
                  	$proc_state_custom_fields = false;
                  	if(total_rows(db_prefix().'customfields',array('fieldto'=>'proc_state','active'=>1)) > 0 ){
					   $proc_state_custom_fields = true;
					  }
                   ?>
					<hr class="hr-panel-heading" />
						<?php echo form_open($this->uri->uri_string()); ?>

						<?php $value = (isset($procurationstate) ? $procurationstate->procurationstate : ''); ?>
						<!-- enable language edit -->
                        <?php echo render_input('procurationstate',_l('procuration_state'),$value); ?> 
						
						<!-- custom_fields -->
						<?php if($proc_state_custom_fields) { ?>
						<div role="tabpanel" id="custom_fields">
							<?php $rel_id=( isset($procurationstate) ? $procurationstate->id : false); ?>
							<?php echo render_custom_fields( 'proc_state',$rel_id); ?>
						</div>
						<?php } ?>
                        <!-- for testing -->
                        
						<!-- <p class="bold"><?php echo _l('procurationstate_message'); ?></p> -->
						<!-- <?php $contents = ''; if(isset($procurationstate)){$contents = $procurationstate->message;} ?> -->
						<!-- <?php echo render_textarea('message','',$contents,array(),array(),'','tinymce'); ?> -->

					
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
		_validate_form($('form'),{procurationstate:'required'});
	});
</script>
</body>
</html>
