<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="modal fade" id="add_designation_group" tabindex="-1" role="dialog" aria-labelledby="designation_group" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("add"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/organization/add_designation_group'),array('id'=>'form_add')); ?>
            <div class="modal-body">

                <?php
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('name','name', '', 'text', ['required' => 'required']); ?>
                    </div>
                </div>

                <p for="description" class="bold"><?php echo _l('description'); ?></p>
                <?php echo render_textarea('description_add', 'description', '', array(), array(), '', 'tinymce'); ?>

            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
                <button group="submit" id="add-submit" class="btn btn-info"><?php echo _l("submit"); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="update_designation_group" tabindex="-1" role="dialog" aria-labelledby="update_designation_group" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("edit"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/organization/update_designation_group'),array('id'=>'form_edit')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('name','name', '', 'text', ['required' => 'required']); ?>
                    </div>
                </div>



                <p for="description" class="bold"><?php echo _l('description'); ?></p>
                <?php echo render_textarea('description', '', '', array(), array(), '', 'tinymce'); ?>

            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
                <button group="submit" id="edit-submit" class="btn btn-info"><?php echo _l("submit"); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>

    function edit(id){

        save_method = 'update';
        $('#form_edit')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hr/organization/json_designation_group') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="id"]').val(data.id);

                $('[name="name"]').val(data.name);

                tinyMCE.activeEditor.setContent(data.description);


                $('#update_designation_group').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
