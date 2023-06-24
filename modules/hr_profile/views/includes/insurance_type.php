
<?php $this->load->view('modals/insurance_type_modal') ?>
<?php if (has_permission('hr_settings', '', 'create')){ ?><a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_insurance_type"><?php echo _l('add_insurance_type'); ?></a>
<?php } ?>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>

<?php render_datatable(array(
    _l('name'),
    _l('insurance_book_number'),
    _l('control'),
),'insurance_type'); ?>




