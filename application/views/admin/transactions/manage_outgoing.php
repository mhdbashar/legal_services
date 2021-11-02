<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php if(has_permission('transactions', '', 'create')) { ?>
                                <a href="<?php echo admin_url('transactions/outgoing'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_outgoing'); ?></a>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                            <?php } else { echo '<h4 class="no-margin bold">'._l('announcements').'</h4>';} ?>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                        $table = [
                            _l('id'),
                            _l('type'),
                            _l('origin'),
                            _l('secret'),
                            _l('importance'),
                            _l('classification'),
                            _l('owner_name'),
                        ];
                        if(has_permission('transactions', '', 'edit') || has_permission('transactions', '', 'delete'))
                            $table[] = _l('options');

                        render_datatable($table,'trans_outgoing'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        initDataTable('.table-trans_outgoing', window.location.href);
    });

    $(document).on('click',"._delete", function () {
        var id = $(this).data('id');

        $.ajax({
            type: 'Get',
            url: admin_url + 'transactions/delete_transaction',
            data: {
                del_id : id,
            },
            success: function(data) {
                $('.table-trans_outgoing').DataTable().ajax.reload(null, false);
            },

        });

    })
</script>
</body>
</html>
