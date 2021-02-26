 <?php $this->load->view('details/modals/document_modal') ?>
 <div class="_buttons">
   <?php if (has_permission('hr', '', 'create')){ ?> <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_document"><?php echo _l('new_document'); ?></a><?php } ?>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    _l('document_type'),
    _l('document_title'),
    _l('notification_email'),
    _l('date_expiry'),
    _l('control'),
    ),'document'); ?>