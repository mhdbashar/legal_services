<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_overtime_request" tabindex="-1" role="dialog" aria-labelledby="update_overtime_request" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/timesheet/update_overtime_request'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
                <?php  if(true){  ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="branch_id" class="control-label"><?php echo _l('branch') ?></label>
                            <select required="required" class="form-control" id="branch_id" placeholder="<?php echo _l('branch') ?>" aria-invalid="false">
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
                            <select required="required" class="form-control" id="e_staff_id" name="staff_id" placeholder="<?php echo _l('staff') ?>" aria-invalid="false">
                                <option></option>
                            </select>     
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('date','date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <label for="in_time" class="control-label"><?php echo _l('in_time') ?></label>
                        <input type="time" id="in_time" name="in_time" required="required" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="out_time" class="control-label"><?php echo _l('out_time') ?></label>
                        <input type="time" id="out_time" name="out_time" required="required" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('reason','reason', '', ['required' => 'required']); ?>
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

<div class="modal fade" id="add_overtime_request" tabindex="-1" role="dialog" aria-labelledby="add_overtime_request" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/timesheet/add_overtime_request'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('status', 'Pending'); ?>
            <div class="modal-body">
                <div class="row">
        <?php if (has_permission('hr', '', 'view')){ ?>
                <?php  if(true){  ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="branch_id" class="control-label"><?php echo _l('branch') ?></label>
                            <select required="required" class="form-control" id="a_branch_id" placeholder="<?php echo _l('branch') ?>" aria-invalid="false">
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
                            </select>     
                        </div>
                    </div>
        <?php 
            }else
                echo form_hidden('staff_id', get_staff_user_id());
         ?>
                    <div class="col-md-12">
                        <?php echo render_date_input('date','date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <label for="in_time" class="control-label"><?php echo _l('in_time') ?></label>
                        <input type="time" id="in_time" name="in_time" required="required" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="out_time" class="control-label"><?php echo _l('out_time') ?></label>
                        <input type="time" id="out_time" name="out_time" required="required" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('reason','reason', '', ['required' => 'required']); ?>
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
            url : "<?php echo site_url('hr/timesheet/json_overtime_request') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);
                
                $('[name="date"]').val(data.date);
                
                $('[name="in_time"]').val(data.in_time);

                $('[name="out_time"]').val(data.out_time);

                $('[name="reason"]').val(data.reason);

                $('[id="branch_id"]').val(data.branch_id);

                $('[name="status"]').val(data.status);

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



                $('#update_overtime_request').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
