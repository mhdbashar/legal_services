 <?php $this->load->view('details/modals/statutory_deduction_modal') ?>
 <?php $this->load->view('details/modals/deduction_type_modal') ?>
 <div class="_buttons">
    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_statutory_deduction"><?php echo 'New Statutory Deductions'; ?></a>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>

<?php render_datatable(array(
    'ID',
    'deduction_type',
    'Title',
    'Amount',
    'Actions',
    ),'statutory_deductions'); ?>

<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
	<a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_deduction_type"><?php echo 'Add deduction type'; ?></a>