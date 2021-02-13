<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
    	<div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                    <?php render_datatable(array(
                        _l('full_name'),
                        _l('branch_name'),
                        _l('salary'),
                        _l('payroll_month'),
                        _l('payroll_date'),
                        _l('control'),
                        ),'payment_history'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('payroll/modals/payment_history'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-payment_history', window.location.href);
   });
</script>
</body>
</html>
