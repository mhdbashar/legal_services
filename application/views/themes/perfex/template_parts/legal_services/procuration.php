<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<table class="table dt-table" data-order-col="0" data-order-type="asc">
    <thead>
    <tr>
        <th><?php echo _l('the_number_sign'); ?></th>
        <th><?php echo _l('procuration_number'); ?></th>
        <th><?php echo _l('start_date'); ?></th>
        <th><?php echo _l('end_date'); ?></th>
        <th><?php echo _l('added_from'); ?></th>
        <th><?php echo _l('type'); ?></th>
        <th><?php echo _l('state'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $ci = &get_instance();
    $ci->load->model('procurationtype_model');
    $ci->load->model('procurationstate_model');
    $ci->load->model('procurations_model');
    $i=1;
    foreach($procuration as $row){ ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['NO']; ?></td>
            <td><?php echo _d($row['start_date']); ?></td>
            <td><?php echo _d($row['end_date']); ?></td>
            <td><?php echo get_staff_full_name($row['addedfrom']); ?></td>
            <td>
                <?php
                if(isset($ci->procurationtype_model->get($row['type'])->procurationtype)) {
                    echo $procuration_type = $ci->procurationtype_model->get($row['type'])->procurationtype;
                }else{
                    echo $procuration_type = 'Not Selected';
                }
                ?>
            </td>
            <td>
                <?php
                if(isset($ci->procurationstate_model->get($row['status'])->procurationstate)) {
                    echo $procuration_state = $ci->procurationstate_model->get($row['status'])->procurationstate;
                }else{
                    echo $procuration_state = 'Not Selected';
                } ?>
            </td>
        </tr>
    <?php $i++; } ?>
    </tbody>
</table>