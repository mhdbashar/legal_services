
<?php if (has_permission('procurations', '', 'create') || is_admin()) { ?>
<a href="<?php echo admin_url('procuration/procurationcu/'.$project->clientid.'/no_id/'.$id); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_procuration'); ?></a>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<?php } ?>
<?php
 render_datatable(array(
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
),'case-procuration'); ?>

<?php $this->load->view('admin/procuration/modal'); ?>
