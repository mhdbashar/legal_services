<!--*********Adding filter***************-->
<div class="_hidden_inputs _filters _tasks_filters">
    <?php

    hooks()->do_action('tasks_filters_hidden_html');
    echo form_hidden('my_tasks',(!has_permission('tasks','','view') ? 'true' : ''));
    echo form_hidden('my_following_tasks');
    echo form_hidden('not_assigned');
    echo form_hidden('today_tasks');
    echo form_hidden('tasks_related_to');

    ?>
</div>
<?php
$class='.table-waiting_sessions_log';
?>
<div class="btn-group pull-right mleft4 btn-with-tooltip-group _filter_data" data-toggle="tooltip" data-title="<?php echo _l('filter_by'); ?>">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-filter" aria-hidden="true"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-right width300">
        <li>
            <a href="#" data-cview="all" onclick="dt_custom_view('','<?php echo $class; ?>',''); return false;">
                <?php echo _l('expenses_list_all'); ?>
            </a>
        </li>

        <li class="filter-group" data-filter-group="group-date">
            <a href="#" data-cview="today_tasks" onclick="dt_custom_view('today_tasks','<?php echo $class; ?>','today_tasks'); return false;">
                <?php echo _l('todays_sessions'); ?>
            </a>
        </li>

        <li class="filter-group <?php echo (!has_permission('tasks','','view') ? ' active' : ''); ?>" data-filter-group="assigned-follower-not-assigned">
            <a href="#" data-cview="my_tasks" onclick="dt_custom_view('my_tasks','<?php echo $class; ?>','my_tasks'); return false;">
                <?php echo _l('sessions_view_assigned_to_user'); ?>
            </a>
        </li>

        <li class="filter-group" data-filter-group="assigned-follower-not-assigned">
            <a href="#" data-cview="my_following_tasks" onclick="dt_custom_view('my_following_tasks','<?php echo $class; ?>','my_following_tasks'); return false;">
                <?php echo _l('sessions_view_follower_by_user'); ?>
            </a>
        </li>


        <li class="filter-group" data-filter-group="assigned-follower-not-assigned">
            <a href="#" data-cview="not_assigned" onclick="dt_custom_view('not_assigned','<?php echo $class; ?>','not_assigned'); return false;">
                <?php echo _l('sessions_list_not_assigned'); ?>
            </a>
        </li>

    </ul>
</div>

<!--**************************************************-->