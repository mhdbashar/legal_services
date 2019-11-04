 <?php $this->load->view('details/modals/commission_modal') ?>
 <div class="_buttons">
    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_other_payment"><?php echo 'New Other Payments'; ?></a>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
    'ID',
    'Title',
    'ammount',
    'Actions',
    ),'other_payments'); ?>
