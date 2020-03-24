<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <?php
            $custom_fields = false;
            if(total_rows(db_prefix().'customfields',array('fieldto'=>$service->slug,'active'=>1)) > 0 ){
                $custom_fields = true;
            }
            ?>
            <?php echo form_open($this->uri->uri_string(),array('id'=>'form')); ?>
            <div class="col-md-8">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <?php
                        $disable_type_edit = '';
                        if(isset($case)){
                            if($case->billing_type != 1){
                                if(total_rows(db_prefix().'tasks',array('rel_id'=>$case->id,'rel_type'=>"$service->slug",'billable'=>1,'billed'=>1)) > 0){
                                    $disable_type_edit = 'disabled';
                                }
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('code', 'CaseCode', $service->prefix . $case->numbering); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('name','CaseTitle',$case->name); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group select-placeholder">
                                    <label for="clientid"
                                           class="control-label"><?php echo _l('project_customer'); ?></label>
                                    <select id="clientid" name="clientid" data-live-search="true" data-width="100%"
                                            class="ajax-search"
                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php $selected = (isset($case) ? $case->clientid : '');
                                        if($selected == ''){
                                            $selected = (isset($case) ? $case->clientid : '');
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
                                <a href="#" data-toggle="modal" data-target="#add-client" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group select-placeholder">
                                    <label for="opponent_id"
                                           class="control-label"><?php echo _l('opponent'); ?></label>
                                    <select id="opponent_id" name="opponent_id" data-live-search="true" data-width="100%"
                                            class="ajax-search"
                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php
                                        $selected = (isset($case) ? $case->opponent_id : '');
                                        if($selected == ''){
                                            $selected = (isset($case) ? $case->opponent_id : '');
                                        }
                                        if ($selected != '') {
                                            $rel_data = get_relation_data('opponents', $selected);
                                            $rel_val = get_relation_values($rel_data, 'opponents');
                                            echo '<option value="' . $rel_val['id'] . '" selected>' . $rel_val['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <a href="#" data-toggle="modal" data-target="#add-opponent" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="representative"><?php echo _l('customer_description'); ?></label>
                                    <select id="representative" name="representative" class="form-control custom_select_arrow"
                                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                        <?php $data = get_relation_data('representative', '');
                                        foreach ($data as $row): ?>
                                            <option value="<?php echo $row['id']; ?>" <?php echo $case->representative == $row['id'] ? 'selected': '' ?>><?php echo $row['representative']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="control-label"><?php echo _l('Categories'); ?></label>
                                    <select class="form-control custom_select_arrow" id="cat_id" onchange="GetSubCat()" name="cat_id" placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                        <?php $data = get_relation_data('mycategory',$ServID);
                                        foreach ($data as $row): ?>
                                            <option value="<?php echo $row->id; ?>" <?php echo $case->cat_id == $row->id ? 'selected': '' ?>><?php echo $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><?php echo _l('SubCategories'); ?></label>
                                    <select class="form-control custom_select_arrow" id="subcat_id" name="subcat_id" placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                        <?php $data = get_relation_data('childmycategory',$case->cat_id);
                                        foreach ($data as $row) {
                                            if($case->subcat_id == $row->id) { ?>
                                                <option value="<?php echo $row->id ?>" selected><?php echo $row->name ?></option>
                                            <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label"><?php echo _l('Court'); ?></label>
                                    <select class="form-control custom_select_arrow" id="court_id" onchange="GetCourtJad()" name="court_id" placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                        <?php $data = get_relation_data('mycourts','');
                                        foreach ($data as $row): ?>
                                            <option value="<?php echo $row->c_id; ?>" <?php echo $case->court_id == $row->c_id ? 'selected': '' ?>><?php echo $row->court_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <a href="#" data-toggle="modal" data-target="#add-court" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label"><?php echo _l('Judicial'); ?></label>
                                    <select class="form-control custom_select_arrow" id="jud_num" name="jud_num" placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                        <?php $data = get_relation_data('myjudicial',$case->court_id);
                                        foreach ($data as $row) {
                                            if($case->jud_num == $row->j_id) { ?>
                                                <option value="<?php echo $row->j_id ?>" selected><?php echo $row->Jud_number ?></option>
                                            <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <a href="#" data-toggle="modal" data-target="#AddJudicialDeptModal" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <?php
                                $judges = get_relation_data('Judges', '');
                                $selected = array();
                                if(isset($case_judges)){
                                    foreach($case_judges as $row){
                                        array_push($selected,$row['id']);
                                    }
                                }
                                echo render_select('judges[]',$judges,array('id',array('name')),'judge',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','judge_select',false);
                                ?>
                            </div>
                            <div class="col-md-1">
                                <a href="#" data-toggle="modal" data-target="#add-judge" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('file_number_case', 'file_number_in_case', $case->file_number_case, 'number'); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('file_number_court', 'file_number_in_court', $case->file_number_court, 'number'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $staff_language = get_option('active_language');
                                if($staff_language == 'arabic'){
                                    $field = 'short_name_ar';
                                    $city_field = 'Name_ar';
                                }else{
                                    $field = 'short_name';
                                    $city_field = 'Name_en';
                                }
                                ?>
                                <?php echo render_select( 'country', get_cases_countries($field),array( 'country_id',array($field)), 'lead_country',$case->country); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="city"><?php echo _l('client_city'); ?></label>
                                    <?php $data = get_relation_data('build_dropdown_cities',''); ?>
                                    <select id="city" name="city" class="form-control custom_select_arrow">
                                        <option selected disabled></option>
                                        <?php foreach ($data as $row): ?>
                                            <option value="<?php echo $row->$city_field; ?>" <?php echo $case->city == $row->$city_field ? 'selected': '' ?>><?php echo $row->$city_field; ?></option>
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
                                        <option value="1" <?php if(isset($case) && $case->billing_type == 1 || !isset($case) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 1){echo 'selected'; } ?>><?php echo _l('project_billing_type_fixed_cost'); ?></option>
                                        <option value="2" <?php if(isset($case) && $case->billing_type == 2 || !isset($case) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 2){echo 'selected'; } ?>><?php echo _l('project_billing_type_project_hours'); ?></option>
                                        <option value="3" data-subtext="<?php echo _l('project_billing_type_project_task_hours_hourly_rate'); ?>" <?php if(isset($case) && $case->billing_type == 3 || !isset($case) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 3){echo 'selected'; } ?>><?php echo _l('project_billing_type_project_task_hours'); ?></option>
                                    </select>
                                    <?php if($disable_type_edit != ''){
                                        echo '<p class="text-danger">'._l('cant_change_billing_type_billed_tasks_found').'</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group select-placeholder">
                                    <label for="case_status"><?php echo _l('case_status'); ?></label>
                                    <div class="clearfix"></div>
                                    <select name="case_status" id="case_status" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                        <?php $data = get_relation_data('Case_status', '');
                                        foreach ($data as $row): ?>
                                            <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $case->case_status ? 'selected': '' ?>><?php echo $row['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php
                        $input_field_hide_class_total_cost = '';
                        if(!isset($case)){
                            if($auto_select_billing_type && $auto_select_billing_type->billing_type != 1 || !$auto_select_billing_type){
                                $input_field_hide_class_total_cost = 'hide';
                            }
                        } else if(isset($case) && $case->billing_type != 1){
                            $input_field_hide_class_total_cost = 'hide';
                        }
                        ?>
                        <div id="project_cost" class="<?php echo $input_field_hide_class_total_cost; ?>">
                            <?php $value = (isset($case) ? $case->project_cost : ''); ?>
                            <?php echo render_input('project_cost','project_total_cost',$value,'number'); ?>
                        </div>
                        <?php
                        $input_field_hide_class_rate_per_hour = '';
                        if(!isset($case)){
                            if($auto_select_billing_type && $auto_select_billing_type->billing_type != 2 || !$auto_select_billing_type){
                                $input_field_hide_class_rate_per_hour = 'hide';
                            }
                        } else if(isset($case) && $case->billing_type != 2){
                            $input_field_hide_class_rate_per_hour = 'hide';
                        }
                        ?>
                        <div id="project_rate_per_hour" class="<?php echo $input_field_hide_class_rate_per_hour; ?>">
                            <?php $value = (isset($case) ? $case->project_rate_per_hour : ''); ?>
                            <?php
                            $input_disable = array();
                            if($disable_type_edit != ''){
                                $input_disable['disabled'] = true;
                            }
                            ?>
                            <?php echo render_input('project_rate_per_hour','project_rate_per_hour',$value,'number',$input_disable); ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('estimated_hours','estimated_hours',isset($case) ? $case->estimated_hours : '','number'); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group select-placeholder">
                                    <label for="status"><?php echo _l('project_status'); ?></label>
                                    <div class="clearfix"></div>
                                    <select name="status" id="status" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($statuses as $status){ ?>
                                            <option value="<?php echo $status['id']; ?>" <?php if(!isset($case) && $status['id'] == 2 || (isset($case) && $case->status == $status['id'])){echo 'selected';} ?>><?php echo $status['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                        <div class="col-md-6">
                                <?php $value = (isset($case) ? _d($case->start_date) : _d(date('Y-m-d'))); ?>
                                <?php echo render_date_input('start_date','project_start_date',$value); ?>
                            </div>
                            <div class="col-md-6">
                                <?php $value = (isset($case) ? _d($case->deadline) : _d(date('Y-m-d'))); ?>
                                <?php echo render_date_input('deadline','project_deadline',$value); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
                                    <input type="text" class="tagsinput" id="tags" name="tags" value="<?php echo (isset($case) ? prep_tags_input(get_tags_in($case->id,$service->slug)) : ''); ?>" data-role="tagsinput">
                                </div>
                            </div>
                            <div class="col-md-10">

                                <?php
                                $selected = array();
                                if(isset($case_members)){
                                    foreach($case_members as $member){
                                        array_push($selected,$member['staff_id']);
                                    }
                                } else {
                                    array_push($selected,get_staff_user_id());
                                }
                                echo render_select('project_members[]',$staff,array('staffid',array('firstname','lastname')),'project_members',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
                                ?>
                            </div>
                            <div class="col-md-1">
                                <a href="<?php echo admin_url('staff')?>" target="_blank" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group select-placeholder">
                                    <label for="case_result"><?php echo _l('ResultCase'); ?></label>
                                    <div class="clearfix"></div>
                                    <select name="case_result" id="case_result" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                        <option value="رابحة" <?php echo $case->case_result == "رابحة" ? 'selected': '' ?>><?php echo _l('Winning'); ?></option>
                                        <option value="خاسرة" <?php echo $case->case_result == "خاسرة" ? 'selected': '' ?>><?php echo _l('Losing'); ?></option>
                                        <option value="متداولة" <?php echo $case->case_result == "متداولة" ? 'selected': '' ?>><?php echo _l('Circulated'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label"><?php echo _l('contracts'); ?></label>
                                <select class="form-control custom_select_arrow" name="contract"
                                        placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                    <option selected disabled></option>
                                    <?php $data = get_relation_data('contracts', '');
                                    foreach ($data as $row): ?>
                                        <option value="<?php echo $row['id']; ?>" <?php echo  $row['id'] == $case->contract ? 'selected': '' ?>><?php echo $row['subject']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="select-placeholder form-group">
                                    <label class="control-label"><?php echo _l('linked_to_previous_case'); ?></label>
                                    <select class="selectpicker" name="previous_case_id" placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>" data-live-search="true">
                                        <option selected disabled></option>
                                        <?php $data = get_relation_data('cases');
                                        foreach ($data as $row):
                                            if ($row['id'] != $case->id): ?>
                                            <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $case->previous_case_id ? 'selected': '' ?>> <?php echo $row['name']; ?></option>
                                        <?php endif; endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <p class="bold"><?php echo _l('project_description'); ?></p>
                        <?php echo render_textarea('description','',$case->description,array(),array(),'','tinymce'); ?>
                        <?php if(total_rows(db_prefix().'emailtemplates',array('slug'=>'assigned-to-project','active'=>0)) == 0){ ?>
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="send_created_email" id="send_created_email">
                                <label for="send_created_email"><?php echo _l('project_send_created_email'); ?></label>
                            </div>
                        <?php } ?>
                        <!-- custom_fields -->
                        <?php if($custom_fields) { ?>
                            <div role="tabpanel" id="custom_fields">
                                <?php $rel_id= (isset($case) ? $case->id : false); ?>
                                <?php echo render_custom_fields($service->slug,$rel_id); ?>
                            </div>
                        <?php } ?>
                        <div class="btn-bottom-toolbar text-right">
                            <button type="submit" data-form="#form" class="btn btn-info" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
                        </div>
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
<div class="modal fade" id="add-opponent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('opponent'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input( 'opponent_company_modal', 'opponent','','text'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="button" id="AddOpponent" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-court" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('Court'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('court_name_modal','name'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="button" id="AddCourt" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-judge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('judge'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('judge_name_modal','name'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="button" id="AddJudge" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="AddJudicialDeptModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('Judicial'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="court_id" class="control-label"><?php echo _l('Court'); ?></label>
                            <select class="form-control" id="court_id_modal" onchange="GetCourtJad()" name="court_id_modal"
                                    placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                <option selected disabled></option>
                                <?php $data = get_relation_data('mycourts', '');
                                foreach ($data as $row): ?>
                                    <option value="<?php echo $row->c_id; ?>"><?php echo $row->court_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('Jud_number_modal','NumJudicialDept'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="button" id="AddJudicialDept" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    init_ajax_search('opponents', '#opponent_id.ajax-search');

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
                        $('#add-client').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('faild'); ?>');
                    }
                }
            });
        }
    });

    $("#AddOpponent").click(function () {
        company = $('#opponent_company_modal').val();
        if(company == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('opponents/add'); ?>',
                data: {
                    company : company,
                    client_type : 1
                },
                type: "POST",
                success: function (data) {
                    if(data){
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                        $('#add-opponent').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('faild'); ?>');
                    }
                }
            });
        }
    });

    $("#AddCourt").click(function () {
        court_name = $('#court_name_modal').val();
        if(court_name == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('LegalServices/Courts_controller/add_court_from_modal'); ?>',
                data: {court_name : court_name},
                type: "POST",
                success: function (data) {
                    if(data){
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                        $("#court_id").append(new Option(court_name, data));
                        $('#add-court').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('faild'); ?>');
                    }
                }
            });
        }
    });


    $("#AddJudge").click(function () {
        var judge_name = $('#judge_name_modal').val();
        if(judge_name == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('judge/add'); ?>',
                data: {name : judge_name},
                type: "POST",
                success: function (data) {
                    if(data){
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                        var $option = $('<option></option>')
                            .attr('value', data)
                            .text(judge_name);
                        $('.judge_select').append($option).change();
                        $('.judge_select').selectpicker("refresh");
                        $('#add-judge').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('faild'); ?>');
                    }
                }
            });
        }
    });

    $("#AddJudicialDept").click(function () {
        var court_id_modal   = $('#court_id_modal').val();
        var Jud_number_modal = $('#Jud_number_modal').val();
        if(court_id_modal == '' || Jud_number_modal == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('LegalServices/Courts_controller/add_judicial_department_modal/'); ?>' + court_id_modal,
                data: {Jud_number : Jud_number_modal},
                type: "POST",
                success: function (data) {
                    if(data){
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                        var $option = $('<option></option>')
                            .attr('value', data)
                            .text(Jud_number_modal)
                            .prop('selected', true);
                        $('#jud_num').append($option).change();
                        $('#AddJudicialDeptModal').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('faild'); ?>');
                    }
                }
            });
        }
    });


    <?php if(isset($case)){ ?>
    var original_project_status = '<?php echo $case->status; ?>';
    <?php } ?>

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

    function GetCourtJad() {
        id = $('#court_id').val();
        $.ajax({
            url: '<?php echo admin_url("judicialByCourt/"); ?>' + id,
            success: function (data) {
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    $('#jud_num').html('<option value="' + value['j_id'] + '">' + value['Jud_number'] + '</option>');
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
            representative: 'required',
            cat_id: 'required',
            subcat_id: 'required',
            court_id: 'required',
            jud_num: 'required',
            billing_type: 'required',
            //rate_per_hour: 'required',
            members : 'required',
            start_date: 'required',
            case_result: 'required',
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
        // Eq Project creator disable TASKS tab, then this function will auto turn off customer project option Allow customer to view tasks

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
        <?php if(!isset($case)) { ?>
        $('#available_features').trigger('change');
        <?php } ?>
    });
</script>
</body>
</html>
