<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_warning"><?php echo _l('new_warning'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        _l('warning_to'),
                        _l('branch'),
                        _l('warning_date'),
                        _l('subject'),
                        _l('warning_by'),
                        _l('control'),
                    ),'warning'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('core_hr/warnings/modals/warnings_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-warning', window.location.href);
   });
</script>
</body>
</html>
