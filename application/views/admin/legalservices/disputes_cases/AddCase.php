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
                            <?php
                            echo _l('permission_create').' '._l('Case'); ?>
                        </h4>
                        <div class="col-md-12" id="required"></div>
                        <hr class="hr-panel-heading"/>
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
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="head_case_info">
                                    <h4  id="head_case_info_1" class="panel-title" role="button" data-toggle="collapse" href="#case_info" aria-expanded="false" aria-controls="collapseOne">
                                        <?php echo _l('case_info'); ?>
                                    </h4>
                                </div>
                                <div id="case_info" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="head_case_info">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php $CodeValue = isset($Numbering->numbering) ? $Numbering->numbering + 1 : $service->numbering; ?>
                                                <?php echo render_input('code', 'CaseCode', $service->prefix . $CodeValue, 'text', ['readonly' => true]); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?php echo render_input('name', 'CaseTitle'); ?>
                                            </div>
                                        </div>
                                        <input type="hidden" name="numbering" value="<?php echo $CodeValue; ?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                $staff_language = get_staff_default_language(get_staff_user_id());
                                                if($staff_language == 'arabic'){
                                                    $field = 'short_name_ar';
                                                    $field_city = 'Name_ar';
                                                }else{
                                                    $field = 'short_name';
                                                    $field_city = 'Name_en';
                                                }
                                                ?>
                                                <?php echo render_select('country', get_cases_countries($field), array('country_id', array($field)), 'lead_country', get_option('company_country')); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="city"><?php echo _l('client_city'); ?></label>
                                                    <?php $data = get_relation_data('build_dropdown_cities',''); ?>
                                                    <select id="city" name="city" class="form-control custom_select_arrow">
                                                        <option selected disabled></option>
                                                        <?php
                                                        if(get_option('company_city') != ''){
                                                            foreach ($data as $row): ?>
                                                                <option value="<?php echo $row->$field_city; ?>" <?php echo get_option('company_city') == $row->Name_en ? 'selected' : (get_option('company_city') == $row->Name_ar ? 'selected' : '') ?>><?php echo $row->$field_city; ?></option>
                                                            <?php endforeach;
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

<!--                                        <div class="row">-->
<!--                                            <div class="col-md-6">-->
                                                <?php  render_input('file_number_case', 'file_number_in_office', ''); ?>
<!--                                            </div>-->
<!--                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="head_client_info">
                                    <h4 class="panel-title collapsed" role="button" data-toggle="collapse" href="#client_info" aria-expanded="false" aria-controls="collapseOne">
                                        <?php echo _l('client_info'); ?>
                                    </h4>
                                </div>
                                <div id="client_info" class="panel-collapse collapse" role="tabpanel" aria-labelledby="head_client_info">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group select-placeholder">
                                                    <label for="clientid" class="control-label"><?php echo _l('project_customer'); ?></label>
                                                    <select id="clientid" name="clientid" data-live-search="true" data-width="100%"
                                                            class="ajax-search"
                                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                        <?php
                                                        $selected = (isset($case) ? $case->clientid : '');
                                                        if ($selected == '') {
                                                            $selected = (isset($customer_id) ? $customer_id : '');
                                                        }
                                                        if ($selected != '') {
                                                            $rel_data = get_relation_data('customer', $selected);
                                                            $rel_val = get_relation_values($rel_data, 'customer');
                                                            echo '<option value="' . $rel_val['id'] . '" selected>' . $rel_val['name'] . '</option>';
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if (has_permission('customers', '', 'create')) { ?>
                                            <div class="col-md-1">
                                                <a href="#" data-toggle="modal" data-target="#add-client" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <?php } ?>
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="representative"><?php echo _l('customer_description'); ?></label>
                                                    <select id="representative" name="representative" class="form-control custom_select_arrow"
                                                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                        <option selected></option>
                                                        <?php $data = get_relation_data('representative', '');
                                                        foreach ($data as $row): ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['representative']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <?php for($i=0; $i<10; $i++) : ?>
                                                        <div class="row opponents <?php echo ($i>0?'hidden':''); ?>">
                                                            <div class="col-md-10">
                                                                <div class="form-group select-placeholder">
                                                                    <label for="opponent_id_<?php echo $i; ?>"
                                                                           class="control-label"><?php echo _l('opponent') . ' ' . ($i+1); ?></label>
                                                                    <select id="opponent_id_<?php echo $i; ?>" name="opponent_id[<?php echo $i; ?>]" data-live-search="true" data-width="100%"
                                                                            class="ajax-search opponent" <?php echo ($i==0?'required':''); ?>
                                                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a href="#" data-toggle="modal" data-target="#add-opponent" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                                                            </div>
                                                        </div>
                                                    <?php endfor; ?>
                                                    <p id="opponent-error" class="text-danger hide">You can not Choose same Opponent</p>
                                                    <div class="row opponent_lawyer">
                                                        <div class="col-md-10">
                                                            <div class="form-group select-placeholder">
                                                                <label for="opponent_lawyer_id"
                                                                       class="control-label"><?php echo _l('opponent_lawyer'); ?></label>
                                                                <select id="opponent_lawyer_id" name="opponent_lawyer_id" data-live-search="true" data-width="100%"
                                                                        class="ajax-search"
                                                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <a href="#" data-toggle="modal" data-target="#add-opponent-lawyer" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="head_court_info">
                                    <h4 class="panel-title collapsed" role="button" data-toggle="collapse" href="#court_info" aria-expanded="false" aria-controls="collapseOne">
                                        <?php echo _l('court_info'); ?>
                                    </h4>
                                </div>
                                <div id="court_info" class="panel-collapse collapse" role="tabpanel" aria-labelledby="head_court_info">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="court_id" class="control-label"><?php echo _l('Court'); ?></label>
                                                    <select class="selectpicker custom_select_arrow" id="court_id" onchange="GetCourtJad()" name="court_id" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                        <option selected></option>
                                                        <?php $data = get_courts_by_country_city(get_option('company_country'),get_option('company_city'));
                                                        foreach ($data as $row): ?>
                                                            <option value="<?php echo $row->c_id; ?>"><?php echo $row->court_name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if (has_permission('courts', '', 'create')) { ?>
                                            <div class="col-md-1">
                                                <a href="#" data-toggle="modal" data-target="#add-court" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <?php } ?>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="jud_num" class="control-label"><?php echo _l('NumJudicialDept'); ?></label>
                                                    <select class="form-control custom_select_arrow" id="jud_num" name="jud_num"
                                                            data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                        <option selected></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if (has_permission('judicial_departments', '', 'create')) { ?>
                                            <div class="col-md-1">
                                                <a href="#" data-toggle="modal" data-target="#AddJudicialDeptModal" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <?php } ?>
                                        </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cat_id" class="control-label"><?php echo _l('Categories'); ?></label>
                                                        <select class="form-control custom_select_arrow" id="cat_id" onchange="GetSubCat()" name="cat_id"
                                                                placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                            <option selected disabled></option>
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
                                                <div id="childsubcat"></div>
                                            </div>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <?php
                                                $selected = array();
                                                $data = get_relation_data('Judges', '');
                                                echo render_select('judges[]',$data,array('id',array('name')),'judge',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','judge_select',false);
                                                ?>
                                            </div>
                                            <?php if (has_permission('judges_manage', '', 'create')) { ?>
                                            <a href="#" data-toggle="modal" data-target="#add-judge" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                                            <?php } ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo render_input('file_number_court', 'file_number_in_court', '', 'number'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="head_payment_info">
                                    <h4 class="panel-title collapsed" role="button" data-toggle="collapse" href="#payment_info" aria-expanded="false" aria-controls="collapseOne">
                                        <?php echo _l('payment_info'); ?>
                                    </h4>
                                </div>
                                <div id="payment_info" class="panel-collapse collapse" role="tabpanel" aria-labelledby="head_payment_info">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group select-placeholder">
                                                    <label for="billing_type"><?php echo _l('project_billing_type'); ?></label>
                                                    <div class="clearfix"></div>
                                                    <select name="billing_type" class="selectpicker" id="billing_type" data-width="100%" <?php echo $disable_type_edit ; ?> data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                        <option value=""></option>
                                                        <option value="1" ><?php echo _l('project_billing_type_fixed_cost'); ?></option>
                                                        <option value="10" ><?php echo _l('project_billing_type_10'); ?></option>
                                                        <option value="11" ><?php echo _l('project_billing_type_11'); ?></option>
                                                    </select>
                                                    <?php if($disable_type_edit != ''){
                                                        echo '<p class="text-danger">'._l('cant_change_billing_type_billed_tasks_found').'</p>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if(total_rows(db_prefix().'emailtemplates',array('slug'=>'project-finished-to-customer','active'=>0)) == 0){ ?>
                                            <div class="form-group project_marked_as_finished hide">
                                                <div class="checkbox checkbox-primary">
                                                    <input type="checkbox" name="project_marked_as_finished_email_to_contacts" id="project_marked_as_finished_email_to_contacts">
                                                    <label for="project_marked_as_finished_email_to_contacts"><?php echo _l('project_marked_as_finished_to_contacts'); ?></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        $input_field_hide_class_total_cost = '';
                                        if(!isset($project)){
                                            if($auto_select_billing_type && $auto_select_billing_type->billing_type == 11 || !$auto_select_billing_type){
                                                $input_field_hide_class_total_cost = 'hide';
                                            }
                                        }
                                        ?>
                                        <div id="project_cost" class="<?php echo $input_field_hide_class_total_cost; ?> hide">
                                            <?php $value = (isset($project) ? $project->project_cost : ''); ?>
                                            <?php echo render_input('project_cost','project_billing_type_fixed_cost','','number'); ?>
                                        </div>
                                        <?php
                                        $input_field_hide_class_rate_per_hour = '';
                                        if(!isset($project)){
                                            if($auto_select_billing_type && $auto_select_billing_type->billing_type == 1 || !$auto_select_billing_type){
                                                $input_field_hide_class_rate_per_hour = 'hide';
                                            }
                                        }
                                        ?>
                                        <div id="project_rate_per_hour" class="<?php echo $input_field_hide_class_rate_per_hour; ?> hide">
                                            <?php
                                            $input_disable = array();
                                            if($disable_type_edit != ''){
                                                $input_disable['disabled'] = true;
                                            }
                                            ?>
                                            <?php echo render_input('project_rate_per_hour','project_rate_percent','','number',$input_disable); ?>
                                        </div>
                                        <?php echo render_input('disputes_total','disputes_total','','number',['min'=>1]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="head_management_info">
                                    <h4 class="panel-title collapsed" role="button" data-toggle="collapse" href="#management_info" aria-expanded="false" aria-controls="collapseOne">
                                        <?php echo _l('management_info'); ?>
                                    </h4>
                                </div>
                                <div id="management_info" class="panel-collapse collapse" role="tabpanel" aria-labelledby="head_management_info">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group select-placeholder">
                                                    <label for="case_status"><?php echo _l('disputes_cases_status'); ?></label>
                                                    <div class="clearfix"></div>
                                                    <select name="case_status" id="case_status" class="selectpicker" data-width="100%"
                                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                        <option selected></option>
                                                        <?php if(isset($case_statuses)){?>
                                                            <?php foreach ($case_statuses as $row){ ?>
                                                                <option value="<?php echo $row->id; ?>" <?php echo $selected == $row->id ? 'selected': '' ?>><?php echo $row->status_name; ?></option>
                                                            <?php } ?>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="#" data-toggle="modal" data-target="#add-status-modal" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php
                                                $selected = array();
                                                if(isset($project_members)){
                                                    foreach($project_members as $member){
                                                        array_push($selected,$member['staff_id']);
                                                    }
                                                } else {
                                                    array_push($selected,get_staff_user_id());
                                                }
                                                echo render_select('project_members[]',$staff,array('staffid',array('firstname','lastname')),'project_members',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
                                                ?>
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
                                        <?php if(isset($project) && $project->date_finished != null && $project->status == 4) { ?>
                                            <?php echo render_datetime_input('date_finished','project_completed_date',_dt($project->date_finished)); ?>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
                                            <input type="text" class="tagsinput" id="tags" name="tags" value="<?php echo (isset($project) ? prep_tags_input(get_tags_in($project->id,'project')) : ''); ?>" data-role="tagsinput">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                        <?php if(isset($case) && project_has_recurring_tasks($case->id)) { ?>
                            <div class="alert alert-warning recurring-tasks-notice hide"></div>
                        <?php } ?>
                        <?php if(is_email_template_active('project-finished-to-customer')){ ?>
                            <div class="form-group project_marked_as_finished hide">
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" name="project_marked_as_finished_email_to_contacts" id="project_marked_as_finished_email_to_contacts">
                                    <label for="project_marked_as_finished_email_to_contacts"><?php echo _l('project_marked_as_finished_to_contacts'); ?></label>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(isset($case)){ ?>
                            <div class="form-group mark_all_tasks_as_completed hide">
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" name="mark_all_tasks_as_completed" id="mark_all_tasks_as_completed">
                                    <label for="mark_all_tasks_as_completed"><?php echo _l('project_mark_all_tasks_as_completed'); ?></label>
                                </div>
                            </div>
                            <div class="notify_project_members_status_change hide">
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" name="notify_project_members_status_change" id="notify_project_members_status_change">
                                    <label for="notify_project_members_status_change"><?php echo _l('notify_project_members_status_change'); ?></label>
                                </div>
                                <hr />
                            </div>
                        <?php } ?>
                        <p for="description" class="bold"><?php echo _l('project_description'); ?></p>
                        <?php echo render_textarea('description', '', '', array(), array(), '', 'tinymce'); ?>
                        <?php if (isset($estimate)) {?>
                <hr class="hr-panel-heading" />
                <h5 class="font-medium"><?php echo _l('estimate_items_convert_to_tasks') ?></h5>
                <input type="hidden" name="estimate_id" value="<?php echo $estimate->id ?>">
                <div class="row">
                    <?php foreach($estimate->items as $item) { ?>
                    <div class="col-md-8 border-right">
                        <div class="checkbox mbot15">
                            <input type="checkbox" name="items[]" value="<?php echo $item['id'] ?>" checked id="item-<?php echo $item['id'] ?>">
                            <label for="item-<?php echo $item['id'] ?>">
                                <h5 class="no-mbot no-mtop text-uppercase"><?php echo $item['description'] ?></h5>
                                <span class="text-muted"><?php echo $item['long_description'] ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div data-toggle="tooltip" title="<?php echo _l('task_single_assignees_select_title'); ?>">
                            <?php echo render_select('items_assignee[]',$staff,array('staffid',array('firstname','lastname')),'', get_staff_user_id(),array('data-actions-box'=>true),array(),'','clean-select',false); ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
                <hr class="hr-panel-heading" />
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
                    <div class="panel-body" id="case-settings-area">
                        <h4 class="no-margin">
                            <?php echo _l('project_settings'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />
           <div class="form-group select-placeholder">
                <label for="contact_notification" class="control-label">
                    <span class="text-danger">*</span>
                    <?php echo _l('projects_send_contact_notification'); ?>
                </label>
                <select name="contact_notification" id="contact_notification" class="form-control selectpicker"
                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" required>
                    <?php
                    $options = [
                        ['id'=> 1 , 'name' => _l('project_send_all_contacts_with_notifications_enabled')],
                        ['id'=> 2 , 'name' => _l('project_send_specific_contacts_with_notification')],
                        ['id'=> 0 , 'name' => _l('project_do_not_send_contacts_notifications')]
                    ];
                    foreach ($options as $option) { ?>
                        <option value="<?php echo $option['id']; ?>" <?php if ((isset($case) && $case->contact_notification == $option['id'])) {
                            echo ' selected';
                        } ?>><?php echo $option['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <!-- hide class -->
            <div class="form-group select-placeholder <?php echo (isset($case) && $case->contact_notification == 2) ? '' : 'hide' ?>" id="notify_contacts_wrapper">
                <label for="notify_contacts" class="control-label"><span class="text-danger">*</span> <?php echo _l('project_contacts_to_notify') ?></label>
                <select name="notify_contacts[]" data-id="notify_contacts" id="notify_contacts" class="ajax-search" data-width="100%" data-live-search="true"
                data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" multiple>
                    <?php
                    $notify_contact_ids = isset($case) ? unserialize($case->notify_contacts) : [];
                    foreach ($notify_contact_ids as $contact_id) {
                        $rel_data = get_relation_data('contact',$contact_id);
                        $rel_val = get_relation_values($rel_data,'contact');
                        echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                    }
                    ?>
                </select>
            </div>
                        <?php  foreach($settings as $setting){
                            //$checked = ' checked';
                            $checked = '';

                            if(isset($case)){
                                //if($case->settings->{$setting} == 0){
                                if($case->settings->{$setting} == 1){
                                    $checked = ' checked';
                                }
                            } else {
                                foreach($last_case_settings as $last_setting) {
                                    if($setting == $last_setting['name']){
                                        // hide_tasks_on_main_tasks_table is not applied on most used settings to prevent confusions
                                        if($last_setting['value'] == 0 || $last_setting['name'] == 'hide_tasks_on_main_tasks_table'){
                                            $checked = '';
                                        }
                                    }
                                }
                                if(count($last_case_settings) == 0 && $setting == 'hide_tasks_on_main_tasks_table') {
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
                                <div class="form-group mtop15 select-placeholder case-available-features">
                                    <label for="available_features"><?php echo _l('visible_tabs'); ?></label>
                                    <select name="settings[<?php echo $setting; ?>][]" id="<?php echo $setting; ?>" multiple="true" class="selectpicker" id="available_features" data-width="100%" data-actions-box="true" data-hide-disabled="true">
                                        <?php foreach(get_disputes_case_tabs_admin() as $tab) {
                                            $selected = '';
                                            if(isset($tab['collapse'])){ ?>
                                                <optgroup label="<?php echo $tab['name']; ?>">
                                                    <?php foreach($tab['children'] as $tab_dropdown) {
                                                        $selected = '';
                                                        if(isset($case) && (
                                                                (isset($case->settings->available_features[$tab_dropdown['slug']])
                                                                    && $case->settings->available_features[$tab_dropdown['slug']] == 1)
                                                                || !isset($case->settings->available_features[$tab_dropdown['slug']]))) {
                                                            $selected = ' selected';
                                                        } else if(!isset($case) && count($last_case_settings) > 0) {
                                                            foreach($last_case_settings as $last_case_setting) {
                                                                if($last_case_setting['name'] == $setting) {
                                                                    if(isset($last_case_setting['value'][$tab_dropdown['slug']])
                                                                        && $last_case_setting['value'][$tab_dropdown['slug']] == 1) {
                                                                        $selected = ' selected';
                                                                    }
                                                                }
                                                            }
                                                        } else if(!isset($case)) {
                                                            $selected = ' selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $tab_dropdown['slug']; ?>"<?php echo $selected; ?><?php if(isset($tab_dropdown['linked_to_customer_option']) && is_array($tab_dropdown['linked_to_customer_option']) && count($tab_dropdown['linked_to_customer_option']) > 0){ ?> data-linked-customer-option="<?php echo implode(',',$tab_dropdown['linked_to_customer_option']); ?>"<?php } ?>><?php echo $tab_dropdown['name']; ?></option>
                                                    <?php } ?>
                                                </optgroup>
                                            <?php } else {
                                                if(isset($case) && (
                                                        (isset($case->settings->available_features[$tab['slug']])
                                                            && $case->settings->available_features[$tab['slug']] == 1)
                                                        || !isset($case->settings->available_features[$tab['slug']]))) {
                                                    $selected = ' selected';
                                                } else if(!isset($case) && count($last_case_settings) > 0) {
                                                    foreach($last_case_settings as $last_case_setting) {
                                                        if($last_case_setting['name'] == $setting) {
                                                            if(isset($last_case_setting['value'][$tab['slug']])
                                                                && $last_case_setting['value'][$tab['slug']] == 1) {
                                                                $selected = ' selected';
                                                            }
                                                        }
                                                    }
                                                } else if(!isset($case)) {
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
<?php if (has_permission('customers', '', 'create')) { ?>
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
<?php } ?>
<?php if (has_permission('opponents', '', 'create')) { ?>
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
<?php } ?>
<?php if (has_permission('opponents', '', 'create')) { ?>
    <div class="modal fade" id="add-opponent-lawyer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        <span class="add-title"><?php echo _l('opponent_lawyer'); ?></span>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo render_input( 'opponent_lawyer_company_modal', 'opponent_lawyer','','text'); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                    <button group="button" id="AddOpponent-lawyer" class="btn btn-info"><?php echo _l('submit'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (has_permission('courts', '', 'create')) { ?>
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
                        <p class="bold"><?php echo _l('_description'); ?></p>
                        <?php echo render_textarea('court_description', '', '', array(), array(), '', 'tinymce'); ?>
                        <div id="cat"></div>
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
<?php } ?>
<?php if (has_permission('judges_manage', '', 'create')) { ?>
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
<?php } ?>
<?php if (has_permission('judicial_departments', '', 'create')) { ?>
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
                        <?php echo render_input('Jud_email','_email',''); ?>
                        <p class="bold"><?php echo _l('_description'); ?></p>
                        <?php echo render_textarea('Jud_description', '', '', array(), array(), '', 'tinymce'); ?>
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
<?php } ?>
<div class="modal fade" id="add-status-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('disputes_cases_status'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('status_name_modal','disputes_cases_status'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="button" id="add_status" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
<script>
    init_ajax_search('opponents', '#opponent_id.ajax-search');
    <?php for($i=0; $i<10; $i++) : ?>
    init_ajax_search('opponents','#opponent_id_<?php echo $i; ?>.ajax-search');
    <?php endfor; ?>
    init_ajax_search('opponents','#opponent_lawyer_id.ajax-search');
    $("#add_status").click(function () {
        status_name = $('#status_name_modal').val();
        if(status_name == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('legalservices/disputes_cases/add_case_statuses_from_modal'); ?>',
                data: {status_name : status_name},
                type: "POST",
                success: function (data) {
                    if(data){
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                        $('#case_status').append($('<option>', {value: data, text: status_name,selected : true}));
                        $('#case_status').selectpicker('refresh');
                        $('#add-status-modal').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                    }
                }
            });
        }
    });

    <?php if (has_permission('customers', '', 'create')) { ?>
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
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                    }
                }
            });
        }
    });
    <?php } ?>

    <?php if (has_permission('opponents', '', 'create')) { ?>
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
                        var newOption = $("#opponent_id").append(new Option(company, data, true, true));
                        $('#opponent_id').append(newOption).trigger('change');
                        $('#add-opponent').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                    }
                }
            });
        }
    });
    <?php } ?>
    <?php if (has_permission('opponents', '', 'create')) { ?>
    $("#AddOpponent-lawyer").click(function () {
        company = $('#opponent_lawyer_company_modal').val();
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
                        var newOption = $("#opponent_lawyer_id").append(new Option(company, data, true, true));
                        $('#opponent_lawyer_id').append(newOption).trigger('change');
                        $('#add-opponent-lawyer').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                    }
                }
            });
        }
    });
    <?php } ?>

    var error = false;
    $(".opponent").on('change',function () {
        var sel = $(this).val();
        var selected_counts = 1;
        var val = 1000;
        $(".opponent").each(function(index){
            if($(this).val()>0){
                selected_counts++;
                if($(this).val() == val){
                    //console.log('error');
                    //$('option:selected', this).remove();
                    error = true;
                }else{
                    val = $(this).val();
                    error = false;
                }
            }

        });
        $(".row.opponents").each(function(index){
            if(index<selected_counts){
                $(this).removeClass('hidden');
            }else
                $(this).addClass('hidden');
        });
        if(error){
            //alert('You can not Choose same Opponent');
            $('#opponent-error').removeClass('hide');
            $('.my_button').prop('disabled', true);
        }else{
            $('#opponent-error').addClass('hide');
            $('.my_button').prop('disabled', false);
        }
    });
    $(".opponent").change();

    <?php if (has_permission('courts', '', 'create')) { ?>
    $("#AddCourt").click(function () {
        court_name = $('#court_name_modal').val();
        var cat_id = [];
        $("input[name='modal_cat_id']:checked").each(function(){
            cat_id.push(this.value);
        });
        if(court_name == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('legalservices/courts/add_court_from_modal'); ?>',
                data: {
                    court_name : court_name,
                    court_description: tinymce.get("court_description").getContent(),
                    country : $('#country').val(),
                    city : $('#city').val(),
                    cat_id : JSON.stringify(cat_id)
                },
                type: "POST",
                success: function (data) {
                    if(data){
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                        $('#court_id').append($('<option>', {value: data, text: court_name,selected : true}));
                        $('#court_id').selectpicker('refresh');
                        $('#add-court').modal('hide');
                        GetCourtJad();
                    }else {
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                    }
                }
            });
        }
    });
    <?php } ?>

    <?php if (has_permission('judges_manage', '', 'create')) { ?>
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
                            .text(judge_name)
                            .prop('selected', true);
                        $('.judge_select').append($option).change();
                        $('#add-judge').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                    }
                }
            });
        }
    });
    <?php } ?>

    <?php if (has_permission('judicial_departments', '', 'create')) { ?>
    $("#AddJudicialDept").click(function () {
        var court_id_modal   = $('#court_id_modal').val();
        var Jud_number_modal = $('#Jud_number_modal').val();
        if(court_id_modal == '' || Jud_number_modal == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('legalservices/courts/add_judicial_department_modal/'); ?>' + court_id_modal,
                data: {
                    Jud_number : Jud_number_modal,
                    Jud_description : tinymce.get("Jud_description").getContent(),
                    Jud_email : $('#Jud_email').val()
                },
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
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                    }
                }
            });
        }
    });
    <?php } ?>

    function GetSubCat() {
        $('#subcat_id').html('');
        $('#childsubcat').html('');
        id = $('#cat_id').val();
        $.ajax({
            url: '<?php echo admin_url("ChildCategory/22/"); ?>' + id,
            success: function (data) {
                response = JSON.parse(data);
                $('#subcat_id').append('<option value=""></option>');
                $.each(response, function (key, value) {
                    $('#subcat_id').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
                });
            }
        });
    }

    function GetCourtJad() {
        $('#jud_num').html('');
        $('#cat_id').empty();
        $('#subcat_id').html('');
        $('#childsubcat').html('');
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
        $.ajax({
            url: "<?php echo admin_url('legalservices/Courts/build_dropdown_court_category'); ?>",
            data: {c_id: $("#court_id").val()},
            type: "POST",
            success: function (data) {
                $('#cat_id').append($('<option>', {
                    value: '',
                    text: '<?php echo _l('dropdown_non_selected_tex'); ?>'
                }));
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    $('#cat_id').append($('<option>', {
                        value: value['id'],
                        text: value['name']
                    }));
                });
            }
        });
    }

    $("#country").change(function () {
        // $('#court_id').empty();
        var groupFilter = $('#court_id');
        groupFilter.selectpicker('val', '');
        groupFilter.find('option').remove();
        groupFilter.selectpicker("refresh");
        $('#jud_num').html('');
        $('#cat_id').empty();
        $('#subcat_id').html('');
        $('#childsubcat').html('');
        $.ajax({
            url: "<?php echo admin_url('Countries/build_dropdown_cities'); ?>",
            data: {country: $(this).val()},
            type: "POST",
            success: function (data) {
                $("#city").html(data);
            }
        });
    });

    $("#city").change(function () {
       var groupFilter = $('#court_id');
       groupFilter.selectpicker('val', '');
       groupFilter.find('option').remove();
       groupFilter.selectpicker("refresh");
       $('#jud_num').html('');
       $('#cat_id').empty();
       $('#subcat_id').html('');
       $('#childsubcat').html('');
        $.ajax({
            url: '<?php echo admin_url("legalservices/courts/build_dropdown_courts"); ?>',
            data: {
                country : $('#country').val(),
                city : $('#city').val()
            },
            type: "POST",
            success: function (data) {
                $('#court_id').append($('<option>', {
                    value: '',
                    text: '<?php echo _l('dropdown_non_selected_tex'); ?>',
                }));
                $('#court_id').selectpicker('refresh');
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    $('#court_id').append($('<option>', {
                        value: value['c_id'],
                        text: value['court_name'],
                    }));
                $('#court_id').selectpicker('refresh');
                });
            }
        });
        $.ajax({
            url: "<?php echo admin_url('legalservices/Courts/build_dropdown_category_for_modal_case'); ?>",
            data: {country: $("#country").val()},
            type: "POST",
            success: function (data) {
                $("#cat").html('');
                $("#cat").html(data);
            }
        });
    });
    $("#subcat_id").change(function () {
        $('#childsubcat').html('');
        id = $('#subcat_id').val();
        $.ajax({
            url: '<?php echo admin_url("ChildCategory/22/"); ?>' + id,
            success: function (data) {
                response = JSON.parse(data);
                if(response.length != 0) {
                    $('#childsubcat').html(`
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="childsubcat_id" class="control-label"><?php echo _l('child_sub_categories'); ?></label>
                        <select class="form-control custom_select_arrow" id="childsubcat_id" name="childsubcat_id"
                                placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                        </select>
                    </div>
                </div>
                `);
                    $('#childsubcat_id').append('<option value=""></option>');
                    $.each(response, function (key, value) {
                        $('#childsubcat_id').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
                    });
                }
                else {
                    $('#childsubcat').html('');
                }
            }
        });
    });

    $("#clientid").change(function () {
        var groupFilter = $('#previous_case_id');
        groupFilter.selectpicker('val', '');
        groupFilter.find('option').remove();
        groupFilter.selectpicker("refresh");
        case_clientid = $("#clientid").val();
        if(case_clientid != ''){
            $.ajax({
                url: "<?php echo admin_url('legalservices/disputes_cases/get_case_by_clientid'); ?>",
                data: {clientid: case_clientid},
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    var newOption = new Option('', '', false, true);
                    $('#previous_case_id').append(newOption).trigger('change');
                    $.each(response, function (response, value) {
                        var newOption = new Option(value.name, value.id, false, false);
                        $('#previous_case_id').append(newOption).trigger('change');
                        $('#previous_case_id').selectpicker('refresh');
                    });

                }
            });
        }
    });

    $(function(){

        $contacts_select = $('#notify_contacts'),
            $contacts_wrapper = $('#notify_contacts_wrapper'),
            $clientSelect = $('#clientid'),
            $contact_notification_select = $('#contact_notification');

            init_ajax_search('contacts', $contacts_select, {
                rel_id: $contacts_select.val(),
                type: 'contacts',
                extra: {
                    client_id: function () {return $clientSelect.val();}
                }
            });

            if ($clientSelect.val() == '') {
                $contacts_select.prop('disabled', true);
                $contacts_select.selectpicker('refresh');
            } else {
                $contacts_select.siblings().find('input[type="search"]').val(' ').trigger('keyup');
            }

            $clientSelect.on('changed.bs.select', function () {
                if ($clientSelect.selectpicker('val') == '') {
                    $contacts_select.prop('disabled', true);
                } else {
                    $contacts_select.siblings().find('input[type="search"]').val(' ').trigger('keyup');
                    $contacts_select.prop('disabled', false);
                }
                deselect_ajax_search($contacts_select[0]);
                $contacts_select.find('option').remove();
                $contacts_select.selectpicker('refresh');
            });

            $contact_notification_select.on('changed.bs.select', function () {
                if ($contact_notification_select.selectpicker('val') == 2) {
                    $contacts_select.siblings().find('input[type="search"]').val(' ').trigger('keyup');
                    $contacts_wrapper.removeClass('hide');
                } else {
                    $contacts_wrapper.addClass('hide');
                    deselect_ajax_search($contacts_select[0]);
                }
            });


        $('select[name="billing_type"]').on('change',function(){
            var type = $(this).val();
            if(type == 1){
                $('#project_cost').removeClass('hide');
                $('#project_rate_per_hour').addClass('hide');
            } else if(type == 10){
                $('#project_cost').removeClass('hide');
                $('#project_rate_per_hour').removeClass('hide');
            } else {
                $('#project_cost').addClass('hide');
                $('#project_rate_per_hour').removeClass('hide');
            }
        });

        var members = $("input[name='project_members[]']");

        appValidateForm($('#form'), {
            code: 'required',
            name: 'required',
            clientid: 'required',
            opponent_id_0: 'required',
            start_date:'required',
            billing_type:'required',
            disputes_total:'required',
            'notify_contacts[]': {
                required: {
                    depends: function() {
                        return !$contacts_wrapper.hasClass('hide');
                    }
                }
            },
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
            if($('#clientid').val() == '' || $('#opponent_id_0').val() == '' || $('#billing_type').val() == '' || $('#disputes_total').val() <= 0) {
                $('#required').append(`<hr class="hr-panel-heading"/>`);
                $('#required').append(`<h4 style="color: red">يجب إدخال الحقول (
                اسم <?php echo _l('opponent')?>
                 + <?php echo _l('project_billing_type')?> + <?php echo _l('disputes_total')?> )

                ليتم حفظ القضية                                        </h4>`);
            }
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

        $('#case-settings-area input').on('change',function(){
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

            if ($(this).attr('id') == 'view_session_logs' && $(this).prop('checked') == false) {
                $('#create_sessions').prop('checked', false).prop('disabled', true);
                $('#edit_sessions').prop('checked', false).prop('disabled', true);
                $('#view_session_comments').prop('checked', false).prop('disabled', true);
                $('#comment_on_sessions').prop('checked', false).prop('disabled', true);
                $('#view_session_attachments').prop('checked', false).prop('disabled', true);
                $('#view_session_checklist_items').prop('checked', false).prop('disabled', true);
                $('#upload_on_sessions').prop('checked', false).prop('disabled', true);
                $('#view_session_total_logged_time').prop('checked', false).prop('disabled', true);
            } else if ($(this).attr('id') == 'view_session_logs' && $(this).prop('checked') == true) {
                $('#create_sessions').prop('disabled', false);
                $('#edit_sessions').prop('disabled', false);
                $('#view_session_comments').prop('disabled', false);
                $('#comment_on_sessions').prop('disabled', false);
                $('#view_session_attachments').prop('disabled', false);
                $('#view_session_checklist_items').prop('disabled', false);
                $('#upload_on_sessions').prop('disabled', false);
                $('#view_session_total_logged_time').prop('disabled', false);
            }
        });

        // Auto adjust customer permissions based on selected project visible tabs
        // Eq Project creator disable TASKS tab, then this function will auto turn off customer project option Allow customer to view tasks

        $('#available_features').on('change',function(){
            $("#available_features option").each(function(){
                if($(this).data('linked-customer-option') && !$(this).is(':selected')) {
                    var opts = $(this).data('linked-customer-option').split(',');
                    for(var i = 0; i<opts.length;i++) {
                        var case_option = $('#'+opts[i]);
                        case_option.prop('checked',false);
                        if(opts[i] == 'view_tasks') {
                            case_option.trigger('change');
                        }
                    }
                }
            });
        });
        $("#view_tasks").trigger('change');
        $.ajax({
            url: "<?php echo admin_url('legalservices/Courts/build_dropdown_category_for_modal_case'); ?>",
            data: {country: $("#country").val()},
            type: "POST",
            success: function (data) {
                $("#cat").html('');
                $("#cat").html(data);
            }
        });
        $("#view_session_logs").trigger('change');
    });
</script>
</body>
</html>