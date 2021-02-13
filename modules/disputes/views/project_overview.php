<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
   <div class="col-md-6 border-right project-overview-left">
      <div class="row">
       <div class="col-md-12">
         <p class="project-info bold font-size-14">
            <?php echo _l('overview'); ?>
         </p>
      </div>
      <?php if(count($project->shared_vault_entries) > 0){ ?>
      <?php $this->load->view('admin/clients/vault_confirm_password'); ?>
      <div class="col-md-12">
         <p class="bold">
           <a href="#" onclick="slideToggle('#project_vault_entries'); return false;">
             <i class="fa fa-cloud"></i> <?php echo _l('project_shared_vault_entry_login_details'); ?>
          </a>
       </p>
       <div id="project_vault_entries" class="hide">
         <?php foreach($project->shared_vault_entries as $vault_entry){ ?>
         <div class="row" id="<?php echo 'vaultEntry-'.$vault_entry['id']; ?>">
            <div class="col-md-6">
               <p class="mtop5">
                  <b><?php echo _l('server_address'); ?>: </b><?php echo $vault_entry['server_address']; ?>
               </p>
               <p>
                  <b><?php echo _l('port'); ?>: </b><?php echo !empty($vault_entry['port']) ? $vault_entry['port'] : _l('no_port_provided'); ?>
               </p>
               <p>
                  <b><?php echo _l('vault_username'); ?>: </b><?php echo $vault_entry['username']; ?>
               </p>
               <p class="no-margin">
                  <b><?php echo _l('vault_password'); ?>: </b><span class="vault-password-fake">
                     <?php echo str_repeat('&bull;',10);?>  </span><span class="vault-password-encrypted"></span> <a href="#" class="vault-view-password mleft10" data-toggle="tooltip" data-title="<?php echo _l('view_password'); ?>" onclick="vault_re_enter_password(<?php echo $vault_entry['id']; ?>,this); return false;"><i class="fa fa-lock" aria-hidden="true"></i></a>
                  </p>
               </div>
               <div class="col-md-6">
                  <?php if(!empty($vault_entry['description'])){ ?>
                  <p>
                     <b><?php echo _l('vault_description'); ?>: </b><br /><?php echo $vault_entry['description']; ?>
                  </p>
                  <?php } ?>
               </div>
            </div>
            <hr class="hr-10" />
            <?php } ?>
         </div>
         <hr class="hr-panel-heading project-area-separation" />
      </div>
      <?php } ?>
      <div class="col-md-7">
         <table class="table no-margin project-overview-table">
            <tbody>
              <tr class="project-overview-customer">
                  <td class="bold"><?php echo _l('project_customer'); ?></td>
                  <td>
                      <a href="<?php echo admin_url(); ?>clients/client/<?php echo $project->clientid; ?>">
                        <?php echo $project->client_data->company; ?>
                      </a>
                  </td>
              </tr>

              <?php if(isset($meta['disputes_total']) && $meta['disputes_total']){ ?>
              <tr class="project-overview-customer">
                  <td class="bold"><?php echo _l('disputes_total'); ?></td>
                  <td><?php echo app_format_money($meta['disputes_total'],$currency); ?></td>
              </tr>
              <?php } ?>

               <?php if(has_permission('projects','','create') || has_permission('projects','','edit')){ ?>
               <tr class="project-overview-billing">
                  <td class="bold"><?php echo _l('project_billing_type'); ?></td>
                  <td>
                     <?php
                     if($project->billing_type == 1){
                       $type_name = 'project_billing_type_fixed_cost';
                    } else if($project->billing_type == 10){
                       $type_name = 'project_billing_type_10';
                    } else {
                       $type_name = 'project_billing_type_11';
                    }
                    echo _l($type_name);
                    ?>
                 </td>
                </tr>
                 <?php if($project->billing_type){
                  if($project->billing_type != 11){
                    echo '<tr>';
                    echo '<td class="bold">'._l('project_billing_type_fixed_cost').'</td>';
                    echo '<td>'.app_format_money($project->project_cost, $currency).'</td>';
                    echo '<tr>';
                  }
                 if($project->billing_type != 1){
                    echo '<tr>';
                    echo '<td class="bold">'._l('project_rate_percent').'</td>';
                    echo '<td>%'.($project->project_rate_per_hour).'</td>';
                    echo '<tr>';
                 }
                 
              }
           }
           ?>
           <tr class="project-overview-status">
            <td class="bold"><?php echo _l('project_status'); ?></td>
            <td><?php echo $project_status['name']; ?></td>
         </tr>
         <tr class="project-overview-date-created">
            <td class="bold"><?php echo _l('project_datecreated'); ?></td>
            <td><?php echo _d($project->project_created); ?></td>
         </tr>
         <tr class="project-overview-start-date">
            <td class="bold"><?php echo _l('project_start_date'); ?></td>
            <td><?php echo _d($project->start_date); ?></td>
         </tr>
         <?php if($project->deadline){ ?>
         <tr class="project-overview-deadline">
            <td class="bold"><?php echo _l('project_deadline'); ?></td>
            <td><?php echo _d($project->deadline); ?></td>
         </tr>
         <?php } ?>
         <?php if($project->date_finished){ ?>
         <tr class="project-overview-date-finished">
            <td class="bold"><?php echo _l('project_completed_date'); ?></td>
            <td class="text-success"><?php echo _dt($project->date_finished); ?></td>
         </tr>
         <?php } ?>
         <?php if($project->estimated_hours && $project->estimated_hours != '0'){ ?>
         <tr class="project-overview-estimated-hours">
            <td class="bold<?php if(hours_to_seconds_format($project->estimated_hours) < (int)$project_total_logged_time){echo ' text-warning';} ?>"><?php echo _l('estimated_hours'); ?></td>
            <td><?php echo str_replace('.', ':', $project->estimated_hours); ?></td>
         </tr>
         <?php } ?>
         <?php if(has_permission('projects','','create')){ ?>
         <tr class="project-overview-total-logged-hours">
            <td class="bold"><?php echo _l('project_overview_total_logged_hours'); ?></td>
            <td><?php echo seconds_to_time_format($project_total_logged_time); ?></td>
         </tr>
         <?php } ?>
         <?php $custom_fields = get_custom_fields('projects');
         if(count($custom_fields) > 0){ ?>
         <?php foreach($custom_fields as $field){ ?>
         <?php $value = get_custom_field_value($project->id,$field['id'],'projects');
         if($value == ''){continue;} ?>
         <tr>
            <td class="bold"><?php echo ucfirst($field['name']); ?></td>
            <td><?php echo $value; ?></td>
         </tr>
         <?php } ?>
         <?php } ?>
      </tbody>
   </table>
</div>
<div class="col-md-5 project-percent-col ">
   <table class="table no-margin project-overview-table">
          <tbody>
          <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('opponent'); ?></td>
              <td>
                <?php foreach ($opponents as $opponent) : ?>
                  <a href="<?php echo admin_url(); ?>opponents/client/<?php echo $opponent->userid; ?>">
                    <?php echo $opponent->company; ?>
                  </a>, 
                  <?php endforeach; ?>
              </td>
          </tr>

          <?php if(isset($opponent_lawyer->userid)){ ?>
          <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('opponent_lawyer'); ?></td>
              <td><a href="<?php echo admin_url(); ?>opponents/client/<?php echo $opponent_lawyer->userid; ?>">
                    <?php echo $opponent_lawyer->company; ?>
                  </a></td>
          </tr>
          <?php } ?>
              

          <?php if(isset($meta['representative']) && $meta['representative']){ ?>
          <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('representative'); ?></td>
              <td><?php echo $this->disputesapp->get_meta_title('my_customer_representative','representative','id',$meta['representative']); ?></td>
          </tr>
          <?php } ?>
          <?php if(isset($meta['country']) && $meta['country']){ ?>
            <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('lead_country'); ?></td>
              <td><?php
                  $staff_language = get_staff_default_language(get_staff_user_id());
                  if($staff_language == 'arabic'){
                      $field = 'short_name_ar';
                      $field_city = 'Name_ar';
                  }else{
                      $field = 'short_name';
                      $field_city = 'Name_en';
                  }
                  echo $this->disputesapp->get_meta_title('countries',$field,'country_id',$meta['country']); ?></td>
          </tr>
          <?php } ?>
          <?php if(isset($meta['city']) && $meta['city']){ ?>
          <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('client_city'); ?></td>
              <td><?php echo $meta['city'] ?></td>
          </tr>
          <?php } ?>
          <?php if(isset($meta['address1']) && $meta['address1']){ ?>
          <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('project_address1'); ?></td>
              <td><?php echo $meta['address1']; ?></td>
          </tr>
          <?php } ?>
          <?php if(isset($meta['address2']) && $meta['address2']){ ?>
          <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('project_address2'); ?></td>
              <td><?php echo $meta['address2']; ?></td>
          </tr>
          <?php } ?>
          <?php if(isset($meta['addressed_to']) && $meta['addressed_to']){ ?>
          <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('project_addressed_to'); ?></td>
              <td><?php echo $meta['addressed_to']; ?></td>
          </tr>
          <?php } ?>
          <?php if(isset($meta['notes']) && $meta['notes']){ ?>
          <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('project_notes'); ?></td>
              <td><?php echo $meta['notes']; ?></td>
          </tr>
          <?php } ?>
          <?php if(isset($meta['projects_status']) && $meta['projects_status']){ ?>
          <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('projects_status'); ?></td>
              <td><?php echo $this->disputesapp->get_meta_title('my_projects_statuses','status_name','id',$meta['projects_status']); ?></td>
          </tr>
          <?php } ?>
          <?php if(isset($meta['cat_id']) && $meta['cat_id']){ ?>
          <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('Categories'); ?></td>
              <td><?php echo $this->disputesapp->get_meta_title('my_categories','name','id',$meta['cat_id']); ?></td>
          </tr>
          <?php } ?>
          <?php if(isset($meta['subcat_id']) && $meta['subcat_id']){ ?>
          <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('SubCategories'); ?></td>
              <td><?php echo $this->disputesapp->get_meta_title('my_categories','name','id',$meta['subcat_id']); ?></td>
          </tr>
          <?php } ?>
          </tbody>
      </table>
</div>
</div>
<?php $tags = get_tags_in($project->id,'project'); ?>
<?php if(count($tags) > 0){ ?>
<div class="clearfix"></div>
<div class="tags-read-only-custom project-overview-tags">
   <hr class="hr-panel-heading project-area-separation hr-10" />
   <?php echo '<p class="font-size-14"><b><i class="fa fa-tag" aria-hidden="true"></i> ' . _l('tags') . ':</b></p>'; ?>
   <input type="text" class="tagsinput read-only" id="tags" name="tags" value="<?php echo prep_tags_input($tags); ?>" data-role="tagsinput">
</div>
<div class="clearfix"></div>
<?php } ?>
<!-- <div class="tc-content project-overview-contacts">
  <hr class="hr-panel-heading project-area-separation" />
  <p class="bold font-size-14 project-info"><?php echo _l('project_contacts'); ?></p>
  <div id="project-overview-contacts" class="project_contacts"></div>
</div>
<div class="clearfix"></div> -->
<div class="tc-content project-overview-description">
   <hr class="hr-panel-heading project-area-separation" />
   <p class="bold font-size-14 project-info"><?php echo _l('project_description'); ?></p>
   <?php if(empty($project->description)){
      echo '<p class="text-muted no-mbot mtop15">' . _l('no_description_project') . '</p>';
   }
   echo check_for_links($project->description); ?>
</div>
<div class="team-members project-overview-team-members">
   <hr class="hr-panel-heading project-area-separation" />
   <?php if(has_permission('projects','','edit')){ ?>
   <div class="inline-block pull-right mright10 project-member-settings" data-toggle="tooltip" data-title="<?php echo _l('add_edit_members'); ?>">
      <a href="#" data-toggle="modal" class="pull-right" data-target="#add-edit-members"><i class="fa fa-cog"></i></a>
   </div>
   <?php } ?>
   <p class="bold font-size-14 project-info">
      <?php echo _l('project_members'); ?>
   </p>
   <div class="clearfix"></div>
   <?php
   if(count($members) == 0){
      echo '<p class="text-muted mtop10 no-mbot">'._l('no_project_members').'</p>';
   }
   foreach($members as $member){ ?>
   <div class="media">
      <div class="media-left">
         <a href="<?php echo admin_url('profile/'.$member["staff_id"]); ?>">
            <?php echo staff_profile_image($member['staff_id'],array('staff-profile-image-small','media-object')); ?>
         </a>
      </div>
      <div class="media-body">
         <?php if(has_permission('projects','','edit')){ ?>
         <a href="<?php echo admin_url('disputes/remove_team_member/'.$project->id.'/'.$member['staff_id']); ?>" class="pull-right text-danger _delete"><i class="fa fa fa-times"></i></a>
         <?php } ?>
         <h5 class="media-heading mtop5"><a href="<?php echo admin_url('profile/'.$member["staff_id"]); ?>"><?php echo get_staff_full_name($member['staff_id']); ?></a>
            <?php if(has_permission('projects','','create') || $member['staff_id'] == get_staff_user_id()){ ?>
            <br /><small class="text-muted"><?php echo _l('total_logged_hours_by_staff') .': '.seconds_to_time_format($member['total_logged_time']); ?></small>
            <?php } ?>
         </h5>
      </div>
   </div>
   <?php } ?>
</div>
</div>
<div class="col-md-6 project-overview-right">
   <div class="row">
      <div class="col-md-<?php echo ($project->deadline ? 6 : 12); ?> project-progress-bars">
         <div class="row">
           <div class="project-overview-open-tasks">
            <div class="col-md-9">
               <p class="text-uppercase bold text-dark font-medium">
                  <?php echo $tasks_not_completed; ?> / <?php echo $total_tasks; ?> <?php echo _l('project_open_tasks'); ?>
               </p>
               <p class="text-muted bold"><?php echo $tasks_not_completed_progress; ?>%</p>
            </div>
            <div class="col-md-3 text-right">
               <i class="fa fa-check-circle<?php if($tasks_not_completed_progress >= 100){echo ' text-success';} ?>" aria-hidden="true"></i>
            </div>
            <div class="col-md-12 mtop5">
               <div class="progress no-margin progress-bar-mini">
                  <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $tasks_not_completed_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: 0%" data-percent="<?php echo $tasks_not_completed_progress; ?>">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php if($project->deadline){ ?>
   <div class="col-md-6 project-progress-bars project-overview-days-left">
      <div class="row">
         <div class="col-md-9">
            <p class="text-uppercase bold text-dark font-medium">
               <?php echo $project_days_left; ?> / <?php echo $project_total_days; ?> <?php echo _l('project_days_left'); ?>
            </p>
            <p class="text-muted bold"><?php echo $project_time_left_percent; ?>%</p>
         </div>
         <div class="col-md-3 text-right">
            <i class="fa fa-calendar-check-o<?php if($project_time_left_percent >= 100){echo ' text-success';} ?>" aria-hidden="true"></i>
         </div>
         <div class="col-md-12 mtop5">
            <div class="progress no-margin progress-bar-mini">
               <div class="progress-bar<?php if($project_time_left_percent == 0){echo ' progress-bar-warning ';} else { echo ' progress-bar-success ';} ?>no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $project_time_left_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: 0%" data-percent="<?php echo $project_time_left_percent; ?>">
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php } ?>
</div>
<hr class="hr-panel-heading" />

<?php if(has_permission('projects','','create')) { ?>
<div class="row">
   <?php if($project->billing_type == 3 || $project->billing_type == 2){ ?>
   <div class="col-md-12 project-overview-logged-hours-finance">
      <div class="col-md-3">
         <?php
         $data = $this->projects_model->total_logged_time_by_billing_type($project->id);
         ?>
         <p class="text-uppercase text-muted"><?php echo _l('project_overview_logged_hours'); ?> <span class="bold"><?php echo $data['logged_time']; ?></span></p>
         <p class="bold font-medium"><?php echo app_format_money($data['total_money'], $currency); ?></p>
      </div>
      <div class="col-md-3">
         <?php
         $data = $this->projects_model->data_billable_time($project->id);
         ?>
         <p class="text-uppercase text-info"><?php echo _l('project_overview_billable_hours'); ?> <span class="bold"><?php echo $data['logged_time'] ?></span></p>
         <p class="bold font-medium"><?php echo app_format_money($data['total_money'], $currency); ?></p>
      </div>
      <div class="col-md-3">
         <?php
         $data = $this->projects_model->data_billed_time($project->id);
         ?>
         <p class="text-uppercase text-success"><?php echo _l('project_overview_billed_hours'); ?> <span class="bold"><?php echo $data['logged_time']; ?></span></p>
         <p class="bold font-medium"><?php echo app_format_money($data['total_money'], $currency); ?></p>
      </div>
      <div class="col-md-3">
         <?php
         $data = $this->projects_model->data_unbilled_time($project->id);
         ?>
         <p class="text-uppercase text-danger"><?php echo _l('project_overview_unbilled_hours'); ?> <span class="bold"><?php echo $data['logged_time']; ?></span></p>
         <p class="bold font-medium"><?php echo app_format_money($data['total_money'], $currency); ?></p>
      </div>
      <div class="clearfix"></div>
      <hr class="hr-panel-heading" />
   </div>
   <?php } ?>
</div>
<div class="row">
   <div class="col-md-12 project-overview-expenses-finance">
      <div class="col-md-3">
         <p class="text-uppercase text-muted"><?php echo _l('project_overview_expenses'); ?></p>
         <p class="bold font-medium"><?php echo app_format_money(sum_from_table(db_prefix().'expenses',array('where'=>array('project_id'=>$project->id),'field'=>'amount')), $currency); ?></p>
      </div>
      <div class="col-md-3">
         <p class="text-uppercase text-info"><?php echo _l('project_overview_expenses_billable'); ?></p>
         <p class="bold font-medium"><?php echo app_format_money(sum_from_table(db_prefix().'expenses',array('where'=>array('project_id'=>$project->id,'billable'=>1),'field'=>'amount')), $currency); ?></p>
      </div>
      <div class="col-md-3">
         <p class="text-uppercase text-success"><?php echo _l('project_overview_expenses_billed'); ?></p>
         <p class="bold font-medium"><?php echo app_format_money(sum_from_table(db_prefix().'expenses',array('where'=>array('project_id'=>$project->id,'invoiceid !='=>'NULL','billable'=>1),'field'=>'amount')), $currency); ?></p>
      </div>
      <div class="col-md-3">
         <p class="text-uppercase text-danger"><?php echo _l('project_overview_expenses_unbilled'); ?></p>
         <p class="bold font-medium"><?php echo app_format_money(sum_from_table(db_prefix().'expenses',array('where'=>array('project_id'=>$project->id,'invoiceid IS NULL','billable'=>1),'field'=>'amount')), $currency); ?></p>
      </div>
   </div>
</div>
<?php } ?>
<div class="project-overview-timesheets-chart">
   <hr class="hr-panel-heading" />
   <div class="dropdown pull-right">
      <a href="#" class="dropdown-toggle" type="button" id="dropdownMenuProjectLoggedTime" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
         <?php if(!$this->input->get('overview_chart')){
            echo _l('this_week');
         } else {
            echo _l($this->input->get('overview_chart'));
         }
         ?>
         <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuProjectLoggedTime">
         <li><a href="<?php echo admin_url('disputes/view/'.$project->id.'?group=project_overview&overview_chart=this_week'); ?>"><?php echo _l('this_week'); ?></a></li>
         <li><a href="<?php echo admin_url('disputes/view/'.$project->id.'?group=project_overview&overview_chart=last_week'); ?>"><?php echo _l('last_week'); ?></a></li>
         <li><a href="<?php echo admin_url('disputes/view/'.$project->id.'?group=project_overview&overview_chart=this_month'); ?>"><?php echo _l('this_month'); ?></a></li>
         <li><a href="<?php echo admin_url('disputes/view/'.$project->id.'?group=project_overview&overview_chart=last_month'); ?>"><?php echo _l('last_month'); ?></a></li>
      </ul>
   </div>
   <div class="clearfix"></div>
   <canvas id="timesheetsChart" style="max-height:300px;" width="300" height="300"></canvas>
</div>

</div>
</div>
<div class="modal fade" id="add-edit-members" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <?php echo form_open(admin_url('disputes/add_edit_members/'.$project->id)); ?>
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo _l('project_members'); ?></h4>
         </div>
         <div class="modal-body">
            <?php
            $selected = array();
            foreach($members as $member){
              array_push($selected,$member['staff_id']);
           }
           echo render_select('project_members[]',$staff,array('staffid',array('firstname','lastname')),'project_members',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
           ?>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
         <button type="submit" class="btn btn-info" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
      </div>
   </div>
   <!-- /.modal-content -->
   <?php echo form_close(); ?>
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
<?php if(isset($project_overview_chart)){ ?>
   var project_overview_chart = <?php echo json_encode($project_overview_chart); ?>;
<?php } ?>

</script>