<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_promotion"><?php echo _l('new_promotion'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        _l('staff_name'),
                        _l('branch'),
                        _l('promotion_title'),
                        _l('promotion_date'),
                        _l('control'),
                    ),'promotion'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('core_hr/promotions/modals/promotion_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-promotion', window.location.href);
   });
</script>
</body>
</html>
