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
						<?php $value = (isset($phase) ? $phase->name : ''); ?>
                        <?php echo render_input('name',_l('name'),$value); ?>
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
