 <?php $this->load->view('details/modals/allowance_modal') ?>
 <div class="_buttons">
    <?php if (has_permission('allowances', '', 'create')){ ?><a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_allowance"><?php echo _l('new_alowance'); ?></a><?php } ?>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    _l('id'),
    _l('allowance_option'),
    _l('title'),
    _l('amount'),
    _l('control'),
    ),'allowances'); ?>
