<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="wrapper" >
</div><?php

if(get_contact_language()=='arabic'){
    $lang='ar';
}else{
    $lang='en';
}

?>


   <div class="content">
   		<?php echo form_hidden('connector', $connector); ?>
   		<?php echo form_hidden('client_default_language', $lang); ?>
   		<?php echo form_hidden('media_locale', get_media_locale($locale)); ?>
  		<div id="elfinder"></div>
	</div>
</div>