<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_hidden('project_id',$project->id); ?>
<?php echo form_hidden('ServID_for_clients',$ServID); ?>
<!---->
<div class="panel_s">
    <div class="panel-body">
		<div class="_buttons">
                <a href="<?php echo site_url('clients/imported_edit/'.$project->id); ?>" class="btn btn-info pull-left display-block mright5">
                    <?php echo _l('edit'); ?>
                </a>
        </div>
        <div class="clearfix"></div>
         <hr class="hr-panel-heading" />
        <?php get_template_part('imported_services/project_tabs'); ?>
        <div class="clearfix mtop15"></div>
        <?php get_template_part('imported_services/'.$group); ?>
    </div>
</div>