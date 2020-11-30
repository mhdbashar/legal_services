<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php
if(isset($rel_type)){
    $this->load->model('LegalServices/LegalServicesModel', 'legal');
    $ServID = $this->legal->get_service_id_by_slug($rel_type);
    if($ServID == 1){
        $route = 'Case';
        $ServID = $ServID.'/';
    }else{
        $route = 'SOther';
        $ServID = $ServID.'/';
    }
}else{
    $ServID = '';
    $route = 'projects';
}
$rel_type = isset($rel_type) ? $rel_type : 'project';
?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row _buttons">
                            <div class="col-md-8">
                                <?php if(has_permission('sessions','','create')){ ?>
                                    <a href="#" onclick="new_session(<?php if($this->input->get('project_id')){ echo "'".admin_url('LegalServices/sessions/task?rel_id='.$this->input->get('project_id').'&rel_type='.$rel_type.'')."'";} ?>); return false;" class="btn btn-info pull-left new"><?php echo _l('new_session'); ?></a>
                                <?php } ?>
                                <a href="<?php if(!$this->input->get('project_id')){ echo admin_url('LegalServices/sessions/switch_kanban/'.$switch_kanban); } else { echo admin_url(''.$route.'/view/'.$ServID.$this->input->get('project_id').'?group=project_tasks'); }; ?>" class="btn btn-default mleft10 pull-left hidden-xs">
                                    <?php if($switch_kanban == 1){ echo _l('switch_to_list_view');}else{echo _l('leads_switch_to_kanban');}; ?>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <?php if($this->session->has_userdata('tasks_kanban_view') && $this->session->userdata('tasks_kanban_view') == 'true') { ?>
                                    <div data-toggle="tooltip" data-placement="bottom" data-title="<?php echo _l('search_by_tags'); ?>">
                                        <?php echo render_input('search','','','search',array('data-name'=>'search','onkeyup'=>'sessions_kanban();','placeholder'=>_l('search_sessions')),array(),'no-margin') ?>
                                    </div>
                                <?php } else { ?>
                                    <?php //$this->load->view('admin/sessions/tasks_filter_by',array('view_table_name'=>'.table-sessions')); ?>
                                    <a href="<?php echo admin_url('LegalServices/sessions/detailed_overview'); ?>" class="btn btn-success pull-right mright5"><?php echo _l('session_detailed_overview'); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                        if($this->session->has_userdata('tasks_kanban_view') && $this->session->userdata('tasks_kanban_view') == 'true') { ?>
                            <div class="kan-ban-tab" id="kan-ban-tab" style="overflow:auto;">
                                <div class="row">
                                    <div id="kanban-params">
                                        <?php echo form_hidden('project_id',$this->input->get('project_id')); ?>
                                    </div>
                                    <div class="container-fluid">
                                        <div id="kan-ban"></div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <?php //$this->load->view('admin/sessions/_summary',array('table'=>'.table-sessions')); ?>
                            <a href="#" data-toggle="modal" data-target="#tasks_bulk_actions" class="hide bulk-actions-btn table-btn" data-table=".table-sessions"><?php echo _l('bulk_actions'); ?></a>
                            <br>
                            <br>
                            <div class="horizontal-scrollable-tabs preview-tabs-top">
                                <div class="horizontal-tabs">
                                    <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
                                        <li role="presentation" class="active" >
                                            <a href="#Waiting_sessions" aria-controls="Waiting_sessions" role="tab" data-toggle="tab">
                                                <?php echo _l('Waiting_sessions'); ?>
                                            </a>
                                        </li>
                                        <li role="presentation" class="tab-separator">
                                            <a href="#Previous_Sessions" aria-controls="Previous_Sessions" role="tab" data-toggle="tab">
                                                <?php echo _l('Previous_Sessions') ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="Waiting_sessions">
                                    <?php $this->load->view('admin/sessions/watting_sessions_table',array('bulk_actions'=>true)); ?>
                                </div>
                                <div role="tabpanel" class="tab-pane " id="Previous_Sessions">
                                    <?php $this->load->view('admin/sessions/previous_sessions_table',array('bulk_actions'=>true)); ?>
                                </div>
                            </div>
                            <?php $this->load->view('admin/sessions/_bulk_actions'); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    taskid = '<?php echo $taskid; ?>';
    $(function(){
        sessions_kanban();
    });
</script>
</body>
</html>
