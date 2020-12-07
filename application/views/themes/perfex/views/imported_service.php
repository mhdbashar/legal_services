<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_hidden('project_id',$project->id); ?>
<?php echo form_hidden('ServID_for_clients',$ServID); ?>
<div class="panel_s">
    <div class="panel-body">
        <h3 class="bold mtop10 project-name pull-left"><?php echo $project->name; ?>
            <span style="color:<?php echo $project_status['color']; ?>; font-size:16px;"><?php echo $project_status['name']; ?></span>
        </h3>
            <a href="<?php echo site_url('clients/legal_services/'.$project->id.'/'.$ServID.'?group=new_task'); ?>" class="btn btn-info pull-right mtop5"><?php echo _l('new_task'); ?></a>
    </div>
</div>
<div class="panel_s">
    <div class="panel-body">
        <?php get_template_part('imported_services/project_tabs'); ?>
        <div class="clearfix mtop15"></div>
        <?php get_template_part('imported_services/'.$group); ?>
    </div>
</div>