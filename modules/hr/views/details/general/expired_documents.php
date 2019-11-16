<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                    _l('document_type'),
                    _l('document_title'),
                    _l('notification_email'),
                    _l('date_expiry'),
                    _l('control'),
                    ),'documents'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-documents', window.location.href);
   });
</script>
</body>
</html>
