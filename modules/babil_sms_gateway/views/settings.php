<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php echo render_input('settings[receive_sms_token]','receive_sms_token',get_option('receive_sms_token'),'text'); ?>
<div class="row">
    <div class="col-md-12">
    <div class="form-group">
        <label for="settings[new_gateway]" class="control-label"><?php echo _l('gateway') ?></label>
        <select required="required" class="form-control" id="settings[new_gateway]" name="settings[new_gateway]"  aria-invalid="false">
            <option <?php if(!get_option('new_gateway')) echo "selected" ?> value="0"><?= _l('old_gateway') ?></option>
            <option <?php if(get_option('new_gateway')) echo "selected" ?> value="1"><?= _l('new_gateway') ?></option>
        </select>
    </div>
    </div>
</div>
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
