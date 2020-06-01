<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="text-danger"><?php echo _l('ConfirmEmptyLegalServicesRecycleBin'); ?></h4>
                        <div class="clearfix"></div>
                        <h5>
                            <?php $empty_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.get_option('automatically_empty_recycle_bin_after_days').' days'));
                            echo _l('EmptyLegalServicesRecycleBinNote').' '. $empty_date; ?>
                        </h5>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <a href="<?php echo admin_url('LegalServices/LegalServices_controller/confirm_empty_recycle_bin/yes'); ?>" class="btn btn-success btn-icon">
                            <?php echo _l('reminder_is_notified_boolean_yes').', '. _l('gdpr_consent_agree'); ?>
                        </a>
                        <a href="<?php echo admin_url('LegalServices/LegalServices_controller/confirm_empty_recycle_bin/no'); ?>" class="btn btn-default btn-icon">
                            <?php echo _l('reminder_is_notified_boolean_no').', '. _l('gdpr_consent_disagree'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
</body>
</html>