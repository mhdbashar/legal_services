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
						<?php echo form_open($this->uri->uri_string()); ?>

						<?php $name = (isset($Judge) ? $Judge->name : ''); ?>
                        <?php echo render_input('name',_l('name'),$name); ?> 

                        <?php $note = (isset($Judge) ? $Judge->note : ''); ?>
                        <?php echo render_textarea('note',_l('note'),$note); ?> 
                        
                        <!-- for testing -->
                        
						<!-- <p class="bold"><?php echo _l('procuration_message'); ?></p> -->
						<!-- <?php $contents = ''; if(isset($procuration)){$contents = $procuration->message;} ?> -->
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
		_validate_form($('form'),{name:'required'});
	});
</script>
</body>
</html>
