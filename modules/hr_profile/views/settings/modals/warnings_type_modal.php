<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_type" tabindex="-1" role="dialog" aria-labelledby="update_type" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo "Edit"; ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr_profile/update_type_warnings'),array('id'=>'form_transout', 'method'=>'post')); ?>
            <div class="modal-body">
<!--                <input type="hidden" name="old" id="old" value="">-->
                <input type="hidden" name="id" id="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('new',_l('warnings'),'','text',['id' => 'new']); ?>
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

<div class="modal fade" id="add_relation_type" tabindex="-1" role="dialog" aria-labelledby="add_relation_type" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo "Add"; ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr_profile/add_warnings_type'),array('id'=>'form_transout')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('name_warnings',_l('warnings')); ?>

                        <!--                        --><?php //echo form_hidden('id'); ?>
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
<script>
    function edit(id){
        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#id').val(id);
    }



</script>
