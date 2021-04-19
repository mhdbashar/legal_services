<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="no-mtop">
    <?php echo _l('gdpr_right_to_be_informed'); ?>
    <small>
        <a href="https://ico.org.uk/for-organisations/guide-to-the-general-data-protection-regulation-gdpr/individual-rights/right-to-be-informed/" target="_blank"><?php echo _l('learn_more'); ?></a>
    </small>
</h4>
<hr class="hr-panel-heading" />
<?php render_yes_no_option('gdpr_enable_terms_and_conditions','gdpr_informed_enable_terms_conditions_for_registration_and_customers_portal'); ?>
<hr />
<?php render_yes_no_option('gdpr_enable_terms_and_conditions_lead_form','gdpr_informed_enable_terms__onditions_for_web_to_lead_forms'); ?>
<hr />
<?php render_yes_no_option('gdpr_enable_terms_and_conditions_ticket_form','gdpr_informed_enable_terms_conditions_for_ticket_form'); ?>
<hr />
<?php render_yes_no_option('gdpr_show_terms_and_conditions_in_footer','gdpr_informed_show_terms_conditions_in_customers_area_footer'); ?>
<hr />
<?php render_yes_no_option('gdpr_enable_terms_and_conditions_estimate_request_form','Enable Terms & Conditions for estimate request forms'); ?>
<hr class="hr-panel-heading" />
<p class="">
    <?php echo _l('terms_and_conditions') ?>
    <br />
    <a href="<?php echo terms_url(); ?>" target="_blank"><?php echo terms_url(); ?></a>
</p>
<?php echo render_textarea('settings[terms_and_conditions]','',get_option('terms_and_conditions'),array(),array(),'','tinymce'); ?>
<hr />
<p class="">
    <i class="fa fa-question-circle" data-toggle="tooltip" data-title="You may want to include the privacy policy in your terms and condtions content."></i> <?php echo _l('gdpr_informed_privacy_policy');?>
    <br />
    <a href="<?php echo privacy_policy_url(); ?>" target="_blank"><?php echo privacy_policy_url(); ?></a>
</p>
<?php echo render_textarea('settings[privacy_policy]','',get_option('privacy_policy'),array(),array(),'','tinymce'); ?>
