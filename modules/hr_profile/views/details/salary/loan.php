 <?php $this->load->view('details/modals/loan_modal') ?>
 <h4 class="text-danger"><?php echo _l('loan_note'); ?></h4>
 <div class="clearfix"></div>
 <hr class="hr-panel-heading" />
 <div class="_buttons">
    <?php if (has_permission('loan', '', 'create')){ ?><a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_loan"><?php echo _l('new_loan'); ?></a><?php } ?>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    _l('id'),
    _l('title'),
    _l('amount'),
    _l('start_date'),
    _l('end_date'),
    _l('reason'),
    _l('control'),
    ),'loan'); ?>
