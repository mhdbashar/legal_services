<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="no-mtop">
    <?php echo _l('gdpr_right_of_access'); ?>/<?php echo _l('gdpr_right_to_rectification'); ?>
    <small>
        <a href="https://ico.org.uk/for-organisations/guide-to-the-general-data-protection-regulation-gdpr/individual-rights/right-of-access/" target="_blank"><?php echo _l('learn_more'); ?></a>
    </small>
</h4>
<hr class="hr-panel-heading" />
<h4 class="bold"><?php echo _l('gdpr_protability_contacts');?></h4>
<hr class="hr-panel-heading" />
<p>
<?php echo _l('gdpr_protability_custmers_view_information');?>
</p>
<p> <?php echo _l('gdpr_protability_contacts_modify');?></p>
<hr class="hr-panel-heading" />
<p class="font-medium"><?php echo _l('gdpr_portability_profile_contact');?></p>
<?php render_yes_no_option('allow_primary_contact_to_view_edit_billing_and_shipping', 'allow_primary_contact_to_view_edit_billing_and_shipping'); ?>
<small><?php echo _l('gdpr_portability_customer_update_info');?></small></p>
<hr />
<?php render_yes_no_option('allow_contact_to_delete_files', 'allow_contact_to_delete_files'); ?>
<hr class="hr-panel-heading" />
<h4 class="bold" id="access_leads"><?php echo _l('gdpr_portability_leads');?></h4>
<hr class="hr-panel-heading" />
<?php render_yes_no_option('gdpr_enable_lead_public_form', 'Enable public form for leads', 'gdpr_portability_leads_update_info'); ?>
<hr />
<?php render_yes_no_option('gdpr_show_lead_custom_fields_on_public_form', 'gdpr_portability_leads_custom_fields'); ?>
<hr />
<?php render_yes_no_option('gdpr_lead_attachments_on_public_form', 'gdpr_portability_leads_attachments'); ?>
