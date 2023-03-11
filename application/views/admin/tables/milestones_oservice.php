<?php defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'name',
    'due_date',
];
$sIndexColumn = 'id';
$sTable       = db_prefix().'milestones';
$where        = [
    'AND rel_sid=' . $project_id,
    'AND rel_stype=' ."'". $slug. "'" ,
];
$result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, [
    'id',
    'milestone_order',
    'description',
    'description_visible_to_customer',
]);
$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = [];

    $nameRow = $aRow['name'];

    if (staff_can('edit_milestones', 'projects')) {
        $nameRow = '<a href="#" onclick="edit_milestone(this,' . $aRow['id'] . '); return false" data-name="' . $aRow['name'] . '" data-due_date="' . _d($aRow['due_date']) . '" data-order="' . $aRow['milestone_order'] . '" data-description="' . htmlspecialchars(clear_textarea_breaks($aRow['description'])) . '" data-description-visible-to-customer="' . $aRow['description_visible_to_customer'] . '">' . $nameRow . '</a>';
    }

    if (staff_can('delete_milestones', 'projects')) {
        $nameRow .= '<div class="row-options">';
        $nameRow .= '<a href="' . admin_url('legalservices/other_services/delete_milestone/' . $ServID . '/' . $project_id . '/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
        $nameRow .= '</div>';
    }

    $row[] = $nameRow;

    $dateRow = _d($aRow['due_date']);

    if (date('Y-m-d') > $aRow['due_date'] && total_rows(db_prefix() . 'tasks', [
                'milestone' => $aRow['id'],
                'status !=' => 5,
                'rel_id' => $project_id,
                'rel_type' => "$slug",
                ]) > 0) {
        $dateRow .= ' <span class="label label-danger mleft5 inline-block">' . _l('project_milestone_duedate_passed') . '</span>';
    }

    $row[] = $dateRow;

    $row[] = clear_textarea_breaks($aRow['description']);

    $row['DT_RowClass'] = 'has-row-options';

    $output['aaData'][] = $row;
}
