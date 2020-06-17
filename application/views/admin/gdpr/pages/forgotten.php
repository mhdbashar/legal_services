<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="no-mtop mbot15">
   <?php echo _l('gdpr_right_to_erasure'); ?>
    <small>
        <a href="https://ico.org.uk/for-organisations/guide-to-the-general-data-protection-regulation-gdpr/individual-rights/right-to-erasure/" target="_blank"><?php echo _l('learn_more'); ?></a>
    </small>
</h4>
<ul class="nav nav-tabs tabs-in-body-no-margin" role="tablist">
    <li role="presentation" class="active">
       <a href="#forgotten_options" aria-controls="forgotten_options" role="tab" data-toggle="tab">
       <?php echo _l('gdpr_config');?>
      </a>
  </li>
  <li role="presentation">
   <a href="#removal_requests" aria-controls="removal_requests" role="tab" data-toggle="tab">
    <?php echo _l('gdpr_removal_requests');?>
       <?php if($not_pending_requests > 0){ ?>
       <span class="badge"><?php echo $not_pending_requests; ?></span>
       <?php } ?>
   </a>
</li>
</ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="forgotten_options">
        <h4 class="no-mtop"><?php echo _l('gdpr_contacts');?></h4>
        <hr class="hr-panel-heading">
        <?php render_yes_no_option('gdpr_contact_enable_right_to_be_forgotten','gdpr_enable_contact_to_request_data_removal'); ?>
        <hr />
        <?php render_yes_no_option('gdpr_on_forgotten_remove_invoices_credit_notes','gdpr_when_deleting_customer_delete_also_invoices_and_credit_notes_related_to_this_customer'); ?>
        <hr />
        <?php render_yes_no_option('gdpr_on_forgotten_remove_estimates','gdpr_when_deleting_customer_delete_also_estimates_related_to_this_customer'); ?>
        <hr class="hr-panel-heading">
        <h4><?php echo _l('gdpr_leads');?></h4>
        <hr class="hr-panel-heading">
        <?php render_yes_no_option('gdpr_lead_enable_right_to_be_forgotten','gdpr_enable_lead_to_request_data_removal_via_public_form'); ?>
        <hr />
        <?php render_yes_no_option('gdpr_after_lead_converted_delete','gdpr_after_lead_is_converted_to_customer_delete_all_lead_data'); ?>
        <hr />
    </div>
    <div role="tabpanel" class="tab-pane" id="removal_requests">
        <table class="table dt-table scroll-responsive" data-order-type="desc" data-order-col="4">
            <thead>
                <tr>
                    <th><?php echo _l('gdpr_request_id');?></th>
                    <th><?php echo _l('gdpr_request_form');?></th>
                    <th><?php echo _l('gdpr_forgotten_description');?></th>
                    <th><?php echo _l('gdpr_request_status');?></th>
                    <th><?php echo _l('gdpr_request_date');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($requests as $request) { ?>
                <tr>
                    <td data-order="<?php echo $request['id']; ?>"><?php echo $request['id']; ?></td>
                    <td><?php echo $request['request_from']; ?>
                        <?php if(!empty($request['contact_id'])) {
                            echo '<span class="label label-info pull-right">Contact</span>';
                        } else if(!empty($request['lead_id'])) {
                            echo '<span class="label label-info pull-right">Lead</span>';
                        }
                        ?>
                    </td>
                    <td><?php echo $request['description']; ?></td>
                    <td data-order="<?php echo $request['status']; ?>">
                        <select class="selectpicker removalStatus" name="status" data-id="<?php echo $request['id']; ?>"  width="100%">
                            <option value="pending"<?php if($request['status'] == 'pending'){echo ' selected';} ?>><?php echo _l('gdpr_forgotten_pending');?></option>
                            <option value="removed"<?php if($request['status'] == 'removed'){echo ' selected';} ?>><?php echo _l('gdpr_forgotten_removed');?></option>
                            <option value="refused"<?php if($request['status'] == 'refused'){echo ' selected';} ?>><?php echo _l('gdpr_forgottin_refused');?></option>
                        </select>
                    </td>
                    <td data-order="<?php echo $request['request_date']; ?>"><?php echo _dt($request['request_date']); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
