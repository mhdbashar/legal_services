<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <?php echo form_open($this->uri->uri_string(),array('id'=>'project_form')); ?>
            <div class="col-md-7">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <?php
                        $disable_type_edit = '';
                        if(isset($project)){
                            if($project->billing_type != 1){
                                if(total_rows(db_prefix().'tasks',array('rel_id'=>$project->id,'rel_type'=>'project','billable'=>1,'billed'=>1)) > 0){
                                    $disable_type_edit = 'disabled';
                                }
                            }
                        }
                        ?>
                        <?php $value = (isset($project) ? $project->name : ''); ?>
                        <?php echo render_input('name','project_name',$value); ?>
                        <!-- <?php //$value = (isset($meta['address1']) ? $meta['address1'] : ''); ?> -->
                        <!-- <?php //echo render_input('address1','project_address1',$value); ?> -->
                        <!-- <?php //$value = (isset($meta['address2']) ? $meta['address2'] : ''); ?> -->
                        <!-- <?php //echo render_input('address2','project_address2',$value); ?> -->
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
                                $selected = (isset($meta['country']) ? $meta['country'] : get_option('company_country'));

                                ?>
                                <?php echo render_select( 'country', get_cases_countries($field),array( 'country_id',array($field)), 'lead_country',$selected); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="city"><?php echo _l('client_city'); ?></label>
                                    <?php $data = get_relation_data('build_dropdown_cities',''); ?>
                                    <?php $selected = (isset($meta['city']) ? $meta['city'] : get_option('company_city') ); ?>
                                    <select id="city" name="city" class="form-control">
                                        <option selected disabled></option>
                                        <?php foreach ($data as $row): ?>
                                            <option value="<?php echo $row->$field_city; ?>" <?php echo $selected == $row->$field_city ? 'selected': '' ?>><?php echo $row->$field_city; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
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
                                        <?php $selected = (isset($project) ? $project->clientid : '');
                                        if($selected == ''){
                                            $selected = (isset($customer_id) ? $customer_id: '');
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
                                <a href="#" data-toggle="modal" data-target="#add-client"
                                   class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="representative"><?php echo _l('customer_description'); ?></label>
                                    <select id="representative" name="representative" class="selectpicker selectpicker"
                                            data-width="100%"
                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected></option>
                                        <?php $data = get_relation_data('representative', '');

                                        $selected = (isset($meta['representative']) ? $meta['representative'] : '');
                                        foreach ($data as $row): ?>
                                            <option value="<?php echo $row['id']; ?>" <?php echo $selected == $row['id'] ? 'selected' : '' ?>><?php echo $row['representative']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <?php //$value = (isset($meta['addressed_to']) ? $meta['addressed_to'] : ''); ?> -->
                        <!-- <?php //echo render_input('addressed_to','project_addressed_to',$value); ?> -->
                        <?php $cats = get_relation_data('cat_modules','Dispute');
                        if($cats){ ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo _l('Categories'); ?></label>
                                        <select class="form-control selectpicker" id="cat_id" onchange="GetSubCat()" name="cat_id" placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                            <option selected disabled></option>
                                            <?php
                                            $selected = (isset($meta['cat_id']) ? $meta['cat_id'] : '');
                                            foreach ($cats as $row): ?>
                                                <option value="<?php echo $row->id; ?>" <?php echo $selected == $row->id ? 'selected': '' ?>><?php echo $row->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subcat_id" class="control-label"><?php echo _l('SubCategories'); ?></label>
                                        <select class="form-control custom_select_arrow" id="subcat_id" name="subcat_id" placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                            <option selected disabled></option>
                                            <?php $data = get_relation_data('childmycategory',$selected);
                                            $selected = (isset($meta['subcat_id']) ? $meta['subcat_id'] : '');
                                            foreach ($data as $row) { ?>
                                                <option value="<?php echo $row->id ?>" <?php echo $selected == $row->id ? 'selected': '' ?>><?php echo $row->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php $value = (isset($meta['notes']) ? $meta['notes'] : ''); ?>
                        <?php echo render_input('notes','project_notes',$value); ?>
                        <?php
                        $opponent_id = (isset($meta['opponent_id']) ? explode(',',$meta['opponent_id']) : array());
                        for($i=0; $i<10; $i++) : ?>
                            <div class="row opponents <?php echo ($i>0?'hidden':''); ?>">
                                <div class="col-md-10">
                                    <div class="form-group select-placeholder">
                                        <label for="opponent_id_<?php echo $i; ?>"
                                               class="control-label"><?php echo _l('opponent') . ' ' . ($i+1); ?></label>
                                        <select id="opponent_id_<?php echo $i; ?>" name="opponent_id[<?php echo $i; ?>]" data-live-search="true" data-width="100%"
                                                class="ajax-search opponent"
                                                data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                            <?php
                                            $selected = (isset($opponent_id[$i]) ? $opponent_id[$i] : '');
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
                                        <?php $opponent_lawyer_id = (isset($meta['opponent_lawyer_id']) ? $meta['opponent_lawyer_id'] : ''); ?>
                                        <?php
                                        $selected = (isset($opponent_lawyer_id) ? $opponent_lawyer_id : '');
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


                        <!-- <div class="row mtop15 mbot10">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="control-label"><?php //echo _l('project_contacts'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="#" data-toggle="modal" data-target="#add-contact" class="btn btn-info btn_plus"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="project_contacts"></div>
                        </div> -->

                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="control-label" for="projects_status"><?php echo _l('projects_status'); ?></label>
                                    <?php $selected = (isset($meta['projects_status']) ? $meta['projects_status'] : ''); ?>
                                    <select id="projects_status" name="projects_status" class="form-control selectpicker">
                                        <option selected disabled></option>
                                        <?php foreach ($projects_statuses as $row): ?>
                                            <option value="<?php echo $row->id; ?>" <?php echo $selected == $row->id ? 'selected': '' ?>><?php echo $row->status_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <a href="#" data-toggle="modal" data-target="#add-status-modal" class="btn btn-info mtop25 btn_plus"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>


                        <?php $value = (isset($meta['disputes_total']) ? $meta['disputes_total'] : ''); ?>
                        <?php echo render_input('disputes_total','disputes_total',$value,'number'); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group select-placeholder">
                                    <label for="billing_type"><?php echo _l('project_billing_type'); ?></label>
                                    <div class="clearfix"></div>
                                    <select name="billing_type" class="selectpicker" id="billing_type" data-width="100%" <?php echo $disable_type_edit ; ?> data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option value=""></option>
                                        <option value="1" <?php if(isset($project) && $project->billing_type == 1 || !isset($project) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 1){echo 'selected'; } ?>><?php echo _l('project_billing_type_fixed_cost'); ?></option>
                                        <option value="10" <?php if(isset($project) && $project->billing_type == 10 || !isset($project) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 10){echo 'selected'; } ?>><?php echo _l('project_billing_type_10'); ?></option>
                                        <option value="11" <?php if(isset($project) && $project->billing_type == 11 || !isset($project) && $auto_select_billing_type && $auto_select_billing_type->billing_type == 11){echo 'selected'; } ?>><?php echo _l('project_billing_type_11'); ?></option>
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
                                            <option value="<?php echo $status['id']; ?>" <?php if(!isset($project) && $status['id'] == 2 || (isset($project) && $project->status == $status['id'])){echo 'selected';} ?>><?php echo $status['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($project) && project_has_recurring_tasks($project->id)) { ?>
                            <div class="alert alert-warning recurring-tasks-notice hide"></div>
                        <?php } ?>
                        <?php if(total_rows(db_prefix().'emailtemplates',array('slug'=>'project-finished-to-customer','active'=>0)) == 0){ ?>
                            <div class="form-group project_marked_as_finished hide">
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" name="project_marked_as_finished_email_to_contacts" id="project_marked_as_finished_email_to_contacts">
                                    <label for="project_marked_as_finished_email_to_contacts"><?php echo _l('project_marked_as_finished_to_contacts'); ?></label>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(isset($project)){ ?>
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
                        <?php
                        $input_field_hide_class_total_cost = '';
                        if(!isset($project)){
                            if($auto_select_billing_type && $auto_select_billing_type->billing_type == 11 || !$auto_select_billing_type){
                                $input_field_hide_class_total_cost = 'hide';
                            }
                        } else if(isset($project) && $project->billing_type == 11){
                            $input_field_hide_class_total_cost = 'hide';
                        }
                        ?>
                        <div id="project_cost" class="<?php echo $input_field_hide_class_total_cost; ?>">
                            <?php $value = (isset($project) ? $project->project_cost : ''); ?>
                            <?php echo render_input('project_cost','project_billing_type_fixed_cost',$value,'number'); ?>
                        </div>
                        <?php
                        $input_field_hide_class_rate_per_hour = '';
                        if(!isset($project)){
                            if($auto_select_billing_type && $auto_select_billing_type->billing_type == 1 || !$auto_select_billing_type){
                                $input_field_hide_class_rate_per_hour = 'hide';
                            }
                        } else if(isset($project) && $project->billing_type == 1){
                            $input_field_hide_class_rate_per_hour = 'hide';
                        }
                        ?>
                        <div id="project_rate_per_hour" class="<?php echo $input_field_hide_class_rate_per_hour; ?>">
                            <?php $value = (isset($project) ? $project->project_rate_per_hour : ''); ?>
                            <?php
                            $input_disable = array();
                            if($disable_type_edit != ''){
                                $input_disable['disabled'] = true;
                            }
                            ?>
                            <?php echo render_input('project_rate_per_hour','project_rate_percent',$value,'number',$input_disable); ?>
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
                                <?php $value = (isset($project) ? ($project->start_date) : (date('Y-m-d'))); ?>
                                <?php echo render_date_input('start_date','project_start_date',$value); ?>
                            </div>
                            <div class="col-md-6">
                                <?php $value = (isset($project) ? ($project->deadline) : ''); ?>
                                <?php echo render_date_input('deadline','project_deadline',$value); ?>
                            </div>
                        </div>
                        <?php if(isset($project) && $project->date_finished != null && $project->status == 4) { ?>
                            <?php echo render_datetime_input('date_finished','project_completed_date',_dt($project->date_finished)); ?>
                        <?php } ?>
                        <div class="form-group">
                            <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
                            <input type="text" class="tagsinput" id="tags" name="tags" value="<?php echo (isset($project) ? prep_tags_input(get_tags_in($project->id,'project')) : ''); ?>" data-role="tagsinput">
                        </div>
                        <?php $rel_id_custom_field = (isset($project) ? $project->id : false); ?>
                        <?php echo render_custom_fields('projects',$rel_id_custom_field); ?>
                        <?php echo render_custom_fields('projects2',$rel_id_custom_field); ?>

                        <p class="bold"><?php echo _l('project_description'); ?></p>
                        <?php $contents = ''; if(isset($project)){$contents = $project->description;} ?>
                        <?php echo render_textarea('description','',$contents,array(),array(),'','tinymce'); ?>
                        <?php if(total_rows(db_prefix().'emailtemplates',array('slug'=>'assigned-to-project','active'=>0)) == 0){ ?>
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="send_created_email" id="send_created_email">
                                <label for="send_created_email"><?php echo _l('project_send_created_email'); ?></label>
                            </div>
                        <?php } ?>
                        <div class="btn-bottom-toolbar text-right">
                            <button type="submit" data-form="#project_form" class="my_button btn btn-info" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
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
                            if(isset($project)){
                                if($project->settings->{$setting} == 0){
                                    $checked = '';
                                }
                            } else {
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
                                            <?php echo _l('project_allow_client_to',_l('project_setting_'.$setting)); ?>
                                        <?php } ?>
                                    </label>
                                </div>
                            <?php } else { ?>
                                <div class="form-group mtop15 select-placeholder project-available-features">
                                    <label for="available_features"><?php echo _l('visible_tabs'); ?></label>
                                    <select name="settings[<?php echo $setting; ?>][]" id="<?php echo $setting; ?>" multiple="true" class="selectpicker" id="available_features" data-width="100%" data-actions-box="true" data-hide-disabled="true">
                                        <?php foreach(get_project_tabs_admin() as $tab) {
                                            $selected = '';
                                            if(isset($tab['collapse'])){ ?>
                                                <optgroup label="<?php echo $tab['name']; ?>">
                                                    <?php foreach($tab['children'] as $tab_dropdown) {
                                                        $selected = '';
                                                        if(isset($project) && (
                                                                (isset($project->settings->available_features[$tab_dropdown['slug']])
                                                                    && $project->settings->available_features[$tab_dropdown['slug']] == 1)
                                                                || !isset($project->settings->available_features[$tab_dropdown['slug']]))) {
                                                            $selected = ' selected';
                                                        } else if(!isset($project) && count($last_project_settings) > 0) {
                                                            foreach($last_project_settings as $last_project_setting) {
                                                                if($last_project_setting['name'] == $setting) {
                                                                    if(isset($last_project_setting['value'][$tab_dropdown['slug']])
                                                                        && $last_project_setting['value'][$tab_dropdown['slug']] == 1) {
                                                                        $selected = ' selected';
                                                                    }
                                                                }
                                                            }
                                                        } else if(!isset($project)) {
                                                            $selected = ' selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $tab_dropdown['slug']; ?>"<?php echo $selected; ?><?php if(isset($tab_dropdown['linked_to_customer_option']) && is_array($tab_dropdown['linked_to_customer_option']) && count($tab_dropdown['linked_to_customer_option']) > 0){ ?> data-linked-customer-option="<?php echo implode(',',$tab_dropdown['linked_to_customer_option']); ?>"<?php } ?>><?php echo $tab_dropdown['name']; ?></option>
                                                    <?php } ?>
                                                </optgroup>
                                            <?php } else {
                                                if(isset($project) && (
                                                        (isset($project->settings->available_features[$tab['slug']])
                                                            && $project->settings->available_features[$tab['slug']] == 1)
                                                        || !isset($project->settings->available_features[$tab['slug']]))) {
                                                    $selected = ' selected';
                                                } else if(!isset($project) && count($last_project_settings) > 0) {
                                                    foreach($last_project_settings as $last_project_setting) {
                                                        if($last_project_setting['name'] == $setting) {
                                                            if(isset($last_project_setting['value'][$tab['slug']])
                                                                && $last_project_setting['value'][$tab['slug']] == 1) {
                                                                $selected = ' selected';
                                                            }
                                                        }
                                                    }
                                                } else if(!isset($project)) {
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

<div class="modal fade" id="add-contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('project_contacts'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!--
                    <div class="col-md-6">
                        <?php //$options = explode(",",_l('project_contacts_types')); ?>
                        <div class="form-group select-placeholder">
                            <label for="status"><?php //echo _l('project_status'); ?></label>
                            <div class="clearfix"></div>
                            <select name="contact_type" id="contact_type" class="selectpicker" data-width="100%">
                                <?php //foreach($options as $key => $option){ ?>
                                    <option value="<?php //echo $key; ?>"><?php //echo $option; ?></option>
                                <?php //} ?>
                            </select>
                        </div>
                    </div>
                    -->
                    <div class="col-md-12">
                        <?php echo render_input( 'contact_name', 'name'); ?>
                        <?php echo render_input( 'contact_address', 'address'); ?>
                        <?php echo render_input( 'contact_email', 'email'); ?>
                        <?php echo render_input( 'contact_phone', 'phone'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="button" id="AddContact" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-status-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('projects_status'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('status_name_modal','projects_status'); ?>
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
    <?php if(isset($project)){ ?>
    var original_project_status = '<?php echo $project->status; ?>';
    <?php } ?>
    init_ajax_search('customer','#clientid.ajax-search');
    <?php for($i=0; $i<10; $i++) : ?>
    init_ajax_search('opponents','#opponent_id_<?php echo $i; ?>.ajax-search');
    <?php endfor; ?>
    init_ajax_search('opponents','#opponent_lawyer_id.ajax-search');
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
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                    }
                }
            });
        }
    });

    $("#add_status").click(function () {
        status_name = $('#status_name_modal').val();
        if(status_name == ''){
            alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
        }else {
            $.ajax({
                url: '<?php echo admin_url('disputes/statuses/add_from_modal'); ?>',
                data: {status_name : status_name},
                type: "POST",
                success: function (data) {
                    if(data){
                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                        $("#projects_status").append(new Option(status_name, data, true, true));
                        $('#add-status-modal').modal('hide');
                    }else {
                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                    }
                }
            });
        }
    });


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


    $(function(){

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

        appValidateForm($('form'),{name:'required',clientid:'required',start_date:'required',billing_type:'required',disputes_total:'required'});

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

        $('.my_button').on('click', function(){
            if(error){
                alert('You can not Choose same Opponent');
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

        $('.project_contacts, .project-overview-contacts').on('click', '.delete_contact', function () {
            var id = $(this).attr('rel');
            if(id == ''){
                alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
            }else{
                $.ajax({
                    url: '<?php echo admin_url('disputes/projects_contacts/delete/'); ?>'+id,
                    data: {project_id : <?php echo (isset($project) ? $project->id : -1); ?>},
                    type: "POST",
                    success: function (data) {
                        if(data || data == ''){
                            alert_float('success', '<?php echo _l('deleted_successfully'); ?>');
                            $('.project_contacts').html(data);
                        }else {
                            alert_float('danger', '<?php echo _l('Faild'); ?>');
                        }
                    }
                });
            }
            return false;
        });

        $.ajax({
            url: '<?php echo admin_url('disputes/projects_contacts/printall/'.(isset($project) ? $project->id : -1)); ?>',
            data: {},
            type: "POST",
            success: function (data) {
                if(data){
                    $('.project_contacts').html(data);
                }
            }
        });


        $("#AddContact").click(function () {
            contact_name = $('#contact_name').val();
            contact_address = $('#contact_address').val();
            contact_email = $('#contact_email').val();
            contact_phone = $('#contact_phone').val();
            contact_type = 0;
            project_id = <?php echo (isset($project) ? $project->id : -1); ?>;
            if(contact_name == ''){
                alert_float('danger', '<?php echo _l('form_validation_required'); ?>');
            }else{

                id = $('#cat_id').val();
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: '<?php echo admin_url("disputes/get_contacts"); ?>',
                    success: function (data) {
                        console.log(data.contact_type);
                        if(data.contact_type != null)
                            contact_type = parseFloat(data.contact_type) + 1;
                        if(!(data.contact_type > 4)){
                            $.ajax({
                                url: '<?php echo admin_url('disputes/projects_contacts/add'); ?>',
                                data: {contact_name : contact_name,contact_address : contact_address,contact_email : contact_email,contact_phone : contact_phone,contact_type : contact_type,project_id : project_id},
                                type: "POST",
                                success: function (data) {
                                    if(data){
                                        alert_float('success', '<?php echo _l('added_successfully'); ?>');
                                        $('#add-contact').modal('hide');
                                        $('#contact_name').val('');
                                        $('#contact_address').val('');
                                        $('#contact_email').val('');
                                        $('#contact_phone').val('');
                                        $('#contact_type').val('');
                                        $('.project_contacts').html(data);
                                    }else {
                                        alert_float('danger', '<?php echo _l('Faild'); ?>');
                                    }
                                }
                            });
                        }else{
                            $('#add-contact').modal('hide');
                            alert('you can added more than 6 witness');
                        }
                    }
                });

            }
        });


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
                            alert_float('danger', '<?php echo _l('Faild'); ?>');
                        }
                    }
                });
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
        <?php if(!isset($project)) { ?>
        $('#available_features').trigger('change');
        <?php } ?>
    });


    function GetSubCat() {
        $('#subcat_id').html('');
        id = $('#cat_id').val();
        $.ajax({
            url: '<?php echo admin_url("legalservices/legal_services/getChildCatModules/"); ?>' + id,
            success: function (data) {
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    $('#subcat_id').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
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
