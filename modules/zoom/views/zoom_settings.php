<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
   <div class="col-md-12">
      <?php echo render_input('settings[zoom_api_key]', 'api_key', get_option('zoom_api_key'), 'text', array('data-ays-ignore'=>true)); ?>
   </div>

   <div class="col-md-12">
      <?php echo render_input('settings[zoom_secret_key]', 'secret_key', get_option('zoom_secret_key'), 'text', array('data-ays-ignore'=>true)); ?>
   </div>

</div>
