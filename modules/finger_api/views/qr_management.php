<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link href="<?php echo base_url('modules/finger_api/assets/main.css'); ?>" rel="stylesheet" type="text/css" />
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
<!--                        <div class="_buttons">-->
<!--                            <a href="#" onclick="new_user(); return false" class="btn btn-info pull-left display-block">--><?php //echo _l('new_user_api'); ?><!--</a>-->
<!--                        </div>-->
                        <h3> <?= _l('qr_code') ?></h3>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <table class="apitable table dt-table">
                            <thead>
                            <th><?php echo _l('full_name'); ?></th>
                            <th><?php echo _l('email'); ?></th>
                            <th><?php echo _l('qr_code'); ?></th>
                            </thead>
                            <tbody>
                            <?php foreach($staffs as $user){ ?>
                                <tr>
                                    <td><?php echo addslashes($user['firstname'] . ' ' . $user['second_name'] . ' '. $user['third_name']. ' ' .$user['lastname']); ?></td>
                                    <td><?php echo addslashes($user['email']); ?></td>
                                    <td>
                                        <?php $qr = $user['staffid'];?>
                                        <img class="img-responsive img-thumbnail" src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?php echo $qr ?>&choe=UTF-8" style="margin: 0 auto;display: block;">
                                        <p class="text-center"><b><i class="fa fa-question-circle" aria-hidden="true"></i> QR Code</b></p>
                                        <p class="text-center"><a href="https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl=<?php echo $qr ?>&choe=UTF-8" target="_blank"><button type="button" class="btn btn-success">Download</button></a></p>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="user_api" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('finger_api/user')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('edit_user_api'); ?></span>
                    <span class="add-title"><?php echo _l('new_user_api'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <?php echo render_input('user','user_api'); ?>
                        <?php echo render_input('name','name_api'); ?>
                        <?php echo render_datetime_input('expiration_date','expiration_date'); ?>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php init_tail(); ?>
<script src="<?php echo base_url('modules/finger_api/assets/main.js'); ?>"></script>