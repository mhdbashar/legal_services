<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<div class="_buttons">
							<?php if (has_permission('procurations', '', 'create') || is_admin()) { ?>
							<a href="<?php echo admin_url('procuration/typecu'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_procuration_type'); ?></a>
							<?php } ?>
							<div class="clearfix"></div>
							<hr class="hr-panel-heading" />
							<?php render_datatable(array(_l('Id'),_l('procuration_type')),'procurationtype');  ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script>
   $(function(){
	initDataTable('.table-procurationtype', admin_url + 'procuration/type', undefined, undefined, 'undefined', [0, 'desc']);
   });

</script>
</body>
</html>
