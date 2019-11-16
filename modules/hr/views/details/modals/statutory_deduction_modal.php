
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_statutory_deduction" tabindex="-1" role="dialog" aria-labelledby="update_statutory_deduction" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/details/update_statutory_deduction'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <?php echo form_hidden('staff_id', $staff_id); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php

                            if(option_exists('deduction_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('deduction_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('deduction_type') ?></label>
                            <select class="form-control" id="deduction_type" name="deduction_type" placeholder="Tax type" aria-invalid="false">
                                <option selected="" disabled=""><?php echo _l('deduction_type') ?></option>
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('title','title', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('amount','amount', '', 'number', ['required' => 'required']); ?>
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

<div class="modal fade" id="add_statutory_deduction" tabindex="-1" role="dialog" aria-labelledby="add_statutory_deduction" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/Details/add_statutory_deduction'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('staff_id', $staff_id); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php

                            if(option_exists('deduction_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('deduction_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>
                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('deduction_type') ?></label>
                            <select class="form-control" id="deduction_type" name="deduction_type" placeholder="Tax type" aria-invalid="false">
                                <option selected="" disabled=""><?php echo _l('deduction_type') ?></option>
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('title','title', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('amount','amount', '', 'number', ['required' => 'required']); ?>
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
            url : "<?php echo site_url('hr/details/json_statutory_deduction') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);

                $('[name="deduction_type"]').val(data.deduction_type);
                
                $('[name="title"]').val(data.title);

                $('[name="amount"]').val(data.amount);

                $('#update_statutory_deduction').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
