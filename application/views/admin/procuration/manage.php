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
							<a href="<?php echo admin_url('procuration/procurationcu'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_procuration'); ?></a>
							<div class="clearfix"></div>
							<hr class="hr-panel-heading" />
							<?php } ?>
						</div>
						<div class="clearfix"></div>
						<?php render_datatable(array(
                            _l('name'),
                            _l('come_from'),
							_l('procuration_number'),
							_l('start_date'),
							_l('end_date'),
							_l('case_id'),
							_l('added_from'),
							_l('type'),
							_l('status'),
							_l('control'),
						),'procurations'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('admin/procuration/modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-procurations', window.location.href);
   });
</script>
</body>
</html>
