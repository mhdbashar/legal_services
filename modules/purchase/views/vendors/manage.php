<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            
            <div class="panel_s">
               <div class="panel-body">
                  <div class="_buttons">
                     <?php if (has_permission('purchase','','create')) { ?>
                     <a href="<?php echo admin_url('purchase/vendor'); ?>" class="btn btn-info mright5 test pull-left display-block">
                     <?php echo _l('new_vendor'); ?></a>

                     <a href="<?php echo admin_url('purchase/vendor_import'); ?>" class="btn btn-info mright5 test pull-left display-block">
                     <?php echo _l('import_vendors'); ?></a>

                     <a href="<?php echo admin_url('purchase/all_contacts'); ?>" class="btn btn-info pull-left display-block mright5">
                     <?php echo _l('vendor_contacts'); ?></a>
                     
                  <?php } ?>
                  </div>
                 
                  
                  
                  <div class="clearfix mtop20"></div>

                 <div class="modal bulk_actions" id="table_vendors_list_bulk_actions" tabindex="-1" role="dialog">
                      <div class="modal-dialog" role="document">
                         <div class="modal-content">
                            <div class="modal-header">
                               <h4 class="modal-title"><?php echo _l('bulk_actions'); ?></h4>
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                               <?php if(has_permission('rec_proposal','','delete') || is_admin()){ ?>
                               <div class="checkbox checkbox-danger">
                                  <input type="checkbox" name="mass_delete" id="mass_delete">
                                  <label for="mass_delete"><?php echo _l('mass_delete'); ?></label>
                               </div>
                              
                               <?php } ?>
                            </div>
                            <div class="modal-footer">
                               <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>

                               <?php if(has_permission('purchase','','delete') || is_admin()){ ?>
                               <a href="#" class="btn btn-info" onclick="purchase_delete_bulk_action(this); return false;"><?php echo _l('confirm'); ?></a>
                                <?php } ?>
                            </div>
                         </div>
                        
                      </div>
                      
                   </div>
                  <div class="row col-md-12"><hr/></div>

                  <a href="#"  onclick="staff_bulk_actions(); return false;" data-table=".table-vendors" class=" hide bulk-actions-btn table-btn"><?php echo _l('bulk_actions'); ?></a>
                  <?php
                     $table_data = array();
                     $_table_data = array(
                      '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="vendors"><label></label></div>',
                       array(
                         'name'=>_l('the_number_sign'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-number')
                        ),
                         array(
                         'name'=>_l('clients_list_company'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-company')
                        ),
                         array(
                         'name'=>_l('contact_primary'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-primary-contact')
                        ),
                         array(
                         'name'=>_l('company_primary_email'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-primary-contact-email')
                        ),
                        array(
                         'name'=>_l('clients_list_phone'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-phone')
                        ),
                         array(
                         'name'=>_l('customer_active'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-active')
                        ),
              
                        array(
                         'name'=>_l('date_created'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-date-created')
                        ),
                      );
                     foreach($_table_data as $_t){
                      array_push($table_data,$_t);
                     }

                     $custom_fields = get_custom_fields('vendors',array('show_on_table'=>1));
                     foreach($custom_fields as $field){
                      array_push($table_data,$field['name']);
                     }

                     render_datatable($table_data,'vendors',[],[
                           'data-last-order-identifier' => 'vendors',
                           'data-default-order'         => get_table_last_order('vendors'),
                     ]);
                     ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php init_tail(); ?>
</body>
</html>
