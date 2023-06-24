<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_allowance" tabindex="-1" role="dialog" aria-labelledby="update_allowance" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr_profile/update_allowance'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <?php echo form_hidden('staff_id', $staff_id); ?>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('tax') ?></label>
                            <select class="form-control" id="tax" name="tax" placeholder="Tax type" aria-invalid="false">
                                <option id="non-tax" value="1"><?php echo _l('non_taxable') ?></option> 
                                <option id="tax" value="2"><?php echo _l('taxable') ?></option>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('title','title', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('amount','amount', '', 'number', ['required' => 'required']); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
                <button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_allowance" tabindex="-1" role="dialog" aria-labelledby="add_allowance" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr_profile/add_allowance'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('staff_id', $staff_id); ?>
            <div class="modal-body">
                <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('tax') ?></label>
                            <select class="form-control" id="tax" name="tax" placeholder="Tax type" aria-invalid="false">
                                <option id="non-tax" value="1"><?php echo _l('non_taxable') ?></option> 
                                <option id="tax" value="2"><?php echo _l('taxable') ?></option>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('title','title', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('amount','amount', '', 'number', ['required' => 'required']); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
                <button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
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


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hr_profile/json_allowance') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);

                if(data.tax == 1){
                    $('#non-tax').attr('selected','selected');
                }

                if(data.tax == 2){
                    $('#tax').attr('selected','selected');
                }
                
                $('[name="title"]').val(data.title);

                $('[name="amount"]').val(data.amount);

                $('#update_allowance').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
