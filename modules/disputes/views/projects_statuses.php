<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();  ?>
<div id="wrapper">
<div class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="panel_s">
            <div class="panel-body">
               <div class="_buttons">
                  <div class="_buttons">
                     <a href="<?php echo admin_url('disputes/statuses/view') ?>" class="btn btn-info pull-left display-block">
                     <?php echo _l('new_status'); ?>
                     </a>                 
                     <div class="clearfix"></div>
                     <hr class="hr-panel-heading" />
                  </div>             
                  <table class="table dt-table scroll-responsive">
                     <thead>
                        <th>#</th>
                        <th><?php echo _l('name'); ?></th>                
                        <th><?php echo _l('options'); ?></th>
                     </thead>
                     <tbody>
                        <?php $i=1; foreach($statuses as $status){ ?>
                        <tr>
                           <td><?php echo $i; ?></td>
                           <td>
                              <?php echo $status->status_name; ?>
                           </td>                      
                           <td>
                              <a href="<?php echo admin_url("disputes/statuses/view/$status->id"); ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>                                     
                              <a href="<?php echo admin_url("disputes/statuses/delete/$status->id"); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>           
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