<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php
if (isset($rel_type)) {
    $this->load->model('legalservices/LegalServicesModel', 'legal');
    $ServID = $this->legal->get_service_id_by_slug($rel_type);
    if ($ServID == 1) {
        $route = 'Case';
        $ServID = $ServID . '/';
    } elseif ($ServID == 22) {
        $route = 'Disputes_cases';
        $ServID = $ServID . '/';
    } else {
        $route = 'SOther';
        $ServID = $ServID . '/';
    }
} else {
    $ServID = '';
    $route = 'projects';
}
$rel_type = isset($rel_type) ? $rel_type : 'project';

$time_format = get_option('time_format');
if ($time_format === '24') {
    $time_type = 'text';
} else {
    $time_type = 'time';
}

?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row _buttons">
                            <div class="col-md-8">
                                <?php if (has_permission('sessions', '', 'create')) { ?>
                                    <a href="#" onclick="new_session(<?php if ($this->input->get('project_id')) {
                                        echo "'" . admin_url('legalservices/sessions/task?rel_id=' . $this->input->get('project_id') . '&rel_type=' . $rel_type . '') . "'";
                                    } ?>); return false;"
                                       class="btn btn-info pull-left new"><?php echo _l('new_session'); ?></a>
                                <?php } ?>
                                <?php /*<a href="<?php if(!$this->input->get('project_id')){ echo admin_url('legalservices/sessions/switch_kanban/'.$switch_kanban); } else { echo admin_url(''.$route.'/view/'.$ServID.$this->input->get('project_id').'?group=project_tasks'); }; ?>" class="btn btn-default mleft10 pull-left hidden-xs">
                                    <?php if($switch_kanban == 1){ echo _l('switch_to_list_view');}else{echo _l('leads_switch_to_kanban');}; ?>
                                </a>*/ ?>
                            </div>
                            <div class="col-md-4">
                                <?php if ($this->session->has_userdata('tasks_kanban_view') && $this->session->userdata('tasks_kanban_view') == 'true') { ?>
                                    <div data-toggle="tooltip" data-placement="bottom"
                                         data-title="<?php echo _l('search_by_tags'); ?>">
                                        <?php echo render_input('search', '', '', 'search', array('data-name' => 'search', 'onkeyup' => 'sessions_kanban();', 'placeholder' => _l('search_sessions')), array(), 'no-margin') ?>
                                    </div>
                                <?php } else { ?>
                                    <?php //$this->load->view('admin/sessions/tasks_filter_by',array('view_table_name'=>'.table-sessions')); ?>
                                    <a href="<?php echo admin_url('legalservices/sessions/detailed_overview'); ?>"
                                       class="btn btn-success pull-right mright5"><?php echo _l('session_detailed_overview'); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <hr class="hr-panel-heading hr-10"/>
                        <div class="clearfix"></div>
                        <?php
                        if ($this->session->has_userdata('tasks_kanban_view') && $this->session->userdata('tasks_kanban_view') == 'true') { ?>
                            <div class="kan-ban-tab" id="kan-ban-tab" style="overflow:auto;">
                                <div class="row">
                                    <div id="kanban-params">
                                        <?php echo form_hidden('project_id', $this->input->get('project_id')); ?>
                                    </div>
                                    <div class="container-fluid" style="width: 100%">
                                        <div id="kan-ban"></div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <?php $this->load->view('admin/sessions/_summary', array('table' => '.table-sessions')); ?>
                            <a href="#" data-toggle="modal" data-target="#tasks_bulk_actions"
                               class="hide bulk-actions-btn table-btn"
                               data-table=".table-sessions"><?php echo _l('bulk_actions'); ?></a>
                            <br>
                            <br>
                            <div class="horizontal-scrollable-tabs preview-tabs-top">
                                <div class="horizontal-tabs">
                                    <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15"
                                        role="tablist">
                                        <li role="presentation" class="active">
                                            <a href="#Waiting_sessions" aria-controls="Waiting_sessions" role="tab"
                                               data-toggle="tab">
                                                <?php echo _l('Waiting_sessions'); ?>
                                            </a>
                                        </li>
                                        <li role="presentation" class="tab-separator">
                                            <a href="#Previous_Sessions" aria-controls="Previous_Sessions" role="tab"
                                               data-toggle="tab">
                                                <?php echo _l('Previous_Sessions') ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="Waiting_sessions">
                                    <?php $this->load->view('admin/sessions/watting_sessions_table', array('bulk_actions' => true)); ?>
                                </div>
                                <div role="tabpanel" class="tab-pane " id="Previous_Sessions">
                                    <?php $this->load->view('admin/sessions/previous_sessions_table', array('bulk_actions' => true)); ?>
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
    sessionid = '<?php echo $taskid; ?>';
    rel_type = '<?php echo isset($rel_type) ? $rel_type : ''; ?>';
    $(function () {
        sessions_kanban();
        initDataTable('.table-previous_sessions_log', admin_url + 'legalservices/sessions/table/previous_sessions_log', undefined, undefined, 'undefined', [6, 'desc']);
        initDataTable('.table-waiting_sessions_log', admin_url + 'legalservices/sessions/table/waiting_sessions_log', undefined, undefined, 'undefined', [7, 'desc']);
    });

    // Init session kan ban
    function sessions_kanban() {
        init_kanban('legalservices/sessions/kanban_for_legalservices/' + rel_type, sessions_kanban_update, '.tasks-status', 265, 360);
    }


    function send_report(task_id) {
        $.ajax({
            url: '<?php echo admin_url("legalservices/sessions/send_report_to_customer/"); ?>' + task_id,
            success: function (data) {
                if (data == 1) {
                    alert_float('success', '<?php echo _l('Done') . ' ' . _l('Send_to_customer'); ?>');
                    reload_tasks_tables();
                } else if (data == 'error_client') {
                    alert_float('danger', '<?php echo _l('no_primary_contact'); ?>');
                } else {
                    alert_float('danger', '<?php echo _l('Faild'); ?>');
                }
            }
        });
    }


    function add_report_session_modal(task_id) {
        var modal = document.getElementById("add_report_session_modal"+task_id);
        var time_type = '<?php echo $time_type;?>';
        if(!modal) {
            $("#wrapper").append(`
                <div class="modal fade" id="add_report_session_modal${task_id}" tabindex="-1" role="dialog" aria-labelledby="customer_report" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">
                                        <span class="add-title"><?php echo _l('Customer_report');?></span>
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" app-field-wrapper="date">
                                                <label for="next_session_date" class="control-label"><?php echo _l('next_session_date');?> </label>
                                                <div class="input-group date">
                                                    <input type="text" id="next_session_date${task_id}" name="next_session_date" class="form-control datepicker"  autocomplete="off" aria-invalid="false">
                                                   <div class="input-group-addon">
                                                        <i class="fa fa-calendar calendar-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" app-field-wrapper="time">
                                                <label for="next_session_time" class="control-label"><?php echo _l('next_session_time');?> </label><br>
                                                <div class="input-group time">
                                                    <input type="${time_type}" class="form-control" id="next_session_time${task_id}" name="next_session_time" autocomplete="off" aria-invalid="false">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o clock-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="bold"><?php echo _l('next_session_link')?></p>
                                            <input type="link" name="session_link" id="session_link${task_id}" class="form-control" style="width: 100%">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="bold"><?php echo _l('Court_decision')?> </p>
                                            <textarea type="text" class="form-control" id="edit_court_decision${task_id}" name="edit_court_decision" rows="4" placeholder="<?php echo _l('Court_decision')?>"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                          <div class="checkbox checkbox-primary">
                                                <input type="checkbox" name="send_mail_to_opponent" id="send_mail_to_opponent${task_id}">
                                                <label for="send_mail_to_opponent"><?php echo _l('send_mail_to_opponent')?> </label>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close') ?> </button>
                                    <button type="button" onclick="add_report_session(${task_id})" class="btn btn-info"><?php echo _l('submit')?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
        }
        init_datepicker();
        if (time_type === 'text') {
            $('#next_session_time'+ task_id).datetimepicker({
                datepicker:false,
                format:'H:i'
            });
        }
        $('#add_report_session_modal' + task_id).modal('show');
    }

    function add_report_session(task_id) {
        next_session_date = $('#next_session_date' + task_id).val();
        next_session_time = $('#next_session_time' + task_id).val();
        court_decision = $('#edit_court_decision' + task_id).val();
        session_link = $('#session_link' + task_id).val();
        send_mail_to_opponent = $('#send_mail_to_opponent' + task_id).prop("checked");
        if (court_decision == '') {
            alert_float('danger', '<?php echo _l('form_validation_required').'  '. _l('Court_decision'); ?>');
        } else {
            $.ajax({
                url: '<?php echo admin_url('legalservices/sessions/add_report_session/'); ?>' + task_id,
                data: {
                    next_session_date: next_session_date,
                    next_session_time: next_session_time,
                    court_decision: court_decision,
                    send_mail_to_opponent: send_mail_to_opponent,
                    session_link: session_link,
                },
                type: "POST",
                success: function (data) {
                    if (data == 1 || data == 'add_successfully') {
                        $('#add_report_session_modal' + task_id).modal('hide');
                        location.reload();
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                    } else if (data == 'error_client') {
                        alert_float('danger', '<?php echo _l('no_primary_contact'); ?>');
                    } else if (data == 'error_opponent') {
                        alert_float('danger', '<?php echo _l('no_primary_opponent'); ?>');
                    } else if (data == 'error_followers') {
                        alert_float('danger', '<?php echo _l('no_primary_followers'); ?>');
                    } else {
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                    }
                }
            });
        }
    }

    function edite_court_decision_modal(task_id) {
        requestGetJSON('legalservices/sessions/edite_court_decision/' + task_id).done(function(response) {
            if (response.edite === true ) {
                var modal = document.getElementById("edite_court_decision_modal"+task_id);
                if(!modal) {
                    $("#wrapper").append(`
                <div class="modal fade" id="edite_court_decision_modal${task_id}" tabindex="-1" role="dialog" aria-labelledby="edite_court_decision_modal" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">
                                        <span class="add-title">${response.title}</span>
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="bold">${response.court_decision_title}</p>
                                            <textarea type="text" class="form-control" id="val_court_decision${task_id}" name="court_decision" rows="4" placeholder="${response.court_decision_title}"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">${response.close}</button>
                                    <button type="button" onclick="edite_court_decision(${task_id})" class="btn btn-info">>${response.submit}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                }
                $('#val_court_decision' + task_id).val(response.court_decision);
                $('#edite_court_decision_modal' + task_id).modal('show');
            }
        });
    }

    function edite_court_decision(task_id) {
        court_decision = $('#val_court_decision' + task_id).val();
        $.ajax({
            url: '<?php echo admin_url('legalservices/sessions/edite_court_decision/'); ?>' + task_id,
            data: {
                court_decision: court_decision,
            },
            type: "POST",
            success: function (data) {
                response = JSON.parse(data);
                alert_float(`${response.alert_type}`, `${response.message}`);
                $('#edite_court_decision_modal' + task_id).modal('hide');
            }
        });
    }

</script>
</body>
</html>
