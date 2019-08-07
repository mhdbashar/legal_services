<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <?php  echo form_hidden('oservice_id',$oservice->id) ?>
	<?php  echo form_hidden('rel_id',$oservice->id) ?>
	<?php  echo form_hidden('rel_type',$service->slug) ?>
	<?php  echo form_hidden('service_id',$service->id) ?>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s project-top-panel panel-full">
                    <div class="panel-body _buttons">
                        <div class="row">
                            <div class="col-md-7 project-heading">
                                <h3 class="hide project-name"><?php echo $oservice->name; ?></h3>
                                <div id="project_view_name" class="pull-left">
                                    <select class="selectpicker" id="project_top" data-width="fit"<?php if(count($oservices) > 6){ ?> data-live-search="true" <?php } ?>>
                                        <option value="<?php echo $oservice->id; ?>" selected><?php echo $oservice->name; ?></option>
                                        <?php foreach($oservices as $op){ ?>
                                            <option value="<?php echo $op['id']; ?>" data-subtext="<?php echo $op['company']; ?>">#<?php echo $op['id']; ?> - <?php echo $op['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="visible-xs">
                                    <div class="clearfix"></div>
                                </div>
                                <?php echo '<div class="label pull-left mleft15 mtop8 p8 project-status-label-'.$oservice->status.'" style="background:'.$oservice_status['color'].'">'.$oservice_status['name'].'</div>'; ?>
                            </div>
                            <div class="col-md-5 text-right">
                                <?php if(has_permission('tasks','','create')){ ?>
                                    <a href="#" onclick="new_task_from_relation(undefined,'<?php echo $service->slug;?>',<?php echo $oservice->id; ?>); return false;" class="btn btn-info"><?php echo _l('new_task'); ?></a>
                                <?php } ?>
                                <?php
                                $invoice_func = 'pre_invoice_oservice';
                                ?>
                                <?php if(has_permission('invoices','','create')){ ?>
                                    <a href="#" onclick="<?php echo $invoice_func; ?>(<?php echo $ServID; ?>,<?php echo $oservice->id; ?>); return false;" class="invoice-project btn btn-info<?php if($oservice->client_data->active == 0){echo ' disabled';} ?>"><?php echo _l('invoice_project'); ?></a>
                                <?php } ?>
                                <?php
                                $oservice_pin_tooltip = _l('pin_project');
                                if(total_rows(db_prefix().'pinned_oservices',array('staff_id'=>get_staff_user_id(),'oservice_id'=>$oservice->id)) > 0){
                                    $oservice_pin_tooltip = _l('unpin_project');
                                }
                                ?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo _l('more'); ?> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right width200 project-actions">
                                        <li>
                                            <a href="<?php echo admin_url('LegalServices/Other_services_controller/pin_action/'.$oservice->id); ?>">
                                                <?php echo $oservice_pin_tooltip; ?>
                                            </a>
                                        </li>
                                        <?php if(has_permission('projects','','edit')){ ?>
                                            <li>
                                                <a href="<?php echo admin_url('SOther/edit/'.$ServID.'/'.$oservice->id); ?>">
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
                                                if($status['id'] == $oservice->status){continue;}
                                                ?>
                                                <li>
                                                    <a href="#" data-name="<?php echo _l('project_status_'.$status['id']); ?>" onclick="oservice_mark_as_modal(<?php echo $status['id']; ?>,<?php echo $oservice->id; ?>, this); return false;"><?php echo _l('project_mark_as',$status['name']); ?></a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                        <li class="divider"></li>
                                        <?php if(has_permission('projects','','create')){ ?>
                                            <li>
                                                <a href="<?php echo admin_url('LegalServices/Other_services_controller/export_project_data/'.$ServID.'/'.$oservice->id); ?>" target="_blank"><?php echo _l('export_project_data'); ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if(is_admin()){ ?>
                                            <li>
                                                <a href="<?php echo admin_url('LegalServices/Other_services_controller/view_project_as_client/'.$service_slug.'/'.$service_id.'/'.$oservice->id .'/'.$oservice->clientid); ?>" target="_blank"><?php echo _l('project_view_as_client'); ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if(has_permission('projects','','delete')){ ?>
                                            <li>
                                                <a href="<?php echo admin_url('LegalServices/SOther/delete/'.$ServID.'/'.$oservice->id); ?>" class="_delete">
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
                        <?php hooks()->do_action('before_render_oservice_view', $oservice->id); ?>
                        <?php $this->load->view('admin/LegalServices/other_services/oservice_tabs'); ?>
                    </div>
                </div>
                <?php 
                if((has_permission('projects','','create') || has_permission('projects','','edit'))
                    && $oservice->status == 1
                    && $oservice_model->timers_started_for_oservice($service->slug, $oservice->id)
                    && $tab['slug'] != 'oservice_milestones') {
                    ?>
                    <div class="alert alert-warning project-no-started-timers-found mbot15">
                        <?php echo _l('project_not_started_status_tasks_timers_found'); ?>
                    </div>
                <?php } ?>
                <?php
                if($oservice->deadline && date('Y-m-d') > $oservice->deadline
                    && $oservice->status == 2
                    && $tab['slug'] != 'oservice_milestones') {
                    ?>
                    <div class="alert alert-warning bold project-due-notice mbot15">
                        <?php echo _l('project_due_notice', floor((abs(time() - strtotime($oservice->deadline)))/(60*60*24))); ?>
                    </div>
                <?php } ?>
                <?php
                if(!has_contact_permission('projects',get_primary_contact_user_id($oservice->clientid))
                    && total_rows(db_prefix().'contacts',array('userid'=>$oservice->clientid)) > 0
                    && $tab['slug'] != 'oservice_milestones') {
                    ?>
                    <div class="alert alert-warning project-permissions-warning mbot15">
                        <?php echo _l('project_customer_permission_warning'); ?>
                    </div>
                <?php } ?>
                <div class="panel_s">
                    <div class="panel-body">
                        <?php $this->load->view(($tab ? $tab['view'] : 'admin/LegalServices/other_services/oservice_overview')); ?>
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
<div id="invoice_oservice"></div>
<div id="pre_invoice_oservice"></div>
<?php $this->load->view('admin/LegalServices/other_services/milestone'); ?>
<?php $this->load->view('admin/LegalServices/other_services/copy_settings'); ?>
<?php $this->load->view('admin/LegalServices/other_services/_mark_tasks_finished'); ?>
<?php init_tail(); ?>
<!-- For invoices table -->
<script>
    taskid = '<?php echo $this->input->get('taskid'); ?>';
</script>
<script>
    var gantt_data = {};
    <?php if(isset($gantt_data)){ ?>
    gantt_data = <?php echo json_encode($gantt_data); ?>;
    <?php } ?>
    var discussion_id = $('input[name="discussion_id"]').val();
    var discussion_user_profile_image_url = $('input[name="discussion_user_profile_image_url"]').val();
    var current_user_is_admin = $('input[name="current_user_is_admin"]').val();
    var oservice_id = $('input[name="oservice_id"]').val();
	var service_id = <?php echo $service->id; ?>;
	var service_slug = "<?php echo $service->slug; ?>";
    if(typeof(discussion_id) != 'undefined'){
        discussion_comments('#discussion-comments',discussion_id,'regular');
    }
    $(function(){
        var oservice_progress_color = '<?php echo hooks()->apply_filters('admin_project_progress_color','#84c529'); ?>';
        var circle = $('.oservice-progress').circleProgress({fill: {
                gradient: [oservice_progress_color, oservice_progress_color]
            }}).on('circle-animation-progress', function(event, progress, stepValue) {
            $(this).find('strong.oservice-percent').html(parseInt(100 * stepValue) + '<i>%</i>');
        });
    });

    function discussion_comments(selector,discussion_id,discussion_type){
        var defaults = _get_jquery_comments_default_config(<?php echo json_encode(get_oservice_discussions_language_array()); ?>);
        var options = {
            currentUserIsAdmin:current_user_is_admin,
            getComments: function(success, error) {
                $.get(admin_url + 'LegalServices/Other_services_controller/get_discussion_comments/'+discussion_id+'/'+discussion_type,function(response){
                    success(response);
                },'json');
            },
            postComment: function(commentJSON, success, error) {
                $.ajax({
                    type: 'post',
                    url: admin_url + 'LegalServices/Other_services_controller/add_discussion_comment/'+discussion_id+'/'+discussion_type,
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
                    url: admin_url + 'LegalServices/Other_services_controller/update_discussion_comment',
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
                    url: admin_url + 'LegalServices/Other_services_controller/delete_discussion_comment/'+commentJSON.id,
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
                            url: admin_url + 'LegalServices/Other_services_controller/add_discussion_comment/'+discussion_id+'/'+discussion_type,
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
</body>
</html>
