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
                        <h3> <?= _l('report') ?></h3>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <table class="apitable table dt-table">
                            <thead>
                            <th><?php echo _l('full_name'); ?></th>
                            <th><?php echo _l('email'); ?></th>
                            <th><?php echo _l('type'); ?></th>
                            <th><?php echo _l('brand'); ?></th>
                            <th><?php echo _l('device'); ?></th>
                            </thead>
                            <tbody>
                            <?php foreach($check_in_out as $item){ ?>
                                <tr>
                                    <td><?php echo addslashes($item['firstname'] . ' ' . $item['second_name'] . ' '. $item['third_name']. ' ' .$item['lastname']); ?></td>
                                    <td><?php echo addslashes($item['email']); ?></td>
                                    <td class="badge"><?php echo $item['type_check'] == 1 ? 'In' : 'Out'; ?></td>
                                    <td><?php echo addslashes($item['brand']); ?></td>
                                    <td><?php echo addslashes($item['device']); ?></td>
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
<?php init_tail(); ?>
