<?php defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance();
$CI->load->library('app_modules');
?>
<?php if ($project->settings->view_session_logs == 1 && !isset($view_task)) : ?>
    <div class="horizontal-scrollable-tabs preview-tabs-top">
        <div class="horizontal-tabs">
            <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
                <?php //  TAB WAITING SESSIONS ?>
                <li role="presentation" class="tab-separator active">
                    <a href="#Waiting_sessions" aria-controls="Waiting_sessions" role="tab" data-toggle="tab"
                       aria-expanded="true">
                        <?php echo _l('Waiting_sessions'); ?>
                    </a>
                </li>
                <?php // TAB RREVIOUS SESSIONS ?>
                <li role="presentation" class="tab-separator">
                    <a href="#Previous_Sessions" aria-controls="Previous_Sessions" role="tab" data-toggle="tab"
                       aria-expanded="false">
                        <?php echo _l('Previous_Sessions') ?>
                    </a>
                </li>
                <?php if ($project->settings->view_session_logs == 1 && $project->settings->create_sessions == 1) { ?>
                    <a href="<?php echo site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=new_session'); ?>"
                       class="btn btn-info pull-right mtop5 mright10 "><?php echo _l('new_session'); ?></a>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php // CONTENT ?>
    <div class="tab-content">
        <?php // CONTENT TABLE WAITING SESSIONS ?>
        <div role="tabpanel" class="tab-pane active" id="Waiting_sessions">
            <table class="table dt-table table-tasks" data-order-col="4"
                   data-order-type="asc">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo _l('tasks_dt_name'); ?></th>
                    <?php if ($project->settings->view_team_members == 1) : ?>
                        <th><?php echo _l('session_assigned'); ?></th>
                    <?php endif; ?>
                    <th><?php echo _l('session_link'); ?></th>
                    <th><?php echo _l('Court'); ?></th>
                    <th class="sorting sorting_asc" aria-sort="ascending"><?php echo _l('session_date'); ?></th>
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
                    if (strtotime($task['startdate'] . ' ' . $task['time']) <= strtotime(date('Y-m-d H:i:s')))
                        continue;
                    //  NAME SECTION OPERATION
                    $outputName = '';
                    $outputName .= '<a href="' . site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=CaseSession&session_id=' . $task['id']) . '" class="display-block main-tasks-table-href-name" onclick="init_session_modal(' . $task['id'] . '); return false;">' . $task['task_name'] . '</a>';
                    if ($task['recurring'] == 1) {
                        $outputName .= '<span class="label label-primary inline-block mtop4"> ' . _l('recurring_task') . '</span>';
                    }

                    $outputName .= '<div class="row-options">';
                    $class = 'text-success bold';
                    $style = '';
                    $tooltip = '';
                    $outputName .= '</div>';
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <?php // NAME SECTION ?>
                        <td>
                            <?php if (
                                $project->settings->edit_sessions == 1 &&
                                $task['is_added_from_contact'] == 1 &&
                                $task['addedfrom'] == get_contact_user_id() &&
                                $task['billed'] == 0) { ?>
                                <a href="<?php echo site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=edit_session&session_id=' . $task['id']); ?>"><i
                                            class="fa fa-pencil-square-o"></i></a>
                            <?php } ?>
                            <?php echo $outputName ?>
                        </td>
                        <?php
                        // SESSION ASSIGNED
                        if ($project->settings->view_team_members == 1) : ?>
                            <td>
                                <?php
                                $_assignees = '';
                                foreach ($task['assignees'] as $assignee) {
                                    $_assignees .= '
                                                      <div data-toggle="tooltip" class="pull-left mleft5 session-user" data-title="' . get_staff_full_name($assignee['assigneeid']) . '">'
                                        . staff_profile_image($assignee['assigneeid'], array(
                                            'staff-profile-image-small'
                                        )) . '</div>';
                                }
                                if ($_assignees == '') {
                                    $_assignees = '<div class="session-connectors-no-indicator display-block">' . _l('session_no_assignees') . '</div>';
                                }
                                echo $_assignees;
                                ?>
                            </td>
                        <?php endif; ?>
                        <td><?php echo $task['session_link'] ?></td>
                        <td>
                            <?php
                            // COURTS
                            if ($task['court_name'] == 'nothing_was_specified' || $task['court_name'] == '') : ?>
                                <?php echo _l('dropdown_non_selected_tex') ?>
                            <?php else :
                                echo $task['court_name'] ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            // START DATAE
                            echo $CI->app_modules->is_active('hijri') ? _d($task['startdate']) . '<br>' . to_hijri_date(_d($task['startdate'])) : _d($task['startdate']);
                            ?></td>
                        <td>
                            <?php
                            // TIME
                            echo $task['time'] ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php // CONTENT TABLE PREVIOUS SESSIONS ?>
        <div role="tabpanel" class="tab-pane " id="Previous_Sessions">
            <table class="table dt-table table-tasks" data-order-col="4"
                   data-s-type='[{"column":3,"type":"task-status"}]' data-order-type="desc">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo _l('tasks_dt_name'); ?></th>
                    <?php if ($project->settings->view_team_members == 1) : ?>
                        <th><?php echo _l('session_assigned'); ?></th>
                    <?php endif; ?>

                    <th><?php echo _l('Court'); ?></th>
                    <th><?php echo _l('session_date'); ?></th>
                    <th><?php echo _l('session_time'); ?></th>
                    <?php  if ($project->settings->view_session_customer_report == 1 ) :
                    ?><th><?php echo _l('Customer_report'); ?></th> <?php endif;?>
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
                    if (strtotime($task['startdate'] . ' ' . $task['time']) > strtotime(date('Y-m-d H:i:s')))
                        continue;
                    //  NAME SECTION OPERATION
                    $outputName = '';
                    $outputName .= '<a href="' . site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=CaseSession&session_id=' . $task['id']) . '" class="display-block main-tasks-table-href-name" onclick="init_session_modal(' . $task['id'] . '); return false;">' . $task['task_name'] . '</a>';
                    if ($task['recurring'] == 1) {
                        $outputName .= '<span class="label label-primary inline-block mtop4"> ' . _l('recurring_task') . '</span>';
                    }

                    $outputName .= '<div class="row-options">';

                    $class = 'text-success bold';
                    $style = '';
                    $tooltip = '';
                    $outputName .= '</div>';
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <?php // NAME SECTION ?>
                        <td>
                            <?php if (
                                $project->settings->edit_sessions == 1 &&
                                $task['is_added_from_contact'] == 1 &&
                                $task['addedfrom'] == get_contact_user_id() &&
                                $task['billed'] == 0) { ?>
                                <a href="<?php echo site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=edit_session&session_id=' . $task['id']); ?>"><i
                                            class="fa fa-pencil-square-o"></i></a>
                            <?php } ?>
                            <?php echo $outputName ?>
                        </td>
                        <?php
                        // SESSION ASSIGNED
                        if ($project->settings->view_team_members == 1) : ?>
                            <td>
                                <?php
                                $_assignees = '';
                                foreach ($task['assignees'] as $assignee) {
                                    $_assignees .= '
                                                      <div data-toggle="tooltip" class="pull-left mleft5 session-user" data-title="' . get_staff_full_name($assignee['assigneeid']) . '">'
                                        . staff_profile_image($assignee['assigneeid'], array(
                                            'staff-profile-image-small'
                                        )) . '</div>';
                                }
                                if ($_assignees == '') {
                                    $_assignees = '<div class="session-connectors-no-indicator display-block">' . _l('session_no_assignees') . '</div>';
                                }
                                echo $_assignees;
                                ?>
                            </td>
                        <?php endif; ?>
                        <td>
                            <?php
                            // COURTS
                            if ($task['court_name'] == 'nothing_was_specified' || $task['court_name'] == '') : ?>
                                <?php echo _l('dropdown_non_selected_tex') ?>
                            <?php else :
                                echo $task['court_name'] ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            // START DATE
                            echo $CI->app_modules->is_active('hijri') ? _d($task['startdate']) . '<br>' . to_hijri_date(_d($task['startdate'])) : _d($task['startdate']);
                            ?>
                        </td>
                        <td>
                            <?php
                            // TIME
                            echo $task['time'] ?>
                        </td>
                      <?php
                      //  CUSTOMER REPORT
                      if ($project->settings->view_session_customer_report == 1) :
                        $report = '<div class="btn-group">
                                 <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> <span class="caret"></span></a>
                                 <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="hidden-xs"><a href="' . site_url('my_sessions/session_report/') . $task['id'] . '">عرض PDF</a></li>
                                    <li class="hidden-xs"><a href="' . site_url('my_sessions/session_report/') . $task['id'] . '" target="_blank">عرض PDF في علامة تبويب جديدة</a></li>
                                    <li><a href="' . site_url('my_sessions/session_report/') . $task['id'] . '/1' . '">تحميل</a></li>
                                 </ul>
                              </div>';
                         ?>
                        <td><?php echo $report ?></td>
                        <?php endif;?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php elseif (isset($view_task)) :
    // VIEW SESSION DETAIL PAGE
    get_template_part('legal_services/project_session');
else :
    redirect(site_url() . 'clients/legal_services/' . $rel_id . '/' . $ServID);
endif; ?>
