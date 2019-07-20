<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="countries_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo "Edit"; ?></span>
                    <span class="add-title"><?php echo "Add"; ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('location_module/L_Locations/edit_country'),array('id'=>'countries-modal')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('short_name','Country name'); ?>
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

    function edit_country_json(element){
        var data = JSON.stringify($(element).attr('data-id'));
        console.log(data);
        $.post(<?='"' . admin_url("location_module/L_Locations/edit_country_json") . '"'?>, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                $("input[name=short_name").val(response.data.short_name);
            } else {
                alert_float('failed', response.message);
            }
        });
    }

    window.addEventListener('load',function(){
       appValidateForm($('#countries-modal'), {
        name: 'required'
    }, manage_countries);

       $('#customer_group_modal').on('show.bs.modal', function(e) {
        var invoker = $(e.relatedTarget);
        var country_id = $(invoker).data('id');
        $('#countries_modal .add-title').removeClass('hide');
        $('#countries_modal .edit-title').addClass('hide');
        $('#countries_modal input[name="id"]').val('');
        $('#countries_modal input[name="name"]').val('');
        // is from the edit button
        if (typeof(country_id) !== 'undefined') {
            $('#countries_modal input[name="id"]').val(group_id);
            $('#countries_modal .add-title').addClass('hide');
            $('#countries_modal .edit-title').removeClass('hide');
            $('#countries_modal input[name="name"]').val($(invoker).parents('tr').find('td').eq(0).text());
        }
    });
   });
    function manage_countries(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                if($.fn.DataTable.isDataTable('.table-countries')){
                    $('.table-countries').DataTable().ajax.reload();
                }
                if($('body').hasClass('dynamic-create-groups') && typeof(response.id) != 'undefined') {
                    var groups = $('select[name="groups_in[]"]');
                    groups.prepend('<option value="'+response.id+'">'+response.name+'</option>');
                    groups.selectpicker('refresh');
                }
                alert_float('success', response.message);
            }
            $('#countries_modal').modal('hide');
        });
        return false;
    }

</script>
