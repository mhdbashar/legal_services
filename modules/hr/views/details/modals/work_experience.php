<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_work_experience" tabindex="-1" role="dialog" aria-labelledby="update_work_experience" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/general/update_work_experience'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <?php echo form_hidden('staff_id', $staff_id); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('company_name','company_name', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" app-field-wrapper="post_hr">
                            <label for="post_hr" class="control-label"><?php echo _l('designation') ?></label>
                            <input type="text" id="post_hr" name="post" class="form-control" required="required" value="">
                        </div>                    
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('from_date','from_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('to_date','to_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','hr_description', '', ['required' => 'required']); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
                <button group="submit" class="btn btn-info"><?php echo _l("submit"); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_work_experience" tabindex="-1" role="dialog" aria-labelledby="add_work_experience" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/general/add_work_experience'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('staff_id', $staff_id); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('company_name','company_name', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" app-field-wrapper="post_hr">
                            <label for="post_hr" class="control-label"><?php echo _l('designation') ?></label>
                            <input type="text" id="post_hr" name="post" class="form-control" required="required" value="">
                        </div>                    
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('from_date','from_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('to_date','to_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','hr_description', '', ['required' => 'required']); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
                <button group="submit" class="btn btn-info"><?php echo _l("submit"); ?></button>
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
            url : "<?php echo site_url('hr/general/json_work_experience') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);
                
                $('[name="company_name"]').val(data.company_name);

                $('[name="post"]').val(data.post);

                $('[name="from_date"]').val(data.from_date);
                
                $('[name="to_date"]').val(data.to_date);

                $('[name="description"]').val(data.description);

                $('#update_work_experience').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
