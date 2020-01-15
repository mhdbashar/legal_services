<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_document"><?php echo _l('new_award'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        _l('award_name'),
                        _l('staff_name'),
                        _l('branch'),
                        _l('gift'),
                        _l('control'),
                    ),'official_documents'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('core_hr/awards/modals/awards_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-official_documents', window.location.href);
   });
</script>
</body>
</html>
