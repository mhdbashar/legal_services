<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="update_holiday" tabindex="-1" role="dialog" aria-labelledby="update_holiday" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo "Edit"; ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/Holidays/update'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('holiday_id'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('event_name','Event Name', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','Description', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('start_date','Start Date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('end_date','End Date', '', ['required' => 'required']); ?>
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

<div class="modal fade" id="add_holiday" tabindex="-1" role="dialog" aria-labelledby="add_holiday" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo "Add"; ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/Holidays/add'),array('id'=>'form_transout')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('event_name','Event Name', '', 'text', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('description','Description', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('start_date','Start Date', '', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('end_date','End Date', '', ['required' => 'required']); ?>
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
            url : "<?php echo site_url('hr/Holidays/json') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="holiday_id"]').val(data.holiday_id);

                $('[name="event_name"]').val(data.event_name);
                
                $('[name="description"]').val(data.description);

                $('[name="start_date"]').val(data.start_date);

                $('[name="end_date"]').val(data.end_date);

                $('#update_holiday').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
