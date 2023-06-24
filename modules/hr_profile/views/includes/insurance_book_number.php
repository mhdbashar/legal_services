
<?php $this->load->view('modals/insurance_book_nums_modal') ?>
<?php if (has_permission('hr_settings', '', 'create')){ ?><a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_insurance_book_num"><?php echo _l('add_insurance_book_num'); ?></a>
<?php } ?>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    _l('insurance_book_number'),
    _l('company_name'),
    _l('start_date'),
    _l('end_date'),
    _l('file'),
    _l('control'),
),'insurance_book_number'); ?>
