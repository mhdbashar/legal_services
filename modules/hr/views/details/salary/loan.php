 <?php $this->load->view('details/modals/loan_modal') ?>
 <div class="_buttons">
    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_loan"><?php echo _l('new_loan'); ?></a>
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
