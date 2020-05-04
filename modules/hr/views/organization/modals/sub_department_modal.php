<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_sub_department" tabindex="-1" role="dialog" aria-labelledby="update_sub_department" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/organization/update_sub_department'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('sub_department_name','sub_department_name', '', 'text', ['required' => 'required']); ?>
                    </div>
                </div>
            <?php  if(true){  ?>
                <div class="form-group">
                    <label for="branch_id" class="control-label"><?php echo _l('branch') ?></label>
                    <select class="form-control" id="a_branch_id" name="branch_id" placeholder="<?php echo _l('branch') ?>" aria-invalid="false">
                        <option></option>
                    <?php foreach ($branches as $value) { ?>
                        <option value="<?php echo $value['key'] ?>"><?php echo $value['value'] ?></option>
                    <?php } ?>
                    </select>     
                </div>
            <?php } ?>
                <div class="form-group">
                    <label for="department_id" class="control-label"><?php echo _l('department') ?></label>
                    <select class="form-control" id="a_department_id" name="department_id" placeholder="<?php echo _l('department') ?>" aria-invalid="false">
                        <option></option>
                    </select>     
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

<div class="modal fade" id="add_sub_department" tabindex="-1" role="dialog" aria-labelledby="add_sub_department" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/organization/add_sub_department'),array('id'=>'form_transout')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('sub_department_name','sub_department_name', '', 'text', ['required' => 'required']); ?>
                    </div>
                </div>
            <?php  if(true){  ?>
                <div class="form-group">
                    <label for="branch_id" class="control-label"><?php echo _l('branch') ?></label>
                    <select class="form-control" id="branch_id" name="branch_id" placeholder="<?php echo _l('branch') ?>" aria-invalid="false">
                        <option></option>
                    <?php foreach ($branches as $value) { ?>
                        <option class="department_id" value="<?php echo $value['key'] ?>"><?php echo $value['value'] ?></option>
                    <?php } ?>
                    </select>     
                </div>
            <?php } ?>
                <div class="form-group">
                    <label for="department_id" class="control-label"><?php echo _l('department') ?></label>
                    <select class="form-control" id="department_id" name="department_id" placeholder="<?php echo _l('department') ?>" aria-invalid="false">
                        <option></option>
                    </select>     
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
            url : "<?php echo site_url('hr/organization/json_sub_department') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);

                $('[name="sub_department_name"]').val(data.sub_department_name);

                $.get(admin_url + 'hr/organization/get_departments_by_branch_id/' + data.branch.branch_id, function(response) {
                    if (response.success == true) {
                        $('#a_department_id').empty();
                        $('#a_department_id').append($('<option>', {
                            value: '',
                            text: ''
                        }));
                        for(let i = 0; i < response.data.length; i++) {
                            let key = response.data[i].key;
                            let value = response.data[i].value;
                            let select = false;
                            if(data.department.departmentid == key)
                                select = true;
                            $('#a_department_id').append($('<option>', {
                                value: key,
                                text: value,
                                selected: select
                            }));
                            $('#a_department_id').selectpicker('refresh');
                        }
                    } else {
                        alert_float('danger', response.message);
                    }
                }, 'json');

                
                $('[name="department_id"]').val(data.department.departmentid);
                $('[name="branch_id"]').val(data.branch.branch_id);
                $('#a_department_id').selectpicker('refresh');


                $('#update_sub_department').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
