<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                       <?php if (has_permission('hr', '', 'create')){ ?> <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_document"><?php echo _l('new_official_document'); ?></a><?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php
                    $data = array(
                        _l('document_type'),
                        _l('document_title'),
                        _l('date_expiry'),
                        _l('file'),
                    );
                    if (has_permission('hr', '', 'edit') || has_permission('hr', '', 'delete') )
                        $data[] = _l('control');
                    render_datatable($data,'official_documents');
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('organization/modals/official_document_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-official_documents', window.location.href);
   });
</script>
</body>
</html>
