<?php

defined('BASEPATH') or exit('No direct script access allowed');

$filter = [];

if ($this->ci->input->post('my_tasks')) {
    array_push($filter, 'OR (' . db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid = ' . get_staff_user_id() . '))');
}

if ($this->ci->input->post('not_assigned')) {
    array_push($filter, 'AND ' . db_prefix() . 'tasks.id NOT IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned)');
}

if ($this->ci->input->post('today_tasks')) {
    array_push($filter, 'AND startdate = "' . date('Y-m-d') . '"');
}

if ($this->ci->input->post('my_following_tasks')) {
    array_push($filter, 'AND (' . db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_followers WHERE staffid = ' . get_staff_user_id() . '))');
}


if (!has_permission('sessions', '', 'view')) {
    array_push($where, get_tasks_where_string());
}

if (count($filter) > 0) {
    array_push($where, 'AND (' . prepare_dt_filter($filter) . ')');
}

$where = hooks()->apply_filters('tasks_table_sql_where', $where);
