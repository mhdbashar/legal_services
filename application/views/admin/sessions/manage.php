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
                        <hr class="hr-panel-heading hr-10" />
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
                            <?php $this->load->view('admin/sessions/_summary',array('table'=>'.table-sessions')); ?>
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
<div id="session_report_data" class="hide">
    <h3 align="center"><u><?php echo _l('session_report'); ?></u></h3>
    <table class="table scroll-responsive" style="border: 1px solid #ebf5ff">
        <thead>
        <tr>
            <th style="width: 30%"><?php echo _l('case_number'); ?></th>
            <td id="tbl1"></td>
        </tr>
        <tr>
            <th style="width: 30%"><?php echo _l('Parties_case'); ?></th>
            <td>
                <p> <?php echo _l('claimant'); ?> <b id="tbl2"></b></p>
                <p> <?php echo _l('accused'); ?> <b id="tbl3"></b></p>
            </td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('court_competent_follow'); ?></th>
            <td id="tbl4"></td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('Current_session_date'); ?></th>
            <td id="tbl5"></td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('Next_session_date'); ?></th>
            <td id="tbl6"></td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('Proceedings_of_session'); ?></th>
            <td id="tbl7"></td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('Court_decision'); ?></th>
            <td id="tbl8"></td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('upcoming_actions'); ?></th>
            <td id="tbl9"></td>
        </tr>
        </thead>
    </table>
</div>
<?php init_tail(); ?>
<script>
    taskid = '<?php echo $taskid; ?>';
    $(function(){
        sessions_kanban();

        initDataTable('.table-previous_sessions_log', admin_url + 'LegalServices/Sessions/table/previous_sessions_log', undefined, undefined, 'undefined', [0, 'asc']);
        initDataTable('.table-waiting_sessions_log', admin_url + 'LegalServices/Sessions/table/waiting_sessions_log', undefined, undefined, 'undefined', [0, 'asc']);
    });

    function print_session_report(task_id) {
        disabled_print_btn(task_id);
        $("#tbl9").html('');
        tag = '#';
        $.ajax({
            url: '<?php echo admin_url("LegalServices/Sessions/print_report/"); ?>' + task_id,
            success: function (data) {
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    if (value == '') {
                        value = '<?php echo _l('smtp_encryption_none') ?>';
                    }
                    $(tag + key).html(value);
                });
            }
        });
        $.ajax({
            url: '<?php echo admin_url("LegalServices/Sessions/checklist_items_description/"); ?>' + task_id,
            success: function (data) {
                arr = JSON.parse(data);
                if (arr.length == 0) {
                    $("#tbl9").html(
                        '<?php echo _l('session_no_checklist_items_found') ?>'
                    );
                }else {
                    $.each(arr, function (row, item) {
                        $("#tbl9").append(
                            '<p>- ' + item.description + '</p>'
                        );
                    });
                }
            }
        });
        setTimeout(function(){
            var printContents = document.getElementById("session_report_data").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        },2000);
    }

    function send_report(task_id) {
        $.ajax({
            url: '<?php echo admin_url("LegalServices/Sessions/send_report_to_customer/"); ?>' + task_id,
            success: function (data) {
                if(data == 1){
                    alert_float('success', '<?php echo _l('Done').' '._l('Send_to_customer'); ?>');
                    reload_tasks_tables();
                }else if (data == 2){
                    alert_float('danger', '<?php echo _l('no_primary_contact'); ?>');
                }else {
                    alert_float('danger', '<?php echo _l('faild'); ?>');
                }
            }
        });
    }

    function edit_customer_report(task_id) {
        next_session_date = $('#next_session_date'+task_id).val();
        next_session_time = $('#next_session_time'+task_id).val();
        court_decision    = $('#edit_court_decision'+task_id).val();
        send_mail_to_opponent    = $('#send_mail_to_opponent'+task_id).prop("checked");
        if(next_session_date == '' || next_session_time == '' || court_decision == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('LegalServices/Sessions/edit_customer_report'); ?>' + '/' + task_id,
                data: {
                    next_session_date : next_session_date,
                    next_session_time : next_session_time,
                    court_decision : court_decision,
                    send_mail_to_opponent : send_mail_to_opponent,
                },
                type: "POST",
                success: function (data) {
                    if(data == 1){
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                        $('#customer_report'+task_id).modal('hide');
                        $('#next_session_date'+task_id).val('');
                        $('#next_session_time'+task_id).val('');
                        $('#edit_court_decision'+task_id).val('');
                        $("#send_mail_to_opponent"+task_id).prop('checked', false);
                        reload_tasks_tables();
                    }else if (data == 'error_client'){
                        alert_float('danger', '<?php echo _l('no_primary_contact'); ?>');
                    }else if (data == 'error_opponent'){
                        alert_float('danger', '<?php echo _l('no_primary_opponent'); ?>');
                    }else {
                        alert_float('danger', '<?php echo _l('faild'); ?>');
                    }
                }
            });
        }
    }
</script>
</body>
</html>
