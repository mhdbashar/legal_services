<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if(!isset($view_task)) { ?>
<table class="table dt-table table-tasks" data-order-col="3" data-s-type='[{"column":3,"type":"task-status"}]' data-order-type="asc">
      <thead>
         <tr>
            <th><?php echo _l('tasks_dt_name'); ?></th>
            <!-- <th><?php echo _l('session_assigned'); ?></th> -->
            <th><?php echo _l('Court'); ?></th>
            <th><?php echo _l('Customer_report'); ?></th>
            <!-- <th><?php echo _l('Send_to_customer'); ?></th> -->
            <th><?php echo _l('session_date'); ?></th>
            <th><?php echo _l('session_time'); ?></th>
            <?php
               $custom_fields = get_custom_fields('tasks',array('show_on_client_portal'=>1));
               foreach($custom_fields as $field){ ?>
            <th><?php echo $field['name']; ?></th>
            <?php } ?>
         </tr>
      </thead>
      <tbody>
    
         <?php
            foreach($project_tasks as $task){ ?>
         <?php
         if($task['startdate'] < date('Y-m-d'))
            continue;   
         $outputName = '';
          $outputName .= '<a href="' . site_url('clients/legal_services/'.$project->id.'/'.$ServID.'?group=CaseSession&session_id='.$task['id']) . '" class="display-block main-tasks-table-href-name" onclick="init_task_modal_session(' . $task['id'] . '); return false;">' . $task['task_name'] . '</a>';
          if ($task['recurring'] == 1) {
              $outputName .= '<span class="label label-primary inline-block mtop4"> ' . _l('recurring_task') . '</span>';
          }

          $outputName .= '<div class="row-options">';

          $class = 'text-success bold';
          $style = '';
          $tooltip = '';

          if ($task['billed'] == 1 || $task['status'] == Tasks_model::STATUS_COMPLETE) {
              $class = 'text-dark disabled';
              $style = 'style="opacity:0.6;cursor: not-allowed;"';
              if ($task['status'] == Tasks_model::STATUS_COMPLETE) {
                  $tooltip = ' data-toggle="tooltip" data-title="' . format_task_status($task['status'], false, true) . '"';
              } elseif ($task['billed'] == 1) {
                  $tooltip = ' data-toggle="tooltip" data-title="' . _l('task_billed_cant_start_timer') . '"';
              } elseif (!$task['is_assigned']) {
                  $tooltip = ' data-toggle="tooltip" data-title="' . _l('task_start_timer_only_assignee') . '"';
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
            <td>
               <?php echo $outputName ?>
            </td>
            <!-- <td><?php echo $task['judge'] ?></td> -->
            <td><?php echo $task['court_name'] ?></td>

            <?php
               if($task['customer_report'] == 0):
                    $report = '<span class="label label inline-block project-status-1" style="color:#989898;border:1px solid #989898">لايوجد</span>';
                else:
                    $report = '<span class="label label inline-block project-status-4" style="color:#84c529;border:1px solid #84c529">يوجد</span>';
                endif;
            ?>
            <td><?php echo $report ?></td>
<!-- 
            <?php
               if($task['send_to_customer'] == 0):
                    $send = '<span class="label label inline-block project-status-1" style="color:#989898;border:1px solid #989898">لم يتم الارسال</span>';
                else:
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
<?php } else {
   get_template_part('legal_services/project_session');
   }
?>