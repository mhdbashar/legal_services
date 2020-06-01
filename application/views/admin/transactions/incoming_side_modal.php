<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="add_incoming_side_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
<!--                    <span class="edit-title">--><?php //echo _l('customer_group_edit_heading'); ?><!--</span>-->
                    <span class="add-title"><?php echo _l('add_incoming_side'); ?></span>
                </h4>
            </div>
            <?php echo form_open('admin/transactions/incoming_side',array('id'=>'add-incoming-side-modal')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('nameEn',_l('incoming_side')); ?>

                        <!--                        --><?php //echo form_hidden('id'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('load',function(){
        appValidateForm($('#add-incoming-side-modal'), {
            name: 'required'
        },manage_incoming_side);

        $('#add_incoming_side_modal').on('show.bs.modal', function(e) {
            var invoker = $(e.relatedTarget);
            var group_id = $(invoker).data('id');
            $('#add_incoming_side_modal .add-title').removeClass('hide');
            // $('#add_incoming_side_modal .edit-title').addClass('hide');
            // $('#add_incoming_side_modal input[name="id"]').val('');
            $('#add_incoming_side_modal input[name="nameEn"]').val('');
            // is from the edit button
            // if (typeof(group_id) !== 'undefined') {
            //     $('#customer_group_modal input[name="id"]').val(group_id);
            //     $('#customer_group_modal .add-title').addClass('hide');
            //     $('#customer_group_modal .edit-title').removeClass('hide');
            //     $('#customer_group_modal input[name="name"]').val($(invoker).parents('tr').find('td').eq(0).text());
            // }
        });
    });
    function manage_incoming_side(form) {
        var data = $(form).serialize();

        var url = form.action;
        $.get(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                console.log(response.data.value)
                alert_float('success', response.message);
                var ctype = $('#incoming_source');
                ctype.find('option:first').after('<option value="'+response.data.key+'">'+response.data.value+'</option>');
                ctype.selectpicker('val',response.data.value);
                ctype.selectpicker('refresh');


            }
            $('#add_incoming_side_modal').modal('hide');
        });
        return false;
    }
    
    function new_incoming_side() {
        $('#add_incoming_side_modal').modal('show');


    }

</script>
