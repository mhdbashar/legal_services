<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_type" tabindex="-1" role="dialog" aria-labelledby="update_type" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo "Edit"; ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/setting/update_insurance_book_num'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('name',_l('insurance_book_number'),'','number'); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('company_name',_l('company_name'),'','text'); ?>
                    </div>

                    <div class="col-md-12">
                        <?php
                        echo render_date_input('start_date','start_date'); ?>
                    </div>
                    <div class="col-md-12">
                        <?php
                        echo render_date_input('end_date','end_date'); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('file') ?></label>
                            <input id="myFile" type="file" extension="<?php echo str_replace('.','',get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="file" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo 'Close'; ?></button>
                <button group="submit" class="btn btn-info"><?php echo 'Submit'; ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_insurance_book_num" tabindex="-1" role="dialog" aria-labelledby="add_insurance_book_num" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo "Add"; ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/setting/add_insurance_book_num'),array('id'=>'form_transout')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('name',_l('insurance_book_number'),'','number'); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('company_name',_l('company_name'),'','text'); ?>
                    </div>

                    <div class="col-md-12">
                        <?php
                        echo render_date_input('start_date','start_date'); ?>
                    </div>
                    <div class="col-md-12">
                        <?php
                        echo render_date_input('end_date','end_date'); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('file') ?></label>
                            <input id="myFile" type="file" extension="<?php echo str_replace('.','',get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="file" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo 'Close'; ?></button>
                <button group="submit" class="btn btn-info"><?php echo 'Submit'; ?></button>
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
            url : "<?php echo site_url('hr/setting/insurance_book_num_json') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="name"]').val(data.name);
                $('[name="company_name"]').val(data.company_name);
                $('[name="start_date"]').val(data.start_date);
                $('[name="end_date"]').val(data.end_date);

                $('[name="id"]').val(data.id);

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
