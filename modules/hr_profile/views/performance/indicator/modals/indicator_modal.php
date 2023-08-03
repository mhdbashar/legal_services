<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_indicator" tabindex="-1" role="dialog" aria-labelledby="update_indicator" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr_profile/performance/update_indicator'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <?php echo form_hidden('added_by'); ?>
            <div class="modal-body">
                <div class="row">
<!--                --><?php // if($this->app_modules->is_active('branches')){  ?>
<!--                    <div class="col-md-12">-->
<!--                        <div class="form-group">-->
<!--                            <label for="branch_id" class="control-label">--><?php //echo _l('branch') ?><!--</label>-->
<!--                            <select required="required" class="form-control" id="branch_id" placeholder="--><?php //echo _l('branch') ?><!--" aria-invalid="false">-->
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
                            <label for="job_position" class="control-label"><?php echo _l('job position') ?></label>
                            <select required="required" class="form-control staff" id="e_designation_id" name="designation_id" placeholder="<?php echo _l('job_position') ?>" aria-invalid="false">
                                <?php
                                 foreach ($job_position as $value) { ?>
                                    <option  selected="selected" value="<?php echo $value['position_code'] ?>">
                                        <?php echo $value['position_name'] ?>
                                <?php } ?>
                              
                            </select>     
                            
                        </div>
                    </div>
                    <?php
                        if(option_exists('technical_competencies_type')){
                            $technical_competencies =array();
                            $ad_opts = json_decode(get_option('technical_competencies_type')) ;

                            foreach ($ad_opts as $option){
                                $sids = json_decode(json_encode($option),true);
                                array_push($technical_competencies,$sids);
                            }
                        }else{
                            $technical_competencies =array();
                        }
                    ?>
                    <?php
                        if(option_exists('organizational_competencies_type')){
                            $organizational_competencies_type =array();
                            $ad_opts = json_decode(get_option('organizational_competencies_type')) ;

                            foreach ($ad_opts as $option){
                                $sids = json_decode(json_encode($option),true);
                                array_push($organizational_competencies_type,$sids);
                            }
                        }else{
                            $organizational_competencies_type =array();
                        }
                    ?>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="h4"><?php echo _l('technical_competencies') ?></div>
                            <div class="form-group">
                                <label for="customer_experience" class="control-label"><?php echo _l('customer_experience') ?></label>
                                <select required="required" class="form-control" id="customer_experience" name="customer_experience" placeholder="<?php echo _l('customer_experience') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($technical_competencies as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                            <div class="form-group">
                                <label for="marketing" class="control-label"><?php echo _l('marketing') ?></label>
                                <select required="required" class="form-control" id="marketing" name="marketing" placeholder="<?php echo _l('marketing') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($technical_competencies as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                            <div class="form-group">
                                <label for="administration" class="control-label"><?php echo _l('administration') ?></label>
                                <select required="required" class="form-control" id="administration" name="administration" placeholder="<?php echo _l('administration') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($technical_competencies as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="h4"><?php echo _l('organizational_competencies') ?></div>
                            <div class="form-group">
                                <label for="professionalism" class="control-label"><?php echo _l('professionalism') ?></label>
                                <select required="required" class="form-control" id="professionalism" name="professionalism" placeholder="<?php echo _l('professionalism') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($organizational_competencies_type as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                            <div class="form-group">
                                <label for="integrity" class="control-label"><?php echo _l('integrity') ?></label>
                                <select required="required" class="form-control" id="integrity" name="integrity" placeholder="<?php echo _l('integrity') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($organizational_competencies_type as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                            <div class="form-group">
                                <label for="attendance" class="control-label"><?php echo _l('attendance') ?></label>
                                <select required="required" class="form-control" id="attendance" name="attendance" placeholder="<?php echo _l('attendance') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($organizational_competencies_type as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                        </div>
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

<div class="modal fade" id="add_indicator" tabindex="-1" role="dialog" aria-labelledby="add_indicator" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr_profile/performance/add_indicator'),array('id'=>'form_transout')); ?>
            <div class="modal-body">
                <div class="row">
<!--                --><?php // if($this->app_modules->is_active('branches')){  ?>
<!--                    <div class="col-md-12">-->
<!--                        <div class="form-group">-->
<!--                            <label for="branch_id" class="control-label">--><?php //echo _l('branch') ?><!--</label>-->
<!--                            <select required="required" class="form-control" id="a_branch_id" placeholder="--><?php //echo _l('branch') ?><!--" aria-invalid="false">-->
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
                            <label for="job_position" class="control-label"><?php echo _l('job_position') ?></label>
                            <select  required="required" class="form-control staff" id="e_designation_id" name="designation_id" placeholder="<?php echo _l('job_position') ?>" aria-invalid="false">
                                <option></option>
                                <?php
                                // if(!$this->app_modules->is_active('branches')){
                                 foreach ($job_position as $value) { ?>
                                    <option   value="<?php echo $value['position_id'] ?>">
                                        <?php echo $value['position_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>     
                        </div>
                    </div>
                    <?php
                        if(option_exists('technical_competencies_type')){
                            $technical_competencies =array();
                            $ad_opts = json_decode(get_option('technical_competencies_type')) ;

                            foreach ($ad_opts as $option){
                                $sids = json_decode(json_encode($option),true);
                                array_push($technical_competencies,$sids);
                            }
                        }else{
                            $technical_competencies =array();
                        }
                    ?>
                    <?php
                        if(option_exists('organizational_competencies_type')){
                            $organizational_competencies_type =array();
                            $ad_opts = json_decode(get_option('organizational_competencies_type')) ;

                            foreach ($ad_opts as $option){
                                $sids = json_decode(json_encode($option),true);
                                array_push($organizational_competencies_type,$sids);
                            }
                        }else{
                            $organizational_competencies_type =array();
                        }
                    ?>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="h4"><?php echo _l('technical_competencies') ?></div>
                            <div class="form-group">
                                <label for="customer_experience" class="control-label"><?php echo _l('customer_experience') ?></label>
                                <select required="required" class="form-control" id="customer_experience" name="customer_experience" placeholder="<?php echo _l('customer_experience') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($technical_competencies as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                            <div class="form-group">
                                <label for="marketing" class="control-label"><?php echo _l('marketing') ?></label>
                                <select required="required" class="form-control" id="marketing" name="marketing" placeholder="<?php echo _l('marketing') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($technical_competencies as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                            <div class="form-group">
                                <label for="administration" class="control-label"><?php echo _l('administration') ?></label>
                                <select required="required" class="form-control" id="administration" name="administration" placeholder="<?php echo _l('administration') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($technical_competencies as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="h4"><?php echo _l('organizational_competencies') ?></div>
                            <div class="form-group">
                                <label for="professionalism" class="control-label"><?php echo _l('professionalism') ?></label>
                                <select required="required" class="form-control" id="professionalism" name="professionalism" placeholder="<?php echo _l('professionalism') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($organizational_competencies_type as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                            <div class="form-group">
                                <label for="integrity" class="control-label"><?php echo _l('integrity') ?></label>
                                <select required="required" class="form-control" id="integrity" name="integrity" placeholder="<?php echo _l('integrity') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($organizational_competencies_type as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                            <div class="form-group">
                                <label for="attendance" class="control-label"><?php echo _l('attendance') ?></label>
                                <select required="required" class="form-control" id="attendance" name="attendance" placeholder="<?php echo _l('attendance') ?>" aria-invalid="false">
                                    <option selected="selected"><?php echo _l('none') ?></option>
                                <?php foreach ($organizational_competencies_type as $value) { ?>
                                    <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                                <?php } ?>
                                </select>     
                            </div>
                        </div>
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
            url : "<?php echo site_url('hr_profile/performance/json_indicator') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);
                
                $('[name="customer_experience"]').val(data.customer_experience);
                
                $('[name="marketing"]').val(data.marketing);

                $('[name="administration"]').val(data.administration);

                $('[name="professionalism"]').val(data.professionalism);

                $('[name="integrity"]').val(data.integrity);

                $('[name="attendance"]').val(data.attendance);

                $('[name="added_by"]').val(data.added_by);

                $('[name="created"]').val(data.created);


                $('[id="position_id"]').val(data.position_id);
                //$('[name="staff_id"]').val(data.staff_id);

                $('#update_indicator').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
