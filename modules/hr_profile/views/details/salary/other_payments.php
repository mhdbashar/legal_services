 <?php $this->load->view('details/modals/other_payments_modal') ?>
 <div class="_buttons">
    <?php if (has_permission('other_payments', '', 'create')){ ?><a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_other_payment"><?php echo _l('new_other_payments'); ?></a><?php } ?>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    _l('id'),
    _l('title'),
    _l('amount'),
    _l('control'),
    ),'other_payments'); ?>
