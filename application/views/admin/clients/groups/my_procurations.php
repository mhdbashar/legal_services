<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="customer-profile-group-heading"><?php echo _l('procurations'); ?></h4>
                  <div class="_buttons">
                     <?php if(is_admin()) { ?>
                     <a href="<?php echo admin_url('procuration/procurationcu'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_procuration'); ?></a>
                     <div class="clearfix"></div>
                     <hr class="hr-panel-heading" />
                     <?php } else { echo '<h4 class="no-margin bold">'._l('announcements').'</h4>';} ?>
                  </div>
            <div class="clearfix"></div>
                    <?php render_datatable(array(
                     _l('NO'),
                     _l('start_date'),
                     _l('end_date'),
                     _l('added_from'),
                     _l('type'),
                     _l('state'),
                     _l('control'),
                  ),'procurations-single-client'); ?>
    
   <?php echo form_close(); ?>
<?php if(isset($client)){ ?>
<?php if (has_permission('customers', '', 'create') || has_permission('customers', '', 'edit')) { ?>
<div class="modal fade" id="customer_admins_assign" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <?php echo form_open(admin_url('clients/assign_admins/'.$client->userid)); ?>
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo _l('assign_admin'); ?></h4>
         </div>
         <div class="modal-body">
            <?php
               $selected = array();
               foreach($customer_admins as $c_admin){
                  array_push($selected,$c_admin['staff_id']);
               }
               echo render_select('customer_admins[]',$staff,array('staffid',array('firstname','lastname')),'',$selected,array('multiple'=>true),array(),'','',false); ?>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
         </div>
      </div>
      <!-- /.modal-content -->
      <?php echo form_close(); ?>
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php } ?>
<?php } ?>
<?php $this->load->view('admin/clients/client_group'); ?>
