 <?php $this->load->view('details/modals/overtime_modal') ?>
 <div class="_buttons">
    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_overtime"><?php echo _l('new_overtime'); ?></a>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    _l('id'),
    _l('title'),
    _l('num_days'),
    _l('num_hours'),
    _l('rate'),
    _l('control'),
    ),'overtime'); ?>
