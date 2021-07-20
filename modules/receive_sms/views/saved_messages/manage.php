<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
    <div id="wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel_s">
                        <div class="panel-body">
                            <h3><?php echo $title ?></h3>
                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading" />
                            <div class="clearfix"></div>
                            <?php
                            $data = array(
                                _l('id'),
                                _l('sender'),
                                _l('message'),
                                _l('staff'),
                                _l('created_at'),
                                _l('options'),
                            );
                            render_datatable($data,'saved_messages');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php init_tail(); ?>
<script>
    $(function(){
        initDataTable('.table-saved_messages', window.location.href);
    });
</script>
