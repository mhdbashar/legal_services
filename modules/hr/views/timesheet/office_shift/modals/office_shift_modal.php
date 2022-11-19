<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_office_shift" tabindex="-1" role="dialog" aria-labelledby="update_office_shift" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/timesheet/update_office_shift'),array('id'=>'form_transout', 'class' => 'edit_form')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
                <?php  if($this->app_modules->is_active('branches')) {  ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="branch_id" class="control-label"><?php echo _l('branch') ?></label>
                            <select required="required" name="branch_id" class="form-control" id="branch_id" placeholder="<?php echo _l('branch') ?>" aria-invalid="false">
                                <option></option>
                            <?php foreach ($branches as $value) { ?>
                                <option value="<?php echo $value['key'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>     
                        </div>
                    </div>
                <?php } ?>
                    <div class="col-md-12">
                        <?php echo render_input('shift_name','shift_name','','text',['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="saturday_in" class="control-label"><?php echo _l('saturday_in') ?></label>
                            <input type="time" id="saturday_in" name="saturday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="saturday_out" class="control-label"><?php echo _l('saturday_out') ?></label>
                            <input type="time" id="saturday_out" name="saturday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="sunday_in" class="control-label"><?php echo _l('sunday_in') ?></label>
                            <input type="time" id="sunday_in" name="sunday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="sunday_out" class="control-label"><?php echo _l('sunday_out') ?></label>
                            <input type="time" id="sunday_out" name="sunday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="monday_in" class="control-label"><?php echo _l('monday_in') ?></label>
                            <input type="time" id="monday_in" name="monday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="monday_out" class="control-label"><?php echo _l('monday_out') ?></label>
                            <input type="time" id="monday_out" name="monday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="tuesday_in" class="control-label"><?php echo _l('tuesday_in') ?></label>
                            <input type="time" id="tuesday_in" name="tuesday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="tuesday_out" class="control-label"><?php echo _l('tuesday_out') ?></label>
                            <input type="time" id="tuesday_out" name="tuesday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="wednesday_in" class="control-label"><?php echo _l('wednesday_in') ?></label>
                            <input type="time" id="wednesday_in" name="wednesday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="wednesday_out" class="control-label"><?php echo _l('wednesday_out') ?></label>
                            <input type="time" id="wednesday_out" name="wednesday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="thursday_in" class="control-label"><?php echo _l('thursday_in') ?></label>
                            <input type="time" id="thursday_in" name="thursday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="thursday_out" class="control-label"><?php echo _l('thursday_out') ?></label>
                            <input type="time" id="thursday_out" name="thursday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="friday_in" class="control-label"><?php echo _l('friday_in') ?></label>
                            <input type="time" id="friday_in" name="friday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="friday_out" class="control-label"><?php echo _l('friday_out') ?></label>
                            <input type="time" id="friday_out" name="friday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="default" class="control-label"><?php echo _l('is_default') ?></label>
                            <select required="required" name="default" class="form-control" id="default" placeholder="<?php echo _l('is_default') ?>" aria-invalid="false">
                                <option value="0"><?php echo _l('no') ?></option>
                                <option value="1"><?php echo _l('yes') ?></option>
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

<div class="modal fade" id="add_office_shift" tabindex="-1" role="dialog" aria-labelledby="add_office_shift" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/timesheet/add_office_shift'),array('id'=>'form_transout', 'class' => 'form')); ?>
            <div class="modal-body">
                <div class="row">
                <?php  if($this->app_modules->is_active('branches')){  ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="branch_id" class="control-label"><?php echo _l('branch') ?></label>
                            <select required="required" name="branch_id" class="form-control" id="branch_id" placeholder="<?php echo _l('branch') ?>" aria-invalid="false">
                                <option></option>
                            <?php foreach ($branches as $value) { ?>
                                <option value="<?php echo $value['key'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>     
                        </div>
                    </div>
                <?php } ?>
                    <div class="col-md-12">
                        <?php echo render_input('shift_name','shift_name','','text',['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="saturday_in" class="control-label"><?php echo _l('saturday_in') ?></label>
                            <input type="time" id="saturday_in" name="saturday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="saturday_out" class="control-label"><?php echo _l('saturday_out') ?></label>
                            <input type="time" id="saturday_out" name="saturday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="sunday_in" class="control-label"><?php echo _l('sunday_in') ?></label>
                            <input type="time" id="sunday_in" name="sunday_in" value="null" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="sunday_out" class="control-label"><?php echo _l('sunday_out') ?></label>
                            <input type="time" id="sunday_out" name="sunday_out" value="null" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="monday_in" class="control-label"><?php echo _l('monday_in') ?></label>
                            <input type="time" id="monday_in" name="monday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="monday_out" class="control-label"><?php echo _l('monday_out') ?></label>
                            <input type="time" id="monday_out" name="monday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="tuesday_in" class="control-label"><?php echo _l('tuesday_in') ?></label>
                            <input type="time" id="tuesday_in" name="tuesday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="tuesday_out" class="control-label"><?php echo _l('tuesday_out') ?></label>
                            <input type="time" id="tuesday_out" name="tuesday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="wednesday_in" class="control-label"><?php echo _l('wednesday_in') ?></label>
                            <input type="time" id="wednesday_in" name="wednesday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="wednesday_out" class="control-label"><?php echo _l('wednesday_out') ?></label>
                            <input type="time" id="wednesday_out" name="wednesday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="thursday_in" class="control-label"><?php echo _l('thursday_in') ?></label>
                            <input type="time" id="thursday_in" name="thursday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="thursday_out" class="control-label"><?php echo _l('thursday_out') ?></label>
                            <input type="time" id="thursday_out" name="thursday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label for="friday_in" class="control-label"><?php echo _l('friday_in') ?></label>
                            <input type="time" id="friday_in" name="friday_in"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="friday_out" class="control-label"><?php echo _l('friday_out') ?></label>
                            <input type="time" id="friday_out" name="friday_out"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="default" class="control-label"><?php echo _l('is_default') ?></label>
                            <select required="required" name="default" class="form-control" id="default" placeholder="<?php echo _l('is_default') ?>" aria-invalid="false">
                                <option value="0"><?php echo _l('no') ?></option>
                                <option value="1"><?php echo _l('yes') ?></option>
                            </select>     
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
                <button  group="submit" class="btn btn-info"><?php echo _l("submit"); ?></button>
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
            url : "<?php echo site_url('hr/timesheet/json_office_shift') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);
                
                $('[name="saturday_in"]').val(data.saturday_in);
                $('[name="saturday_out"]').val(data.saturday_out);

                $('[name="sunday_in"]').val(data.sunday_in);
                $('[name="sunday_out"]').val(data.sunday_out);

                $('[name="monday_in"]').val(data.monday_in);
                $('[name="monday_out"]').val(data.monday_out);

                $('[name="tuesday_in"]').val(data.tuesday_in);
                $('[name="tuesday_out"]').val(data.tuesday_out);

                $('[name="wednesday_in"]').val(data.wednesday_in);
                $('[name="wednesday_out"]').val(data.wednesday_out);

                $('[name="thursday_in"]').val(data.thursday_in);
                $('[name="thursday_out"]').val(data.thursday_out);

                $('[name="friday_in"]').val(data.friday_in);
                $('[name="friday_out"]').val(data.friday_out);

                $('[id="branch_id"]').val(data.branch_id);

                $('[name="shift_name"]').val(data.shift_name);
                $('[name="default"]').val(data.default);



                $('#update_office_shift').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
