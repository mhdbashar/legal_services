<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();  ?>
<div id="wrapper">
<div class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="panel_s">
            <div class="panel-body">
               <div class="_buttons">
                   <?php if (has_permission('judicial_departments', '', 'create')) { ?>
                  <div class="_buttons">
                     <a href="<?php echo admin_url("add_judicial/$CourtID") ?>" class="btn btn-info pull-left display-block">
                     <?php echo _l('AddJudicialDept'); ?>
                     </a>                 
                     <div class="clearfix"></div>
                     <hr class="hr-panel-heading" />
                  </div>
                   <?php } ?>
                  <table class="table dt-table scroll-responsive">
                     <thead>
                        <th>#</th>
                        <th><?php echo _l('NumJudicialDept'); ?></th>       
                        <th><?php echo _l('options'); ?></th>
                     </thead>
                     <tbody>
                        <?php $i=1; foreach($judicials as $judicial){ ?>
                        <tr>
                           <td><?php echo $i; ?></td>                      
                           <td>
                              <?php echo $judicial->Jud_number; ?>
                           </td>
                           <td>
                               <?php if (has_permission('judicial_departments', '', 'edit')) { ?>
                              <a href="<?php echo admin_url("edit_judicial/$judicial->c_id/$judicial->j_id") ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>
                               <?php } ?>
                               <?php if (has_permission('judicial_departments', '', 'delete')) { ?>
                              <a href="<?php echo admin_url("delete_jud/$judicial->c_id/$judicial->j_id") ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                               <?php } ?>
                           </td>
                        </tr>
                        <?php $i++; } ?>
                     </tbody>
                  </table>  
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<?php init_tail(); ?>
</body>
</html>