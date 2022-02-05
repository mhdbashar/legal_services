<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_hidden('project_id', $project->id); ?>
<?php echo form_hidden('ServID_for_clients', $ServID); ?>
<div class="panel_s">
    <div class="panel-body">
        <h3 class="bold mtop10 project-name pull-left"><?php echo $project->name; ?>
            <span style="color:<?php echo $project_status['color']; ?>; font-size:16px;"><?php echo $project_status['name']; ?></span>
        </h3>
        <?php if ($project->settings->view_tasks == 1 && $project->settings->create_tasks == 1) { ?>
            <a href="<?php echo site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=new_task'); ?>" class="btn btn-info pull-right mtop5"><?php echo _l('new_task'); ?></a>
        <?php } ?>
        <?php if ($project->settings->view_session_logs == 1 && $project->settings->create_sessions == 1) { ?>
            <a href="<?php echo site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=new_session'); ?>" class="btn btn-info pull-right mtop5 mright5"><?php echo _l('new_session'); ?></a>
        <?php } ?>
    </div>
</div>
<div class="panel_s">
    <div class="panel-body">
        <?php get_template_part('legal_services/project_tabs'); ?>
        <div class="clearfix mtop15"></div>
        <?php get_template_part('legal_services/' . $group); ?>
    </div>
</div>
<script>
    function view_case_file(id, project_id, ServID) {
        $.post(site_url + 'clients/legal_services/' + project_id + '/' + ServID, {
            action: 'get_file',
            id: id,
            project_id: project_id,
            ServID: ServID
        }).done(function(response) {
            $('#project_file_data').html(response);
        }).fail(function(error) {
            alert_float('danger', error.statusText);
        });
    }

    function view_oservice_file(id, project_id, ServID) {
        $.post(site_url + 'clients/legal_services/' + project_id + '/' + ServID, {
            action: 'get_file',
            id: id,
            project_id: project_id,
            ServID: ServID
        }).done(function(response) {
            $('#project_file_data').html(response);
        }).fail(function(error) {
            alert_float('danger', error.statusText);
        });
    }
</script>