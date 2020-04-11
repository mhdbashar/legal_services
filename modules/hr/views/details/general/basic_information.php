<div class="content">
   <div class="row">
      <?php if(isset($member)){ ?>
      <div class="member">
         <?php echo form_hidden('isedit'); ?>
         <?php echo form_hidden('memberid',$member->staffid); ?>
      </div>
      <?php } ?>
      <?php if(isset($member)){ ?>

      <div class="col-md-12">
         <?php if(total_rows(db_prefix().'departments',array('email'=>$member->email)) > 0) { ?>
            <div class="alert alert-danger">
               The staff member email exists also as support department email, according to the docs, the support department email must be unique email in the system, you must change the staff email or the support department email in order all the features to work properly.
            </div>
         <?php } ?>
      </div>
      <?php } ?>
      <?php echo form_open_multipart(admin_url('hr/general/member/'.$staff_id),array('class'=>'staff-form','autocomplete'=>'off')); ?>
      <div class="col-md-12" id="small-table">
         <div class="panel_s">
            <div class="panel-body">
               <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active">
                     <a href="#tab_staff_profile" aria-controls="tab_staff_profile" role="tab" data-toggle="tab">
                     <?php echo _l('staff_profile_string'); ?>
                     </a>
                  </li>
                  <li role="presentation">
                     <a href="#staff_permissions" aria-controls="staff_permissions" role="tab" data-toggle="tab">
                     <?php echo _l('staff_add_edit_permissions'); ?>
                     </a>
                  </li>
               </ul>
               <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="tab_staff_profile">
                     <?php if(total_rows(db_prefix().'emailtemplates',array('slug'=>'two-factor-authentication','active'=>0)) == 0){ ?>
                     <div class="checkbox checkbox-primary">
                        <input type="checkbox" value="1" name="two_factor_auth_enabled" id="two_factor_auth_enabled"<?php if(isset($member) && $member->two_factor_auth_enabled == 1){echo ' checked';} ?>>
                        <label for="two_factor_auth_enabled"><i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('two_factor_authentication_info'); ?>"></i>
                        <?php echo _l('enable_two_factor_authentication'); ?></label>
                     </div>
                     <?php } ?>
                     <div class="is-not-staff<?php if(isset($member) && $member->admin == 1){ echo ' hide'; }?>">
                        <div class="checkbox checkbox-primary">
                           <?php
                              $checked = '';
                              if(isset($member)) {
                               if($member->is_not_staff == 1){
                                $checked = ' checked';
                              }
                              }
                              ?>
                           <input type="checkbox" value="1" name="is_not_staff" id="is_not_staff" <?php echo $checked; ?>>
                           <label for="is_not_staff"><?php echo _l('is_not_staff_member'); ?></label>
                        </div>
                        <hr />
                     </div>
                     <?php if((isset($member) && $member->profile_image == NULL) || !isset($member)){ ?>
                     <div class="form-group">
                        <label for="profile_image" class="profile-image"><?php echo _l('staff_edit_profile_image'); ?></label>
                        <input type="file" name="profile_image" class="form-control" id="profile_image">
                     </div>
                     <?php } ?>
                     <?php if(isset($member) && $member->profile_image != NULL){ ?>
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-9">
                              <?php echo staff_profile_image($member->staffid,array('img','img-responsive','staff-profile-image-thumb'),'thumb'); ?>
                           </div>
                           <div class="col-md-3 text-right">
                              <a href="<?php echo admin_url('staff/remove_staff_profile_image/'.$member->staffid); ?>"><i class="fa fa-remove"></i></a>
                           </div>
                        </div>
                     </div>



                     <?php } ?>
                     <div class="row">
                     	<div class="col-md-12">
                     		 <?php $value = (isset($member) ? $member->firstname : ''); ?>
		                     <?php $attrs = (isset($member) ? array() : array('autofocus'=>true)); ?>
		                     <?php echo render_input('firstname','staff_add_edit_fullname',$value,'text',$attrs); ?>
                         <?php echo form_hidden('lastname', ' ') ?>
                     	</div>
                      <!--
                     	<div class="col-md-6">
                     		<?php $value = (isset($member) ? $member->lastname : ''); ?>
                    		<?php echo render_input('lastname','staff_add_edit_lastname',$value); ?>
                     	</div>
                     -->
                     </div>
                     <?php $branches = $this->Branches_model->getBranches(); ?>
                        <?php if($this->app_modules->is_active('branches')){?>
                           <?php $value = (isset($branch) ? $branch : ''); ?>
                           <?php echo render_select('branch_id',(isset($branches)?$branches:[]),['key','value'],_l('branch_name'),$value, ['onchange'=> 'getval(this);']); ?>
                        <?php } ?>
                           <?php 
                           $departmentid = '';
                           $name = '';

                           // if ($this->Extra_info_model->get($member->staffid)){
                           //    $departmentid = $this->Extra_info_model->get_staff_department($member->staffid)->departmentid;

                           //    $name = $this->Extra_info_model->get_staff_department($member->staffid)->name;
                           // }
                          // echo render_select('departments[]',(isset($departments)?$departments:[]),['departmentid','name'], _l('staff_add_edit_departments'), $department); ?>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                  <label for="staff_add_edit_departments" class="control-label"><small class="req text-danger">* </small><?php echo _l('staff_add_edit_departments') ?></label>
                                  <select onchange="check(this)" required="required" class="form-control" id="department_id" name="departments[]" placeholder="<?php echo _l('staff_add_edit_departments') ?>" aria-invalid="false">
                                  </select>     
                              </div>
                           </div>
                        </div>
                     <div class="row">
                     	<div class="col-md-6">
                     		<?php echo render_input('emloyee_id','emloyee_id',$extra_info->emloyee_id ); ?>
                     	</div>
                     	<div class="col-md-6">
                     		<?php $value = (isset($member) ? $member->email : ''); ?>
                     		<?php echo render_input('email','staff_add_edit_email',$value,'email',array('autocomplete'=>'off')); ?>
                     	</div>
                     </div>
                     <!-- <?php 
                        $sub_department_name = '';
                        $designation_name = '';
                        if(is_numeric($extra_info->sub_department)){
                           $sub_department = $this->Sub_department_model->get($extra_info->sub_department);
                           $sub_department_name = $sub_department->sub_department_name;
                        }
                        if(is_numeric($extra_info->designation)){
                           $designation = $this->Designation_model->get_designation($extra_info->designation);
                           $designation_name = $designation->designation_name;
                        }
                     ?> -->
                     <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                              
                                <label for="sub_department_id" class="control-label"><small class="req text-danger">* </small><?php echo _l('sub_department') ?></label>
                                <select required="required" class="form-control" id="sub_department_id" name="sub_department" placeholder="<?php echo _l('sub_department') ?>" aria-invalid="false">
                                </select>     
                            </div>  
                        </div>
                     	<div class="col-md-4">
                            <div class="form-group">
                                <label for="designation_id" class="control-label"><small class="req text-danger">* </small><?php echo _l('designation') ?></label>
                                <select required="required" class="form-control" id="designation_id" name="designation" placeholder="<?php echo _l('designation') ?>" aria-invalid="false">
                                </select>     
                            </div>  
                        </div>
                        <div class="form-group select-placeholder col-md-4">
                           <label for="gender"><?php echo _l('gendre'); ?></label>
                           <select class="selectpicker" data-none-selected-text="<?php echo _l('system_default_string'); ?>" data-width="100%" name="gender" id="gender">
                              <option value="" <?php if(isset($extra_info) && empty($extra_info->gender)){echo 'selected';} ?>></option>
                              <option value="Male" <?php if(isset($extra_info) && $extra_info->gender == 'Male'){echo 'selected';} ?>>Male</option>
                              <option value="Female" <?php if(isset($extra_info) && $extra_info->gender == 'Female'){echo 'selected';} ?>>Female</option>
                           </select>
                        </div>
                     </div>

                     <div class="row">
                     <!--
                     	<div class="col-md-4">
                     		<?php echo render_input('marital_status','marital_status',$extra_info->marital_status ); ?>
                     	</div>
                     -->
                     	<div class="col-md-4">
                     		<?php echo render_input('office_sheft','office_sheft',$extra_info->office_sheft ); ?>
                     	</div>
                     	<div class="col-md-4">
                     		<?php echo render_date_input('date_birth','date_birth',_d($extra_info->date_birth) ); ?>
                     	</div>
                     </div>

                        <?php
                            $selected = array();
                            if(isset($extra_info)){
                              $selected_leaves = $extra_info->leaves;
                              
                              if($selected_leaves != ''){
                                  foreach($selected_leaves as $row){
                                    array_push($selected,$row['id']);
                                  }
                              }
                            }
                             echo render_select('leaves[]',$leaves,array('id',array('name')),'leaves',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
                         ?>

                     <div class="row">
                     	<div class="col-md-4">
                     		<?php echo render_input('state_province','state_province',$extra_info->state_province ); ?>
                     	</div>
                     	<div class="col-md-4">
                     		<?php echo render_input('city','city',$extra_info->city ); ?>
                     	</div>
                     	<div class="col-md-4">
                     		<?php echo render_input('zip_code','zip_code',$extra_info->zip_code ); ?>
                     	</div>
                     </div>
                     
                     <?php echo render_input('address','address',$extra_info->address ); ?>
                     <div class="form-group">
                        <label for="hourly_rate"><?php echo _l('staff_hourly_rate'); ?></label>
                        <div class="input-group">
                           <input type="number" name="hourly_rate" value="<?php if(isset($member)){echo $member->hourly_rate;} else {echo 0;} ?>" id="hourly_rate" class="form-control">
                           <span class="input-group-addon">
                           <?php echo $base_currency->symbol; ?>
                           </span>
                        </div>
                     </div>
                     <?php $value = (isset($member) ? $member->phonenumber : ''); ?>
                     <?php echo render_input('phonenumber','staff_add_edit_phonenumber',$value); ?>
                     

                     <?php if(get_option('disable_language') == 0){ ?>
                     <div class="form-group select-placeholder">
                        <label for="default_language" class="control-label"><?php echo _l('localization_default_language'); ?></label>
                        <select name="default_language" data-live-search="true" id="default_language" class="form-control selectpicker" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                           <option value=""><?php echo _l('system_default_string'); ?></option>
                           <?php foreach($this->app->get_available_languages() as $availableLanguage){
                              $selected = '';
                              if(isset($member)){
                               if($member->default_language == $availableLanguage){
                                $selected = 'selected';
                              }
                              }
                              ?>
                           <option value="<?php echo $availableLanguage; ?>" <?php echo $selected; ?>><?php echo ucfirst($availableLanguage); ?></option>
                           <?php } ?>
                        </select>
                     </div>
                     <?php } ?>
                     <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="<?php echo _l('staff_email_signature_help'); ?>"></i>
                     <?php $value = (isset($member) ? $member->email_signature : ''); ?>
                     <?php echo render_textarea('email_signature','settings_email_signature',$value, ['data-entities-encode'=>'true']); ?>
                     <div class="form-group select-placeholder">
                        <label for="direction"><?php echo _l('document_direction'); ?></label>
                        <select class="selectpicker" data-none-selected-text="<?php echo _l('system_default_string'); ?>" data-width="100%" name="direction" id="direction">
                           <option value="" <?php if(isset($member) && empty($member->direction)){echo 'selected';} ?>></option>
                           <option value="ltr" <?php if(isset($member) && $member->direction == 'ltr'){echo 'selected';} ?>>LTR</option>
                           <option value="rtl" <?php if(isset($member) && $member->direction == 'rtl'){echo 'selected';} ?>>RTL</option>
                        </select>
                     </div>
                     
                     <?php $rel_id = (isset($member) ? $member->staffid : false); ?>
                     <?php echo render_custom_fields('staff',$rel_id); ?>

                     <div class="row">
                        <div class="col-md-12">
                           <hr class="hr-10" />
                           <?php if (is_admin()){ ?>
                           <div class="checkbox checkbox-primary">
                              <?php
                                 $isadmin = '';
                                 if(isset($member) && ($member->staffid == get_staff_user_id() || is_admin($member->staffid))) {
                                   $isadmin = ' checked';
                                 }
                              ?>
                              <input type="checkbox" name="administrator" id="administrator" <?php echo $isadmin; ?>>
                              <label for="administrator"><?php echo _l('staff_add_edit_administrator'); ?></label>
                           </div>
                            <?php } ?>
                            <?php if(!isset($member) && total_rows(db_prefix().'emailtemplates',array('slug'=>'new-staff-created','active'=>0)) === 0){ ?>
                              <div class="checkbox checkbox-primary">
                                 <input type="checkbox" name="send_welcome_email" id="send_welcome_email" checked>
                                 <label for="send_welcome_email"><?php echo _l('staff_send_welcome_email'); ?></label>
                              </div>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="staff_permissions">
                     <?php
                        hooks()->do_action('staff_render_permissions');
                        $selected = '';
                        foreach($roles as $role){
                         if(isset($member)){
                          if($member->role == $role['roleid']){
                           $selected = $role['roleid'];
                         }
                        } else {
                        $default_staff_role = get_option('default_staff_role');
                        if($default_staff_role == $role['roleid'] ){
                         $selected = $role['roleid'];
                        }
                        }
                        }
                        ?>
                     <?php echo render_select('role',$roles,array('roleid','name'),'staff_add_edit_role',$selected); ?>
                     <hr />
                     <h4 class="font-medium mbot15 bold"><?php echo _l('staff_add_edit_permissions'); ?></h4>
                     <?php
                     $permissionsData = [ 'funcData' => ['staff_id'=> isset($member) ? $member->staffid : null ] ];
                     if(isset($member)) {
                        $permissionsData['member'] = $member;
                     }
                     $this->load->view('admin/staff/permissions', $permissionsData);
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="btn-bottom-toolbar text-left btn-toolbar-container-out">
         <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
      </div>
      <?php echo form_close(); ?>
      
   </div>
   <div class="btn-bottom-pusher"></div>
</div>
<script>
   function getval(sel)
    {
      console.log('#department_'+sel.value);
      $('.department').addClass('hide');
      $('.department input').prop('checked', false);
      $('.department_'+sel.value).removeClass('hide');
    }
</script>