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
            _l('session_info'),
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
            _l('Court_decision'),
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
<div class="modal fade" id="customer_report" tabindex="-1" role="dialog" aria-labelledby="customer_report" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('Customer_report'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" app-field-wrapper="date">
                            <label for="date" class="control-label"><?php echo _l('session_date'); ?></label>
                            <div class="input-group date">
                                <input type="text" id="next_session_date" name="next_session_date" class="form-control datepicker" value="<?php /*echo '20' . date('y') . '-' . date('m') . '-' . date('d'); */?>" autocomplete="off" aria-invalid="false">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar calendar-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="ammount" class="col-form-label"><?php echo _l('session_time'); ?></label>
                        <input type="time" class="form-control" id="next_session_time" name="next_session_time">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="bold"><?php echo _l('Court_decision'); ?></p>
                        <textarea type="text" class="form-control" id="edit_court_decision" name="edit_court_decision" rows="6" placeholder="<?php echo _l('Court_decision'); ?>"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="button" id="edit_details" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="session_report_data" class="hide">
    <h3 class="text-center"><u><?php echo _l('session_report'); ?></u></h3>
    <table class="table scroll-responsive text-center">
        <thead>
        <tr>
            <th style="width: 20%;text-align: center">اطراف القضية</th>
            <td id="tbl1" style="border: 1px solid #ebf5ff"></td>
        </tr>
        <tr>
            <th style="width: 20%;;text-align: center">المحكمة المختصة بنظر القضية</th>
            <td id="tbl2"></td>
        </tr>
        <tr>
            <th style="width: 20%;;text-align: center">رقم القضية</th>
            <td id="tbl3"></td>
        </tr>
        <tr>
            <th style="width: 20%;;text-align: center">موعد الجلسة</th>
            <td id="tbl4"></td>
        </tr>
        <tr>
            <th style="width: 20%;;text-align: center">وقائع الجلسة</th>
            <td id="tbl5"></td>
        </tr>
        <tr>
            <th style="width: 20%;;text-align: center">الإجراء القادم</th>
            <td id="tbl6"></td>
        </tr>
        </thead>
    </table>
</div>
<script type="text/javascript">
     //init_datepicker();
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
            console.log(error);
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
        tag = '#';
        $.ajax({
            url: '<?php echo admin_url("LegalServices/ServicesSessions/get_session_data_to_print/"); ?>' + task_id,
            success: function (data) {
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    $(tag+key).html(value);
                });
            }
        });
        setTimeout(function(){
            var printContents = document.getElementById("session_report_data").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        },500);
        reload_tasks_tables();
    }
</script>
<!--<div class="modal fade" id="add_session" tabindex="-1" role="dialog" aria-labelledby="add_session" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php /*echo _l('add_new_session'); */?></span>
                </h4>
            </div>
            <div class="modal-body">
                <form id="form_transout" method="get" action="<?php /*echo base_url() . 'session/old_service_sessions/add/'.$rel_id.'/'.$service_id . '/' . get_staff_user_id() */?>">
                    <input type="hidden" name="rel_type" value="<?php /*echo $service->slug; */?>">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="subject" class="col-form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="staff_id" class="col-form-label">Court</label>
                            <div class="row-fluid">
                                <select required style="padding: 6px 9px; border-radius: 3px; width: 100%" name="court_id">
                                    <option value="">Not Selected</option>
                                    <?php /*foreach ($courts as $court){ */?>

                                        <option value="<?php /*echo $court['c_id'] */?>"><?php /*echo $court['court_name'] */?></option>

                                    <?php /*} */?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="staff_id" class="col-form-label">Judge</label>
                            <div class="row-fluid">
                                <select name="judge_id" required style="padding: 6px 9px; border-radius: 3px; width: 100%" >
                                    <option value="">Not Selected</option>
                                    <?php /*foreach ($judges as $judge){ */?>
                                        <option value="<?php /*echo $judge['id'] */?>"><?php /*echo $judge['name'] */?></option>
                                    <?php /*} */?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6" app-field-wrapper="date">
                                <label for="date" class="control-label">Date</label>
                                <div class="input-group date">
                                    <input type="text" id="date" name="date" class="form-control datepicker" value="<?php /*echo '20' . date('y') . '-' . date('m') . '-' . date('d'); */?>" autocomplete="off" aria-invalid="false">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar calendar-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="ammount" class="col-form-label">Time</label>
                                <input type="time" class="form-control" value="" name="time">
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="update_session" tabindex="-1" role="dialog" aria-labelledby="update_session" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Update Session</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_transout" method="get" action="<?php /*echo base_url() . 'session/old_service_sessions/update/'.$rel_id.'/'.$service_id */?>">
                    <div class="form-group">
                        <input aria-hidden="true" type="hidden" class="form-control" id="id" name="id">
                        <div class="form-group">
                            <label for="subject" class="col-form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="staff_id" class="col-form-label">Court</label>
                            <div class="row-fluid">
                                <select required style="padding: 6px 9px; border-radius: 3px; width: 100%" name="court_id">
                                    <?php /*foreach ($courts as $court){ */?>
                                        <option value="<?php /*echo $court['c_id'] */?>"><?php /*echo $court['court_name'] */?></option>
                                    <?php /*} */?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="staff_id" class="col-form-label">Judge</label>
                            <div class="row-fluid">
                                <select name="judge_id" required style="padding: 6px 9px; border-radius: 3px; width: 100%" ><?php /*foreach ($judges as $judge){ */?>

                                        <option value="<?php /*echo $judge['id'] */?>"><?php /*echo $judge['name'] */?></option>
                                    <?php /*} */?>
                                </select>

                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6" app-field-wrapper="date">
                                <label for="date" class="control-label">Date</label>
                                <div class="input-group date">
                                    <input type="text" id="date" name="date" class="form-control datepicker" value="<?php /*echo '20' . date('y') . '-' . date('m') . '-' . date('d'); */?>" autocomplete="off" aria-invalid="false">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar calendar-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="ammount" class="col-form-label">Time</label>
                                <input type="time" class="form-control" value="" name="time">
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>-->

