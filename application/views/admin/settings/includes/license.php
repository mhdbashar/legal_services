<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
   <div class="col-md-12">
      <?php echo render_input('settings[license_key]', 'license_key', get_option('license_key'), 'text', array('data-ays-ignore'=>true)); ?>
   </div>
   <?php my_check_license()?>

</div>
