<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_promotion" tabindex="-1" role="dialog" aria-labelledby="update_promotion" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/core_hr/update_promotion'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
                <?php  if($this->app_modules->is_active('branches')){  ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="branch_id" class="control-label"><?php echo _l('branch') ?></label>
                            <select required="required" class="form-control" id="branch_id" name="branch_id" placeholder="<?php echo _l('branch') ?>" aria-invalid="false">
                                <option></option>
                            <?php foreach ($branches as $value) { ?>
                                <option value="<?php echo $value['key'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>     
                        </div>
                    </div>
                <?php } ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="staff_id" class="control-label"><?php echo _l('staff') ?></label>
                            <select required="required" class="form-control staff" id="e_staff_id" name="staff_id" placeholder="<?php echo _l('staff') ?>" aria-invalid="false">
                                <option></option>
                                <?php
                                if(!$this->app_modules->is_active('branches')){
                                 foreach ($staffes as $value) { ?>
                                    <option value="<?php echo $value['staffid'] ?>">
                                        <?php echo $value['firstname'] ?>
                                    </option>
                                <?php }} ?>
                            </select>     
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="designation" class="control-label"><?php echo _l('designation') ?></label>
                            <select required="required" class="form-control" id="e_designation_id" name="designation" placeholder="<?php echo _l('designation') ?>" aria-invalid="false">
                            </select>     
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('promotion_title','promotion_title', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('promotion_date','promotion_date', '', ['required' => 'required']); ?>
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

<div class="modal fade" id="add_promotion" tabindex="-1" role="dialog" aria-labelledby="add_promotion" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/core_hr/add_promotion'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
                <?php  if($this->app_modules->is_active('branches')){  ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="branch_id" class="control-label"><?php echo _l('branch') ?></label>
                            <select required="required" class="form-control" id="a_branch_id" name="branch_id" placeholder="<?php echo _l('branch') ?>" aria-invalid="false">
                                <option></option>
                            <?php foreach ($branches as $value) { ?>
                                <option value="<?php echo $value['key'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>     
                        </div>
                    </div>
                <?php } ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="staff_id" class="control-label"><?php echo _l('staff') ?></label>
                            <select required="required" class="form-control" id="staff_id" name="staff_id" placeholder="<?php echo _l('staff') ?>" aria-invalid="false">
                                <option></option>
                                <?php
                                if(!$this->app_modules->is_active('branches')){
                                 foreach ($staffes as $value) { ?>
                                    <option value="<?php echo $value['staffid'] ?>">
                                        <?php echo $value['firstname'] ?>
                                    </option>
                                <?php }} ?>
                            </select>     
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="designation" class="control-label"><?php echo _l('designation') ?></label>
                            <select required="required" class="form-control staff" id="designation_id" name="designation" placeholder="<?php echo _l('designation') ?>" aria-invalid="false">
                            </select>     
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('promotion_title','promotion_title', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('promotion_date','promotion_date', '', ['required' => 'required']); ?>
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
            url : "<?php echo site_url('hr/core_hr/promotion_json') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);
                
                $('[name="promotion_title"]').val(data.promotion_title);
                
                $('[name="promotion_date"]').val(data.promotion_date);

                $('[name="description"]').val(data.description);

                $('[name="branch_id"]').val(data.branch_id);

                $.get(admin_url + 'hr/organization/get_designations_by_staff_id/' + data.staff_id, function(response) {
                    if (response.success == true) {
                        $('#e_designation_id').empty();
                        $('#e_designation_id').append($('<option>', {
                            value: '',
                            text: ''
                        }));
                        for(let i = 0; i < response.data.length; i++) {
                            let key = response.data[i].key;
                            let value = response.data[i].value;
                            let select = false;
                            if(data.designation.id == key)
                                select = true;
                            console.log(data.designation.id + "  " + key);
                            $('#e_designation_id').append($('<option>', {
                                value: key,
                                text: value,
                                selected: select
                            }));
                            $('#e_designation_id').selectpicker('refresh');
                        }
                    } else {
                        alert_float('danger', response.message);
                    }
                }, 'json');

                $.get(admin_url + 'hr/organization/get_staffs_by_branch_id/' + data.branch_id, function(response) {
                    if (response.success == true) {
                        $('#e_staff_id').empty();
                        $('#e_staff_id').append($('<option>', {
                            value: '',
                            text: ''
                        }));
                        for(let i = 0; i < response.data.length; i++) {
                            let key = response.data[i].key;
                            let value = response.data[i].value;
                            let select = false;
                            if(data.staff_id == key)
                                select = true;
                            $('#e_staff_id').append($('<option>', {
                                value: key,
                                text: value,
                                selected: select
                            }));
                            $('#e_staff_id').selectpicker('refresh');
                        }
                    } else {
                        alert_float('danger', response.message);
                    }
                }, 'json');

                //$('[name="staff_id"]').val(data.staff_id);



                $('#update_promotion').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
