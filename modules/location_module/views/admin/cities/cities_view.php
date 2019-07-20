<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="cities_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo "Edit"; ?></span>
                    <span class="add-title"><?php echo "Add"; ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('location_module/L_Locations/edit_city'),array('id'=>'cities-modal')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('Name_en','City name'); ?>
                        <?php echo form_hidden('Id'); ?>
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
    window.addEventListener('load',function(){
       appValidateForm($('#cities-modal'), {
        name: 'required'
    }, manage_cities);

       $('#cities_modal').on('show.bs.modal', function(e) {
        var invoker = $(e.relatedTarget);
        var city_id = $(invoker).data('id');
        $('#cities_modal .add-title').removeClass('hide');
        $('#cities_modal .edit-title').addClass('hide');
        $('#cities_modal input[name="id"]').val('');
        $('#cities_modal input[name="name"]').val('');
        // is from the edit button
        if (typeof(city_id) !== 'undefined') {
            $('#cities_modal input[name="id"]').val(group_id);
            $('#cities_modal .add-title').addClass('hide');
            $('#cities_modal .edit-title').removeClass('hide');
            $('#cities_modal input[name="name"]').val($(invoker).parents('tr').find('td').eq(0).text());
        }
    });
   });
    function manage_cities(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                if($.fn.DataTable.isDataTable('.table-cities')){
                    $('.table-cities').DataTable().ajax.reload();
                }
                if($('body').hasClass('dynamic-create-groups') && typeof(response.id) != 'undefined') {
                    var groups = $('select[name="groups_in[]"]');
                    groups.prepend('<option value="'+response.id+'">'+response.name+'</option>');
                    groups.selectpicker('refresh');
                }
                alert_float('success', response.message);
            }
            $('#cities_modal').modal('hide');
        });
        return false;
    }

</script>
