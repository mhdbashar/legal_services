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
            <?php echo form_open(admin_url('hr_profile/hr_profile/update_insurance_type'),array('id'=>'form_transout', 'method'=>'get')); ?>
            <?php echo form_hidden('id'); ?>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="insurance_book_number" class="control-label"><?php echo _l('insurance_book_number') ?></label>
                            <select required="required" class="form-control" id="insurance_book_id" name="insurance_book_id" placeholder="<?php echo _l('insurance_book_number') ?>" aria-invalid="false">
                                <?php foreach ($insurance_book_numbers as $insurance_book_number) { ?>
                                    <option value="<?php echo $insurance_book_number['id'] ?>"><?php echo $insurance_book_number['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('name',_l('name'),'','text'); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <input id="for_staff" value="1" class="" type="checkbox" name="for_staff"> <?php echo _l('can_it_for_staff') ?>
                            </div>
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

<div class="modal fade" id="add_insurance_type" tabindex="-1" role="dialog" aria-labelledby="add_insurance_type" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo "Add"; ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr_profile/hr_profile/add_insurance_type'),array('id'=>'form_transout', 'method'=>'get')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cat_id" class="control-label"><?php echo _l('insurance_book_number') ?></label>
                            <select required="required" class="form-control" id="insurance_book_id" name="insurance_book_id" placeholder="<?php echo _l('insurance_book_number') ?>" aria-invalid="false">
                                <?php foreach ($insurance_book_numbers as $insurance_book_number) { ?>
                                    <option value="<?php echo $insurance_book_number['id'] ?>"><?php echo $insurance_book_number['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('name',_l('name'),'','text'); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <input id="for_staff" value="1" class="" type="checkbox" name="for_staff"> <?php echo _l('can_it_for_staff') ?>
                            </div>
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
            url : "<?php echo site_url('hr_profile/hr_profile/insurance_type_json') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="name"]').val(data.name);

                $('[name="insurance_book_id"]').val(data.insurance_book_id);

                if(data.for_staff == 1){
                    $('[name="for_staff"]').prop("checked", true);
                }else{
                    $('[name="for_staff"]').prop("checked", false);
                }

                $('[name="id"]').val(data.id);

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
