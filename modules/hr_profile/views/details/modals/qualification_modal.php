<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_qualification" tabindex="-1" role="dialog" aria-labelledby="update_qualification" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr_profile/update_qualification'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <?php echo form_hidden('staff_id', $staff_id); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('school_university','school_university', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php

                            if(option_exists('education_level_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('education_level_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('education_level') ?></label>
                            <select class="form-control" id="education_level" name="education_level" placeholder="<?php echo _l('education_level') ?>" aria-invalid="false">
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('from_date','from_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('to_date','to_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php

                            if(option_exists('education_type')){
                                $data2 =array();
                                $ad_opts = json_decode(get_option('education_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data2,$sids);
                                }
                            }else{
                                $data2 =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="education" class="control-label"><?php echo _l('education') ?></label>
                            <select class="form-control" id="education" name="education" placeholder="<?php echo _l('education') ?>" aria-invalid="false">
                            <?php foreach ($data2 as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php

                            if(option_exists('skill_type')){
                                $data3 =array();
                                $ad_opts = json_decode(get_option('skill_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data3,$sids);
                                }
                            }else{
                                $data3 =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="skill" class="control-label"><?php echo _l('professional_courses') ?></label>
                            <select class="form-control" id="skill" name="skill" placeholder="<?php echo _l('skill') ?>" aria-invalid="false">
                            <?php foreach ($data3 as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','hr_description', ''); ?>
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

<div class="modal fade" id="add_qualification" tabindex="-1" role="dialog" aria-labelledby="add_qualification" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr_profile/add_qualification'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('staff_id', $staff_id); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('school_university','school_university', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php

                            if(option_exists('education_level_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('education_level_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('education_level') ?></label>
                            <select class="form-control" id="education_level" name="education_level" placeholder="<?php echo _l('education_level') ?>" aria-invalid="false">
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('from_date','from_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('to_date','to_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php

                            if(option_exists('education_type')){
                                $data2 =array();
                                $ad_opts = json_decode(get_option('education_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data2,$sids);
                                }
                            }else{
                                $data2 =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="education" class="control-label"><?php echo _l('education') ?></label>
                            <select class="form-control" id="education" name="education" placeholder="<?php echo _l('education') ?>" aria-invalid="false">
                            <?php foreach ($data2 as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php

                            if(option_exists('skill_type')){
                                $data3 =array();
                                $ad_opts = json_decode(get_option('skill_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data3,$sids);
                                }
                            }else{
                                $data3 =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="skill" class="control-label"><?php echo _l('professional_courses') ?></label>
                            <select class="form-control" id="skill" name="skill" placeholder="<?php echo _l('skill') ?>" aria-invalid="false">
                            <?php foreach ($data3 as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','hr_description', ''); ?>
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
            url : "<?php echo site_url('hr_profile/json_qualification') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);
                
                $('[name="school_university"]').val(data.school_university);

                $('[name="education_level"]').val(data.education_level);

                $('[name="from_date"]').val(data.from_date);
                
                $('[name="to_date"]').val(data.to_date);

                $('[name="skill"]').val(data.skill);

                $('[name="education"]').val(data.education);

                $('[name="description"]').val(data.description);

                $('#update_qualification').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
