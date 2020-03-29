<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (has_permission('tasks', '', 'create')) { ?>
    <a href="#" onclick="new_session(undefined,'<?php echo $service->slug; ?>',<?php echo $rel_id; ?>); return false;" class="btn btn-info"><?php echo _l('add_new_session'); ?></a>
<?php } ?>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
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
        <?php
        $table_data = [
            _l('the_number_sign'),
            [
                'name'     => _l('name'),
                'th_attrs' => [
                    'style' => 'min-width:150px',
                ],
            ],
            _l('session_assigned'),
            _l('Court'),
            //_l('session_info'),
            _l('Customer_report'),
            _l('Send_to_customer'),
            _l('session_date'),
            _l('session_time'),
        ];
        $table_attributes['data-new-rel-slug'] = $service->slug;
        render_datatable($table_data, 'waiting_sessions_log', [], $table_attributes);
        ?>
    </div>
    <div role="tabpanel" class="tab-pane " id="Previous_Sessions">
        <?php
        $table_data = [
            _l('the_number_sign'),
            [
                'name'     => _l('name'),
                'th_attrs' => [
                    'style' => 'min-width:150px',
                ],
            ],
            _l('session_assigned'),
            _l('Court'),
//            _l('Court_decision'),
            _l('Customer_report'),
            _l('Send_to_customer'),
            _l('session_date'),
            _l('session_time'),
            _l('Customer_report'),
        ];
        $table_attributes['data-new-rel-slug'] = $service->slug;
        render_datatable($table_data, 'previous_sessions_log', [], $table_attributes);
        ?>
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
<script type="text/javascript">
    // Create new session directly from relation, related options selected after modal is shown
    function new_session(table, rel_type, rel_id) {
        if (typeof(rel_type) == 'undefined' && typeof(rel_id) == 'undefined') {
            rel_id = $(table).data('new-rel-id');
            rel_type = $(table).data('new-rel-type');
        }
        var url = admin_url + 'tasks/services_sessions?rel_id=' + rel_id + '&rel_type=' + rel_type;
        new_session_url(url);
    }

    // New task function, various actions performed
    function new_session_url(url) {

        url = typeof(url) != 'undefined' ? url : admin_url + 'tasks/services_sessions';

        var $leadModal = $('#lead-modal');
        if ($leadModal.is(':visible')) {
            url += '&opened_from_lead_id=' + $leadModal.find('input[name="leadid"]').val();
            if (url.indexOf('?') === -1) { url = url.replace('&', '?'); }
            $leadModal.modal('hide');
        }

        var $taskSingleModal = $('#task-modal');
        if ($taskSingleModal.is(':visible')) { $taskSingleModal.modal('hide'); }

        var $taskEditModal = $('#_task_modal');
        if ($taskEditModal.is(':visible')) { $taskEditModal.modal('hide'); }

        requestGet(url).done(function(response) {
            $('#_task').html(response);
            $("body").find('#_task_modal').modal({ show: true, backdrop: 'static' });
        }).fail(function(error) {
            alert_float('danger', error.responseText);
        })
    }

    // Go to edit view
    function edit_session(task_id) {
        requestGet('tasks/services_sessions/' + task_id).done(function(response) {
            $('#_task').html(response);
            $('#task-modal').modal('hide');
            $("body").find('#_task_modal').modal({ show: true, backdrop: 'static' });
        });
    }

    // Init task modal and get data from server
    function init_task_modal_session(task_id, comment_id) {

        var queryStr = '';
        var $leadModal = $('#lead-modal');
        var $taskAddEditModal = $('#_task_modal');
        if ($leadModal.is(':visible')) {
            queryStr += '?opened_from_lead_id=' + $leadModal.find('input[name="leadid"]').val();
            $leadModal.modal('hide');
        } else if ($taskAddEditModal.attr('data-lead-id') != undefined) {
            queryStr += '?opened_from_lead_id=' + $taskAddEditModal.attr('data-lead-id');
        }

        requestGet('tasks/get_task_data_with_session/' + task_id + queryStr).done(function(response) {
            _task_append_html(response);
            if (typeof(comment_id) != 'undefined') {
                setTimeout(function() {
                    $('[data-task-comment-href-id="' + comment_id + '"]').click();
                }, 1000);
            }
        }).fail(function(data) {
            $('#task-modal').modal('hide');
            alert_float('danger', data.responseText);
        });
    }

    // Task single edit description with inline editor, used from task single modal
    function edit_session_inline_court_decision(e, id) {

        tinyMCE.remove('#court_decision');

        if ($(e).hasClass('editor-initiated')) {
            $(e).removeClass('editor-initiated');
            return;
        }

        $(e).addClass('editor-initiated');
        $.Shortcuts.stop();
        tinymce.init({
            selector: '#court_decision',
            theme: 'inlite',
            skin: 'perfex',
            auto_focus: "task_view_description",
            plugins: 'table link paste contextmenu textpattern',
            insert_toolbar: 'quicktable',
            selection_toolbar: 'bold italic | quicklink h2 h3 blockquote',
            inline: true,
            table_default_styles: {
                width: '100%'
            },
            setup: function(editor) {
                editor.on('blur', function(e) {
                    if (editor.isDirty()) {
                        $.post(admin_url + 'LegalServices/ServicesSessions/update_session_court_decision/' + id, {
                            court_decision: editor.getContent()
                        });
                    }
                    setTimeout(function() {
                        editor.remove();
                        $.Shortcuts.start();
                    }, 500);
                });
            }
        });
    }

    function edit_session_inline_session_information(e, id) {

        tinyMCE.remove('#session_information');

        if ($(e).hasClass('editor-initiated')) {
            $(e).removeClass('editor-initiated');
            return;
        }

        $(e).addClass('editor-initiated');
        $.Shortcuts.stop();
        tinymce.init({
            selector: '#session_information',
            theme: 'inlite',
            skin: 'perfex',
            auto_focus: "task_view_description",
            plugins: 'table link paste contextmenu textpattern',
            insert_toolbar: 'quicktable',
            selection_toolbar: 'bold italic | quicklink h2 h3 blockquote',
            inline: true,
            table_default_styles: {
                width: '100%'
            },
            setup: function(editor) {
                editor.on('blur', function(e) {
                    if (editor.isDirty()) {
                        $.post(admin_url + 'LegalServices/ServicesSessions/update_session_information/' + id, {
                            session_information: editor.getContent()
                        });
                    }
                    setTimeout(function() {
                        editor.remove();
                        $.Shortcuts.start();
                    }, 500);
                });
            }
        });
    }

    function print_session_report(task_id) {
        disabled_print_btn(task_id);
        $("#tbl9").html('');
        tag = '#';
        $.ajax({
            url: '<?php echo admin_url("LegalServices/ServicesSessions/print_report/"); ?>' + task_id,
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
            url: '<?php echo admin_url("LegalServices/ServicesSessions/checklist_items/"); ?>' + task_id,
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
    
    function disabled_print_btn(task_id) {
        $("#print_btn"+task_id).attr("disabled", true).removeAttr("onclick");
    }

    function send_report(task_id) {
        $.ajax({
            url: '<?php echo admin_url("LegalServices/ServicesSessions/send_report_to_customer/"); ?>' + task_id,
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

     // Handles task add/edit form modal.
     function session_form_handler(form) {
         tinymce.triggerSave();
         $('#_task_modal').find('input[name="startdate"]').prop('disabled', false);

         $("#_task_modal input[type=file]").each(function() {
             if ($(this).val() === "") {
                 $(this).prop('disabled', true);
             }
         });

         var formURL = form.action;
         var formData = new FormData($(form)[0]);

         $.ajax({
             type: $(form).attr('method'),
             data: formData,
             mimeType: $(form).attr('enctype'),
             contentType: false,
             cache: false,
             processData: false,
             url: formURL
         }).done(function(response) {
             response = JSON.parse(response);
             if (response.success === true || response.success == 'true') { alert_float('success', response.message); }
             if (!$("body").hasClass('project')) {
                 $('#_task_modal').attr('data-task-created', true);
                 $('#_task_modal').modal('hide');
                 init_task_modal_session(response.id);
                 reload_tasks_tables();
                 if ($('body').hasClass('kan-ban-body') && $('body').hasClass('tasks')) {
                     tasks_kanban();
                 }
             } else {
                 // reload page on project area
                 var location = window.location.href;
                 var params = [];
                 location = location.split('?');
                 var group = get_url_param('group');
                 var excludeCompletedTasks = get_url_param('exclude_completed');
                 if (group) { params['group'] = group; }
                 if (excludeCompletedTasks) { params['exclude_completed'] = excludeCompletedTasks; }
                 params['sessionid'] = response.id;
                 window.location.href = buildUrl(location[0], params);
             }
         }).fail(function(error) {
             alert_float('danger', JSON.parse(error.responseText));
         });

         return false;
     }

     function load_time_picker(id) {
         $('#next_session_time'+id).datetimepicker({
             datepicker:false,
             format:'H:i'
         });
     }

</script>
