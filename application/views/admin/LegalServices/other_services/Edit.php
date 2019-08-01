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
                                if(total_rows(db_prefix().'tasks',array('rel_id'=>$OtherServ->id,'rel_type'=>'project','billable'=>1,'billed'=>1)) > 0){
                                    $disable_type_edit = 'disabled';
                                }
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('code', 'ServiceCode', $service->prefix . $OtherServ->numbering); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('name', 'ServiceTitle',$OtherServ->name); ?>
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
                                        <?php $selected = (isset($OtherServ) ? $OtherServ->clientid : '');
                                        if($selected == ''){
                                            $selected = (isset($OtherServ) ? $OtherServ->clientid : '');
                                        }
                                        if ($selected != '') {
                                            $rel_data = get_relation_data('customer', $selected);
                                            $rel_val = get_relation_values($rel_data, 'customer');
                                            echo '<option value="' . $rel_val['id'] . '" selected>' . $rel_val['name'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <a href="#" data-toggle="modal" data-target="#add-client" class="btn btn-info mtop25"><i class="fa fa-plus"></i></a>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="cat_id" class="control-label"><?php echo _l('Categories'); ?></label>
                                    <select class="form-control" id="cat_id" onchange="GetSubCat()" name="cat_id"
                                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                        <?php $data = get_relation_data('mycategory',$ServID);
                                        foreach ($data as $row): ?>
                                            <option value="<?php echo $row->id; ?>" <?php echo $OtherServ->cat_id == $row->id ? 'selected': '' ?>><?php echo $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subcat_id"
                                           class="control-label"><?php echo _l('SubCategories'); ?></label>
                                    <select class="form-control" id="subcat_id" name="subcat_id"
                                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                        <?php $data = get_relation_data('childmycategory',$OtherServ->cat_id);
                                        foreach ($data as $row) {
                                            if($OtherServ->subcat_id == $row->id) { ?>
                                                <option value="<?php echo $row->id ?>" selected><?php echo $row->name ?></option>
                                            <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $staff_language = get_staff_default_language(get_staff_user_id());
                                if($staff_language == 'arabic'){
                                    $field = 'short_name_ar';
                                }else{
                                    $field = 'short_name';
                                }
                                ?>
                                <?php echo render_select( 'country',get_cases_countries($field),array( 'country_id',array($field)), 'lead_country',$OtherServ->country); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="city"><?php echo _l('client_city'); ?></label>
                                    <?php $data = get_relation_data('build_dropdown_cities',''); ?>
                                    <select id="city" name="city" class="form-control">
                                        <option selected disabled></option>
                                        <?php foreach ($data as $row): ?>
                                            <option value="<?php echo $row->Name_en; ?>" <?php echo $OtherServ->city == $row->Name_en ? 'selected': '' ?>><?php echo $row->Name_en; ?></option>
                                        <?php endforeach; ?>
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
                                        <option value="1" <?php if(isset($OtherServ) && $OtherServ->billing_type == 1 || !isset($OtherServ) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 1){echo 'selected'; } ?>><?php echo _l('project_billing_type_fixed_cost'); ?></option>
                                        <option value="2" <?php if(isset($OtherServ) && $OtherServ->billing_type == 2 || !isset($OtherServ) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 2){echo 'selected'; } ?>><?php echo _l('project_billing_type_project_hours'); ?></option>
                                        <option value="3" data-subtext="<?php echo _l('project_billing_type_project_task_hours_hourly_rate'); ?>" <?php if(isset($OtherServ) && $OtherServ->billing_type == 3 || !isset($OtherServ) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 3){echo 'selected'; } ?>><?php echo _l('project_billing_type_project_task_hours'); ?></option>
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
                                            <option value="<?php echo $status['id']; ?>" <?php if(!isset($OtherServ) && $status['id'] == 2 || (isset($OtherServ) && $OtherServ->status == $status['id'])){echo 'selected';} ?>><?php echo $status['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('estimated_hours','estimated_hours',isset($OtherServ) ? $OtherServ->estimated_hours : '','number'); ?>
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
                                <?php echo render_date_input('start_date', 'project_start_date',$OtherServ->start_date); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_date_input('deadline', 'project_deadline',$OtherServ->deadline); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
                                    <input type="text" class="tagsinput" id="tags" name="tags" value="<?php echo (isset($OtherServ) ? prep_tags_input(get_tags_in($OtherServ->id,$service->slug)) : ''); ?>" data-role="tagsinput">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <?php
                                $selected = array();
                                if(isset($other_members)){
                                    foreach($other_members as $member){
                                        array_push($selected,$member['staff_id']);
                                    }
                                } else {
                                    array_push($selected,get_staff_user_id());
                                }
                                echo render_select('project_members[]',$staff,array('staffid',array('firstname','lastname')),'project_members',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
                                ?>
                            </div>
                            <div class="col-md-1">
                                <a href="<?php echo admin_url('staff')?>" target="_blank" class="btn btn-info mtop25"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="col-md-12">
                                <label for="contract" class="control-label"><?php echo _l('contracts'); ?></label>
                                <select class="form-control" name="contract"
                                        placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                    <option selected disabled></option>
                                    <?php $data = get_relation_data('contracts', '');
                                    foreach ($data as $row): ?>
                                        <option value="<?php echo $row['id']; ?>" <?php echo  $row['id'] == $OtherServ->contract ? 'selected': '' ?>><?php echo $row['subject']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <p class="bold"><?php echo _l('project_description'); ?></p>
                        <?php echo render_textarea('description','',$OtherServ->description,array(),array(),'','tinymce'); ?>
                        <?php if(total_rows(db_prefix().'emailtemplates',array('slug'=>'assigned-to-project','active'=>0)) == 0){ ?>
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="send_created_email" id="send_created_email">
                                <label for="send_created_email"><?php echo _l('project_send_created_email'); ?></label>
                            </div>
                        <?php } ?>
                        <!-- custom_fields -->
                        <?php if ($custom_fields) { ?>
                            <div role="tabpanel" id="custom_fields">
                                <?php $rel_id = (isset($OtherServ) ? $OtherServ->id : false); ?>
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
                        <hr class="hr-panel-heading"/>
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
                        <?php echo render_input( 'company', 'client_company','','text'); ?>
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
        company = $('#company').val();
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
                        $('#add-client').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('faild'); ?>');
                    }
                }
            });
        }
    });

    $(function () {
        _validate_form($('#form'), {
            code: 'required',
            title: 'required',
            clientid: 'required',
            cat_id: 'required',
            subcat_id: 'required',
            billing_type: 'required',
            //rate_per_hour: 'required',
            members: 'required',
            start_date: 'required',
            end_date: 'required',
        });

        $('select[name="billing_type"]').on('change', function () {
            var type = $(this).val();
            if (type == 1) {
                $('#project_rate_per_hour').addClass('hide');
            } else if (type == 2) {
                $('#project_rate_per_hour').removeClass('hide');
            } else {
                $('#project_rate_per_hour').addClass('hide');
            }
        });


    });

    function GetSubCat() {
        id = $('#cat_id').val();
        $.ajax({
            url: '<?php echo admin_url("ChildCategory/$ServID/"); ?>' + id,
            success: function (data) {
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    $('#subcat_id').html('<option value="' + value['id'] + '">' + value['name'] + '</option>');
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
</script>
</body>
</html>
