<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_list"><?php echo _l('add_procedures_list'); ?></a>
<div class="modal fade" id="add_list" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('LegalServices/legal_procedures/add_list'),array('id'=>'add_list_form')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="add-title"><?php echo _l('add_procedures_list'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php echo form_hidden('rel_id',$project->id); ?>
                    <?php echo form_hidden('rel_type',$service->slug); ?>
                    <div class="col-md-12">
                        <?php
                        echo render_select_with_input_group('cat_id',isset($category) ? $category : array(),array('id','name'),'legal_procedure','','<a href="'.admin_url("LegalServices/legal_procedures").'" target="_blank"><i class="fa fa-plus"></i></a>');
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                </div>
            </div>
            <!-- /.modal-content -->
            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /.modal -->
<div class="row master mtop25">
    <?php
    if(!empty($procedure_lists)):
    foreach ($procedure_lists as $list): ?>
    <div class="col-md-3 cols">
    <div class="panel-heading">
        <span class="bold heading"><?php echo $list['cat_name']; ?></span>
        <a href="#" data-toggle="modal" data-target="#add_procedures<?php echo $list['id']; ?>" class="pull-right text-dark" onclick="get_subcat(<?php echo $list['id']; ?>,<?php echo $list['cat_id']; ?>)">
            <i class="fa fa-plus" data-toggle="tooltip" title="<?php echo _l('add_legal_procedures'); ?>"></i>
        </a>
    </div>
    <?php
    $procedures = legal_procedure_by_list_id($list['id']);
    if(!empty($procedures)):
    foreach ($procedures as $proc): ?>
    <div class="card">
        <a href="<?php echo admin_url("LegalServices/legal_procedures/delete_contract/".$proc['reference_id']); ?>" class="text-danger _delete pull-right" data-toggle="tooltip" title="<?php echo _l('delete'); ?>"><i class="fa fa-trash"></i></a>
        <a href="<?php echo admin_url("LegalServices/legal_procedures/procedure_text/".$proc['reference_id']); ?>" data-toggle="tooltip" title="<?php echo _l('view'); ?>">
        <?php echo $proc['subcat_name']; ?>
        </a>
        <br><br>
        <small>
            <b><?php echo _d($proc['datecreated']); ?></b>
        </small>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
    </div>
    <div class="modal fade" id="add_procedures<?php echo $list['id']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <?php echo form_open(admin_url('LegalServices/legal_procedures/add_legal_procedure'),array('id'=>'add_procedure_form')); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <span class="add-title"><?php echo _l('add_legal_procedures'); ?></span>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_hidden('list_id',$list['id']); ?>
                            <div class="form-group">
                                <label for="cat_id" class="control-label"><?php echo _l('legal_procedure'); ?></label>
                                <select class="form-control custom_select_arrow" id="cat_id" name="cat_id"
                                        placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>" disabled>
                                    <option selected disabled></option>
                                    <?php foreach ($category as $row): ?>
                                        <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $list['cat_id'] ? 'selected' : ''; ?>><?php echo $row['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 div_subcat<?php echo $list['id']; ?>">
                            <?php
                            echo render_select_with_input_group('subcat_id',array(),array('id','name'),'sub_legal_procedures','','<a href="'.admin_url("LegalServices/legal_procedures").'" target="_blank"><i class="fa fa-plus"></i></a>',array('required' => 'required'));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                </div>
            </div>
            <!-- /.modal-content -->
            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <?php endforeach;
    else: ?>
    <div class="alert alert-info mtop15 no-mbot">
        <?php echo _l('no_procedure_list_found'); ?>
    </div>
    <?php endif; ?>
</div>







