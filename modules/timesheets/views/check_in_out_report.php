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
                            <div class="row">
                                <?php echo form_open(admin_url('timesheets/check_in_out_filter'));
                                $from = date('Y-m-d h:i:s', strtotime('-20 days'));
                                $to = date('Y-m-d h:i:s');
                                ?>

                                <div class="col-md-3">
                                    <?php echo render_date_input('from_date','from_date', _d($from)); ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo render_date_input('to_date','to_date', _d($to)); ?>
                                </div>


                                <div class="col-md-3">
                                    <label  class="control-label"><?php echo _l('type_check'); ?></label>
                                    <select name="type_check" data-live-search="true" class="form-control"  data-actions-box="true" data-width="100%" <?php echo _l('select type_check'); ?>  >

                                    <option value='<?php echo $type_check ?>'><?php  if($type_check==1) echo _l('in'); else  if($type_check==2) echo _l('out'); else echo _l('all');    ?></option>
                                    <option value="1" >  <?php echo _l('in'); ?> </option>
                                        <option value="2" >  <?php echo _l('out'); ?> </option>
                                        <option value="3" >  <?php echo _l('all'); ?> </option>

                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-info btn-submit mtop25"><?php echo _l('filter'); ?></button>
                                </div>
                                <?php echo form_close(); ?>

                            </div>



                            <thead>
                            <th><?php echo _l('full_name'); ?></th>
                            <th><?php echo _l('date'); ?></th>
                            <th><?php echo _l('email'); ?></th>
                            <th><?php echo _l('type'); ?></th>
                            <th><?php echo _l('brand'); ?></th>
                            <th><?php echo _l('device'); ?></th>
                            </thead>
                            <tbody>
                            <?php foreach($check_in_out as $item){ ?>
                                <tr>
                                    <td>
                                        <a href=" <?php echo admin_url('hr/general/general/' . $item['staff_id'] . '?group=basic_information')?>">
                                            <?php echo addslashes($item['firstname'] . ' ' . $item['second_name'] . ' '. $item['third_name']. ' ' .$item['lastname']); ?>
                                        </a>
                                        </td>
                                    <td><?php echo addslashes($item['date']); ?></td>
                                    <td><?php echo addslashes($item['email']); ?></td>
                                    <td style="font-weight: bold"><?php echo $item['type_check'] == 1 ? 'دخول' : 'خروج'; ?></td>
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
<script>
    var from_date = $('input[name="from_date"]').val();
    var to_date = $('input[name="to_date"]').val();
</script>