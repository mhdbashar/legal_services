<div class="modal fade" id="add_bank" tabindex="-1" role="dialog" aria-labelledby="add_bank" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo "Add"; ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hrm/details/add_bank'),array('id'=>'form_transout')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('bank_name','Bank Name', '', 'text',  ['required' => 'required']); ?>
                        <?php echo render_input('account_name','Account Name', '', 'text',  ['required' => 'required']); ?>
                        <?php echo render_input('routing_number','Routing Number', '', 'number', ['required' => 'required']); ?>
                        <?php echo render_input('account_number','Account Number', '', 'number', ['required' => 'required']); ?>
                        <input aria-hidden="true" type="hidden" class="form-control" value="<?php echo $staff_id ?>" name="staff_id">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo 'Close'; ?></button>
                <button group="submit" class="btn btn-info"><?php echo 'Submit'; ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_bank" tabindex="-1" role="dialog" aria-labelledby="edit_city" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo "Edit"; ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hrm/details/edit_bank'),array('id'=>'form_transout')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('bank_name','Bank Name', '', 'text',  ['required' => 'required']); ?>
                        <?php echo render_input('account_name','Account Name', '', 'text',  ['required' => 'required']); ?>
                        <?php echo render_input('routing_number','Routing Number', '', 'number', ['required' => 'required']); ?>
                        <?php echo render_input('account_number','Account Number', '', 'number', ['required' => 'required']); ?>
                        <input aria-hidden="true" type="hidden" class="form-control" value="<?php echo $id ?>" name="id">
                        <input aria-hidden="true" type="hidden" class="form-control" value="<?php echo $staff_id ?>" name="staff_id">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo 'Close'; ?></button>
                <button group="submit" class="btn btn-info"><?php echo 'Submit'; ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>