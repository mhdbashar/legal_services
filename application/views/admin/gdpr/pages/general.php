<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="no-mtop">
    <?php echo _l('settings_group_general'); ?>
</h4>
<hr class="hr-panel-heading" />
<?php render_yes_no_option('enable_gdpr','gdpr_general_enable_gdpr'); ?>
<hr />
<?php render_yes_no_option('show_gdpr_in_customers_menu','gdpr_general_show_gdpr_link_in_customers_area_navigation'); ?>
<hr />
<?php render_yes_no_option('show_gdpr_link_in_footer','gdpr_general_show_gdpr_link_in_customers_area_footer'); ?>
<hr />
<p class="">
    <?php echo _l('gdpr_general_gdpr_page_top_information_block');?>
</p>
<?php echo render_textarea('settings[gdpr_page_top_information_block]','',get_option('gdpr_page_top_information_block'),array(),array(),'','tinymce'); ?>
