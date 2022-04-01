<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="googlesheets_save" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('googlesheets/insert_file'), array('id'=>'google-sheets-form')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="add-title"><?php echo _l('add_relation'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php   $rel_type = '';
                                     $rel_id = ''; ?>
                        <?php echo form_hidden('id', '');?>
                        <?php echo form_hidden('name', '');?>
                        <label for="rel_type" class="control-label"><?php echo _l('related_to'); ?></label>
                        <select name="rel_type" class="selectpicker" id="rel_type" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                            <option value=""></option>
                            <option value="project"
                                <?php if($this->input->get('rel_type')){if($rel_type == 'project'){echo 'selected';}} ?>><?php echo _l('project'); ?></option>
                            <option value="invoice" <?php if(isset($task) || $this->input->get('rel_type')){if($rel_type == 'invoice'){echo 'selected';}} ?>>
                                <?php echo _l('invoice'); ?>
                            </option>
                            <option value="customer"
                                <?php if(isset($task) || $this->input->get('rel_type')){if($rel_type == 'customer'){echo 'selected';}} ?>>
                                <?php echo _l('client'); ?>
                            </option>
                            <option value="estimate" <?php if(isset($task) || $this->input->get('rel_type')){if($rel_type == 'estimate'){echo 'selected';}} ?>>
                                <?php echo _l('estimate'); ?>
                            </option>
                            <option value="contract" <?php if(isset($task) || $this->input->get('rel_type')){if($rel_type == 'contract'){echo 'selected';}} ?>>
                                <?php echo _l('contract'); ?>
                            </option>
                            <option value="ticket" <?php if(isset($task) || $this->input->get('rel_type')){if($rel_type == 'ticket'){echo 'selected';}} ?>>
                                <?php echo _l('ticket'); ?>
                            </option>
                            <option value="expense" <?php if(isset($task) || $this->input->get('rel_type')){if($rel_type == 'expense'){echo 'selected';}} ?>>
                                <?php echo _l('expense'); ?>
                            </option>
                            <option value="lead" <?php if(isset($task) || $this->input->get('rel_type')){if($rel_type == 'lead'){echo 'selected';}} ?>>
                                <?php echo _l('lead'); ?>
                            </option>
                            <option value="proposal" <?php if(isset($task) || $this->input->get('rel_type')){if($rel_type == 'proposal'){echo 'selected';}} ?>>
                                <?php echo _l('proposal'); ?>
                            </option>
                            <?php
                            hooks()->do_action('task_modal_rel_type_select', ['task' => (isset($task) ? $task : 0), 'rel_type' => $rel_type]);
                            ?>
                        </select>
                        </div>
                        <div class="form-group<?php if($rel_id == ''){echo ' hide';} ?>" id="rel_id_wrapper">
                            <label for="rel_id" class="control-label"><span class="rel_id_label"></span></label>
                            <div id="rel_id_select">
                                <select name="rel_id" id="rel_id" class="ajax-sesarch" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                    <?php if($rel_id != '' && $rel_type != ''){
                                        $rel_data = get_relation_data($rel_type,$rel_id);
                                        $rel_val = get_relation_values($rel_data,$rel_type);
                                        echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


