<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-3">
                    <ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked customer-tabs">
                        <li class="customer_tab_contacts">
                  <a data-group='deduction' href="?group=deduction"><?php echo _l('deduction') ?></a>
                </li>
                <li class="customer_tab_contacts">
                  <a data-group='document' href="?group=document"><?php echo _l('document') ?></a>
                </li>
                <li class="customer_tab_contacts">
                  <a data-group='relation' href="?group=relation"><?php echo _l('relation') ?></a>
                </li>
                <li class="customer_tab_contacts">
                  <a data-group='branch' href="?group=branch"><?php echo _l('branch') ?></a>
                </li>
                <li class="customer_tab_contacts">
                  <a data-group='<?php echo $qualification ?>' href="?group=education_level"><?php echo _l('qualification') ?></a>
                </li>
                    </ul>
            </div>
            <div class="col-md-9">
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
