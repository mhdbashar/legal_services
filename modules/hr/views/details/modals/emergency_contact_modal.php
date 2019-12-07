<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_emergency_contact" tabindex="-1" role="dialog" aria-labelledby="update_emergency_contact" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/general/update_emergency_contact'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <?php echo form_hidden('staff_id', $staff_id); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php

                            if(option_exists('relation_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('relation_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('relation') ?></label>
                            <select class="form-control" id="relation" name="relation" placeholder="<?php echo _l('relation') ?>" aria-invalid="false">
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('name','name', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('email','email', '', 'email', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('personal','personal', '', 'email', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <input id="is_primary" value="1" class="" type="checkbox" name="is_primary"> is_primary
                            </div>
                            <div class="col-md-6">
                                <input id="is_dependent" value="1" class="" type="checkbox" name="is_dependent"> is_dependent
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('address_1','address_1', '', 'text'); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('address_2','address_2', '', 'text'); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9">
                                <?php echo render_input('work','work', '', 'number', ['required' => 'required']); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo render_input('ext','ext', '', 'number', ['required' => 'required']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('mobile','mobile', '', 'number', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('home','home', '', 'number', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <?php echo render_input('city','city', '', 'text', ['required' => 'required']); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo render_input('state','state', '', 'text', ['required' => 'required']); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo render_input('zip_code','zip_code', '', 'number', ['required' => 'required']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('country','country', '', 'text', ['required' => 'required']); ?>
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

<div class="modal fade" id="add_emergency_contact" tabindex="-1" role="dialog" aria-labelledby="add_emergency_contact" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/general/add_emergency_contact'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('staff_id', $staff_id); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php

                            if(option_exists('relation_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('relation_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('relation') ?></label>
                            <select class="form-control" id="relation" name="relation" placeholder="<?php echo _l('relation') ?>" aria-invalid="false">
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('name','name', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('email','email', '', 'email', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('personal','personal', '', 'email', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <input id="is_primary" value="1" class="" type="checkbox" name="is_primary"> is_primary
                            </div>
                            <div class="col-md-6">
                                <input id="is_dependent" value="1" class="" type="checkbox" name="is_dependent"> is_dependent
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('address_1','address_1', '', 'text'); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('address_2','address_2', '', 'text'); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9">
                                <?php echo render_input('work','work', '', 'number', ['required' => 'required']); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo render_input('ext','ext', '', 'number', ['required' => 'required']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('mobile','mobile', '', 'number', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('home','home', '', 'number', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <?php echo render_input('city','city', '', 'text', ['required' => 'required']); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo render_input('state','state', '', 'text', ['required' => 'required']); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo render_input('zip_code','zip_code', '', 'number', ['required' => 'required']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('country','country', '', 'text', ['required' => 'required']); ?>
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
            url : "<?php echo site_url('hr/general/json_emergency_contact') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);
                
                $('[name="relation"]').val(data.relation);

                $('[name="email"]').val(data.email);

                $('[name="personal"]').val(data.personal);
                
                // $('[name="is_primary"]').val(data.is_primary);
                if(data.is_primary == 1){
                    $('[name="is_primary"]').attr('checked', 'true');
                }else{
                    $('[name="is_primary"]').attr('checked', 'false')
                }

                // $('[name="is_dependent"]').val(data.is_dependent);
                if(data.is_dependent == 1){
                    $('[name="is_dependent"]').attr('checked', 'true')
                }else{
                    $('[name="is_dependent"]').attr('checked', 'false')
                }

                $('[name="name"]').val(data.name);

                $('[name="address_1"]').val(data.address_1);
                
                $('[name="address_2"]').val(data.address_2);

                $('[name="work"]').val(data.work);

                $('[name="mobile"]').val(data.work);

                $('[name="ext"]').val(data.ext);

                $('[name="home"]').val(data.home);
                
                $('[name="city"]').val(data.city);

                $('[name="state"]').val(data.state);

                $('[name="zip_code"]').val(data.zip_code);

                $('[name="country"]').val(data.country);

                $('#update_emergency_contact').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
