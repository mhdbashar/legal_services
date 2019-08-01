<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<div class="_buttons">
							<?php if(is_admin()) { ?>
							<a href="<?php echo admin_url('procuration/procurationcu'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_procuration'); ?></a>
							<div class="clearfix"></div>
							<hr class="hr-panel-heading" />
							<?php } else { echo '<h4 class="no-margin bold">'._l('announcements').'</h4>';} ?>
						</div>
						<div class="clearfix"></div>
						<!-- <?php render_datatable(array(_l('Id'),_l('procuration_state')),'procurationstate'); ?> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
</body>
</html>
