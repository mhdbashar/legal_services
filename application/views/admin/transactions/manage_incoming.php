<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php if(is_admin()) { ?>
                                <a href="<?php echo admin_url('transactions/incoming'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_incoming'); ?></a>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                            <?php } else { echo '<h4 class="no-margin bold">'._l('announcements').'</h4>';} ?>
                        </div>
                        <div class="clearfix"></div>
                        <?php render_datatable(array(
                            _l('id'),
                            _l('type'),
                            _l('origin'),
                            _l('incoming_num'),
                            _l('incoming_source'),
                            _l('incoming_type'),
                            _l('secret'),
                            _l('importance'),
                            _l('classification'),
                            _l('owner_name'),
                            _l('date'),
                            _l('options'),

                        ),'trans_incoming'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    console.log(window.location.href)
    $(function(){
        initDataTable('.table-trans_incoming', window.location.href);
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
                $('.table-trans_incoming').DataTable().ajax.reload(null, false);
            },

        });

    })
</script>
</body>
</html>
