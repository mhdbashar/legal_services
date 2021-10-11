<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php echo render_input('settings[receive_sms_token]','receive_sms_token',get_option('receive_sms_token'),'text'); ?>
<hr />
<!--<div class="row">-->
<!--    <div class="col-md-4">-->
<!--        --><?php //echo render_input('settings[sms_sender_1]','sms_sender_1',get_option('sms_sender_1'),'text'); ?>
<!--    </div>-->
<!--    <div class="col-md-4">-->
<!--        --><?php //echo render_input('settings[sms_sender_2]','sms_sender_2',get_option('sms_sender_2'),'text'); ?>
<!--    </div>-->
<!--    <div class="col-md-4">-->
<!--        --><?php //echo render_input('settings[sms_sender_3]','sms_sender_3',get_option('sms_sender_3'),'text'); ?>
<!--    </div>-->
<!--</div>-->

<div class="form-group" id="tbl_div">
    <label class="control-label clearfix">
        <?php echo _l('sms_senders') ?>
    </label>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <table class="table table-bordered table-hover" id="tab_logic">
                <thead>
                <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th class="text-center">
                        <?php echo _l('sender')?>
                    </th>

                </tr>
                </thead>
                <tbody>
                <tr id='addr0'>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr>
<a id="add_row" class="btn btn-success pull-left"><?php echo _l('add') ?></a><a id='delete_row'
                                                                                    class="pull-right btn btn-danger"><?php echo _l('delete') ?></a>
