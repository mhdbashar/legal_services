<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();  ?>
<div id="wrapper">
<div class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="panel_s">
            <div class="panel-body">
               <div class="_buttons">
                   <?php if (has_permission('courts', '', 'create')) { ?>
                  <div class="_buttons">
                     <a href="<?php echo admin_url('add_court') ?>" class="btn btn-info pull-left display-block">
                     <?php echo _l('NewCourt'); ?>
                     </a>                 
                     <div class="clearfix"></div>
                     <hr class="hr-panel-heading" />
                  </div>
                   <?php } ?>
                  <table class="table dt-table scroll-responsive">
                     <thead>
                        <th>#</th>
                        <th><?php echo _l('name'); ?></th>                
                        <th><?php echo _l('options'); ?></th>
                     </thead>
                     <tbody>
                        <?php $i=1; foreach($courts as $court){ ?>
                        <tr>
                           <td><?php echo $i; ?></td>
                           <td>
                              <?php echo $court->court_name; ?>
                           </td>                      
                           <td>
                               <?php if (has_permission('courts', '', 'edit')) { ?>
                              <a href="<?php echo admin_url("edit_court/$court->c_id"); ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>
                               <?php } ?>
                               <?php if (has_permission('courts', '', 'delete')) { ?>
                              <a href="<?php echo admin_url("delete_court/$court->c_id"); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                               <?php } ?>
                               <?php if (has_permission('judicial_departments', '', 'create')) { ?>
                              <a href="<?php echo admin_url("judicial_control/$court->c_id"); ?>" class="btn btn-info btn-icon">                               
		                       <?php echo _l('Judicial'); ?>
		                      </a>
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