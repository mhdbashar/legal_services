<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="<?php echo admin_url('branches/field'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_branch'); ?></a>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php render_datatable(
                            array(
                                _l('id'),
                                _l('title'),
                                _l('country'),
                                _l('phone'),
                            ),'custom-fields'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        initDataTable('.table-custom-fields', window.location.href);
    });
</script>
<div class="modal fade" id="delete_branch" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <?php echo form_open(admin_url('branches/delete',array('delete_branch_form'))); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo _l('delete_branch'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="delete_id">
                    <?php echo form_hidden('id'); ?>
                </div>
                <p><?php echo _l('delete_branch_info'); ?></p>
                <?php echo render_select('transfer_data_to',(isset($branches)?$branches:[]),['key','value'],'branch_name'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-danger _delete"><?php echo _l('confirm'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php init_tail(); ?>
<script>
    $(function(){
        initDataTable('.table-staff', window.location.href);
    });
    function delete_branch(id){
        $('#delete_branch').modal('show');
        $('#transfer_data_to').find('option').prop('disabled',false);
        $('#transfer_data_to').find('option[value="'+id+'"]').prop('disabled',true);
        $('#delete_branch .delete_id input').val(id);
        $('#transfer_data_to').selectpicker('refresh');
    }
</script>
</body>
</html>