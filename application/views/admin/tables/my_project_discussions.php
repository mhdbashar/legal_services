<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'subject',
    'last_activity',
    '(SELECT COUNT(*) FROM '.db_prefix().'my_sessiondiscussioncomments WHERE discussion_id = '.db_prefix().'my_sessiondiscussions.id AND discussion_type="regular")',
    'show_to_customer',
    ];
$sIndexColumn = 'id';
$sTable       = db_prefix().'my_sessiondiscussions';
$where        = [];
if (isset($session_id)):
    array_push($where, 'AND session_id = '.$session_id);
endif;
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, [
    'id',
    'description',
    ]);
$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'subject') {
            $_data = '<a href="' . base_url() .'session/session_info/session_detail/' . $session_id . '?tab=discussion&discussion_id=' . $aRow['id'] . '">' . $_data . '</a>';
            if (has_permission('projects', '', 'edit') || has_permission('projects', '', 'delete')) {
                $_data .= '<div class="row-options">';
                if (has_permission('projects', '', 'edit')) {
                    $_data .= icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#edit_discussion', 'onclick' => 'edit_session_json(' . $aRow['id'] . ')']);
                }
                if (has_permission('projects', '', 'delete')) {
                     $_data .= icon_btn(base_url() .'session/session_info/delete_discussion/' . $aRow['id'], 'remove', 'btn-danger _delete');
                }
                
                $_data .= '</div>';
            }
        } elseif ($aColumns[$i] == 'show_to_customer') {
            if ($_data == 1) {
                $_data = _l('project_discussion_visible_to_customer_yes');
            } else {
                $_data = _l('project_discussion_visible_to_customer_no');
            }
        } elseif ($aColumns[$i] == 'last_activity') {
            if (!is_null($_data)) {
                $_data = '<span class="text-has-action" data-toggle="tooltip" data-title="' . _dt($_data) . '">' . time_ago($_data) . '</span>';
            } else {
                $_data = _l('project_discussion_no_activity');
            }
        }
        $row[] = $_data;
    }

    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
