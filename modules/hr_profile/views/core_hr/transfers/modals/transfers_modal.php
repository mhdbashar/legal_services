<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_transfer" tabindex="-1" role="dialog" aria-labelledby="update_transfer" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr_profile/core_hr/update_transfer'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
<!--                --><?php // if($this->app_modules->is_active('branches')){  ?>
<!--                    <div class="col-md-12">-->
<!--                        <div class="form-group">-->
<!--                            <label for="branch_id" class="control-label">--><?php //echo _l('branch') ?><!--</label>-->
<!--                            <select required="required" class="form-control" id="branch_id" name="branch_id" placeholder="--><?php //echo _l('branch') ?><!--" aria-invalid="false">-->
<!--                                <option></option>-->
<!--                            --><?php //foreach ($branches as $value) { ?>
<!--                                <option value="--><?php //echo $value['key'] ?><!--">--><?php //echo $value['value'] ?><!--</option>-->
<!--                            --><?php //} ?>
<!--                            </select>     -->
<!--                        </div>-->
<!--                    </div>-->
<!--                --><?php //} ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="staff_id" class="control-label"><?php echo _l('staff') ?></label>
                            <select required="required" class="form-control" id="e_staff_id" name="staff_id" placeholder="<?php echo _l('staff') ?>" aria-invalid="false">
                                <option></option>
                                <?php
                                // if(!$this->app_modules->is_active('branches')){
                                 foreach ($staffes as $value) { ?>
                                    <option value="<?php echo $value['staffid'] ?>">
                                        <?php echo $value['firstname'] ?>
                                    </option>
                                <?php } ?>
                            </select>     
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('transfer_date','transfer_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','hr_description', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="to_department" class="control-label"><?php echo _l('to_department') ?></label>
                            <select required="required" required="required" class="form-control" id="department_id" name="to_department" placeholder="<?php echo _l('to_department') ?>" aria-invalid="false">
                                <option></option>
                                <?php foreach($departments as $department){ ?>
                                    <option value="<?php echo $department['departmentid'] ?>"><?php echo $department['name']; ?></option>
                                <?php } ?>
                            </select>     
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="to_sub_department" class="control-label"><?php echo _l('to_sub_department') ?></label>
                            <select required="required" class="form-control" id="sub_department_id" name="to_sub_department" placeholder="<?php echo _l('to_department') ?>" aria-invalid="false">
<option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status" class="control-label"><?php echo _l('hr_status') ?></label>
                            <select required="required" class="form-control" id="status" name="status" placeholder="<?php echo _l('status') ?>" aria-invalid="false">
                                <option value="Pending">Pending</option>
                                <option value="Accepted">Accepted</option>
                                <option value="Rejected">Rejected</option>
                            </select>     
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
                <button onclick="required_file()" group="submit" class="btn btn-info"><?php echo _l("submit"); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_transfer" tabindex="-1" role="dialog" aria-labelledby="add_transfer" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr_profile/core_hr/add_transfer'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('status', 'Pending'); ?>
            <div class="modal-body">
                <div class="row">
<!--                --><?php // if($this->app_modules->is_active('branches')){  ?>
<!--                    <div class="col-md-12">-->
<!--                        <div class="form-group">-->
<!--                            <label for="branch_id" class="control-label">--><?php //echo _l('branch') ?><!--</label>-->
<!--                            <select required="required" class="form-control" id="a_branch_id" name="branch_id" placeholder="--><?php //echo _l('branch') ?><!--" aria-invalid="false">-->
<!--                                <option></option>-->
<!--                            --><?php //foreach ($branches as $value) { ?>
<!--                                <option value="--><?php //echo $value['key'] ?><!--">--><?php //echo $value['value'] ?><!--</option>-->
<!--                            --><?php //} ?>
<!--                            </select>     -->
<!--                        </div>-->
<!--                    </div>-->
<!--                --><?php //} ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="staff_id" class="control-label"><?php echo _l('staff') ?></label>
                            <select required="required" class="form-control" id="staff_id" name="staff_id" placeholder="<?php echo _l('staff') ?>" aria-invalid="false">
                                <option></option>
                                <?php
                                //if(!$this->app_modules->is_active('branches')){
                                 foreach ($staffes as $value) { ?>
                                    <option value="<?php echo $value['staffid'] ?>">
                                        <?php echo $value['firstname'] ?>
                                    </option>
                                <?php } ?>
                            </select>     
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('transfer_date','transfer_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','hr_description', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="to_department" class="control-label"><?php echo _l('to_department') ?></label>
                            <select required="required" class="form-control" id="a_department_id" name="to_department" placeholder="<?php echo _l('to_department') ?>" aria-invalid="false">
                                <option></option>
                                <?php foreach($departments as $department){ ?>
                                    <option value="<?php echo $department['departmentid'] ?>"><?php echo $department['name']; ?></option>
                                <?php } ?>
                            </select>     
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="to_sub_department" class="control-label"><?php echo _l('to_sub_department') ?></label>
                            <select required="required" class="form-control" id="a_sub_department_id" name="to_sub_department" placeholder="<?php echo _l('to_department') ?>" aria-invalid="false">
                                <option></option>
                            </select>     
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
                <button onclick="required_file()" group="submit" class="btn btn-info"><?php echo _l("submit"); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
function required_file() {
  var x = document.getElementById("myFile").required;
}
</script>

<script>

    
    function edit(id){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hr_profile/core_hr/json_transfer') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);
                
                $('[name="transfer_date"]').val(data.transfer_date);
                
                $('[name="to_department"]').val(data.to_department);

                $('[name="description"]').val(data.description);

                $('[name="to_sub_department"]').val(data.to_sub_department);


                $.get(admin_url + 'hr_profile/organization/get_sub_departments/' + data.department.departmentid, function(response) {
                    if (response.success == true) {
                        $('#sub_department_id').empty();
                        $('#sub_department_id').append($('<option>', {
                            value: '',
                            text: ''
                        }));
                        for(let i = 0; i < response.data.length; i++) {
                            let key = response.data[i].key;
                            let value = response.data[i].value;
                            let select = false;
                            if(data.sub_department.id == key)
                                select = true;
                            $('#sub_department_id').append($('<option>', {
                                value: key,
                                text: value,
                                selected: select
                            }));
                            $('#sub_department_id').selectpicker('refresh');
                        }
                    } else {
                        alert_float('danger', response.message);
                    }
                }, 'json');

                $('[name="branch_id"]').val(data.branch_id);

                $('[name="status"]').val(data.status);

                $('[id="e_staff_id"]').val(data.staff_id);

                $('[id="department_id"]').val(data.to_department);



                $('#update_transfer').modal('show'); // show bootstrap modal when complete loaded

                if (!data.has_extra_info){
                    $('#update_transfer').modal('hide');
                    console.log('You Should Add Staff To HR System');
                    alert('You Should Add Staff To HR System');
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
