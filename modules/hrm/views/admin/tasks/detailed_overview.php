<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

         <div class="col-md-9">
            <?php $_POST['member'] = 2; ?>
            <div class="panel_s">
               <div class="panel-body">
                  <?php foreach($overview as $month =>$data){ if(count($data) == 0){continue;} ?>
                  <h4 class="bold text-success"><?php echo  _l(date('F', mktime(0, 0, 0, $month, 1))); ?>
                     <?php if($this->input->get('project_id')){ echo ' - ' . get_project_name_by_id($this->input->get('project_id'));} ?>
                     <?php if(is_numeric($staff_id) && has_permission('tasks','','view')) { echo ' ('.get_staff_full_name($staff_id).')';} ?>
                  </h4>
                  <table class="table tasks-overview dt-table scroll-responsive">
                     <thead>
                        <tr>
                           <th><?php echo _l('tasks_dt_name'); ?></th>
                           <th><?php echo _l('tasks_dt_datestart'); ?></th>
                           <th><?php echo _l('task_duedate'); ?></th>
                           <th><?php echo _l('task_status'); ?></th>
                           <th><?php echo _l('tasks_total_added_attachments'); ?></th>
                           <th><?php echo _l('tasks_total_comments'); ?></th>
                           <th><?php echo _l('task_checklist_items'); ?></th>
                           <th><?php echo _l('staff_stats_total_logged_time'); ?></th>
                           <th><?php echo _l('task_finished_on_time'); ?></th>
                           <th><?php echo _l('task_assigned'); ?></th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           foreach($data as $task){ ?>
                        <tr>
                           <td data-order="<?php echo htmlentities($task['name']); ?>"><a href="<?php echo admin_url('tasks/view/'.$task['id']); ?>" onclick="init_task_modal(<?php echo $task['id']; ?>); return false;"><?php echo $task['name']; ?></a>
                              <?php
                                 if (!empty($task['rel_id'])) {
                                   echo '<br />'. _l('task_related_to').': <a class="text-muted" href="' . task_rel_link($task['rel_id'],$task['rel_type']) . '">' . task_rel_name($task['rel_name'],$task['rel_id'],$task['rel_type']) . '</a>';
                                 }
                                 ?>
                           </td>
                           <td data-order="<?php echo $task['startdate']; ?>"><?php echo _d($task['startdate']); ?></td>
                           <td data-order="<?php echo $task['duedate']; ?>"><?php echo _d($task['duedate']); ?></td>
                           <td><?php echo format_task_status($task['status']); ?></td>
                           <td data-order="<?php echo $task['total_files']; ?>">
                              <span class="label label-default-light" data-toggle="tooltip" data-title="<?php echo _l('tasks_total_added_attachments'); ?>">
                              <i class="fa fa-paperclip"></i>
                              <?php
                                 if(!is_numeric($staff_id)) {
                                    echo $task['total_files'];
                                 } else {
                                    echo $task['total_files_staff'] . '/' . $task['total_files'];
                                 }
                              ?>
                              </span>
                           </td>
                           <td data-order="<?php echo $task['total_comments']; ?>">
                              <span class="label label-default-light" data-toggle="tooltip" data-title="<?php echo _l('tasks_total_comments'); ?>">
                              <i class="fa fa-comments"></i>
                               <?php
                                 if(!is_numeric($staff_id)) {
                                    echo $task['total_comments'];
                                 } else {
                                    echo $task['total_comments_staff'] . '/' . $task['total_comments'];
                                 }
                              ?>
                              </span>
                           </td>
                           <td>
                              <span class="label <?php if($task['total_checklist_items'] == '0'){ echo 'label-default-light'; } else if(($task['total_finished_checklist_items'] != $task['total_checklist_items'])){ echo 'label-danger';
                                 } else if($task['total_checklist_items'] == $task['total_finished_checklist_items']){echo 'label-success';} ?> pull-left mright5" data-toggle="tooltip" data-title="<?php echo _l('tasks_total_checklists_finished'); ?>">
                              <i class="fa fa-th-list"></i>
                              <?php echo $task['total_finished_checklist_items']; ?>/<?php echo $task['total_checklist_items']; ?>
                              </span>
                           </td>
                           <td data-order="<?php echo $task['total_logged_time']; ?>">
                              <span class="label label-default-light pull-left mright5" data-toggle="tooltip" data-title="<?php echo _l('staff_stats_total_logged_time'); ?>">
                              <i class="fa fa-clock-o"></i> <?php echo seconds_to_time_format($task['total_logged_time']); ?>
                              </span>
                           </td>
                           <?php
                              $finished_on_time_class = '';
                              $finishedOrder = 0;
                              if(date('Y-m-d',strtotime($task['datefinished'])) > $task['duedate'] && $task['status'] == Tasks_model::STATUS_COMPLETE && is_date($task['duedate'])){
                               $finished_on_time_class = 'text-danger';
                               $finished_showcase = _l('task_not_finished_on_time_indicator');
                              } else if(date('Y-m-d',strtotime($task['datefinished'])) <= $task['duedate'] && $task['status'] == Tasks_model::STATUS_COMPLETE && is_date($task['duedate'])){
                               $finishedOrder = 1;
                               $finished_showcase = _l('task_finished_on_time_indicator');
                              } else {
                               $finished_on_time_class = '';
                               $finished_showcase = '';
                              }
                              ?>
                           <td data-order="<?php echo $finishedOrder; ?>">
                              <span class="<?php echo $finished_on_time_class; ?>">
                              <?php echo $finished_showcase; ?>
                              </span>
                           </td>
                           <td>
                              <?php
                                 echo format_members_by_ids_and_names($task['assignees_ids'],$task['assignees'], false);
                                 ?>
                           </td>
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
                  <?php } ?>
               </div>
            </div>
         </div>