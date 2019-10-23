<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <?php echo form_hidden('project_id',$project->id) ?>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s project-top-panel panel-full">
                    <div class="panel-body _buttons">
                        <div class="row">
                            <div class="col-md-7 project-heading">
                                <h3 class="hide project-name"><?php echo $project->name; ?></h3>
                                <div id="project_view_name" class="pull-left">
                                    <select class="selectpicker" id="project_top" data-servid="<?php echo $ServID; ?>" data-width="fit"<?php if(count($other_projects) > 6){ ?> data-live-search="true" <?php } ?>>
                                        <option value="<?php echo $project->id; ?>" selected><?php echo $project->name; ?></option>
                                        <?php foreach($other_projects as $op){ ?>
                                            <option value="<?php echo $op['id']; ?>" data-subtext="<?php echo $op['company']; ?>">#<?php echo $op['id']; ?> - <?php echo $op['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="visible-xs">
                                    <div class="clearfix"></div>
                                </div>
                                <?php echo '<div class="label pull-left mleft15 mtop8 p8 project-status-label-'.$project->status.'" style="background:'.$project_status['color'].'">'.$project_status['name'].'</div>'; ?>
                            </div>
                            <div class="col-md-5 text-right">
                                <a href="<?php echo admin_url('LegalServices/case_movement_controller/edit/' .$ServID.'/'. $project->id); ?>" class="btn btn-info"><?php echo _l('NewCaseMovement'); ?></a>
                                <?php if(has_permission('tasks','','create')){ ?>
                                    <a href="#" onclick="new_task_from_relation(undefined,'<?php echo $service->slug; ?>',<?php echo $project->id; ?>); return false;" class="btn btn-info"><?php echo _l('new_task'); ?></a>
                                <?php } ?>
                                <?php
                                $invoice_func = 'pre_invoice_case';
                                ?>
                                <?php if(has_permission('invoices','','create')){ ?>
                                    <a href="#" onclick="<?php echo $invoice_func; ?>(<?php echo $ServID; ?>); return false;" class="invoice-project btn btn-info<?php if($project->client_data->active == 0){echo ' disabled';} ?>"><?php echo _l('invoice_project'); ?></a>
                                <?php } ?>
                                <?php
                                $project_pin_tooltip = _l('pin_project');
                                if(total_rows(db_prefix().'pinned_cases',array('staff_id'=>get_staff_user_id(),'project_id'=>$project->id)) > 0){
                                    $project_pin_tooltip = _l('unpin_project');
                                }
                                ?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo _l('more'); ?> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right width200 project-actions">
                                        <li>
                                            <a href="<?php echo admin_url('LegalServices/Cases_controller/pin_action/'.$project->id); ?>">
                                                <?php echo $project_pin_tooltip; ?>
                                            </a>
                                        </li>
                                        <?php if(has_permission('projects','','edit')){ ?>
                                            <li>
                                                <a href="<?php echo admin_url('Case/edit/'.$ServID.'/'.$project->id); ?>">
                                                    <?php echo _l('edit_project'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(has_permission('projects','','create')){ ?>
                                            <li>
                                                <a href="#" onclick="copy_project(); return false;">
                                                    <?php echo _l('copy_project'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(has_permission('projects','','create') || has_permission('projects','','edit')){ ?>
                                            <li class="divider"></li>
                                            <?php foreach($statuses as $status){
                                                if($status['id'] == $project->status){continue;}
                                                ?>
                                                <li>
                                                    <a href="#" data-name="<?php echo _l('project_status_'.$status['id']); ?>" onclick="project_mark_as_modal(<?php echo $status['id']; ?>,<?php echo $project->id; ?>, this); return false;"><?php echo _l('project_mark_as',$status['name']); ?></a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                        <li class="divider"></li>
                                        <?php if(has_permission('projects','','create')){ ?>
                                            <li>
                                                <a href="<?php echo admin_url('LegalServices/Cases_controller/export_project_data/'.$ServID.'/'.$project->id); ?>" target="_blank"><?php echo _l('export_project_data'); ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if(is_admin()){ ?>
                                            <li>
                                                <a href="<?php echo admin_url('LegalServices/Cases_controller/view_project_as_client/'.$project->id .'/'.$project->clientid); ?>" target="_blank"><?php echo _l('project_view_as_client'); ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if(has_permission('projects','','delete')){ ?>
                                            <li>
                                                <a href="<?php echo admin_url('LegalServices/Cases_controller/move_to_recycle_bin/'.$ServID.'/'.$project->id); ?>" class="_delete">
                                                    <span class="text-danger"><?php echo _l('delete_project'); ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel_s project-menu-panel">
                    <div class="panel-body">
                        <?php hooks()->do_action('before_render_project_view', $project->id); ?>
                        <?php $this->load->view('admin/LegalServices/cases/project_tabs'); ?>
                    </div>
                </div>
                <?php
                if((has_permission('projects','','create') || has_permission('projects','','edit'))
                    && $project->status == 1
                    && $case_model->timers_started_for_project($service->slug, $project->id)
                    && $tab['slug'] != 'project_milestones') {
                    ?>
                    <div class="alert alert-warning project-no-started-timers-found mbot15">
                        <?php echo _l('project_not_started_status_tasks_timers_found'); ?>
                    </div>
                <?php } ?>
                <?php
                if($project->deadline && date('Y-m-d') > $project->deadline
                    && $project->status == 2
                    && $tab['slug'] != 'project_milestones') {
                    ?>
                    <div class="alert alert-warning bold project-due-notice mbot15">
                        <?php echo _l('project_due_notice', floor((abs(time() - strtotime($project->deadline)))/(60*60*24))); ?>
                    </div>
                <?php } ?>
                <?php
                if(!has_contact_permission('projects',get_primary_contact_user_id($project->clientid))
                    && total_rows(db_prefix().'contacts',array('userid'=>$project->clientid)) > 0
                    && $tab['slug'] != 'project_milestones') {
                    ?>
                    <div class="alert alert-warning project-permissions-warning mbot15">
                        <?php echo _l('project_customer_permission_warning'); ?>
                    </div>
                <?php } ?>
                <div class="panel_s">
                    <div class="panel-body">
                        <?php $this->load->view(($tab ? $tab['view'] : 'admin/LegalServices/cases/project_overview')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php if(isset($discussion)){
    echo form_hidden('discussion_id',$discussion->id);
    echo form_hidden('discussion_user_profile_image_url',$discussion_user_profile_image_url);
    echo form_hidden('current_user_is_admin',$current_user_is_admin);
}
echo form_hidden('project_percent',$percent);
?>
<div id="invoice_project"></div>
<div id="pre_invoice_project"></div>
<?php $this->load->view('admin/LegalServices/cases/milestone'); ?>
<?php $this->load->view('admin/LegalServices/cases/copy_settings'); ?>
<?php $this->load->view('admin/LegalServices/cases/_mark_tasks_finished', array('slug' => $service->slug)); ?>
<?php init_tail(); ?>
<!-- For invoices table -->
<script>
    taskid = '<?php echo $this->input->get('taskid'); ?>';
    sessionid = '<?php echo $this->input->get('sessionid'); ?>';
</script>
<script>
    var gantt_data = {};
    <?php if(isset($gantt_data)){ ?>
    gantt_data = <?php echo json_encode($gantt_data); ?>;
    <?php } ?>
    var discussion_id = $('input[name="discussion_id"]').val();
    var discussion_user_profile_image_url = $('input[name="discussion_user_profile_image_url"]').val();
    var current_user_is_admin = $('input[name="current_user_is_admin"]').val();
    var project_id = $('input[name="project_id"]').val();
    if(typeof(discussion_id) != 'undefined'){
        discussion_comments_case('#discussion-comments',discussion_id,'regular');
    }
    $(function(){
        var project_progress_color = '<?php echo hooks()->apply_filters('admin_project_progress_color','#84c529'); ?>';
        var circle = $('.project-progress').circleProgress({fill: {
                gradient: [project_progress_color, project_progress_color]
            }}).on('circle-animation-progress', function(event, progress, stepValue) {
            $(this).find('strong.project-percent').html(parseInt(100 * stepValue) + '<i>%</i>');
        });
    });

    function discussion_comments_case(selector,discussion_id,discussion_type){
        var defaults = _get_jquery_comments_default_config(<?php echo json_encode(get_case_discussions_language_array()); ?>);
        var options = {
            currentUserIsAdmin:current_user_is_admin,
            getComments: function(success, error) {
                $.get(admin_url + 'LegalServices/Cases_controller/get_discussion_comments/'+discussion_id+'/'+discussion_type,function(response){
                    success(response);
                },'json');
            },
            postComment: function(commentJSON, success, error) {
                $.ajax({
                    type: 'post',
                    url: admin_url + 'LegalServices/Cases_controller/add_discussion_comment/'+ <?php echo $ServID; ?> + '/' + discussion_id+'/'+discussion_type,
                    data: commentJSON,
                    success: function(comment) {
                        comment = JSON.parse(comment);
                        success(comment)
                    },
                    error: error
                });
            },
            putComment: function(commentJSON, success, error) {
                $.ajax({
                    type: 'post',
                    url: admin_url + 'LegalServices/Cases_controller/update_discussion_comment',
                    data: commentJSON,
                    success: function(comment) {
                        comment = JSON.parse(comment);
                        success(comment)
                    },
                    error: error
                });
            },
            deleteComment: function(commentJSON, success, error) {
                $.ajax({
                    type: 'post',
                    url: admin_url + 'LegalServices/Cases_controller/delete_discussion_comment/'+commentJSON.id,
                    success: success,
                    error: error
                });
            },
            uploadAttachments: function(commentArray, success, error) {
                var responses = 0;
                var successfulUploads = [];
                var serverResponded = function() {
                    responses++;
                    // Check if all requests have finished
                    if(responses == commentArray.length) {
                        // Case: all failed
                        if(successfulUploads.length == 0) {
                            error();
                            // Case: some succeeded
                        } else {
                            successfulUploads = JSON.parse(successfulUploads);
                            success(successfulUploads)
                        }
                    }
                }
                $(commentArray).each(function(index, commentJSON) {
                    // Create form data
                    var formData = new FormData();
                    if(commentJSON.file.size && commentJSON.file.size > app.max_php_ini_upload_size_bytes){
                        alert_float('danger',"<?php echo _l("file_exceeds_max_filesize"); ?>");
                        serverResponded();
                    } else {
                        $(Object.keys(commentJSON)).each(function(index, key) {
                            var value = commentJSON[key];
                            if(value) formData.append(key, value);
                        });

                        if (typeof(csrfData) !== 'undefined') {
                            formData.append(csrfData['token_name'], csrfData['hash']);
                        }
                        $.ajax({
                            url: admin_url + 'LegalServices/Cases_controller/add_discussion_comment/'+ <?php echo $ServID; ?> +'/'+ discussion_id+'/'+discussion_type,
                            type: 'POST',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(commentJSON) {
                                successfulUploads.push(commentJSON);
                                serverResponded();
                            },
                            error: function(data) {
                                var error = JSON.parse(data.responseText);
                                alert_float('danger',error.message);
                                serverResponded();
                            },
                        });
                    }
                });
            }
        }
        var settings = $.extend({}, defaults, options);
        $(selector).comments(settings);
    }
</script>
<script>

    $(function(){
        initDataTable('.table-previous_sessions_log', admin_url + 'tasks/init_previous_sessions_log/<?php echo $project->id; ?>/<?php echo $service->slug; ?>', undefined, undefined, 'undefined', [0, 'asc']);
        initDataTable('.table-waiting_sessions_log', admin_url + 'tasks/waiting_sessions_log/<?php echo $project->id; ?>/<?php echo $service->slug; ?>', undefined, undefined, 'undefined', [0, 'asc']);

        // Init single task data
        if (typeof(sessionid) !== 'undefined' && sessionid !== '') { init_task_modal_session(sessionid); }
    });


    slug_previous_sessions = $(".table-previous_sessions_log").attr('data-new-rel-slug');
    init_previous_sessions_log_table(project_id, slug_previous_sessions);

    slug_waiting_sessions = $(".table-waiting_sessions_log").attr('data-new-rel-slug');
    init_waiting_sessions_log_table(project_id, slug_waiting_sessions);

    // Initing relation tasks tables
    function init_previous_sessions_log_table(rel_id, rel_type, selector) {
        if (typeof(selector) == 'undefined') { selector = '.table-previous_sessions_log'; }
        var $selector = $("body").find(selector);
        if ($selector.length === 0) { return; }

        var TasksServerParamsCase = {},
            tasksRelationTableNotSortableCase = [0], // bulk actions
            TasksFiltersCase;

        TasksFiltersCase = $('body').find('._hidden_inputs._filters._tasks_filters input');

        $.each(TasksFiltersCase, function() {
            TasksServerParamsCase[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
        });

        var url = admin_url + 'tasks/init_previous_sessions_log/' + rel_id + '/' + rel_type;

        if ($selector.attr('data-new-rel-type') == rel_type) {
            url += '?bulk_actions=true';
        }

        initDataTable($selector, url, tasksRelationTableNotSortableCase, tasksRelationTableNotSortableCase, TasksServerParamsCase, [0, 'asc']);
    }

    // Initing waiting_sessions_log tables
    function init_waiting_sessions_log_table(rel_id, rel_type, selector) {
        if (typeof(selector) == 'undefined') { selector = '.table-waiting_sessions_log'; }
        var $selector = $("body").find(selector);
        if ($selector.length === 0) { return; }

        var TasksServerParamsCase = {},
            tasksRelationTableNotSortableCase = [0], // bulk actions
            TasksFiltersCase;

        TasksFiltersCase = $('body').find('._hidden_inputs._filters._tasks_filters input');

        $.each(TasksFiltersCase, function() {
            TasksServerParamsCase[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
        });

        var url = admin_url + 'tasks/init_waiting_sessions_log/' + rel_id + '/' + rel_type;

        if ($selector.attr('data-new-rel-type') == rel_type) {
            url += '?bulk_actions=true';
        }

        initDataTable($selector, url, tasksRelationTableNotSortableCase, tasksRelationTableNotSortableCase, TasksServerParamsCase, [0, 'asc']);
    }

    // Reload all tasks possible table where the table data needs to be refreshed after an action is performed on task.
    function reload_tasks_tables() {
        var av_tasks_tables = ['.table-tasks','.table-tasks_case', '.table-rel-tasks', '.table-rel-tasks_case' , '.table-rel-tasks-leads', '.table-timesheets', '.table-timesheets_case' , '.table-timesheets-report', '.table-previous_sessions_log','.table-waiting_sessions_log'];
        $.each(av_tasks_tables, function(i, selector) {
            if ($.fn.DataTable.isDataTable(selector)) {
                $(selector).DataTable().ajax.reload(null, false);
            }
        });
    }

    function edit_customer_report(task_id) {
        next_session_date = $('#next_session_date'+task_id).val();
        next_session_time = $('#next_session_time'+task_id).val();
        court_decision    = $('#edit_court_decision'+task_id).val();
        if(next_session_date == '' || next_session_time == '' || court_decision == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('LegalServices/ServicesSessions/edit_customer_report'); ?>' + '/' + task_id,
                data: {
                    next_session_date : next_session_date,
                    next_session_time : next_session_time,
                    court_decision : court_decision,
                },
                type: "POST",
                success: function (data) {
                    if(data == 1){
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                        $('#customer_report'+task_id).modal('hide');
                        $('#next_session_date'+task_id).val('');
                        $('#next_session_time'+task_id).val('');
                        $('#edit_court_decision'+task_id).val('');
                        reload_tasks_tables();
                    }else {
                        alert_float('danger', '<?php echo _l('faild'); ?>');
                    }
                }
            });
        }
    }

    $("#add_task_timesheet").click(function () {
        name = $('#task_name_timesheet').val();
        startdate = $('#task_startdate_timesheet').val();
        rel_id = <?php echo $project->id; ?>;
        rel_type = '<?php echo $service->slug; ?>';
        if(name == '' || startdate == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('LegalServices/Cases_controller/add_task_to_select_timesheet'); ?>',
                data: {
                        name : name,
                        startdate: startdate,
                        rel_id: rel_id,
                        rel_type: rel_type
                      },
                type: "POST",
                success: function (data) {
                    if(data){
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                        var $option = $('<option></option>')
                            .attr('value', data)
                            .text(name)
                            .prop('selected', true);
                        $('#timesheet_task_id').append($option).change();
                        $('#add_task_to_select').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('faild'); ?>');
                    }
                }
            });
        }
    });

    $(function(){
        appValidateForm($('#form_phases'), {});
    });
</script>

</body>
</html>
