<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_leave" tabindex="-1" role="dialog" aria-labelledby="update_leave" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/timesheet/update_leave'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_textarea('leave_reason','leave_reason', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('remarks','remarks', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status" class="control-label"><?php echo _l('hr_status') ?></label>
                            <select required="required" class="form-control" id="status" name="status" placeholder="<?php echo _l('status') ?>" aria-invalid="false">
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="First Level Approved">First Level Approved</option>
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

<div class="modal fade" id="add_leave" tabindex="-1" role="dialog" aria-labelledby="add_leave" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/timesheet/add_leave'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('status', 'Pending'); ?>
            <div class="modal-body">
                <div class="row">
        <?php if (has_permission('hr', '', 'view')){ ?>
                <?php  if(true){  ?>
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
                            </select>     
                        </div>
                    </div>
        <?php 
            }else
                echo form_hidden('staff_id', get_staff_user_id());
         ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="leave_type" class="control-label"><?php echo _l('leave_type') ?></label>
                            <select required="required" class="form-control" id="leave_type" name="leave_type" placeholder="<?php echo _l('leave_type') ?>" aria-invalid="false">
                                <option></option>
                            </select>     
                        </div>
                     </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('start_date','start_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('end_date','end_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('leave_reason','leave_reason', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('remarks','remarks', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <input id="half_day?" value="true" class="" type="checkbox" name="half_day"> <?php echo _l('half_day?') ?>
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
            url : "<?php echo site_url('hr/timesheet/leave_json') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);

                $('[name="leave_reason"]').val(data.leave_reason);

                $('[name="remarks"]').val(data.remarks);

                $('[name="status"]').val(data.status);

                /*

                if(data.half_day == 1){
                    $('[name="half_day"]').prop('checked', 'true');
                    console.log(data.half_day);
                }else{
                    $('[name="half_day"]').removeAttr('checked');
                    console.log('hey');
                }

                

                $('[name="branch_id"]').val(data.branch_id);

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

                $.get(admin_url + 'hr/timesheet/get_leave_types_by_staff_id/' + data.staff_id, function(response) {
                    if (response.success == true) {
                        $('#e_leave_type').empty();
                        $('#e_leave_type').append($('<option>', {
                            value: '',
                            text: ''
                        }));
                        for(let i = 0; i < response.data.length; i++) {
                            let key = response.data[i].key;
                            let value = response.data[i].value;
                            let select = false;
                            if(data.leave_type == key)
                                select = true;
                            $('#e_leave_type').append($('<option>', {
                                value: key,
                                text: value,
                                selected: select
                            }));
                            $('#e_leave_type').selectpicker('refresh');
                        }
                    } else {
                        alert_float('danger', response.message);
                    }
                }, 'json');
                */



                $('#update_leave').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
