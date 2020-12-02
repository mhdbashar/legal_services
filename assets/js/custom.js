let lang = "english";
let dateType = "AD";
let isHijri = "off";
let hijriPages = "";
let adjust = "0";

$.ajax({
    type: 'Get',
    url: admin_url + 'My_custom_controller/get_date_options',
    async: false,
    success: function(data) {

        isHijri = JSON.parse(data).isHijri;
        lang = JSON.parse(data).lang;
        dateType = JSON.parse(data).mode;
        hijriPages = JSON.parse(data).hijri_pages;
    },

});

var current_url = window.location.href;
var daminURL= admin_url;
var this_page = current_url.replace(daminURL,'');

function isJson(data){
    try {
        JSON.parse(data);
    }catch (e) {
        return false;
    }
    return true;
}

function search_url(hijriPages, url){
    var i = 0;
    if(isJson(hijriPages)){
        $.each(JSON.parse(hijriPages), function (index, page) {
            if(url.search(page) != -1){
                i++
            }
        });
    }

    return i;
}

if(search_url(hijriPages,this_page) != 0){
    if((dateType == 'hijri') && (isHijri == "on") ) {
        if(true){

            function appDatepicker(e) {
                initHijrDatePicker();
            }

            function initHijrDatePicker() {
                let dateobj = document.getElementsByClassName('datepicker');
                let datetimeobj = document.getElementsByClassName('datetimepicker');

                $.each(datetimeobj, function (k, v) {

                    let stored= $(this).val();

                    $(this).hijriDatePicker({
                        locale: "ar-sa",
                        hijriFormat:"iYYYY-iMM-iDD hh:mm",
                        //dayViewHeaderFormat: "MMMM YYYY",
                        //hijriDayViewHeaderFormat: "iMMMM iYYYY",
                        showSwitcher: false,
                        allowInputToggle: true,
                        showTodayButton: false,
                        useCurrent: true,
                        isRTL: false,
                        keepOpen: false,
                        hijri: true,
                        debug: true,
                        showClear: true,
                        showTodayButton: true,
                        showClose: true
                    });
                    if (stored !== null){
                        $(this).val(stored);
                    }
                });
                $.each(dateobj, function (k, v) {
                    let stored= $(this).val();
                    $(this).hijriDatePicker({
                        locale: "ar-sa",
                        //format: "DD-MM-YYYY",
                        //hijriFormat:"iYYYY-iMM-iDD",
                        //dayViewHeaderFormat: "MMMM YYYY",
                        //hijriDayViewHeaderFormat: "iMMMM iYYYY",
                        showSwitcher: false,
                        allowInputToggle: true,
                        showTodayButton: false,
                        useCurrent: true,
                        isRTL: false,
                        keepOpen: false,
                        hijri: true,
                        debug: true,
                        showClear: true,
                        showTodayButton: true,
                        showClose: true
                    });
                    if (stored !== null){
                        $(this).val(stored);
                    }
                    
                });
            }

            function initHijrDatePickerDefault() {

                $("#hijri-date-input").hijriDatePicker();
            }
        }
// When the user clicks anywhere outside of the modal, close it
        $(".datepicker").on("blur", function(e) {
            var addon = $(this).parent().children('.input-group-addon');
           $($(this)[0].nextSibling).toggle(false);
            addon.removeAttr('style');
        });
        $(".datepicker").on("click", function(e) {
            $($(this)[0].nextSibling).toggle(true);
        });
        $(".datetimepicker").on("blur", function(e) {
            $($(this)[0].nextSibling).toggle(false);
        });
        $(".datetimepicker").on("click", function(e) {
            $($(this)[0].nextSibling).toggle(true);
        });
    }
}else{

}

var hijri_page = window.location.href;

hijri_page = hijri_page.replace(admin_url,'');

if(hijri_page == 'settings?group=Hijri'){

    $(document).ready(function(){

        var isHijriVal = isHijri; // from database
        var Hijrichange = "off";
        var checked= false;
        if(isHijriVal == "on"){
            document.getElementById('hijri_check').checked =true;
            $(".toggle").removeClass('btn btn-light off');
            $(".toggle").addClass('btn btn-primary');
            $("#adjust_div").show();
            $("#tbl_div").show();


        }else{
            $("#adjust_div").hide();
            $("#tbl_div").hide();
        }

        $("#hijri_check").on('change', function () {
            checked = document.getElementById("hijri_check").checked;
            if(checked){
                Hijrichange ="on";
            }else {
                Hijrichange = "off";
            }

            if(Hijrichange == "on"){
                $("#adjust_div").show();
                $("#tbl_div").show();
            }else{
                $("#adjust_div").hide();
                $("#tbl_div").hide();
            }

        });
        var arr =[];
        if(hijriPages != []){
            arr = JSON.parse(hijriPages);
        }

        var i=0;
        if (arr && arr.length != 0) {
            $.each(arr, function( index, value ) {
                $('#addr'+index).html("<td>"+ (index+1) +"</td><td><input name='link"+index+"' type='text' value='"+value+"'  class='form-control input-md'  /> </td>");

                $('#tab_logic').append('<tr id="addr'+(index+1)+'"></tr>');
                i = index+1;
            });

        } else {
            $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='link"+i+"' type='text' placeholder='Link' class='form-control input-md'  /> </td>");
            $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
            i=1;
        }



        $("#add_row").click(function(){
            $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='link"+i+"' type='text' placeholder='Link' class='form-control input-md'  /> </td>");

            $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
            i++;
        });
        $("#delete_row").click(function(){
            if(i>1){
                $("#addr"+(i-1)).html('');
                i--;
            }
        });

    });
    $(document).on('click',"#btn_add_adjust", function () {

        var month = $('#month_adj').val();
        var year = $('#year_adj').val();
        $.ajax({
            type: 'Get',
            url: admin_url + 'My_custom_controller/add_adjust_form',
            data: {
                add_month : month,
                add_year : year,
            },
            success: function(data) {
                $('#add_form_adj').append(data);

                $("#btn_add_adjust").attr('disabled','disabled');
            },

        });

    });

    $(document).on('click',"#add_adjust_action", function () {

        $(this).attr('disabled','disabled');

        var month = $('#month_adj').val();
        var year = $('#year_adj').val();
        var target_value = $('#target_adjust').val();
        $.ajax({
            type: 'Get',
            url: admin_url + 'My_custom_controller/set_hijri_adjust',
            data: {
                add_month : month,
                add_year : year,
                add_value: target_value,
            },
            success: function(data) {
                var res_data = JSON.parse(data);
                $('#new_adjustement').append(res_data.new);
                $('#txt_adj').val(res_data.adjdata);
                $('#adjust_data').val(res_data.adjdata);



            },

        });

    });

    $(document).on('click',"#cancel_btn", function () {
        $(this).parents('#form_div').hide();
        $("#btn_add_adjust").attr('disabled',false);

    });

    $(document).on('click',"#delete_btn", function () {
        $(this).parents('#delete_div').hide();
        var month = $(this).data('month');
        var year = $(this).data('year');

        $.ajax({
            type: 'Get',
            url: admin_url + 'My_custom_controller/delete_hijri_adjust',
            data: {
                del_month : month,
                del_year : year,
            },
            success: function(data) {
                var res_data = JSON.parse(data);
                $('#new_adjustement').append(res_data.new);
                $('#txt_adj').val(res_data.adjdata);
                $('#adjust_data').val(res_data.adjdata);
            },

        });
    });

    $(document).on('click',"#delete_his_btn", function () {
        var month = $(this).data('month');
        var year = $(this).data('year');

        $.ajax({
            type: 'Get',
            url: admin_url + 'My_custom_controller/delete_hijri_adjust',
            data: {
                del_month : month,
                del_year : year,
            },
            success: function(data) {
                var res_data = JSON.parse(data);
                $('#txt_adj').val(res_data.adjdata);
                $('#adjust_data').val(res_data.adjdata);
            },

        });
        $('#delete_his_div').hide();
    });
}

$("body").on('change', '.f_client_id select[name="clientid"]', function() {
    $('#rel_sid').html('');
    var val = $(this).val();
    var servicesWrapper = $('.services-wrapper');
    if (!val) {
        servicesWrapper.addClass('hide');
    }else {
        servicesWrapper.removeClass('hide');
    }
});

function get_legal_services_by_slug() {
    $('#div_rel_sid').removeClass('hide');
    $('#rel_sid').html('');
    slug = $('#rel_stype').val();
    clientid = $('select[name="clientid"]').val();
    $.ajax({
        type: 'POST',
        url: admin_url + 'LegalServices/LegalServices_controller/all_legal_services',
        data: {
            clientid : clientid,
            slug : slug
        },
        success: function(data) {
            response = JSON.parse(data);
            $('#rel_sid').append('<option value="" disabled selected>-- --</option>');
            $.each(response, function (key, value) {
                $('#rel_sid').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
            });
        }
    });

}

$(function() {

     /** Create New Case **/
     add_hotkey('Shift+P', function() {
        window.location.href = admin_url + 'Case/add/1';
    });

    /** List Cases **/
    add_hotkey('Alt+P', function() {
        window.location.href = admin_url + 'Service/1';
    });

    table_sessions = $('.table-sessions');
    if (table_sessions.length) {
        var SessionsServerParams = {},
            Sessions_Filters;
        Sessions_Filters = $('._hidden_inputs._filters._tasks_filters input');
        $.each(Sessions_Filters, function() {
            SessionsServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
        });

        // Tasks not sortable
        var sessionsTableNotSortable = [0]; // bulk actions
        var sessionsTableURL = admin_url + 'LegalServices/sessions/table';

        if ($("body").hasClass('tasks-page')) {
            sessionsTableURL += '?bulk_actions=true';
        }

        _table_api = initDataTable(table_sessions, sessionsTableURL, sessionsTableNotSortable, sessionsTableNotSortable, SessionsServerParams, [table_sessions.find('th.duedate').index(), 'asc']);

        if (_table_api && $("body").hasClass('dashboard')) {
            _table_api.column(5).visible(false, false)
                .column(6).visible(false, false)
                .columns.adjust();
        }
    }

    // Copy task href/button event.
    $("body").on('click', '.copy_session_action', function() {
        var data = {};
        $(this).prop('disabled', true);
        data.copy_from = $(this).data('task-copy-from');
        data.copy_task_assignees = $("body").find('#copy_task_assignees').prop('checked');
        data.copy_task_followers = $("body").find('#copy_task_followers').prop('checked');
        data.copy_task_checklist_items = $("body").find('#copy_task_checklist_items').prop('checked');
        data.copy_task_attachments = $("body").find('#copy_task_attachments').prop('checked');
        data.copy_task_status = $("body").find('input[name="copy_task_status"]:checked').val();
        $.post(admin_url + 'LegalServices/sessions/copy', data).done(function(response) {
            response = JSON.parse(response);
            if (response.success === true || response.success == 'true') {
                var $taskModal = $('#_task_modal');
                if ($taskModal.is(':visible')) {
                    $taskModal.modal('hide');
                }
                init_session_modal(response.new_task_id);
                reload_sessions_tables();

            }
            alert_float(response.alert_type, response.message);
        });
        return false;
    });

    // Add follower to task
    $("body").on('change', 'select[name="select-session-followers"]', function() {
        var data = {};
        data.follower = $('select[name="select-session-followers"]').val();
        if (data.follower !== '') {
            data.taskid = $(this).attr('data-task-id');
            $("body").append('<div class="dt-loader"></div>');
            $.post(admin_url + 'LegalServices/Sessions/add_task_followers', data).done(function(response) {
                response = JSON.parse(response);
                $("body").find('.dt-loader').remove();
                _task_append_html(response.taskHtml);
            });
        }
    });

    // Assign task to staff member
    $("body").on('change', 'select[name="select-session-assignees"]', function() {
        $("body").append('<div class="dt-loader"></div>');
        var data = {};
        data.assignee = $('select[name="select-session-assignees"]').val();
        if (data.assignee !== '') {
            data.taskid = $(this).attr('data-task-id');
            $.post(admin_url + 'LegalServices/Sessions/add_task_assignees', data).done(function(response) {
                $("body").find('.dt-loader').remove();
                response = JSON.parse(response);
                reload_sessions_tables();
                _task_append_html(response.taskHtml);
            });
        }
    });

    // New timesheet add manually from session single modal
    $("body").on('click', '.session-single-add-timesheet', function(e) {
        e.preventDefault();
        var start_time = $("body").find('#task-modal input[name="timesheet_start_time"]').val();
        var end_time = $("body").find('#task-modal input[name="timesheet_end_time"]').val();
        var duration = $("body").find('#task-modal input[name="timesheet_duration"]').val();
        if ((start_time !== '' && end_time !== '') || duration !== '') {
            var data = {};
            data.timesheet_duration = duration;
            data.start_time = start_time;
            data.end_time = end_time;
            data.timesheet_task_id = $(this).data('task-id');
            data.note = $("body").find('#task_single_timesheet_note').val();
            data.timesheet_staff_id = $("body").find('#task-modal select[name="single_timesheet_staff_id"]').val();
            $.post(admin_url + 'LegalServices/Sessions/log_time', data).done(function(response) {
                response = JSON.parse(response);
                if (response.success === true || response.success == 'true') {
                    init_session_modal(data.timesheet_task_id);
                    alert_float('success', response.message);
                    setTimeout(function() {
                        reload_sessions_tables();
                    }, 20);
                } else {
                    alert_float('warning', response.message);
                }
            });
        }
    });

    // Delete session timesheet from the session single modal
    $("body").on('click', '.session-single-delete-timesheet', function(e) {
        e.preventDefault();
        if (confirm_delete()) {
            var _delete_timesheet_task_id = $(this).data('task-id');
            requestGet($(this).attr('href')).done(function(response) {
                init_session_modal(_delete_timesheet_task_id);
                setTimeout(function() {
                    reload_sessions_tables();
                    init_timers();
                }, 20);
            });
        }
    });

    init_table_staff_cases();
    init_table_staff_services();
});
$(document).ready(function() {



    var numItems = $('li.fancyTab').length;


    if (numItems == 12){
        $("li.fancyTab").width('8.3%');
    }
    if (numItems == 11){
        $("li.fancyTab").width('9%');
    }
    if (numItems == 10){
        $("li.fancyTab").width('10%');
    }
    if (numItems == 9){
        $("li.fancyTab").width('11.1%');
    }
    if (numItems == 8){
        $("li.fancyTab").width('12.5%');
    }
    if (numItems == 7){
        $("li.fancyTab").width('14.2%');
    }
    if (numItems == 6){
        $("li.fancyTab").width('16.666666666666667%');
    }
    if (numItems == 5){
        $("li.fancyTab").width('20%');
    }
    if (numItems == 4){
        $("li.fancyTab").width('25%');
    }
    if (numItems == 3){
        $("li.fancyTab").width('33.3%');
    }
    if (numItems == 2){
        $("li.fancyTab").width('50%');
    }




});

$(window).load(function() {

    $('.fancyTabs').each(function() {

        var highestBox = 0;
        $('.fancyTab a', this).each(function() {

            if ($(this).height() > highestBox)
                highestBox = $(this).height();
        });

        $('.fancyTab a', this).height(highestBox);

    });
});

$(function() {
    init_table_staff_cases();
    init_table_staff_services();

    $('#dispute_top').on('change', function() {
        var val = $(this).val();
        var __project_group = get_url_param('group');
        if (__project_group) {
            __project_group = '?group=' + __project_group;
        } else {
            __project_group = '';
        }
        window.location.href = admin_url + 'disputes/view/' + val + __project_group;
    });
});
// Staff cases table in staff profile
function init_table_staff_cases(manual) {
    if (typeof(manual) == 'undefined' && $("body").hasClass('dashboard')) { return false; }
    if ($("body").find('.table-staff-cases').length === 0) { return; }

    var staffProjectsParams = {},
        Staff_Projects_Filters = $('._hidden_inputs._filters.staff_projects_filter input');

    $.each(Staff_Projects_Filters, function() {
        staffProjectsParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
    });

    initDataTable('.table-staff-cases', admin_url + 'LegalServices/Cases_controller/staff_cases', 'undefined', 'undefined', staffProjectsParams, [2, 'asc']);
}

// Staff services table in staff profile
function init_table_staff_services(manual) {
    if (typeof(manual) == 'undefined' && $("body").hasClass('dashboard')) { return false; }
    if ($("body").find('.table-staff-services').length === 0) { return; }

    var staffProjectsParams = {},
        Staff_Projects_Filters = $('._hidden_inputs._filters.staff_projects_filter input');

    $.each(Staff_Projects_Filters, function() {
        staffProjectsParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
    });

    initDataTable('.table-staff-services', admin_url + 'LegalServices/Other_services_controller/staff_services', 'undefined', 'undefined', staffProjectsParams, [2, 'asc']);
}

// Reload all session possible table where the table data needs to be refreshed after an action is performed on session.
function reload_sessions_tables() {
    var av_sessions_tables = ['.table-sessions', '.table-rel-sessions', '.table-rel-sessions-leads', '.table-timesheets', '.table-timesheets-report'];
    $.each(av_sessions_tables, function(i, selector) {
        if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().ajax.reload(null, false);
        }
    });
}

// Init session modal and get data from server
// function init_session_modal(task_id, comment_id) {
//     var queryStr = '';
//     var $leadModal = $('#lead-modal');
//     var $taskAddEditModal = $('#_task_modal');
//     if ($leadModal.is(':visible')) {
//         queryStr += '?opened_from_lead_id=' + $leadModal.find('input[name="leadid"]').val();
//         $leadModal.modal('hide');
//     } else if ($taskAddEditModal.attr('data-lead-id') != undefined) {
//         queryStr += '?opened_from_lead_id=' + $taskAddEditModal.attr('data-lead-id');
//     }
//
//     requestGet('LegalServices/Sessions/get_task_data/' + task_id + queryStr).done(function(response) {
//         _task_append_html(response);
//         if (typeof(comment_id) != 'undefined') {
//             setTimeout(function() {
//                 $('[data-task-comment-href-id="' + comment_id + '"]').click();
//             }, 1000);
//         }
//     }).fail(function(data) {
//         $('#task-modal').modal('hide');
//         alert_float('danger', data.responseText);
//     });
// }

// New session function, various actions performed
function new_session(url) {
    url = typeof(url) != 'undefined' ? url : admin_url + 'LegalServices/Sessions/task';

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

// Sessions bulk actions action
function sessions_bulk_action(event) {
    if (confirm_delete()) {
        var ids = [],
            data = {},
            mass_delete = $('#mass_delete').prop('checked');
        if (mass_delete == false || typeof(mass_delete) == 'undefined') {
            data.status = $('#move_to_status_tasks_bulk_action').val();

            var assignees = $('#task_bulk_assignees');
            data.assignees = assignees.length ? assignees.selectpicker('val') : '';

            var tags_bulk = $('#tags_bulk');
            data.tags = tags_bulk.length ? tags_bulk.tagit('assignedTags') : '';

            var milestone = $('#task_bulk_milestone');
            data.milestone = milestone.length ? milestone.selectpicker('val') : '';

            data.priority = $('#task_bulk_priority').val();
            data.priority = typeof(data.priority) == 'undefined' ? '' : data.priority;

            if (data.status === '' && data.priority === '' && data.tags === '' && data.assignees === '' && data.milestone === '') {
                return;
            }
        } else {
            data.mass_delete = true;
        }
        var rows = $($('#tasks_bulk_actions').attr('data-table')).find('tbody tr');
        $.each(rows, function() {
            var checkbox = $($(this).find('td').eq(0)).find('input');
            if (checkbox.prop('checked') === true) {
                ids.push(checkbox.val());
            }
        });
        data.ids = ids;
        $(event).addClass('disabled');
        setTimeout(function() {
            $.post(admin_url + 'LegalServices/Sessions/bulk_action', data).done(function() {
                window.location.reload();
            });
        }, 200);
    }
}

// Create new session directly from relation, related options selected after modal is shown
function new_session_from_relation(table, rel_type, rel_id) {
    if (typeof(rel_type) == 'undefined' && typeof(rel_id) == 'undefined') {
        rel_id = $(table).data('new-rel-id');
        rel_type = $(table).data('new-rel-type');
    }
    var url = admin_url + 'LegalServices/Sessions/task?rel_id=' + rel_id + '&rel_type=' + rel_type;
    new_session(url);
}

// Init session modal and get data from server
function init_session_modal(task_id, comment_id) {

    var queryStr = '';
    var $leadModal = $('#lead-modal');
    var $taskAddEditModal = $('#_task_modal');
    if ($leadModal.is(':visible')) {
        queryStr += '?opened_from_lead_id=' + $leadModal.find('input[name="leadid"]').val();
        $leadModal.modal('hide');
    } else if ($taskAddEditModal.attr('data-lead-id') != undefined) {
        queryStr += '?opened_from_lead_id=' + $taskAddEditModal.attr('data-lead-id');
    }

    requestGet('LegalServices/Sessions/get_task_data/' + task_id + queryStr).done(function(response) {
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

// Change session priority from sigle modal
function session_change_priority(priority_id, task_id) {
    url = 'LegalServices/Sessions/change_priority/' + priority_id + '/' + task_id;
    var taskModalVisible = $('#task-modal').is(':visible');
    url += '?single_task=' + taskModalVisible;
    requestGetJSON(url).done(function(response) {
        if (response.success === true || response.success == 'true') {
            reload_sessions_tables();
            if (taskModalVisible) { _task_append_html(response.taskHtml); }
        }
    });
}

// Go to edit view
function edit_session(task_id) {
    requestGet('LegalServices/Sessions/task/' + task_id).done(function(response) {
        $('#_task').html(response);
        $('#task-modal').modal('hide');
        $("body").find('#_task_modal').modal({ show: true, backdrop: 'static' });
    });
}

// Mark session status
function session_mark_as(status, task_id, url) {
    url = typeof(url) == 'undefined' ? 'LegalServices/Sessions/mark_as/' + status + '/' + task_id : url;
    var taskModalVisible = $('#task-modal').is(':visible');
    url += '?single_task=' + taskModalVisible;
    $("body").append('<div class="dt-loader"></div>');
    requestGetJSON(url).done(function(response) {
        $("body").find('.dt-loader').remove();
        if (response.success === true || response.success == 'true') {
            reload_sessions_tables();
            if (taskModalVisible) { _task_append_html(response.taskHtml); }
            if (status == 5 && typeof(_maybe_remove_task_from_project_milestone) == 'function') {
                _maybe_remove_task_from_project_milestone(task_id);
            }
            if ($('.tasks-kanban').length === 0) { alert_float('success', response.message); }
        }
    });
}

// New session reminder custom function
function new_session_reminder(id) {
    var $container = $('#newTaskReminderToggle');
    if (!$container.is(':visible') || $container.is(':visible') && $container.attr('data-edit') != undefined) {

        $container.slideDown(400, function() {
            fix_task_modal_left_col_height();
        });

        $('#taskReminderFormSubmit').html(app.lang.create_reminder);
        $container.find('form').attr('action', admin_url + 'LegalServices/Sessions/add_reminder/' + id);

        $container.find('#description').val('');
        $container.find('#date').val('');
        $container.find('#staff').selectpicker('val', $container.find('#staff').attr('data-current-staff'));
        $container.find('#notify_by_email').prop('checked', false);
        if ($container.attr('data-edit') != undefined) {
            $container.removeAttr('data-edit');
        }
        if (!$container.isInViewport()) {
            $('#task-modal').animate({
                scrollTop: $container.offset().top + 'px'
            }, 'fast');
        }
    } else {
        $container.slideUp();
    }
}

// Edit reminder function
function edit_session_reminder(id, e) {
    requestGetJSON('misc/get_reminder/' + id).done(function(response) {
        var $container = $('.reminder-modal-' + response.rel_type + '-' + response.rel_id);
        var actionURL = admin_url + 'misc/edit_reminder/' + id;
        if ($container.length === 0 && $('body').hasClass('all-reminders')) {
            // maybe from view all reminders?
            $container = $('.reminder-modal--');
            $container.find('input[name="rel_type"]').val(response.rel_type);
            $container.find('input[name="rel_id"]').val(response.rel_id);
        } else if ($('#task-modal').is(':visible')) {

            $container = $('#newTaskReminderToggle');

            if ($container.attr('data-edit') && $container.attr('data-edit') == id) {
                $container.slideUp();
                $container.removeAttr('data-edit');
            } else {
                $container.slideDown(400, function() {
                    fix_task_modal_left_col_height();
                });
                $container.attr('data-edit', id);
                if (!$container.isInViewport()) {
                    $('#task-modal').animate({
                        scrollTop: $container.offset().top + 'px'
                    }, 'fast');
                }
            }
            actionURL = admin_url + 'LegalServices/Sessions/edit_reminder/' + id;
            $('#taskReminderFormSubmit').html(app.lang.save);
        }

        $container.find('form').attr('action', actionURL);
        // For focusing the date field
        $container.find('form').attr('data-edit', true);
        $container.find('#description').val(response.description);
        $container.find('#date').val(response.date);
        $container.find('#staff').selectpicker('val', response.staff);
        $container.find('#notify_by_email').prop('checked', response.notify_by_email == 1 ? true : false);
        if ($container.hasClass('modal')) {
            $container.modal('show');
        }
    });
}

// Remove session assignee
function remove_session_assignee(id, task_id) {
    if (confirm_delete()) {
        requestGetJSON('LegalServices/Sessions/remove_assignee/' + id + '/' + task_id).done(function(response) {
            if (response.success === true || response.success == 'true') {
                alert_float('success', response.message);
                _task_append_html(response.taskHtml);
            }
        });
    }
}

// Remove session follower
function remove_session_follower(id, task_id) {
    if (confirm_delete()) {
        requestGetJSON('LegalServices/Sessions/remove_follower/' + id + '/' + task_id).done(function(response) {
            if (response.success === true || response.success == 'true') {
                alert_float('success', response.message);
                _task_append_html(response.taskHtml);
            }
        });
    }
}

// Save session edited comment
function save_session_edited_comment(id, task_id) {
    tinymce.triggerSave();
    var data = {};
    data.id = id;
    data.task_id = task_id;
    data.content = $('[data-edit-comment="' + id + '"]').find('textarea').val();
    if (is_ios()) {
        data.no_editor = true;
    }
    $.post(admin_url + 'LegalServices/Sessions/edit_comment', data).done(function(response) {
        response = JSON.parse(response);
        if (response.success === true || response.success == 'true') {
            alert_float('success', response.message);
            _task_append_html(response.taskHtml);
        } else {
            cancel_edit_comment(id);
        }
        tinymce.remove('[data-edit-comment="' + id + '"] textarea');
    });
}

// Add new session comment from the modal
function add_session_comment(task_id) {
    var data = {};

    if (taskCommentAttachmentDropzone.files.length > 0) {
        taskCommentAttachmentDropzone.processQueue(task_id);
        return;
    }
    if (tinymce.activeEditor) {
        data.content = tinyMCE.activeEditor.getContent();
    } else {
        data.content = $('#task_comment').val();
        data.no_editor = true;
    }
    data.taskid = task_id;
    $.post(admin_url + 'LegalServices/Sessions/add_task_comment', data).done(function(response) {
        response = JSON.parse(response);
        _task_append_html(response.taskHtml);
        // Remove task comment editor instance
        // Causing error because of are you sure you want to leave this page, the plugin still sees as active and dirty.
        tinymce.remove('#task_comment');
    });
}

// Action for session timer start/stop
function timer_session_action(e, task_id, timer_id, adminStop) {

    timer_id = typeof(timer_id) == 'undefined' ? '' : timer_id;

    var $timerSelectTask = $('#timer-select-task');
    if (task_id === '' && $timerSelectTask.is(':visible')) {
        return;
    }
    if (timer_id !== '' && task_id == '0') {
        var popupData = {};
        popupData.content = '';
        popupData.content += '<div class="row">';
        popupData.content += '<div class="form-group"><select id="timer_add_task_id" data-empty-title="' + app.lang.search_tasks + '" data-width="60%" class="ajax-search" data-live-search="true">';
        popupData.content += '</select></div>';
        popupData.content += '<div class="form-group">';
        popupData.content += '<textarea id="timesheet_note" placeholder="' + app.lang.note + '" style="margin:0 auto;width:60%;" rows="4" class="form-control"></textarea>';
        popupData.content += '</div>';
        popupData.content += '<button type=\'button\' onclick=\'timer_session_action(this,document.getElementById("timer_add_task_id").value,' + timer_id + ');return false;\' class=\'btn btn-info\'>' + app.lang.confirm + '</button>';

        popupData.message = app.lang.task_stop_timer;
        var $popupHTML = system_popup(popupData);
        $popupHTML.attr('id', 'timer-select-task');
        init_ajax_search('tasks', '#timer_add_task_id', undefined, admin_url + 'LegalServices/Sessions/ajax_search_assign_task_to_timer');
        return false;
    }

    $(e).addClass('disabled');

    var data = {};
    data.task_id = task_id;
    data.timer_id = timer_id;
    data.note = $("body").find('#timesheet_note').val();
    if (!data.note) { data.note = ''; }
    var taskModalVisible = $('#task-modal').is(':visible');
    var reqUrl = admin_url + 'LegalServices/Sessions/timer_tracking?single_task=' + taskModalVisible;
    if (adminStop) {
        reqUrl += '&admin_stop=' + adminStop;
    }
    $.post(reqUrl, data).done(function(response) {
        response = JSON.parse(response);

        // Timer action, stopping from staff/member/id
        if ($('body').hasClass('member')) {
            window.location.reload();
        }

        if (taskModalVisible) { _task_append_html(response.taskHtml); }

        if ($timerSelectTask.is(':visible')) {
            $timerSelectTask.find('.system-popup-close').click();
        }

        _init_timers_top_html(JSON.parse(response.timers));

        $('.popover-top-timer-note').popover('hide');
        reload_sessions_tables();
    });
}

// Fetches all staff timers and append to DOM
function init_session_timers() {
    requestGetJSON('LegalServices/Sessions/get_staff_started_timers').done(function(response) {
        _init_timers_top_html(response);
    });
}

// Tracking stats modal from session single
function session_tracking_stats(id) {
    requestGet('LegalServices/Sessions/task_tracking_stats/' + id).done(function(response) {
        $('<div/>', { id: 'tracking-stats' }).appendTo('body').html(response);
        $('#task-tracking-stats-modal').modal('toggle');
    });
}

// Marking session as complete
function session_mark_complete(task_id) {
    session_mark_as(5, task_id);
}

// Unmarking session as complete
function session_unmark_complete(task_id) {
    session_mark_as(4, task_id, 'LegalServices/Sessions/unmark_complete/' + task_id);
}

// Makes session public with AJAX request
function make_session_public(task_id) {
    requestGetJSON('LegalServices/Sessions/make_public/' + task_id).done(function(response) {
        if (response.success === true || response.success == 'true') {
            reload_sessions_tables();
            _task_append_html(response.taskHtml);
        }
    });
}

// Init session kan ban
function sessions_kanban() {
    init_kanban('LegalServices/Sessions/kanban', sessions_kanban_update, '.tasks-status', 265, 360);
}

// Updates session when action performed form kan ban area eq status changed.
function sessions_kanban_update(ui, object) {
    if (object === ui.item.parent()[0]) {
        var status = $(ui.item.parent()[0]).data('task-status-id');
        var tasks = $(ui.item.parent()[0]).find('[data-task-id]');

        var data = {};
        data.order = [];
        var i = 0;
        $.each(tasks, function () {
            data.order.push([$(this).data('task-id'), i]);
            i++;
        });

        session_mark_as(status, $(ui.item).data('task-id'));
        check_kanban_empty_col('[data-task-id]');
        setTimeout(function () {
            $.post(admin_url + 'LegalServices/Sessions/update_order', data);
        }, 200);
    }
}

// Handles session add/edit form modal.
function session_form_handler(form) {

    tinymce.triggerSave();

    $('#_task_modal').find('input[name="startdate"]').prop('disabled', false);
    // Disable the save button in cases od duplicate clicks
    $('#_task_modal').find('button[type="submit"]').prop('disabled', true);

    $("#_task_modal input[type=file]").each(function () {
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
    }).done(function (response) {
        response = JSON.parse(response);
        if (response.success === true || response.success == 'true') {
            alert_float('success', response.message);
        }

        if (window._timer_id) {
            requestGet(admin_url + '/LegalServices/Sessions/get_task_by_id/' + response.id).done(function (response) {
                $('[data-timer-id="' + window._timer_id + '"').click();
                response = JSON.parse(response);
                var option = '<option value="' + response.id + '" title="' + response.name + '" selected>' + response.name + '</option>';
                $('#timer_add_task_id').append(option);
                $('#timer_add_task_id').trigger('change').data('AjaxBootstrapSelect').list.cache = {};
                $('#timer_add_task_id').selectpicker('refresh')
                delete window._timer_id;
            });
            $('#_task_modal').modal('hide');
            $('#task-modal').modal('hide');
            return false;
        }

        if (!$("body").hasClass('project')) {
            $('#_task_modal').attr('data-task-created', true);
            $('#_task_modal').modal('hide');
            init_session_modal(response.id);
            reload_sessions_tables();
            if ($('body').hasClass('kan-ban-body') && $('body').hasClass('tasks')) {
                sessions_kanban();
            }
        } else {
            // reload page on project area
            var location = window.location.href;
            var params = [];
            location = location.split('?');
            var group = get_url_param('group');
            var excludeCompletedTasks = get_url_param('exclude_completed');
            if (group) {
                params['group'] = group;
            }
            if (excludeCompletedTasks) {
                params['exclude_completed'] = excludeCompletedTasks;
            }
            params['taskid'] = response.id;
            window.location.href = buildUrl(location[0], params);
        }
    }).fail(function (error) {
        alert_float('danger', JSON.parse(error.responseText));
    });

    return false;
}

// Session single edit description with inline editor, used from session single modal
function edit_session_inline_description(e, id) {

    tinyMCE.remove('#task_view_description');

    if ($(e).hasClass('editor-initiated')) {
        $(e).removeClass('editor-initiated');
        return;
    }

    $(e).addClass('editor-initiated');
    $.Shortcuts.stop();
    tinymce.init({
        selector: '#task_view_description',
        theme: 'inlite',
        skin: 'perfex',
        auto_focus: "task_view_description",
        plugins: 'table link paste contextmenu textpattern',
        contextmenu: "link table paste pastetext",
        insert_toolbar: 'quicktable',
        selection_toolbar: 'bold italic | quicklink h2 h3 blockquote',
        inline: true,
        table_default_styles: {
            width: '100%'
        },
        setup: function (editor) {
            editor.on('blur', function (e) {
                if (editor.isDirty()) {
                    $.post(admin_url + 'LegalServices/Sessions/update_task_description/' + id, {
                        description: editor.getContent()
                    });
                }
                setTimeout(function () {
                    editor.remove();
                    $.Shortcuts.start();
                }, 500);
            });
        }
    });
}

// New session checklist item
function add_session_checklist_item(task_id, description, e) {
    if (e) {
        $(e).addClass('disabled');
    }

    description = typeof (description) == 'undefined' ? '' : description;

    $.post(admin_url + 'LegalServices/Sessions/add_checklist_item', {
        taskid: task_id,
        description: description
    }).done(function () {
        init_session_checklist_items(true, task_id);
    }).always(function () {
        if (e) {
            $(e).removeClass('disabled');
        }
    })
}

// Fetches session checklist items.
function init_session_checklist_items(is_new, task_id) {
    $.post(admin_url + 'LegalServices/Sessions/init_checklist_items', {
        taskid: task_id
    }).done(function (data) {
        $('#checklist-items').html(data);
        if (typeof (is_new) != 'undefined') {
            var first = $('#checklist-items').find('.checklist textarea').eq(0);
            if (first.val() === '') {
                first.focus();
            }
        }
        recalculate_checklist_items_progress();
        update_session_checklist_order();
    });
}

// Updates session checklist items order
function update_session_checklist_order() {
    var order = [];
    var items = $("body").find('.checklist');
    if (items.length === 0) {
        return;
    }
    var i = 1;
    $.each(items, function () {
        order.push([$(this).data('checklist-id'), i]);
        i++;
    });
    var data = {};
    data.order = order;
    $.post(admin_url + 'LegalServices/Sessions/update_checklist_order', data);
}

// Deletes session comment from database
function remove_session_comment(commentid) {
    if (confirm_delete()) {
        requestGetJSON('LegalServices/Sessions/remove_comment/' + commentid).done(function (response) {
            if (response.success === true || response.success == 'true') {
                $('[data-commentid="' + commentid + '"]').remove();
                $('[data-comment-attachment="' + commentid + '"]').remove();
                _task_attachments_more_and_less_checks();
            }
        });
    }
}

function sessionExternalFileUpload(files, externalType, taskId) {
    $.post(admin_url + 'LegalServices/Sessions/add_external_attachment', {
        files: files,
        task_id: taskId,
        external: externalType
    }).done(function () {
        init_session_modal(taskId);
    });
}

function send_written_report (report_id, service_id, msg) {
    var res = confirm(""+msg+"");
    if(res){
        $.ajax({
            url: admin_url + 'Written_reports/send_mail_to_client/' + report_id + '/' + service_id,
            success: function (data) {
                if(data[0] == 1){
                    alert_float('success', data[1]);
                }else if (data[0] == 2){
                    alert_float('danger', data[1]);
                }else {
                    alert_float('danger', 'Operation failed!');
                }
            }
        });
    }
}

function load_time_picker(id) {
    $('#next_session_time'+id).datetimepicker({
        datepicker:false,
        format:'H:i'
    });
}
$(function(){
    appValidateForm($('#written-reports-form'), {
        available_until: 'required',
        report: 'required'
    });

    //Form Phases
    appValidateForm($('#form_phases'), {});
});

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

    var url = admin_url + 'LegalServices/Sessions/init_previous_sessions_log/' + rel_id + '/' + rel_type;

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

    var url = admin_url + 'LegalServices/Sessions/init_waiting_sessions_log/' + rel_id + '/' + rel_type;

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
                    $.post(admin_url + 'LegalServices/Sessions/update_session_court_decision/' + id, {
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
                    $.post(admin_url + 'LegalServices/Sessions/update_session_information/' + id, {
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

$(function(){
appValidateForm($('#written-reports-form'), {
    available_until: 'required',
    report: 'required',});
});

function disabled_print_btn(task_id) {
    $("#print_btn"+task_id).attr("disabled", true).removeAttr("onclick");
}
