 <?php $this->load->view('details/modals/immigration_modal') ?>
 <div class="_buttons">
   <?php if (has_permission('hr_profile', '', 'create')){ ?> <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_immigration"><?php echo _l('new_immigration'); ?></a><?php } ?>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    _l('document_type'),
    _l('issue_date'),
    _l('date_expiry'),
    _l('country'),
    _l('eligible_review_date'),
    _l('file'),
    _l('control'),
    ),'immigration'); ?>