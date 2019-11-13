 <?php $this->load->view('details/modals/work_experience') ?>
 <div class="_buttons">
    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_work_experience"><?php echo _l('new_work_experience'); ?></a>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    _l('company_name'),
    _l('post'),
    _l('from_date'),
    _l('to_date'),
    _l('hr_description'),
    _l('control'),
    ),'work_experience'); ?>
