<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_immigration" tabindex="-1" role="dialog" aria-labelledby="update_immigration" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr_profile/update_immigration'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <?php echo form_hidden('staff_id', $staff_id); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php

                            if(option_exists('document_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('document_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('document_type') ?></label>
                            <select class="form-control" id="document_type" name="document_type" placeholder="<?php echo _l('document_type') ?>" aria-invalid="false">
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>     
                        </div>
      
                    </div>
                            </br>
                    <div class="col-md-12">
                        <?php echo render_input('document_number','document_number', '', 'text',['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('issue_date','issue_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('date_expiry','date_expiry', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <label for="cat_id" class="control-label"><?php echo _l('document_file') ?></label>
                        <input id="myFile" type="file" extension="<?php echo str_replace('.','',get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="document_file" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">                  
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('eligible_review_date','eligible_review_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('country','country', '', 'text', ['required' => 'required']); ?>
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

<div class="modal fade" id="add_immigration" tabindex="-1" role="dialog" aria-labelledby="add_immigration" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr_profile/add_immigration'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('staff_id',$staff_id); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php

                            if(option_exists('document_type')){
                                $data =array();
                                $ad_opts = json_decode(get_option('document_type')) ;

                                foreach ($ad_opts as $option){
                                    $sids = json_decode(json_encode($option),true);
                                    array_push($data,$sids);
                                }
                            }else{
                                $data =array();
                            }
                        ?>

                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('document_type') ?></label>
                            <select class="form-control" id="document_type" name="document_type" placeholder="<?php echo _l('document_type') ?>" aria-invalid="false">
                            <?php foreach ($data as $value) { ?>
                                <option value="<?php echo $value['value'] ?>"><?php echo $value['value'] ?></option>
                            <?php } ?>
                            </select>     
                        </div>
                    </div>
                            </br>
                    <div class="col-md-12">
                        <?php echo render_input('document_number','document_number', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('issue_date','issue_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('date_expiry','date_expiry', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <label for="cat_id" class="control-label"><?php echo _l('document_file') ?></label>
                        <input id="myFile" type="file" extension="<?php echo str_replace('.','',get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="document_file" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">                  
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('eligible_review_date','eligible_review_date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('country','country', '', 'text', ['required' => 'required']); ?>
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
            url : "<?php echo site_url('hr_profile/json_immigration') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);
                
                $('[name="document_number"]').val(data.document_number);
                
                $('[name="issue_date"]').val(data.issue_date);

                $('[name="date_expiry"]').val(data.date_expiry);

                $('[name="country"]').val(data.country);

                // $('[name="document_file"]').val(data.document_file);

                $('[name="eligible_review_date"]').val(data.eligible_review_date);


                if(data.is_notification == 0){
                    $('#no_notify').attr('selected','selected');
                }

                if(data.is_notification == 1){
                    $('#yes_notify').attr('selected','selected');
                }

                // $('[name="document_file"]').val(data.document_file);


                $('#update_work_experience').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
