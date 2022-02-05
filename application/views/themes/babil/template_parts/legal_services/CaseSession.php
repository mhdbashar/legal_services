<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($project->settings->view_session_logs == 1 &&  !isset($view_task)) : ?>
   <div id="wrapper">
      <div class="content">
         <div class="row">
            <div class="col-md-12">
               <div class="panel_s">
                  <div class="panel-body">
                     <div class="clearfix"></div>
                     <?php
                     if ($this->session->has_userdata('tasks_kanban_view') && $this->session->userdata('tasks_kanban_view') == 'true') { ?>
                        <div class="kan-ban-tab" id="kan-ban-tab" style="overflow:auto;">
                           <div class="row">
                              <div id="kanban-params">
                                 <?php echo form_hidden('project_id', $this->input->get('project_id')); ?>
                              </div>
                              <div class="container-fluid" style="width: 100%">
                                 <div id="kan-ban"></div>
                              </div>
                           </div>
                        </div>
                     <?php } else { ?>
                        <div class="horizontal-scrollable-tabs preview-tabs-top">
                           <div class="horizontal-tabs">
                              <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
                                 <li role="presentation" class="active">
                                    <a href="#Waiting_sessions" aria-controls="Waiting_sessions" role="tab" data-toggle="tab">
                                       <?php echo _l('Waiting_sessions'); ?>
                                    </a>
                                 </li>
                                 <li role="presentation" class="tab-separator">
                                    <a href="#Previous_Sessions" aria-controls="Previous_Sessions" role="tab" data-toggle="tab">
                                       <?php echo _l('Previous_Sessions') ?>
                                    </a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <div class="tab-content">
                           <div role="tabpanel" class="tab-pane active" id="Waiting_sessions">
                              <table class="table dt-table table-tasks" data-order-col="3" data-s-type='[{"column":3,"type":"task-status"}]' data-order-type="asc">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th><?php echo _l('tasks_dt_name'); ?></th>
                                       <?php if ($project->settings->view_team_members == 1) : ?>
                                          <th><?php echo _l('session_assigned'); ?></th>
                                       <?php endif; ?>

                                       <!-- <th><?php echo _l('session_assigned'); ?></th> -->
                                       <th><?php echo _l('Court'); ?></th>
                                       <th><?php echo _l('Customer_report'); ?></th>
                                       <!-- <th><?php echo _l('Send_to_customer'); ?></th> -->
                                       <th><?php echo _l('session_date'); ?></th>
                                       <th><?php echo _l('session_time'); ?></th>
                                       <?php
                                       $custom_fields = get_custom_fields('sessions', array('show_on_client_portal' => 1));
                                       foreach ($custom_fields as $field) { ?>
                                          <th><?php echo $field['name']; ?></th>
                                       <?php } ?>
                                    </tr>
                                 </thead>
                                 <tbody>

                                    <?php
                                    $i = 1;
                                    foreach ($project_tasks as $task) { ?>
                                       <?php
                                       if (strtotime($task['startdate'] . ' ' . $task['time']) < strtotime(date('Y-m-d H:i:s')))
                                          continue;
                                       $outputName = '';
                                       $outputName .= '<a href="' . site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=CaseSession&session_id=' . $task['id']) . '" class="display-block main-tasks-table-href-name" onclick="init_session_modal(' . $task['id'] . '); return false;">' . $task['task_name'] . '</a>';
                                       if ($task['recurring'] == 1) {
                                          $outputName .= '<span class="label label-primary inline-block mtop4"> ' . _l('recurring_task') . '</span>';
                                       }

                                       $outputName .= '<div class="row-options">';

                                       $class = 'text-success bold';
                                       $style = '';
                                       $tooltip = '';

                                       if ($task['billed'] == 1 || $task['status'] == Sessions_model::STATUS_COMPLETE) {
                                          $class = 'text-dark disabled';
                                          $style = 'style="opacity:0.6;cursor: not-allowed;"';
                                          if ($task['status'] == Sessions_model::STATUS_COMPLETE) {
                                             $tooltip = ' data-toggle="tooltip" data-title="' . format_task_status($task['status'], false, true) . '"';
                                          } elseif ($task['billed'] == 1) {
                                             $tooltip = ' data-toggle="tooltip" data-title="' . _l('session_billed_cant_start_timer') . '"';
                                          } elseif (!$task['is_assigned']) {
                                             $tooltip = ' data-toggle="tooltip" data-title="' . _l('session_start_timer_only_assignee') . '"';
                                          }
                                       }

                                       //   $outputName .= '<span' . $tooltip . ' ' . $style . '>
                                       // <a href="#" class="' . $class . ' tasks-table-start-timer" onclick="timer_action(this,' . $task['id'] . '); return false;">' . _l('task_start_timer') . '</a>
                                       // </span>';

                                       //   $outputName .= '<span class="text-dark"> | </span><a href="#" onclick="edit_session(' . $task['id'] . '); return false">' . _l('edit') . '</a>';

                                       //   $outputName .= '<span class="text-dark"> | </span><a href="' . admin_url('tasks/delete_task/' . $task['id']) . '" class="text-danger _delete task-delete">' . _l('delete') . '</a>';
                                       $outputName .= '</div>';
                                       ?>
                                       <tr>
                                          <td><?php echo $i++; ?></td>
                                          <td>
                                             <?php if (
                                                $project->settings->edit_sessions == 1 &&
                                                $task['is_added_from_contact'] == 1 &&
                                                $task['addedfrom'] == get_contact_user_id() &&
                                                $task['billed'] == 0
                                             ) { ?>
                                                <a href="<?php echo site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=edit_session&session_id=' . $task['id']); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                             <?php } ?>
                                             <?php echo $outputName ?>
                                          </td>
                                          <!-- <td><?php echo $task['judge'] ?></td> -->
                                          <?php if ($project->settings->view_team_members == 1) : ?>
                                             <td>
                                                <?php if ($task['emp_assignee_id'] != null) : ?>
                                                   <img src="<?php echo site_url(); ?>assets/images/user-placeholder.jpg" data-toggle="tooltip" data-title="<?php echo $task['fullname']; ?>" class="staff-profile-image-small mleft5" data-original-title="" title="">
                                                   <span class='hide'><?php echo $task['fullname']; ?></span>
                                                <?php endif; ?>
                                             </td>
                                          <?php endif;  ?>
                                          <td>
                                             <?php if ($task['court_name'] == 'nothing_was_specified' ||  $task['court_name'] == '') : ?>
                                                <?php echo _l('dropdown_non_selected_tex') ?>
                                             <?php else :
                                                echo $task['court_name'] ?>
                                             <?php endif; ?>
                                          </td>

                                          <?php
                                          if ($task['customer_report'] == 0) :
                                             $report = '<span class="label label inline-block project-status-1" style="color:#989898;border:1px solid #989898">' . _l("smtp_encryption_none") . '</span>';
                                          else :
                                             $report = '<span class="label label inline-block project-status-4" style="color:#84c529;border:1px solid #84c529">' . _l("smtp_encryption_none") . '</span>';
                                          endif;
                                          ?>
                                          <td><?php echo $report ?></td>
                                          <!-- 
                                       <?php
                                       if ($task['send_to_customer'] == 0) :
                                          $send = '<span class="label label inline-block project-status-1" style="color:#989898;border:1px solid #989898">لم يتم الارسال</span>';
                                       else :
                                          $send = '<span class="label label inline-block project-status-4" style=color:#84c529;border:1px solid #84c529">مرسل</span>';
                                       endif;
                                       ?>
                                       <td><?php echo $send ?></td> -->

                                          <td><?php echo _d($task['startdate']) ?></td>
                                          <td><?php echo $task['time'] ?></td>


                                       </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                           <div role="tabpanel" class="tab-pane " id="Previous_Sessions">
                              <table class="table dt-table table-tasks" data-order-col="3" data-s-type='[{"column":3,"type":"task-status"}]' data-order-type="asc">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th><?php echo _l('tasks_dt_name'); ?></th>
                                       <?php if ($project->settings->view_team_members == 1) : ?>
                                          <th><?php echo _l('session_assigned'); ?></th>
                                       <?php endif; ?>
                                       <!-- <th><?php echo _l('session_assigned'); ?></th> -->
                                       <th><?php echo _l('Court'); ?></th>
                                       <th><?php echo _l('Customer_report'); ?></th>
                                       <!-- <th><?php echo _l('Send_to_customer'); ?></th> -->
                                       <th><?php echo _l('session_date'); ?></th>
                                       <th><?php echo _l('session_time'); ?></th>
                                       <?php
                                       $custom_fields = get_custom_fields('sessions', array('show_on_client_portal' => 1));
                                       foreach ($custom_fields as $field) { ?>
                                          <th><?php echo $field['name']; ?></th>
                                       <?php } ?>
                                    </tr>
                                 </thead>
                                 <tbody>

                                    <?php
                                    $i = 1;
                                    foreach ($project_tasks as $task) { ?>
                                       <?php
                                       if (strtotime($task['startdate'] . ' ' . $task['time']) < strtotime(date('Y-m-d H:i:s'))) {

                                          $outputName = '';
                                          $outputName .= '<a href="' . site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=CaseSession&session_id=' . $task['id']) . '" class="display-block main-tasks-table-href-name" onclick="init_session_modal(' . $task['id'] . '); return false;">' . $task['task_name'] . '</a>';
                                          if ($task['recurring'] == 1) {
                                             $outputName .= '<span class="label label-primary inline-block mtop4"> ' . _l('recurring_task') . '</span>';
                                          }

                                          $outputName .= '<div class="row-options">';

                                          $class = 'text-success bold';
                                          $style = '';
                                          $tooltip = '';

                                          if ($task['billed'] == 1 || $task['status'] == Sessions_model::STATUS_COMPLETE) {
                                             $class = 'text-dark disabled';
                                             $style = 'style="opacity:0.6;cursor: not-allowed;"';
                                             if ($task['status'] == Sessions_model::STATUS_COMPLETE) {
                                                $tooltip = ' data-toggle="tooltip" data-title="' . format_task_status($task['status'], false, true) . '"';
                                             } elseif ($task['billed'] == 1) {
                                                $tooltip = ' data-toggle="tooltip" data-title="' . _l('session_billed_cant_start_timer') . '"';
                                             } elseif (!$task['is_assigned']) {
                                                $tooltip = ' data-toggle="tooltip" data-title="' . _l('session_start_timer_only_assignee') . '"';
                                             }
                                          }

                                          //   $outputName .= '<span' . $tooltip . ' ' . $style . '>
                                          // <a href="#" class="' . $class . ' tasks-table-start-timer" onclick="timer_action(this,' . $task['id'] . '); return false;">' . _l('task_start_timer') . '</a>
                                          // </span>';

                                          //   $outputName .= '<span class="text-dark"> | </span><a href="#" onclick="edit_session(' . $task['id'] . '); return false">' . _l('edit') . '</a>';

                                          //   $outputName .= '<span class="text-dark"> | </span><a href="' . admin_url('tasks/delete_task/' . $task['id']) . '" class="text-danger _delete task-delete">' . _l('delete') . '</a>';
                                          $outputName .= '</div>';
                                       ?>
                                          <tr>
                                             <td><?php echo $i++; ?></td>
                                             <td>
                                                <?php if (
                                                   $project->settings->edit_sessions == 1 &&
                                                   $task['is_added_from_contact'] == 1 &&
                                                   $task['addedfrom'] == get_contact_user_id() &&
                                                   $task['billed'] == 0
                                                ) { ?>
                                                   <a href="<?php echo site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=edit_session&session_id=' . $task['id']); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                                <?php } ?>
                                                <?php echo $outputName ?>
                                             </td>
                                             <?php if ($project->settings->view_team_members == 1) : ?>
                                                <td>
                                                   <?php if ($task['emp_assignee_id'] != null) : ?>
                                                      <img src="<?php echo site_url(); ?>assets/images/user-placeholder.jpg" data-toggle="tooltip" data-title="<?php echo $task['fullname']; ?>" class="staff-profile-image-small mleft5" data-original-title="" title="">
                                                      <span class='hide'><?php echo $task['fullname']; ?></span>
                                                   <?php endif; ?>
                                                </td>
                                             <?php endif; ?>
                                             <td>
                                                <?php if ($task['court_name'] == 'nothing_was_specified' ||  $task['court_name'] == '') : ?>
                                                   <?php echo _l('dropdown_non_selected_tex') ?>
                                                <?php else :
                                                   echo $task['court_name'] ?>
                                                <?php endif; ?>
                                             </td>
                                             <!-- <td><?php echo $task['judge'] ?></td> -->

                                             <?php
                                             if ($task['customer_report'] == 0) :
                                                $report = '<span class="label label inline-block project-status-1" style="color:#989898;border:1px solid #989898">' . _l("smtp_encryption_none") . '</span>';
                                             else :
                                                $report = '<span class="label label inline-block project-status-4" style="color:#84c529;border:1px solid #84c529">' . _l("smtp_encryption_none") . '</span>';
                                             endif;
                                             ?>
                                             <td><?php echo $report ?></td>
                                             <!-- 
                                          <?php
                                          if ($task['send_to_customer'] == 0) :
                                             $send = '<span class="label label inline-block project-status-1" style="color:#989898;border:1px solid #989898">لم يتم الارسال</span>';
                                          else :
                                             $send = '<span class="label label inline-block project-status-4" style=color:#84c529;border:1px solid #84c529">مرسل</span>';
                                          endif;
                                          ?>
                                          <td><?php echo $send ?></td> -->

                                             <td><?php echo _d($task['startdate']) ?></td>
                                             <td><?php echo $task['time'] ?></td>


                                          </tr>
                                    <?php }
                                    } ?>

                                 </tbody>
                              </table>
                           </div>
                        </div>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script>reload_tasks_tables();</script>
<?php elseif(isset($view_task)) :
   get_template_part('legal_services/project_session');
else :
   redirect(site_url() . 'clients/legal_services/' . $rel_id . '/' . $ServID);
endif; ?>