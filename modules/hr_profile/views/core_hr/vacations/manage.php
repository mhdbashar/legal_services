<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();
$this->load->model('hr_profile/timesheets_model');
$this->load->model('departments_model');
$this->load->helper('hr_profile_helper') ;
$valid_cur_date = $this->timesheets_model->get_next_shift_date(get_staff_user_id(), date('Y-m-d'));
?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4><?php echo '<i class=" fa fa-clipboard"></i> ' . _l('manage_requisition') ?></h4>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                         <ul class="nav nav-tabs nav-tabs-horizontal mbot15" role="tablist">
                                  
                        <div class="tab-content active">
                              <div role="tabpanel" class="tab-pane <?php if (!isset($tab)) {
                                echo 'active';
                            } ?>" id="registration_on_leave">
                            <div class="row">
                                <div class="col-md-12 mtop15">
                                    <a href="#" onclick="new_requisition(); return false;"
                                       class="btn mright5 btn-info pull-left display-block"
                                       data-toggle="sidebar-right" data-target=".requisition_m">
                                        <?php echo _l('Create_requisition'); ?>
                                    </a>
                                    <div class="clearfix"></div>
                                    <br>
                                    <br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <select name="chose" class="selectpicker" data-width="100%" id="chose"
                                            data-none-selected-text="<?php echo _l('filter_by'); ?>">
                                        <option value="all"><?php echo _l('all') ?></option>
                                        <option value="my_approve"><?php echo _l('my_approve') ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="status_filter[]" class="selectpicker" data-width="100%"
                                            id="status_filter" multiple
                                            data-none-selected-text="<?php echo _l('filter_by_status'); ?>">
                                        <option value="0"><?php echo _l('Create') ?></option>
                                        <option value="1"><?php echo _l('approved') ?></option>
                                        <option value="2"><?php echo _l('Reject') ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="rel_type_filter[]" class="selectpicker" data-width="100%"
                                            id="rel_type_filter" multiple
                                            data-none-selected-text="<?php echo _l('filter_by_type'); ?>">
                                        <option value="1"><?php echo _l('Leave') ?></option>
                                        <option value="2"><?php echo _l('late') ?></option>
                                        <option value="6"><?php echo _l('early') ?></option>
                                        <option value="3"><?php echo _l('Go_out') ?></option>
                                        <option value="4"><?php echo _l('Go_on_bussiness') ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="department_filter[]" class="selectpicker" data-width="100%"
                                            id="department_filter" multiple data-live-search="true"
                                            data-none-selected-text="<?php echo _l('filter_by_department'); ?>">
                                        <?php foreach ($departments as $dpm) { ?>
                                            <option value="<?php echo html_entity_decode($dpm['departmentid']); ?>"><?php echo html_entity_decode($dpm['name']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="clearfix"></div>
                            <br>
                            <div class="modal bulk_actions fade" id="table_registration_leave_bulk_actions"
                                 tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title"><?php echo _l('bulk_actions'); ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php if (is_admin()) { ?>
                                                <div class="checkbox checkbox-danger">
                                                    <input type="checkbox" name="mass_delete" id="mass_delete">
                                                    <label for="mass_delete"><?php echo _l('mass_delete'); ?></label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal"><?php echo _l('close'); ?></button>

                                            <?php if (is_admin()) { ?>
                                                <a href="#" class="btn btn-info"
                                                   onclick="staff_delete_bulk_action(this); return false;"><?php echo _l('confirm'); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" onclick="staff_bulk_actions(); return false;" data-toggle="modal"
                               data-table=".table-table_registration_leave" data-target="#leads_bulk_actions"
                               class=" hide bulk-actions-btn table-btn"><?php echo _l('bulk_actions'); ?></a>
                                <?php
                            $table_data = array(
                                _l('id'),
                                '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="table_registration_leave"><label></label></div>',
                                _l('Subject'),
                                _l('name'),
                                _l('start_time'),
                                _l('end_time'),
                                _l('approver'),
                                _l('Follower'),
                                _l('reason'),
                                _l('Type'),
                                _l('status'),
                                _l('date_created'),
                                _l('options'),
                            );
                            render_datatable($table_data, 'table_registration_leave',
                                array('customizable-table'),
                                array(
                                    'id' => 'table-table_registration_leave',
                                    'data-last-order-identifier' => 'table_registration_leave',
                                    'data-default-order' => get_table_last_order('table_registration_leave'),
                                )); 
?>

                        </div>

                        <!-- The Modal -->
                        <!-- start -->
                        <div class="modal fade" id="requisition_m" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">
                                            <span class="edit-title"><?php echo _l('edit_requisition_m'); ?></span>
                                            <span class="add-title"><?php echo _l('new_requisition_m'); ?></span>
                                        </h4>
                                    </div>
                                    <?php echo form_open_multipart(admin_url('hr_profile/add_requisition_ajax1'), array('id' => 'requisition-form')); ?>
                                    <div class="modal-body">
                                        <div id="additional_contract_type"></div>
                                        <div class="form">
                                            
                                            <div class="hidden">

                                                <input type="text"
                                                       id="is_after"
                                                       name="is_after"
                                                       class="form-control"
                                                       value=""
                                                       aria-invalid="false">


                                            </div>
                                            <div class="hidden">
                                                <input type="text"
                                                       id="is_before"
                                                       name="is_before"
                                                       class="form-control"
                                                       value=""
                                                       aria-invalid="true">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                              <?php echo render_input('subject','Subject','') ?>

                                                    <div id="additional_contract_type"></div>
                                                    <div class="form" id="new_requisition">
                                                        <div class="row">
                                                            <div class="col-md-12">

                                                            </div>
                                                        </div>
                                                        <?php

                                                        if (is_admin() || has_permission('leave_management', '', 'view')) { ?>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <?php $pro = get_hr_staffs(); ?>
                                                                    <?php echo render_select('staff_id', $pro, array('staffid', array('firstname', 'lastname')), 'staff', '', [], [], '', '', true); ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>


                                                        <div class="row mtop10">
                                                            <div class="col-md-6 pb-4 hide" id="type">
                                                                <label for="type_of_leave"
                                                                       class="control-label"><?php echo _l('type_of_leave'); ?></label>
                                                                <select name="type_of_leave" class="selectpicker"
                                                                        id="rel_type" data-width="100%">

                                                                </select>

                                                            </div>

                                                            <div class="col-md-6 pb-4" id="type">
                                                                <label for="rel_type"
                                                                       class="control-label"><?php echo _l('Type'); ?></label>
                                                                <select name="rel_type" class="selectpicker"
                                                                        id="rel_type" data-width="100%"
                                                                        data-none-selected-text="<?php echo _l('none_type'); ?>">
                                                                    <option value="1"><?php echo _l('Leave') ?></option>
                                                                    <option value="2"><?php echo _l('late') ?></option>
                                                                    <option value="6"><?php echo _l('early') ?></option>
                                                                    <option value="3"><?php echo _l('Go_out') ?></option>
                                                                    <option value="4"><?php echo _l('Go_on_bussiness') ?></option>
                                                                </select>
                                                            </div>


                                                            <div class="col-md-12 hide" id="advance_payment_rq">
                                                                <div class="panel panel-warning">
                                                                    <div class="panel-heading"><?php echo _l('advance_payment_request'); ?></div>
                                                                    <div class="panel-body">
                                                                        <div id="list_jp">
                                                                            <div class="new-kpi-al">

                                                                                <div class="col-md-6">
                                                                                    <label for="used_to[0]"
                                                                                           class="control-label"><?php echo _l('used_to') ?></label>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label for="amoun_of_money[0]"
                                                                                           class="control-label"><?php echo _l('amoun_of_money') ?></label>
                                                                                </div>

                                                                                <div id="new_kpi"
                                                                                     class="row new_kpi_row">

                                                                                    <div class="col-md-6">
                                                                                        <input type="text"
                                                                                               id="used_to[0]"
                                                                                               name="used_to[0]"
                                                                                               class="form-control"
                                                                                               value=""
                                                                                               aria-invalid="false">
                                                                                    </div>
                                                                                    <div class="col-md-5">
                                                                                        <input type="text"
                                                                                               id="amoun_of_money[0]"
                                                                                               name="amoun_of_money[0]"
                                                                                               class="form-control"
                                                                                               value=""
                                                                                               aria-invalid="false"
                                                                                               data-type="currency">
                                                                                    </div>

                                                                                    <div class="col-md-1 button_add_kpi"
                                                                                         name="button_add_kpi">
                                                                                        <button name="add"
                                                                                                class="btn new_kpi btn-success"
                                                                                                data-ticket="true"
                                                                                                type="button"><i
                                                                                                    class="fa fa-plus"></i>
                                                                                        </button>
                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <br><br>
                                                                        <?php echo render_date_input('request_date', 'request_date', ''); ?>
                                                                        <?php echo render_textarea('advance_payment_reason', 'advance_payment_reason'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mtop10 date">
                                                            <div class="col-md-6 start_time">
                                                                <?php echo render_date_input('start_time', 'From_Date', _d($valid_cur_date), ['required' => 'required']) ?>
                                                            </div>
                                                            <div class="col-md-6 end_time">
                                                                <?php echo render_date_input('end_time', 'To_Date', _d($valid_cur_date), ['required' => 'required']) ?>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                    <label for="place_of_business"
                                                                           class="control-label"><?php echo 'العنوان أثناء الاجازة'; ?></label>
                                                                    <?php echo render_input('place_of_business') ?>
                                                                <br>
                                                                <?php


                                                                $value_number_day = 0.5;
                                                                ?>
                                                                <div class="form-group " id="number_of_days"
                                                                     app-field-wrapper="number_of_leaving_day">
                                                                    <label for="number_of_leaving_day"
                                                                           class="control-label"><?php echo _l('number_of_days'); ?></label>
                                                                    <input type="number" id="number_of_leaving_day"
                                                                           name="number_of_leaving_day"
                                                                           class="form-control"
                                                                           step="0.5"

                                                                           value="<?php echo html_entity_decode($value_number_day); ?>"
                                                                           aria-invalid="false">
                                                                    <!--                                                                    --><?php //echo  render_input('number_of_leaving_day',_l('number_of_days'),'0','number') ?>
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <div class="row mtop10">
                                                            <div class="col-md-12 pb-4" id="leave_">
                                                                <label for="followers_id"
                                                                       class="control-label"><?php echo _l('Follower'); ?></label>
                                                                <select name="followers_id" id="followers_id"
                                                                        data-live-search="true" class="selectpicker"
                                                                        data-actions-box="true" data-width="100%"
                                                                        data-none-selected-text="<?php echo _l('none'); ?>">
                                                                    <option value=""></option>
                                                                    <?php foreach ($pro as $s) { ?>
                                                                        <option value="<?php echo html_entity_decode($s['staffid']); ?>"><?php echo html_entity_decode($s['firstname'] . ' ' . $s['lastname']); ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 pb-4" id="leave_handover_recipients">
                                                                <br>
                                                                <label for="handover_recipients"
                                                                       class="control-label"><?php echo _l('handover_recipients'); ?></label>
                                                                <select name="handover_recipients"
                                                                        id="handover_recipients" data-live-search="true"
                                                                        class="selectpicker" data-actions-box="true"
                                                                        data-width="100%"
                                                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                                    <option value=""></option>
                                                                    <?php foreach ($pro as $s) { ?>
                                                                        <option value="<?php echo html_entity_decode($s['staffid']); ?>"><?php echo html_entity_decode($s['firstname'] . ' ' . $s['lastname']); ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="row mtop10">
                                                            <div class="col-md-12">
                                                                <?php echo render_textarea('reason', 'reason_') ?>
                                                            </div>
                                                        </div>
                                                        <div class="mtop10">
                                                            <label for="file"
                                                                   class="control-label"><?php echo _l('requisition_files'); ?></label>
                                                            <input type="file" id="file" name="file"
                                                                   class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal"><?php echo _l('close'); ?></button>
                                        <button type="submit" id="submit"
                                                class="btn btn-info btn-submit"><?php echo _l('submit'); ?></button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="additional_timesheets_modalss" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('hr_profile/send_additional_timesheets'), array('id' => 'edit_timesheets-form')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4>
                    <?php echo _l('additional_timesheets'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <?php echo render_date_input('additional_day', 'additional_day'); ?>
                    <?php echo render_input('time_in', 'time_in', '', 'time'); ?>
                    <?php echo render_input('time_out', 'time_out', '', 'time'); ?>
                    <?php echo render_input('timekeeping_value', 'timekeeping_value', ''); ?>
                    <?php echo render_textarea('reason', 'reason_'); ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button class="btn btn-info btn-additional-timesheets"><?php echo _l('submit'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<input type="hidden" name="current_date" value="<?php echo _d(date('Y-m-d')); ?>">
<?php $this->load->view('core_hr/vacations/modals/vacations_modal'); ?>
<?php init_tail(); ?>
<?php require 'modules/hr_profile/assets/js/requisition_manage_js.php'; ?>

<script>

    //$(function () {
    //    var valid_cur_date = ''
    //    $.get(admin_url + 'timesheets/get_next_shift_date/' + '<?//= get_staff_user_id()?>///<?//= date('Y-m-d')?>//' , function (response) {
    //       valid_cur_date = response.next_shift_date
    //        $('#start_time').val(valid_cur_date)
    //        $('#end_time').val(valid_cur_date)
    //    }, 'json');
    //});


    // $('#submit').click(function () {
    //
    // })
    $('#start_time').click(function () {
        var numberOfDays = $('#number_of_leaving_day').val();
        var startTime = $('#start_time').val();
        var date = new Date(startTime);
        var nextDate = new Date(startTime);
        date.toISOString().substring(0, 10);
        nextDate.setDate(date.getDate() + (parseInt(numberOfDays) + 0.5));
        console.log(nextDate.toISOString().substring(0, 10));
        $('#end_time').val(nextDate.toISOString().substring(0, 10));

    })

    var date_created = '';
    $(function () {
        initDataTable('.table-official_documents', window.location.href);
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        console.log('agt');
        $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end()
            .find(".branch")
            .remove()
            .find(".staff")
            .remove()
    })

    function new_requisition() {
        "use strict";
        $('#requisition_m').modal('show');
        $('.edit-title').addClass('hide');
        $('.add-title').removeClass('hide');
    }

    var number_of_day;
    var day_value;

    $("#rel_type").change(function () {
            $('#number_of_days').removeClass('hide');
            // $('#end_time').val('');
            $('#is_after').val(0);
            $('#is_before').val(0);


            // alert($('#rel_type').val());
$.get(admin_url + 'hr_profile/number_of_days/' + $(this).val() + '/' + $('#staff_id').val() + '/' + $('#rel_type').val(), function (response) {
    number_of_day = response;
    var days = response.days.number_of_days;3
    console.log(response);
    

    if (response.deserving_after_days && response.deserving_before_days) {
        var days_after_deserving = response.deserving_after_days.deserving_after_days;
        var days_before_deserving = response.deserving_before_days.deserving_before_days;
        
        if (response.years.deserving_in_years > 0) {
            if (response[0] > date_created) {
                //after deserving
                $('#is_after').val(response.deserving_after_days.deserving_after_days);
                $('#number_of_leaving_day').val(days_after_deserving - response.total_of_leaving_day_after);
            } else {//before deserving
                $('#is_before').val(response.deserving_before_days.deserving_before_days);
                $('#number_of_leaving_day').val(days_before_deserving - response.total_of_leaving_day_before);
            }
        }
    } else if (response.years.deserving_in_years == 0) {
        day_value = response.number_of_days_in_leave.number_of_days - response.total_of_leaving_day;
        $('#number_of_leaving_day').val(day_value);
    }
}, 'json');

        }
    );
    $("#number_of_leaving_day").change(function () {

      
        // console.log(number_of_day);
        var numberOfDays = $('#number_of_leaving_day').val();
        var startTime = $('#start_time').val();
        var date = new Date(startTime);
        var nextDate = new Date(startTime);
        date.toISOString().substring(0, 10);
        nextDate.setDate(date.getDate() + (parseInt(numberOfDays) + 0.5));
        // console.log(nextDate.toISOString().substring(0, 10));
        $('#end_time').val(nextDate.toISOString().substring(0, 10));


        // var value = $('#number_of_leaving_day').val();
        //
        // var startdate=$('#start_time').val();
        //
        // var years=$('#start_time').val().substring(0,4);
        // var month=$('#start_time').val().substring(5,7);
        // var days=$('#start_time').val().substring(8,10);
        //
        // var date=new Date(startdate);
        // console.log(date.toISOString().substring(0,10));
        // var nextdate=new Date(startdate);
        // nextdate.setDate(date.getDate()+parseInt(value)-1);
        // $('#end_time').val(nextdate.toISOString().substring(0,10));
        // console.log(date.toISOString());


        // var days = number_of_day.days.number_of_days;
        console.log(number_of_day);

        var days_after_deserving = number_of_day.deserving_after_days.deserving_after_days;

        var days_before_deserving = number_of_day.deserving_before_days.deserving_before_days;

        if (number_of_day.years.deserving_in_years > 0) {
            if (number_of_day[0] > date_created) {
                //after deserving
                if ($('#number_of_leaving_day').val() > number_of_day.deserving_after_days.deserving_after_days - number_of_day.total_of_leaving_day_after) {
                    alert('you cant add more day');
                    $('#number_of_leaving_day').val(number_of_day.deserving_after_days.deserving_after_days - number_of_day.total_of_leaving_day_after);
                }
            } else {//before deserving
                if ($('#number_of_leaving_day').val() > parseInt(days_before_deserving) - number_of_day.total_of_leaving_day_before) {
                    alert('you cant add more day');
                    $('#number_of_leaving_day').val(parseInt(days_before_deserving) - number_of_day.total_of_leaving_day_before);
                }
            }
        } else if (number_of_day.years.deserving_in_years == 0) {
            // alert(days);
            if ($('#number_of_leaving_day').val() > day_value) {
                alert('you cant add more day');
                $('#number_of_leaving_day').val(day_value);
            }
        }
    })


    $("#staff_id").change(function () {

        $('#rel_type').html(' ');
        $('#end_time').val(' ');

        $('#rel_type').selectpicker("refresh")
        $.get(admin_url + 'hr_profile/get_type_of_leave/' + $(this).val(), function (response) {

            $('#end_time').val(' ');
            date_created = response[0];
            if (response.length > 0) {

                $('#rel_type').append($('<option>', {
                    value: '',
                    text: ''
                }));

                for (let i = 0; i < response.length; i++) {
                    let key = response[i].id;
                    let value = response[i].name;
                    $('#rel_type').append($('<option>', {
                        value: key,
                        text: value
                    }));
                    $('#rel_type').selectpicker('refresh');
                }
            } else {
                alert_float('danger', 'your date its not allow you to take a leave');
            }
        }, 'json');
        //$.ajax({
        //    url: '<?php //echo admin_url('timesheets/get_type_of_leave');?>//'+'/'+staffid,
        //    success: function (data) {
        //        response=JSON.parse(data);
        //        $.each(response, function (key, value) {
        //            $('#rel_type').append('<option value="' + value['id'] + '">'+ value['name']+'</option>');
        //
        //        });
        //
        //
        //    }
        //});
        if ($('#staff_id').val() != '') {
            $('#type').removeClass('hide');
        } else {
            $('#type').addClass('hide')
        }

    });
</script>
</body>
</html>
