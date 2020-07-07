<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="no-mtop">
  <?php echo _l('gdpr_right_to_data_portability'); ?>
  <small>
    <a href="https://ico.org.uk/for-organisations/guide-to-the-general-data-protection-regulation-gdpr/individual-rights/right-to-data-portability/" target="_blank"><?php echo _l('learn_more'); ?></a>
  </small>
</h4>
<hr class="hr-panel-heading" />
<h4><?php echo _l('gdpr_protability_contacts');?></h4>
<hr class="hr-panel-heading" />
<?php render_yes_no_option('gdpr_data_portability_contacts','gdpr_portability_enable_contact_to_export_data'); ?>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <?php
      $valAllowed = get_option('gdpr_contact_data_portability_allowed');
      if(empty($valAllowed)) {
        $valAllowed = array();
      } else {
        $valAllowed = unserialize($valAllowed);
      }
      ?>
      <label for="gdpr_contact_data_portability_allowed"><?php echo _l('gdpr_portability_enable_contact_to_export_data');?></label>
      <div class="select-placeholder">
       <select name="settings[gdpr_contact_data_portability_allowed][]" data-actions-box="true" multiple title="None" id="gdpr_contact_data_portability_allowed" class="selectpicker" data-width="100%">
        <option value="profile_data"<?php if(in_array('profile_data', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_contact_profile_data');?></option>
        <option value="consent"<?php if(in_array('consent', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_contact_history');?></option>
        <option value="tickets"<?php if(in_array('tickets', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_consent_tickets');?></option>
          <option data-divider="true"></option>
          <option value="" disabled="true"><?php echo _l('gdpr_portability_only_applied_if_contact_is_primary');?></option>

         <optgroup label="Customer">
          <option value="customer_profile_data"<?php if(in_array('customer_profile_data', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_cutomer_profile_data');?></option>
          <option value="profile_notes"<?php if(in_array('profile_notes', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_potability_customer_profile_notes');?></option>
          <option value="contacts"<?php if(in_array('contacts', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_contacts_sec');?></option>
        </optgroup>
        <optgroup label="Invoices">
          <option value="invoices"<?php if(in_array('invoices', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_invoices_data');?></option>
          <option value="invoices_notes"<?php if(in_array('invoices_notes', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_invoices_notes');?></option>
          <option value="invoices_activity_log"<?php if(in_array('invoices_activity_log', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_activity_log');?></option>
        </optgroup>
        <optgroup label="Estimates">
          <option value="estimates"<?php if(in_array('estimates', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_estimates_data');?></option>
          <option value="estimates_notes"<?php if(in_array('invoices_notes', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_estimates_notes');?></option>
          <option value="estimates_activity_log"<?php if(in_array('estimates_activity_log', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_activity_log');?></option>
        </optgroup>
        <optgroup label="Projects">
            <option value="projects"<?php if(in_array('projects', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_projects');?></option>
            <option value="related_tasks"<?php if(in_array('related_tasks', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_tasks_creates_from_contact');?></option>
            <option value="related_discussions"<?php if(in_array('related_discussions', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_discussion_created_from_contact');?></option>
            <option value="projects_activity_log"<?php if(in_array('projects_activity_log', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_activity_log');?></option>
        </optgroup>

        <option value="credit_notes"<?php if(in_array('credit_notes', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_credit_notes');?></option>
        <option value="proposals"<?php if(in_array('proposals', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_proposals');?></option>
        <option value="subscriptions"<?php if(in_array('subscriptions', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_subscriptions');?></option>
        <option value="expenses"<?php if(in_array('expenses', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_expenses');?></option>
        <option value="contracts"<?php if(in_array('contracts', $valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_contracts');?></option>


    </select>
  </div>
</div>

</div>
</div>
<hr class="hr-panel-heading" />
<h4><?php echo _l('gdpr_portability_leads');?></h4>
<hr class="hr-panel-heading" />
<?php render_yes_no_option('gdpr_data_portability_leads','gdpr_portability_enable_leads_to_export_data'); ?>
<hr />
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <?php
      $valAllowed = get_option('gdpr_lead_data_portability_allowed');
      if(empty($valAllowed)) {
        $valAllowed = array();
      } else {
        $valAllowed = unserialize($valAllowed);
      }
      ?>
      <label for="gdpr_lead_data_portability_allowed"><?php echo _l('gdpr_portability_on_export_the_following_data');?></label>
      <div class="select-placeholder">
       <select name="settings[gdpr_lead_data_portability_allowed][]" data-actions-box="true" multiple title="None" id="gdpr_lead_data_portability_allowed" class="selectpicker" data-width="100%">
        <option value=""></option>
        <option value="profile_data"<?php if(in_array('profile_data',$valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_potability_profile_data');?></option>
        <option value="custom_fields"<?php if(in_array('custom_fields',$valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_cusom_fields');?></option>
        <option value="notes"<?php if(in_array('notes',$valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portabiltity_notes');?></option>
        <option value="activity_log"<?php if(in_array('activity_log',$valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_activity_log');?></option>
        <option value="proposals"<?php if(in_array('proposals',$valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_proposals');?></option>
        <option value="integration_emails"<?php if(in_array('integration_emails',$valAllowed)){echo ' selected';} ?>><?php echo _l('gdpr_portability_email_integration');?></option>
        <option value="consent"<?php if(in_array('consent',$valAllowed)){echo ' selected';} ?>><?php echo _l('gadpr_potability_consent_history');?></option>
      </select>
    </div>
  </div>

</div>
</div>
