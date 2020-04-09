<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if(has_permission('projects','','create')){ ?>
    <a href="#" class="btn btn-info" onclick="new_proc();return false;"><?php echo _l('add_legal_procedures'); ?></a>
<?php } ?>
<a href="#" class="btn btn-default" onclick="milestones_case_switch_view(<?php //echo $ServID; ?>, '<?php //echo $service->slug; ?>'); return false;"><i class="fa fa-th-list"></i></a>
<?php /*($milestones_found) { ?>
    <div id="kanban-params" class="pull-right">
        <div class="checkbox">
            <input type="checkbox" value="yes" id="exclude_completed_tasks" name="exclude_completed_tasks"<?php if($milestones_exclude_completed_tasks){echo ' checked';} ?> onclick="window.location.href = '<?php echo admin_url('Case/view/'.$ServID.'/'.$project->id.'?group=project_milestones&exclude_completed='); ?>'+(this.checked ? 'yes' : 'no')">
            <label for="exclude_completed_tasks"><?php echo _l('exclude_completed_tasks') ?></label>
        </div>
        <div class="clearfix"></div>
        <?php echo form_hidden('project_id',$project->id); ?>
    </div>
    <div class="clearfix"></div>
<?php } ?>
<?php if($milestones_found){ ?>
    <div class="case-milestones-kanban">
        <div class="kan-ban-tab" id="kan-ban-tab" style="overflow:auto;">
            <div class="row">
                <div class="container-fluid">
                    <div id="kan-ban"></div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-info mtop15 no-mbot">
        <?php echo _l('no_milestones_found'); ?>
    </div>
<?php }*/ ?>
<!--<div id="milestones-table" class="hide mtop25">-->
<!--    --><?php
//    $table_attributes['data-slug'] = $service->slug;
//    render_datatable(array(
//        _l('milestone_name'),
//        _l('milestone_due_date'),
//    ),'milestones_case', [], $table_attributes); ?>
<!--</div>-->


<div class="modal fade" id="legal_proc" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('LegalServices'),array('id'=>'milestone_form')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('edit_legal_procedures'); ?></span>
                    <span class="add-title"><?php echo _l('add_legal_procedures'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_hidden('rel_id',$project->id); ?>
                        <?php echo form_hidden('rel_type',$service->slug); ?>
                        <div id="additional_milestone"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cat_id" class="control-label"><?php echo _l('legal_procedure'); ?></label>
                                    <select class="form-control custom_select_arrow" id="cat_id" onchange="get_subcat()" name="cat_id"
                                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                        <?php foreach ($category as $row): ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="subcat_id" class="control-label"><?php echo _l('sub_legal_procedures'); ?></label>
                                    <select class="form-control custom_select_arrow" id="subcat_id" name="subcat_id"
                                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option selected disabled></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php echo render_input('name','milestone_name'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->