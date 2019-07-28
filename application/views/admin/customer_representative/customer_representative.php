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
                  	$representative_custom_fields = false;
                  	if(total_rows(db_prefix().'customfields',array('fieldto'=>'cust_repres','active'=>1)) > 0 ){
					   $representative_custom_fields = true;
					  }
                   ?>
					<hr class="hr-panel-heading" />
						<?php echo form_open($this->uri->uri_string()); ?>

						<?php $value = (isset($customer_representative) ? $customer_representative->representative : ''); ?>
						<!-- enable language edit -->
                        <?php echo render_input('representative','customer_representative',$value); ?> 
						
						<!-- custom_fields -->
						<?php if($representative_custom_fields) { ?>
						<div role="tabpanel" id="custom_fields">
							<?php $rel_id=( isset($customer_representative) ? $customer_representative->id : false); ?>
							<?php echo render_custom_fields( 'cust_repres',$rel_id); ?>
						</div>
						<?php } ?>

					
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
		_validate_form($('form'),{representative:'required'});
	});
</script>
</body>
</html>
