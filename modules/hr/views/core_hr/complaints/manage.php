<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_complaint"><?php echo _l('new_complaint'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        _l('complaint_from'),
                        _l('complaint_againts'),
                        _l('branches'),
                        _l('complaint_date'),
                        _l('complaint_title'),
                        _l('control'),
                    ),'complaint'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('core_hr/complaints/modals/complaints_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-complaint', window.location.href);
   });
</script>
</body>
</html>
