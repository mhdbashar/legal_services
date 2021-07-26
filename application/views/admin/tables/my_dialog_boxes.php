<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id',
    'title',
    'desc_ar',
    'desc_en',
    'page_url',
    'active',
];
$sIndexColumn = 'id';
$where = [];
$join = [];
$sTable = db_prefix() . 'my_dialog_boxes';
$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where);
$output = $result['output'];
$rResult = $result['rResult'];
$i = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $i;
    $_data = $aRow['title'];
    $_data .= '<div class="row-options">';
    $_data .= '<a href="#" data-toggle="modal" data-target="#edit' . $aRow['id'] . '">' . _l('edit') . '</a>';
    $_data .= ' | <a href="' . admin_url('dialog_boxes/remove/'.$aRow["id"]).'"  class="text-danger _delete">' . _l('delete') . '</a>';
    $_data .= '</div>';
    $row[] = $_data;
    $row[] = $aRow['desc_ar'];
    $row[] = $aRow['desc_en'];
    $row[] = $aRow['page_url'];
    $row['DT_RowClass'] = 'has-row-options';
    $onoffswitch = '<td>';
    $onoffswitch .= '<div class="onoffswitch">';
    $active = $aRow["active"] == 1 ? 'checked' : '';
    $onoffswitch .= '<input type="checkbox" name="is_primary" class="onoffswitch-checkbox" onchange="active(this.id)" id="' . $aRow["id"] . '" value="' . $aRow["active"] . '" data-id="' . $aRow["id"] . '" ' . $active . '>';
    $onoffswitch .= '<label class="onoffswitch-label" for="' . $aRow["id"] . '"></label>';
    $onoffswitch .= '</div>';
    $onoffswitch .= '</td>';
    $row[] = $onoffswitch;
    $_data1 = '<script type="text/javascript">';
    $_data1 .= ' $(function(){';
    $_data1 .= "_validate_form($('#edit-dialog-form".$aRow['id']."'),{title:'required',desc_ar:'required',desc_en:'required',page_url:'required'});";
    $_data1 .= '});';
    $_data1 .= '</script>';
    $_data1 .= '<div class="modal fade" id="edit'.$aRow['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
    $_data1 .= '<div class="modal-dialog" role="document">';
    $_data1 .= '<div class="modal-content">';
    $_data1 .= '  <div class="modal-header">';
    $_data1 .= ' <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    $_data1 .= '   <h4 class="modal-title" id="myModalLabel">';
    $_data1 .= '   <span class="add-title">' . _l('edit_dialog_box') . '</span>';
    $_data1 .= '  </h4>';
    $_data1 .= ' </div>';
    $_data1 .= form_open(admin_url('dialog_boxes/edit/' . $aRow['id']), array('id' => 'edit-dialog-form'.$aRow['id']));
    $_data1 .= ' <div class="modal-body">';
    $_data1 .= ' <div class="row">';
    $_data1 .= '    <div class="col-md-12">';
    $_data1 .= render_input('title', 'title', $aRow['title']);
    $_data1 .= '  </div>';
    $_data1 .= '   <div class="col-md-6">';
    $_data1 .= render_textarea('desc_ar', 'desc_ar', $aRow['desc_ar']);
    $_data1 .= '  </div>';
    $_data1 .= '<div class="col-md-6">';
    $_data1 .= render_textarea('desc_en', 'desc_en', $aRow['desc_en']);
    $_data1 .= ' </div>';
    $_data1 .= ' <div class="col-md-12">';
    $_data1 .= '  <div class="form-group">';
    $_data1 .= '   <label for="bs_column"><span><i class="fa fa-question-circle" data-toggle="tooltip" data-title="' . _l('link_for_page') . '"></i></span> ' . _l('link') . '</label>';
    $dir = is_rtl(true) ? 'direction: ltr' : 'direction: rtl';
    $_data1 .= '<div class="input-group" style="' . $dir . '">';
    $_data1 .= '<span class="input-group-addon">' . base_url() . '</span>';
    $_data1 .= '<input type="text" class="form-control" name="page_url" id="page_url" value="' . $aRow['page_url'] . '">';
    $_data1 .= '</div>';
    $_data1 .= '</div>';
    $_data1 .= '   </div>';
    $_data1 .= '   </div>';
    $_data1 .= '   </div>';
    $_data1 .= '  <div class="modal-footer">';
    $_data1 .= '<button group="button" class="btn btn-default" data-dismiss="modal">' . _l('close') . '</button>';
    $_data1 .= ' <button group="submit" class="btn btn-info">' . _l('submit') . '</button>';
    $_data1 .= '</div>';
    $_data1 .= form_close();
    $_data1 .= '</div>';
    $_data1 .= '</div>';
    $_data1 .= '</div>';
    $row[] = $_data1;
    $output['aaData'][] = $row;
    $i++;
}