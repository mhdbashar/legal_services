<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
   <div class="col-md-12">
      <?php echo render_input('settings[zoom_api_key]', _l('api_key'), get_option('zoom_api_key'), 'text', array('data-ays-ignore'=>true)); ?>
   </div>

   <div class="col-md-12">
      <?php echo render_input('settings[zoom_secret_key]',_l('secret_key'), get_option('zoom_secret_key'), 'text', array('data-ays-ignore'=>true)); ?>
   </div>
   &nbsp&nbsp <a target="_blank" href="https://zoom.us/signin"><?php echo _l('link_to_register');?></a><br><br>
    
   &nbsp&nbsp  <a target="_blank" href="https://marketplace.zoom.us/develop/create"><?php echo _l('link_to_create_jwt_app');?></a>
    
</div>
