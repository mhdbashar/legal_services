<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_travel" tabindex="-1" role="dialog" aria-labelledby="update_travel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/core_hr/update_travel'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            if(option_exists('arrangement_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('arrangement_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('arrangement_type') ?></label>
                            <select required="required" class="form-control" id="arrangement_type" name="arrangement_type" placeholder="<?php echo _l('arrangement_type') ?>" aria-invalid="false">
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>     
                        </div>
                    </div>

                    <div class="col-md-12">
                        <?php
                            if(option_exists('travel_mode_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('travel_mode_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('travel_mode_type') ?></label>
                            <select required="required" class="form-control" id="travel_mode_type" name="travel_mode_type" placeholder="<?php echo _l('travel_mode_type') ?>" aria-invalid="false">
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
                        <?php echo render_date_input('start_date','start_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('end_date','end_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('expected_budget','expected_budget', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('actual_budget','actual_budget', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('purpose','purpose_of_visit', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('place','place_of_visit', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','hr_description', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status" class="control-label"><?php echo _l('status') ?></label>
                            <select required="required" class="form-control" id="status" name="status" placeholder="<?php echo _l('hr_status') ?>" aria-invalid="false">
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

<div class="modal fade" id="add_travel" tabindex="-1" role="dialog" aria-labelledby="add_travel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/core_hr/add_travel'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <?php echo form_hidden('status', 'Pending'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            if(option_exists('arrangement_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('arrangement_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('arrangement_type') ?></label>
                            <select required="required" class="form-control" id="arrangement_type" name="arrangement_type" placeholder="<?php echo _l('arrangement_type') ?>" aria-invalid="false">
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>     
                        </div>
                    </div>

                    <div class="col-md-12">
                        <?php
                            if(option_exists('travel_mode_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('travel_mode_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('travel_mode_type') ?></label>
                            <select required="required" class="form-control" id="travel_mode_type" name="travel_mode_type" placeholder="<?php echo _l('travel_mode_type') ?>" aria-invalid="false">
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
                        <?php echo render_date_input('start_date','start_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('end_date','end_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('expected_budget','expected_budget', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('actual_budget','actual_budget', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('purpose','purpose_of_visit', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('place','place_of_visit', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','hr_description', '', ['required' => 'required']); ?>
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
            url : "<?php echo site_url('hr/core_hr/json_travel') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);
                
                $('[name="start_date"]').val(data.start_date);

                $('[name="end_date"]').val(data.end_date);
                
                $('[name="place"]').val(data.place);

                $('[name="description"]').val(data.description);

                $('[name="purpose"]').val(data.purpose);

                $('[name="expected_budget"]').val(data.expected_budget);

                $('[name="actual_budget"]').val(data.actual_budget);

                $('[name="status"]').val(data.status);

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



                $('#update_travel').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
