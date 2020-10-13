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

function get_legal_services_by_slug()
{
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

// Reload all tasks possible table where the table data needs to be refreshed after an action is performed on task.
function reload_sessions_tables() {
    var av_sessions_tables = ['.table-sessions', '.table-rel-sessions', '.table-rel-sessions-leads', '.table-timesheets', '.table-timesheets-report'];
    $.each(av_sessions_tables, function(i, selector) {
        if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().ajax.reload(null, false);
        }
    });
}

// Init task modal and get data from server
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

// New task function, various actions performed
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

// Tasks bulk actions action
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