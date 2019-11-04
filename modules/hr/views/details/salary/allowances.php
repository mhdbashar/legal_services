 <?php $this->load->view('details/modals/allowance_modal') ?>
 <div class="_buttons">
    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_allowance"><?php echo 'New Allowance'; ?></a>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    'ID',
    'Allowance Option',
    'Tilte',
    'Amount',
    'Control',
    ),'allowances'); ?>
