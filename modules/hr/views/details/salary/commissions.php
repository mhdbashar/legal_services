 <?php $this->load->view('details/modals/commission_modal') ?>
 <div class="_buttons">
    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_commission"><?php echo 'New Commission'; ?></a>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    'ID',
    'Title',
    'ammount',
    'Actions',
    ),'commissions'); ?>
