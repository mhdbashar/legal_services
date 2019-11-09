 <?php $this->load->view('details/modals/overtime_modal') ?>
 <div class="_buttons">
    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_overtime"><?php echo 'New Overtime'; ?></a>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    'ID',
    'Title',
    'Number of Days',
    'Number of Hours',
    'Rate',
    'Actions',
    ),'overtime'); ?>
