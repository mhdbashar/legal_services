 <?php $this->load->view('details/modals/bank_account') ?>
 <div class="_buttons">
    <?php if (has_permission('bank_account', '', 'create')){ ?><a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_bank_account"><?php echo _l('new_bank_account'); ?></a><?php } ?>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    _l('account_title'),
    _l('account_number'),
    _l('bank_name'),
    _l('bank_code'),
    _l('bank_branch'),
    _l('control'),
    ),'bank_account'); ?>
