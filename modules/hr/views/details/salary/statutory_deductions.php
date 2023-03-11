 <?php $this->load->view('details/modals/statutory_deduction_modal') ?>
 <div class="_buttons">
    <?php if (has_permission('hr', '', 'create')){ ?><a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_statutory_deduction"><?php echo _l('new_statutory_deductions'); ?></a><?php } ?>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>

<?php render_datatable(array(
    _l('id'),
    _l('deduction_type'),
    _l('title'),
    _l('amount'),
    _l('control'),
    ),'statutory_deductions'); ?>