<?php if (has_permission('procurations', '', 'create')) { ?>
<a href="<?php echo admin_url('procuration/procurationcu/'.$project->clientid.'/no_id/'.$id); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_procuration'); ?></a>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<?php } ?>
<?php // } else { echo '<h4 class="no-margin bold">'._l('announcements').'</h4>';} ?>
<?php
// Example : http://localhost/crm2/admin/procuration/procurationcu/case/no_id/4
 render_datatable(array(
    _l('the_number_sign'),
    _l('start_date'),
    _l('end_date'),
    _l('case_id'),
    _l('added_from'),
    _l('type'),
    _l('state'),
    _l('control'),
),'case-procuration'); ?>
