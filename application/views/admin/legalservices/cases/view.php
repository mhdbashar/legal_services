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
                                <div class="visible-xs">
                                    <div class="clearfix"></div>
                                </div>
                                <?php if(!empty($linked_services)){ ?>
                                    <div class="label btn btn-danger pull-left mleft15 mtop8 p8 " href="#" onclick="linked_services(); return false;">
                                            <?php echo _l('linked_services'); ?>
                                    </div>
                                <?php } ?>
                                <?php if(isset($project->previous_case_id) && $project->previous_case_id != 0): ?>
                                <h4 class="mtop15">&nbsp;&nbsp;<?php echo _l('linked_case'); ?>
                                    <a href="<?php echo admin_url('Case/view/' .$ServID.'/'. $project->previous_case_id); ?>" target="_blank"><?php echo get_case_name_by_id($project->previous_case_id); ?></a>
                                </h4>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-5 text-right">
                                <a href="<?php echo admin_url('legalservices/case_movement/edit/' .$ServID.'/'. $project->id); ?>" class="btn btn-info"><?php echo _l('NewCaseMovement'); ?></a>
                                <?php if(has_permission('tasks','','create')){ ?>
                                    <a href="#" onclick="new_task_from_relation(undefined,'<?php echo $service->slug; ?>',<?php echo $project->id; ?>); return false;" class="btn btn-info"><?php echo _l('new_task'); ?></a>
                                <?php } ?>
                                <?php
                                $invoice_func = 'pre_invoice_case';
                                ?>
                                <?php if(has_permission('invoices','','create')){ ?>
                                    <a href="#" onclick="<?php echo $invoice_func; ?>(<?php echo $ServID; ?>); return false;" class="invoice-project btn btn-info<?php if(isset($project->client_data->active) && $project->client_data->active == 0){echo ' disabled';} ?>"><?php echo _l('invoice_project'); ?></a>
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
                                             <a href="#" onclick="link_service(); return false;">
                                             <?php echo _l('link_service'); ?>
                                             </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo admin_url('legalservices/cases/pin_action/'.$project->id); ?>">
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
                                                <a href="<?php echo admin_url('legalservices/cases/export_project_data/'.$ServID.'/'.$project->id); ?>" target="_blank"><?php echo _l('export_project_data'); ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if(is_admin()){ ?>
                                            <li>
                                                <a href="<?php echo admin_url('legalservices/cases/view_project_as_client/'.$project->id .'/'.$project->clientid.'/'.$ServID); ?>" target="_blank"><?php echo _l('project_view_as_client'); ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if(has_permission('projects','','delete')){ ?>
                                            <li>
                                                <a href="<?php echo admin_url('legalservices/cases/move_to_recycle_bin/'.$ServID.'/'.$project->id); ?>" class="_delete">
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

                    <?php
                        $days=get_dur_number_of_days_by_id($project->duration_id);
                        $dur_name=get_dur_name_by_id($project->duration_id);
                        $duration_date=$project->regular_duration_begin_date;
                        $end_date_case  = strtotime($duration_date . " +".$days."days");
                        $end_date_case = date('Y-m-d',$end_date_case);

                        if( $project->regular_header == 1){
                          if($end_date_case < date('Y-m-d'))
                           {

                            $this->db->where('id', $project->id);
                            $this->db->update(db_prefix() . 'my_cases', [
                            'regular_header' => 0,
                             ]);
                           }
                         else { ?>
                             <div class="alert alert-warning" font-medium="">
                                 <h4><b><?php echo _l('Regular duration Reminder') ?></b>!</h4>
                                 <hr class="hr-10">
                                 <?php echo _l('remember that') ?> <b><?php echo $dur_name ?></b>
                                 <?php echo _l('which started at') ?>
                                 <b> <?php echo $duration_date ?> </b>
                                 <?php echo _l('will end at') ?><b><?php echo $end_date_case ;?></b>
                             </div>

                         <?php } ?>
                          <?php // if(has_permission('tasks','','create')) {?>

                        <?php // } ?>

                    <?php } ?>

                <div class="panel_s project-menu-panel">
                    <div class="panel-body">
                        <?php hooks()->do_action('before_render_project_view', $project->id); ?>
                        <?php $this->load->view('admin/legalservices/cases/project_tabs'); ?>
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
                        <?php $this->load->view(($tab ? $tab['view'] : 'admin/legalservices/cases/project_overview')); ?>
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
<?php $this->load->view('admin/legalservices/cases/milestone'); ?>
<?php $this->load->view('admin/legalservices/cases/copy_settings'); ?>
<?php $this->load->view('admin/legalservices/cases/link_service'); ?>
<?php $this->load->view('admin/legalservices/cases/linked_services'); ?>
<?php $this->load->view('admin/legalservices/cases/_mark_tasks_finished', array('slug' => $service->slug)); ?>
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
      // https://github.com/Viima/jquery-comments/pull/169
      wysiwyg_editor: {
            opts: {
                enable: true,
                is_html: true,
                container_id: 'editor-container',
                comment_index: 0,
            },
            init: function (textarea, content) {
                var comment_index = textarea.data('comment_index');
                 var editorConfig = _simple_editor_config();
                 editorConfig.setup = function(ed) {
                      textarea.data('wysiwyg_editor', ed);

                      ed.on('change', function() {
                          var value = ed.getContent();
                          if (value !== ed._lastChange) {
                            ed._lastChange = value;
                            textarea.trigger('change');
                          }
                      });

                      ed.on('keyup', function() {
                        var value = ed.getContent();
                          if (value !== ed._lastChange) {
                            ed._lastChange = value;
                            textarea.trigger('change');
                          }
                      });

                      ed.on('Focus', function (e) {
                        setTimeout(function(){
                          textarea.trigger('click');
                        }, 500)
                      });

                      ed.on('init', function() {
                        if (content) ed.setContent(content);

                        if ($('#mention-autocomplete-css').length === 0) {
                              $('<link>').appendTo('head').attr({
                                 id: 'mention-autocomplete-css',
                                 type: 'text/css',
                                 rel: 'stylesheet',
                                 href: site_url + 'assets/plugins/tinymce/plugins/mention/autocomplete.css'
                              });
                           }

                           if ($('#mention-css').length === 0) {
                              $('<link>').appendTo('head').attr({
                                 type: 'text/css',
                                 id: 'mention-css',
                                 rel: 'stylesheet',
                                 href: site_url + 'assets/plugins/tinymce/plugins/mention/rte-content.css'
                              });
                           }
                      })
                  }

                  editorConfig.plugins[0] += ' mention';
                  editorConfig.content_style = 'span.mention {\
                     background-color: #eeeeee;\
                     padding: 3px;\
                  }';
                  var projectUserMentions = [];
                  editorConfig.mentions = {
                     source: function (query, process, delimiter) {
                           if (projectUserMentions.length < 1) {
                              $.getJSON(admin_url + 'legalservices/cases/get_staff_names_for_mentions/' + project_id, function (data) {
                                 projectUserMentions = data;
                                 process(data)
                              });
                           } else {
                              process(projectUserMentions)
                           }
                     },
                     insert: function(item) {
                           return '<span class="mention" contenteditable="false" data-mention-id="'+ item.id + '">@'
                           + item.name + '</span>&nbsp;';
                     }
                  };

                var containerId = this.get_container_id(comment_index);
                tinyMCE.remove('#'+containerId);

                setTimeout(function(){
                  init_editor('#'+ containerId, editorConfig)
                },100)
            },
            get_container: function (textarea) {
                if (!textarea.data('comment_index')) {
                    textarea.data('comment_index', ++this.opts.comment_index);
                }

                return $('<div/>', {
                    'id': this.get_container_id(this.opts.comment_index)
                });
            },
            get_contents: function(editor) {
               return editor.getContent();
            },
            on_post_comment: function(editor, evt) {
               editor.setContent('');
            },
            get_container_id: function(comment_index) {
              var container_id = this.opts.container_id;
              if (comment_index) container_id = container_id + "-" + comment_index;
              return container_id;
            }
        },
            currentUserIsAdmin:current_user_is_admin,
            getComments: function(success, error) {
                $.get(admin_url + 'legalservices/cases/get_discussion_comments/'+discussion_id+'/'+discussion_type,function(response){
                    success(response);
                },'json');
            },
            postComment: function(commentJSON, success, error) {
                $.ajax({
                    type: 'post',
                    url: admin_url + 'legalservices/cases/add_discussion_comment/'+ <?php echo $ServID; ?> + '/' + discussion_id+'/'+discussion_type,
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
                    url: admin_url + 'legalservices/cases/update_discussion_comment',
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
                    url: admin_url + 'legalservices/cases/delete_discussion_comment/'+commentJSON.id,
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
                            url: admin_url + 'legalservices/cases/add_discussion_comment/'+ <?php echo $ServID; ?> +'/'+ discussion_id+'/'+discussion_type,
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
        initDataTable('.table-previous_sessions_log', admin_url + 'legalservices/sessions/init_previous_sessions_log/<?php echo $project->id; ?>/<?php echo $service->slug; ?>', undefined, undefined, 'undefined', [0, 'asc']);
        initDataTable('.table-waiting_sessions_log', admin_url + 'legalservices/sessions/init_waiting_sessions_log/<?php echo $project->id; ?>/<?php echo $service->slug; ?>', undefined, undefined, 'undefined', [0, 'asc']);

        // Init single task data
        if (typeof(sessionid) !== 'undefined' && sessionid !== '') { init_session_modal(sessionid); }

        if (typeof(taskid) !== 'undefined' && taskid !== '') { init_task_modal(taskid); }
    });

    slug_previous_sessions = $(".table-previous_sessions_log").attr('data-new-rel-slug');
    init_previous_sessions_log_table(project_id, slug_previous_sessions);

    slug_waiting_sessions = $(".table-waiting_sessions_log").attr('data-new-rel-slug');
    init_waiting_sessions_log_table(project_id, slug_waiting_sessions);

    function edit_customer_report(task_id) {
        next_session_date = $('#next_session_date'+task_id).val();
        next_session_time = $('#next_session_time'+task_id).val();
        court_decision    = $('#edit_court_decision'+task_id).val();
        send_mail_to_opponent    = $('#send_mail_to_opponent'+task_id).prop("checked");
        if(next_session_date == '' || next_session_time == '' || court_decision == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('legalservices/sessions/edit_customer_report'); ?>' + '/' + task_id,
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
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
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
                url: '<?php echo admin_url('legalservices/cases/add_task_to_select_timesheet'); ?>',
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
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                    }
                }
            });
        }
    });

    $("body").on('click', '.services-new-task-to-milestone', function(e) {
        e.preventDefault();
        var milestone_id = $(this).parents('.milestone-column').data('col-status-id');
        new_task(admin_url + 'tasks/task?rel_type=<?php echo $service->slug; ?>&rel_id=' + project_id + '&milestone_id=' + milestone_id);
        $('body [data-toggle="popover"]').popover('hide');
    });
</script>
</body>
</html>
