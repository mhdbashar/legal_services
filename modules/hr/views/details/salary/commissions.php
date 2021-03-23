 <?php $this->load->view('details/modals/commission_modal') ?>
 <div class="_buttons">
    <?php if (has_permission('hr', '', 'create')){ ?><a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_commission"><?php echo _l('new_commission'); ?></a><?php } ?>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    _l('id'),
    _l('title'),
    _l('amount'),
    _l('actions'),
    ),'commissions'); ?>
