 <?php $this->load->view('details/modals/loan_modal') ?>
 <div class="_buttons">
    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_loan"><?php echo 'New loan'; ?></a>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    'ID',
    'Title',
    'Amount',
    'Start date',
    'End date',
    'Reason',
    'Actions',
    ),'loan'); ?>
