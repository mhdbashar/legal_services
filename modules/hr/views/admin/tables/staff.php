<?php

defined('BASEPATH') or exit('No direct script access allowed');

$has_permission_delete = has_permission('staff', '', 'delete');

$custom_fields = get_custom_fields('staff', [
    'show_on_table' => 1,
    ]);
$aColumns = [
    'firstname',
    db_prefix().'staff.email',
    db_prefix().'roles.name',
    'last_login',
    'CASE
        WHEN designation != "" THEN "<h4 class=\'text-success\'>'._l("completed").'</h4>"
        ELSE "<h4 class=\'text-danger\'>'._l("not_completed").'</h4><p>'._l("you_must_add_sub_department_and_designation_to_this_staff").'</p>"
    END',
    'active',
    ];

$aColumns = hooks()->apply_filters('staffs_table_aColumns', $aColumns);

$sIndexColumn = 'staffid';
$sTable       = db_prefix().'staff';
$join         = ['LEFT JOIN '.db_prefix().'roles ON '.db_prefix().'roles.roleid = '.db_prefix().'staff.role'];
$join[]         = 'LEFT JOIN '.db_prefix().'staff_departments ON '.db_prefix().'staff_departments.staffid = '.db_prefix().'staff.staffid';
$join[]         = 'LEFT JOIN '.db_prefix().'departments ON '.db_prefix().'departments.departmentid = '.db_prefix().'staff_departments.departmentid';
$ci = &get_instance();
$join = hooks()->apply_filters('staffs_table_sql_join', $join);
$join[] = 'LEFT JOIN '.db_prefix().'hr_extra_info ON '.db_prefix().'hr_extra_info.staff_id='.db_prefix().'staff.staffid';
$i            = 0;
foreach ($custom_fields as $field) {
    $select_as = 'cvalue_' . $i;
    if ($field['type'] == 'date_picker' || $field['type'] == 'date_picker_time') {
        $select_as = 'date_picker_cvalue_' . $i;
    }
    array_push($aColumns, 'ctable_' . $i . '.value as ' . $select_as);
    array_push($join, 'LEFT JOIN '.db_prefix().'customfieldsvalues as ctable_' . $i . ' ON '.db_prefix().'staff.staffid = ctable_' . $i . '.relid AND ctable_' . $i . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $i . '.fieldid=' . $field['id']);
    $i++;
}
            // Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}

$where = hooks()->apply_filters('staff_table_sql_where', []);
if(has_permission('hr', '', 'view_own') && !has_permission('hr', '', 'view')){
    $where[] = 'AND '. db_prefix() . 'staff.staffid='.get_staff_user_id();
}
$department_id = $this->ci->input->post('hrm_deparment');

if($this->ci->input->post('hrm_deparment')){
    $where_department = '';
    $staff_department      = $this->ci->input->post('hrm_deparment');
    foreach ($staff_department as $department_id) {
        if($department_id != '')
        {
            if($where_department == ''){
                $where_department .= '( '.db_prefix().'departments.departmentid = '.$department_id;
            }else{
                $where_department .= ' or '.db_prefix().'departments.departmentid = '.$department_id;
            }
        }
    }

    if($where_department != '')
    {
        $where_department .= ' )';
        if($where_department != ''){
            array_push($where, 'AND '. $where_department);
        }else{
            array_push($where, $where_department);
        }

    }

}


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    'profile_image',
    'lastname',
    'second_name',
    'third_name',
    db_prefix().'staff.staffid',
    ]);

$output  = $result['output'];
$rResult = $result['rResult'];

$staffid = '';
foreach ($rResult as $aRow) {
    if($aRow['staffid'] == $staffid)
        continue;
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
            $_data = $aRow[strafter($aColumns[$i], 'as ')];
        } else {
            $_data = $aRow[$aColumns[$i]];
        }
        if ($aColumns[$i] == 'last_login') {
            if ($_data != null) {
                $_data = '<span class="text-has-action is-date" data-toggle="tooltip" data-title="' . _dt($_data) . '">' . time_ago($_data) . '</span>';
            } else {
                $_data = 'Never';
            }
        } elseif ($aColumns[$i] == 'active') {
            $checked = '';
            if ($aRow['active'] == 1) {
                $checked = 'checked';
            }

            $_data = '<div class="onoffswitch">
                <input type="checkbox" ' . (($aRow['staffid'] == get_staff_user_id() || (is_admin($aRow['staffid']) || !has_permission('staff', '', 'edit')) && !is_admin()) ? 'disabled' : '') . ' data-switch-url="' . admin_url() . 'staff/change_staff_status" name="onoffswitch" class="onoffswitch-checkbox" id="c_' . $aRow['staffid'] . '" data-id="' . $aRow['staffid'] . '" ' . $checked . '>
                <label class="onoffswitch-label" for="c_' . $aRow['staffid'] . '"></label>
            </div>';

            // For exporting
            $_data .= '<span class="hide">' . ($checked == 'checked' ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';
        } elseif ($aColumns[$i] == 'firstname') {
            $_data = '<a href="' . admin_url('staff/profile/' . $aRow['staffid']) . '">' . staff_profile_image($aRow['staffid'], [
                'staff-profile-image-small',
                ]) . '</a>';
            

                $_data .= ' <a href="' . admin_url('staff/member/' . $aRow['staffid']) . '">' . $aRow['firstname'] . ' ' . $aRow['second_name']  . ' ' . $aRow['third_name']  . ' ' . $aRow['lastname'] . '</a>';

                $_data .= '<div class="row-options">';
                $_data .= '<a href="' . admin_url('staff/member/' . $aRow['staffid']) . '">' . _l('view') . '</a>';
            if($ci->app_modules->is_active('hr'))
                $_data .= ' | <a class="text-success" href="' . admin_url('hr/general/general/' . $aRow['staffid']) . '?group=basic_information">' . _l('details') . '</a>';

            if (($has_permission_delete && ($has_permission_delete && !is_admin($aRow['staffid']))) || is_admin()) {
                if ($has_permission_delete && $output['iTotalRecords'] > 1 && $aRow['staffid'] != get_staff_user_id()) {
                    $_data .= ' | <a href="#" onclick="delete_staff_member(' . $aRow['staffid'] . '); return false;" class="text-danger">' . _l('delete') . '</a>';
                }
            }

            $_data .= '</div>';
        } elseif ($aColumns[$i] == 'email') {
            $_data = '<a href="mailto:' . $_data . '">' . $_data . '</a>';
        } else {
            if (strpos($aColumns[$i], 'date_picker_') !== false) {
                $_data = (strpos($_data, ' ') !== false ? _dt($_data) : _d($_data));
            }
        }
        $row[] = $_data;
    }
//    if($ci->app_modules->is_active('branches')){
//        $row[] = $aRow['branch_id'];
//    }

    $row['DT_RowClass'] = 'has-row-options';

    $row = hooks()->apply_filters('staffs_table_row_data', $row, $aRow);

    $staffid = $aRow['staffid'];
    $output['aaData'][] = $row;
}
