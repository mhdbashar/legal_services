<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
   <div class="col-md-12">
      <?php echo render_input('settings[license_key]', 'license_key', get_option('license_key'), 'text', array('data-ays-ignore'=>true)); ?>
   </div>
   <div class="col-md-12 text-center">
      <div class="alert alert-info">
         <h4 class="bold"><?php echo _l('license_info'); ?></h4>
         <p class="font-medium bold"><?php
         $results=my_check_license(); 
         if (is_array($results)){
         
            unset($results['localkey']);
          foreach($results as $key=>$value){
            echo "$key=$value<br />";
          }
         }
          ?></p>
      </div>
   </div>

</div>
