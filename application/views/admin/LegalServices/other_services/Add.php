<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <?php
			
            $custom_fields = false;
            if (total_rows(db_prefix() . 'customfields', array('fieldto' => $service->slug, 'active' => 1)) > 0) {
                $custom_fields = true;
            }
            ?>
            <?php echo form_open($this->uri->uri_string(), array('id' => 'form')); ?>
            <div class="col-md-7">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo _l('permission_create') . ' ' . $service->name; ?>
                        </h4>
                        <hr class="hr-panel-heading"/>
                        <?php
                        $disable_type_edit = '';
                        if(isset($OtherServ)){
                            if($OtherServ->billing_type != 1){
                                if(total_rows(db_prefix().'tasks',array('rel_id'=>$OtherServ->id,'rel_type'=>$service->slug,'billable'=>1,'billed'=>1)) > 0){
                                    $disable_type_edit = 'disabled';
                                }
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?php $CodeValue = isset($Numbering->numbering) ? $Numbering->numbering + 1 : $service->numbering; ?>
                                <?php echo render_input('code', 'ServiceCode', $service->prefix . $CodeValue); ?>
                                <input type="hidden" name="numbering" value="<?php echo $CodeValue; ?>">
                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('name', 'ServiceTitle'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group select-placeholder">
                                    <label for="clientid"
                                           class="control-label"><?php echo _l('project_customer'); ?></label>
                                    <select id="clientid" name="clientid" data-live-search="true" data-width="100%"
                                            class="ajax-search"
                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php
                                        $selected = (isset($OtherServ) ? $OtherServ->clientid : '');
                                        if ($selected == '') {
                                            $selected = (isset($OtherServ) ? $OtherServ->clientid : '');
                                        }
                                        if ($selected != '') {
                                            $rel_data = get_relation_data('customer', '');
                                            $rel_val = get_relation_values($rel_data, 'customer');
                                            echo '<option value="' . $rel_val['id'] . '" selected>' . $rel_val['name'] . '</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <a href="#" data-toggle="modal" data-target="#add-client" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>

                        <?php $cats = get_relation_data('mycategory', $ServID);
                        if($cats){ ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cat_id" class="control-label"><?php echo _l('Categories'); ?></label>
                                    <select class="form-control custom_select_arrow" id="cat_id" onchange="GetSubCat()" name="cat_id"
                                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                        <?php foreach ($cats as $row): ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subcat_id" class="control-label"><?php echo _l('SubCategories'); ?></label>
                                    <select class="form-control custom_select_arrow" id="subcat_id" name="subcat_id"
                                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
//                                $staff_language = get_staff_default_language(get_staff_user_id());
                                $staff_language = get_option('active_language');

                                if($staff_language == 'arabic'){
                                    $field = 'short_name_ar';
                                }else{
                                    $field = 'short_name';
                                }
                                ?>
                                <?php echo render_select('country', get_cases_countries($field), array('country_id', array($field)), 'lead_country', array('data-none-selected-text' => _l('dropdown_non_selected_tex'))); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="city"><?php echo _l('client_city'); ?></label>
                                    <select id="city" name="city" class="form-control custom_select_arrow">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group select-placeholder">
                                    <label for="billing_type"><?php echo _l('project_billing_type'); ?></label>
                                    <div class="clearfix"></div>
                                    <select name="billing_type" class="selectpicker" id="billing_type" data-width="100%" <?php echo $disable_type_edit ; ?> data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option value=""></option>
                                        <option value="1"><?php echo _l('project_billing_type_fixed_cost'); ?></option>
                                        <option value="2"><?php echo _l('project_billing_type_project_hours'); ?></option>
                                        <option value="3" data-subtext="<?php echo _l('project_billing_type_project_task_hours_hourly_rate'); ?>"><?php echo _l('project_billing_type_project_task_hours'); ?></option>
                                    </select>
                                    <?php if($disable_type_edit != ''){
                                        echo '<p class="text-danger">'._l('cant_change_billing_type_billed_tasks_found').'</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group select-placeholder">
                                    <label for="status"><?php echo _l('project_status'); ?></label>
                                    <div class="clearfix"></div>
                                    <select name="status" id="status" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($statuses as $status){ ?>
                                            <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('estimated_hours','estimated_hours','','number'); ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $input_field_hide_class_total_cost = '';
                                if(!isset($OtherServ)){
                                    if($auto_select_billing_type && $auto_select_billing_type->billing_type != 1 || !$auto_select_billing_type){
                                        $input_field_hide_class_total_cost = 'hide';
                                    }
                                } else if(isset($OtherServ) && $OtherServ->billing_type != 1){
                                    $input_field_hide_class_total_cost = 'hide';
                                }
                                ?>
                                <div id="project_cost" class="<?php echo $input_field_hide_class_total_cost; ?>">
                                    <?php $value = (isset($OtherServ) ? $OtherServ->project_cost : ''); ?>
                                    <?php echo render_input('project_cost','project_total_cost',$value,'number'); ?>
                                </div>
                                <?php
                                $input_field_hide_class_rate_per_hour = '';
                                if(!isset($OtherServ)){
                                    if($auto_select_billing_type && $auto_select_billing_type->billing_type != 2 || !$auto_select_billing_type){
                                        $input_field_hide_class_rate_per_hour = 'hide';
                                    }
                                } else if(isset($OtherServ) && $OtherServ->billing_type != 2){
                                    $input_field_hide_class_rate_per_hour = 'hide';
                                }
                                ?>
                                <div id="project_rate_per_hour" class="<?php echo $input_field_hide_class_rate_per_hour; ?>">
                                    <?php $value = (isset($OtherServ) ? $OtherServ->project_rate_per_hour : ''); ?>
                                    <?php
                                    $input_disable = array();
                                    if($disable_type_edit != ''){
                                        $input_disable['disabled'] = true;
                                    }
                                    ?>
                                    <?php echo render_input('project_rate_per_hour','project_rate_per_hour',$value,'number',$input_disable); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php $value = _d(date('Y-m-d')); ?>
                                <?php echo render_date_input('start_date', 'project_start_date',$value); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_date_input('deadline', 'project_deadline'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?>
                                    </label>
                                    <input type="text" class="tagsinput" id="tags" name="tags" data-role="tagsinput">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <?php
                                $selected = array();
                                array_push($selected,get_staff_user_id());
                                echo render_select('project_members[]',$staff,array('staffid',array('firstname','lastname')),'project_members',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
                                ?>
                            </div>

                                <a href="<?php echo admin_url('staff')?>" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                            <div class="col-md-12">
                                <label for="contract" class="control-label"><?php echo _l('contracts'); ?></label>
                                <select class="form-control custom_select_arrow" name="contract"
                                        placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                    <option selected disabled></option>
                                    <?php $data = get_relation_data('contracts', '');
                                    foreach ($data as $row): ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['subject']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" name="service_session_link" id="service_session_link">
                            <label for="service_session_link"><?php echo _l('link_with_service_session'); ?></label>
                        </div>
                        <p class="bold"><?php echo _l('project_description'); ?></p>
                        <?php echo render_textarea('description', '', '', array(), array(), '', 'tinymce'); ?>
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" name="send_created_email" id="send_created_email">
                            <label for="send_created_email"><?php echo _l('project_send_created_email'); ?></label>
                        </div>
                        <!-- custom_fields -->
                        <?php if ($custom_fields) { ?>
                            <div role="tabpanel" id="custom_fields">
                                <?php $rel_id = (isset($case) ? $case->id : false); ?>
                                <?php echo render_custom_fields($service->slug, $rel_id); ?>
                            </div>
                        <?php } ?>
                        <div class="btn-bottom-toolbar text-right">
                            <button type="submit" data-form="#form" class="btn btn-info" autocomplete="off"
                                    data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel_s">
                    <div class="panel-body" id="project-settings-area">
           <h4 class="no-margin">
               <?php echo _l('project_settings'); ?>
           </h4>
           <hr class="hr-panel-heading" />
           <?php foreach($settings as $setting){

            $checked = ' ';
           if(isset($OtherServ)){
                if($OtherServ->settings->{$setting} == 1){
                    $checked = ' checked';
                }
            } else {
                // var_dump($last_project_settings);
                // foreach($last_project_settings as $last_setting) {
                // var_dump($last_setting);
                // }
                // exit();
                foreach($last_project_settings as $last_setting) {
                    if($setting == $last_setting['name']){
                        // hide_tasks_on_main_tasks_table is not applied on most used settings to prevent confusions
                        if($last_setting['value'] == 0 || $last_setting['name'] == 'hide_tasks_on_main_tasks_table'){
                            $checked = '';
                        }
                    }
                }

                if(count($last_project_settings) == 0 && $setting == 'hide_tasks_on_main_tasks_table') {
                    $checked = '';
                }
            } ?>
            <?php if($setting != 'available_features'){ ?>
                <div class="checkbox">
                    <input type="checkbox" name="settings[<?php echo $setting; ?>]" <?php echo $checked; ?> id="<?php echo $setting; ?>">
                    <label for="<?php echo $setting; ?>">
                        <?php if($setting == 'hide_tasks_on_main_tasks_table'){ ?>
                            <?php echo _l('hide_tasks_on_main_tasks_table'); ?>
                        <?php } else{ ?>
                            <?php echo _l('project_allow_client_to').' '._l('project_setting_'.$setting); ?>
                        <?php } ?>
                    </label>
                </div>
            <?php } else { ?>
                <div class="form-group mtop15 select-placeholder project-available-features">
                    <label for="available_features"><?php echo _l('visible_tabs'); ?></label>
                    <select name="settings[<?php echo $setting; ?>][]" id="<?php echo $setting; ?>" multiple="true" class="selectpicker" id="available_features" data-width="100%" data-actions-box="true" data-hide-disabled="true">
                        <?php foreach(get_oservice_tabs_admin() as $tab) {
                            $selected = '';
                            if(isset($tab['collapse'])){ ?>
                                <optgroup label="<?php echo $tab['name']; ?>">
                                    <?php foreach($tab['children'] as $tab_dropdown) {
                                        $selected = '';
                                        if(isset($OtherServ) && (
                                            (isset($OtherServ->settings->available_features[$tab_dropdown['slug']])
                                                && $OtherServ->settings->available_features[$tab_dropdown['slug']] == 1)
                                            || !isset($OtherServ->settings->available_features[$tab_dropdown['slug']]))) {
                                            $selected = ' selected';
                                    } else if(!isset($OtherServ) && count($last_project_settings) > 0) {
                                        foreach($last_project_settings as $last_project_setting) {
                                            if($last_project_setting['name'] == $setting) {
                                                if(isset($last_project_setting['value'][$tab_dropdown['slug']])
                                                    && $last_project_setting['value'][$tab_dropdown['slug']] == 1) {
                                                    $selected = ' selected';
                                            }
                                        }
                                    }
                                } else if(!isset($OtherServ)) {
                                    $selected = ' selected';
                                }
                                ?>
                                <option value="<?php echo $tab_dropdown['slug']; ?>"<?php echo $selected; ?><?php if(isset($tab_dropdown['linked_to_customer_option']) && is_array($tab_dropdown['linked_to_customer_option']) && count($tab_dropdown['linked_to_customer_option']) > 0){ ?> data-linked-customer-option="<?php echo implode(',',$tab_dropdown['linked_to_customer_option']); ?>"<?php } ?>><?php echo $tab_dropdown['name']; ?></option>
                            <?php } ?>
                        </optgroup>
                    <?php } else {
                        if(isset($OtherServ) && (
                            (isset($OtherServ->settings->available_features[$tab['slug']])
                             && $OtherServ->settings->available_features[$tab['slug']] == 1)
                            || !isset($OtherServ->settings->available_features[$tab['slug']]))) {
                            $selected = ' selected';
                    } else if(!isset($OtherServ) && count($last_project_settings) > 0) {
                        foreach($last_project_settings as $last_project_setting) {
                            if($last_project_setting['name'] == $setting) {
                                if(isset($last_project_setting['value'][$tab['slug']])
                                    && $last_project_setting['value'][$tab['slug']] == 1) {
                                    $selected = ' selected';
                            }
                        }
                    }
                } else if(!isset($OtherServ)) {
                    $selected = ' selected';
                }
                ?>
                <option value="<?php echo $tab['slug']; ?>"<?php if($tab['slug'] =='project_overview'){echo ' disabled selected';} ?>
                <?php echo $selected; ?>
                <?php if(isset($tab['linked_to_customer_option']) && is_array($tab['linked_to_customer_option']) && count($tab['linked_to_customer_option']) > 0){ ?> data-linked-customer-option="<?php echo implode(',',$tab['linked_to_customer_option']); ?>"<?php } ?>>
                <?php echo $tab['name']; ?>
            </option>
        <?php } ?>
    <?php } ?>
</select>
</div>
<?php } ?>
<hr class="no-margin" />
<?php } ?>
</div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div class="modal fade" id="add-client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('client_company'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input( 'company_modal', 'client_company','','text'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="button" id="AddClient" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>

    $("#AddClient").click(function () {
        company = $('#company_modal').val();
        if(company == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('clients/add'); ?>',
                data: {company : company},
                type: "POST",
                success: function (data) {
                    if(data){
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                        var newOption = $("#clientid").append(new Option(company, data, true, true));
                        $('#clientid').append(newOption).trigger('change');
                        $('#add-client').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('faild'); ?>');
                    }
                }
            });
        }
    });

    function GetSubCat() {
        $('#subcat_id').html('');
        id = $('#cat_id').val();
        $.ajax({
            url: '<?php echo admin_url("ChildCategory/$ServID/"); ?>' + id,
            success: function (data) {
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    $('#subcat_id').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
                });
            }
        });
    }

    function GetCourtJad() {
        id = $('#court_id').val();
        $.ajax({
            url: '<?php echo admin_url("judicialByCourt/"); ?>' + id,
            success: function (data) {
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    $('#jud_num').append('<option value="' + value['j_id'] + '">' + value['Jud_number'] + '</option>');
                });
            }
        });
    }

    $("#country").change(function () {
        $.ajax({
            url: "<?php echo admin_url('Countries/build_dropdown_cities'); ?>",
            data: {country: $(this).val()},
            type: "POST",
            success: function (data) {
                $("#city").html(data);
            }
        });
    });

    $(function(){

        $('select[name="billing_type"]').on('change',function(){
            var type = $(this).val();
            if(type == 1){
                $('#project_cost').removeClass('hide');
                $('#project_rate_per_hour').addClass('hide');
            } else if(type == 2){
                $('#project_cost').addClass('hide');
                $('#project_rate_per_hour').removeClass('hide');
            } else {
                $('#project_cost').addClass('hide');
                $('#project_rate_per_hour').addClass('hide');
            }
        });

        var members = $("input[name='project_members[]']");

        appValidateForm($('#form'), {
            code: 'required',
            name: 'required',
            clientid: 'required',
            cat_id: 'required',
            subcat_id: 'required',
            billing_type: 'required',
            //rate_per_hour: 'required',
            members : 'required',
            start_date: 'required',
        });

        $('select[name="status"]').on('change',function(){
            var status = $(this).val();
            var mark_all_tasks_completed = $('.mark_all_tasks_as_completed');
            var notify_project_members_status_change = $('.notify_project_members_status_change');
            mark_all_tasks_completed.removeClass('hide');
            if(typeof(original_project_status) != 'undefined'){
                if(original_project_status != status){

                    mark_all_tasks_completed.removeClass('hide');
                    notify_project_members_status_change.removeClass('hide');

                    if(status == 4 || status == 5 || status == 3) {
                        $('.recurring-tasks-notice').removeClass('hide');
                        var notice = "<?php echo _l('project_changing_status_recurring_tasks_notice'); ?>";
                        notice = notice.replace('{0}', $(this).find('option[value="'+status+'"]').text().trim());
                        $('.recurring-tasks-notice').html(notice);
                        $('.recurring-tasks-notice').append('<input type="hidden" name="cancel_recurring_tasks" value="true">');
                        mark_all_tasks_completed.find('input').prop('checked',true);
                    } else {
                        $('.recurring-tasks-notice').html('').addClass('hide');
                        mark_all_tasks_completed.find('input').prop('checked',false);
                    }
                } else {
                    mark_all_tasks_completed.addClass('hide');
                    mark_all_tasks_completed.find('input').prop('checked',false);
                    notify_project_members_status_change.addClass('hide');
                    $('.recurring-tasks-notice').html('').addClass('hide');
                }
            }

            if(status == 4){
                $('.project_marked_as_finished').removeClass('hide');
            } else {
                $('.project_marked_as_finished').addClass('hide');
                $('.project_marked_as_finished').prop('checked',false);
            }
        });

        $('form').on('submit',function(){
            $('select[name="billing_type"]').prop('disabled',false);
            $('#available_features,#available_features option').prop('disabled',false);
            $('input[name="project_rate_per_hour"]').prop('disabled',false);
        });

        var progress_input = $('input[name="progress"]');
        var progress_from_tasks = $('#progress_from_tasks');
        var progress = progress_input.val();

        $('.project_progress_slider').slider({
            min:0,
            max:100,
            value:progress,
            disabled:progress_from_tasks.prop('checked'),
            slide: function( event, ui ) {
                progress_input.val( ui.value );
                $('.label_progress').html(ui.value+'%');
            }
        });

        progress_from_tasks.on('change',function(){
            var _checked = $(this).prop('checked');
            $('.project_progress_slider').slider({disabled:_checked});
        });

        $('#project-settings-area input').on('change',function(){
            if($(this).attr('id') == 'view_tasks' && $(this).prop('checked') == false){
                $('#create_tasks').prop('checked',false).prop('disabled',true);
                $('#edit_tasks').prop('checked',false).prop('disabled',true);
                $('#view_task_comments').prop('checked',false).prop('disabled',true);
                $('#comment_on_tasks').prop('checked',false).prop('disabled',true);
                $('#view_task_attachments').prop('checked',false).prop('disabled',true);
                $('#view_task_checklist_items').prop('checked',false).prop('disabled',true);
                $('#upload_on_tasks').prop('checked',false).prop('disabled',true);
                $('#view_task_total_logged_time').prop('checked',false).prop('disabled',true);
            } else if($(this).attr('id') == 'view_tasks' && $(this).prop('checked') == true){
                $('#create_tasks').prop('disabled',false);
                $('#edit_tasks').prop('disabled',false);
                $('#view_task_comments').prop('disabled',false);
                $('#comment_on_tasks').prop('disabled',false);
                $('#view_task_attachments').prop('disabled',false);
                $('#view_task_checklist_items').prop('disabled',false);
                $('#upload_on_tasks').prop('disabled',false);
                $('#view_task_total_logged_time').prop('disabled',false);
            }
        });

        // Auto adjust customer permissions based on selected project visible tabs
        // Eq project creator disable TASKS tab, then this function will auto turn off customer project option Allow customer to view tasks

        $('#available_features').on('change',function(){
            $("#available_features option").each(function(){
                if($(this).data('linked-customer-option') && !$(this).is(':selected')) {
                    var opts = $(this).data('linked-customer-option').split(',');
                    for(var i = 0; i<opts.length;i++) {
                        var project_option = $('#'+opts[i]);
                        project_option.prop('checked',false);
                        if(opts[i] == 'view_tasks') {
                            project_option.trigger('change');
                        }
                    }
                }
            });
        });
        $("#view_tasks").trigger('change');
    });
</script>
</body>
</html>