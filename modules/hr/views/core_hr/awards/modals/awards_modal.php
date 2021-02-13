<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_document" tabindex="-1" role="dialog" aria-labelledby="update_document" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/core_hr/update_document'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php

                            if(option_exists('award_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('award_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('award_type') ?></label>
                            <select required="required" class="form-control" id="award_type" name="award_type" placeholder="<?php echo _l('award_type') ?>" aria-invalid="false">
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>     
                        </div>
                    </div>
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
                            <select required="required" class="form-control" id="e_staff_id" name="staff_id" placeholder="<?php echo _l('staff') ?>" aria-invalid="false">
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
                        <?php echo render_date_input('date','date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('gift','gift', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('cash','cash', '', 'number', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('award_information','award_information', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','hr_description', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <label for="cat_id" class="control-label"><?php echo _l('award_photo') ?></label>
                        <input id="myFile" type="file" extension="<?php echo str_replace('.','',get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="award_photo" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">                  
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

<div class="modal fade" id="add_document" tabindex="-1" role="dialog" aria-labelledby="add_document" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/core_hr/add_document'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php

                            if(option_exists('award_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('award_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('award_type') ?></label>
                            <select required="required" class="form-control" id="award_type" name="award_type" placeholder="<?php echo _l('award_type') ?>" aria-invalid="false">
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>     
                        </div>
                    </div>
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
                        <?php echo render_date_input('date','date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('gift','gift', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('cash','cash', '', 'number', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('award_information','award_information', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','hr_description', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <label for="cat_id" class="control-label"><?php echo _l('award_photo') ?></label>
                        <input id="myFile" type="file" extension="<?php echo str_replace('.','',get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="award_photo" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">                  
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
            url : "<?php echo site_url('hr/core_hr/json_document') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);
                
                $('[name="award_type"]').val(data.award_type);

                $('[name="gift"]').val(data.gift);
                
                $('[name="date"]').val(data.date);

                $('[name="cash"]').val(data.cash);

                $('[name="description"]').val(data.description);

                $('[name="award_information"]').val(data.award_information);

                $('[name="cash"]').val(data.cash);

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



                $('#update_document').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
