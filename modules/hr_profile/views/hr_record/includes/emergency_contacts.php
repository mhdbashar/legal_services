 <?php $this->load->view('details/modals/emergency_contact_modal') ?>
 <div class="_buttons">
 <?php if (has_permission('emergency_contacts', '', 'create')){ ?>   <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_emergency_contact"><?php echo _l('new_emergency_contact'); ?></a><?php } ?>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
/*`['name', 'relation', 'email', 'mobile'];*/
    _l('name'),
    _l('relation'),
    _l('email'),
    _l('mobile'),
    _l('control'),
    ),'emergency_contacts'); ?>
