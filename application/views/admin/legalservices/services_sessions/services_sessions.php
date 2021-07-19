<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (has_permission('sessions', '', 'create')) { ?>
    <a href="#" onclick="new_session_from_relation(undefined,'<?php echo $service->slug; ?>',<?php echo $rel_id; ?>); return false;" class="btn btn-info"><?php echo _l('add_new_session'); ?></a>
<?php } ?>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="horizontal-scrollable-tabs preview-tabs-top">
    <div class="horizontal-tabs">
        <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
            <li role="presentation" class="active" >
                <a href="#Waiting_sessions" aria-controls="Waiting_sessions" role="tab" data-toggle="tab">
                    <?php echo _l('Waiting_sessions'); ?>
                </a>
            </li>
            <li role="presentation" class="tab-separator">
                <a href="#Previous_Sessions" aria-controls="Previous_Sessions" role="tab" data-toggle="tab">
                    <?php echo _l('Previous_Sessions') ?>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="Waiting_sessions">
        <?php
        $table_data = [
            _l('the_number_sign'),
            [
                'name'     => _l('name'),
                'th_attrs' => [
                    'style' => 'min-width:150px',
                ],
            ],
            _l('session_assigned'),
            _l('Court'),
            //_l('session_info'),
            _l('Customer_report'),
            _l('Send_to_customer'),
            _l('session_date'),
            _l('session_time'),
        ];
        $table_attributes['data-new-rel-slug'] = $service->slug;
        $custom_fields = get_custom_fields('sessions', [
            'show_on_table' => 1,
        ]);

        foreach ($custom_fields as $field) {
            array_push($table_data, $field['name']);
        }
        render_datatable($table_data, 'waiting_sessions_log', [], $table_attributes);
        ?>
    </div>
    <div role="tabpanel" class="tab-pane " id="Previous_Sessions">
        <?php
        $table_data = [
            _l('the_number_sign'),
            [
                'name'     => _l('name'),
                'th_attrs' => [
                    'style' => 'min-width:150px',
                ],
            ],
            _l('session_assigned'),
            _l('Court'),
//            _l('Court_decision'),
            _l('Customer_report'),
            _l('Send_to_customer'),
            _l('session_date'),
            _l('session_time'),
            _l('Customer_report'),
        ];
        $table_attributes['data-new-rel-slug'] = $service->slug;
        $custom_fields = get_custom_fields('sessions', [
            'show_on_table' => 1,
        ]);

        foreach ($custom_fields as $field) {
            array_push($table_data, $field['name']);
        }
        render_datatable($table_data, 'previous_sessions_log', [], $table_attributes);
        ?>
    </div>
</div>

<div id="session_report_data" class="hide">
    <h3 align="center"><u><?php echo _l('session_report'); ?></u></h3>
    <table class="table scroll-responsive" style="border: 1px solid #ebf5ff">
        <thead>
        <tr>
            <th style="width: 30%"><?php echo _l('case_number'); ?></th>
            <td id="tbl1"></td>
        </tr>
        <tr>
            <th style="width: 30%"><?php echo _l('Parties_case'); ?></th>
            <td>
                <p> <?php echo _l('claimant'); ?> <b id="tbl2"></b></p>
                <p> <?php echo _l('accused'); ?> <b id="tbl3"></b></p>
            </td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('court_competent_follow'); ?></th>
            <td id="tbl4"></td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('Current_session_date'); ?></th>
            <td id="tbl5"></td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('Next_session_date'); ?></th>
            <td id="tbl6"></td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('Proceedings_of_session'); ?></th>
            <td id="tbl7"></td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('Court_decision'); ?></th>
            <td id="tbl8"></td>
        </tr>
        <tr>
            <th style="width: 30%;"><?php echo _l('upcoming_actions'); ?></th>
            <td id="tbl9"></td>
        </tr>
        </thead>
    </table>
</div>
<script type="text/javascript">

    function print_session_report(task_id) {
        disabled_print_btn(task_id);
        $("#tbl9").html('');
        tag = '#';
        $.ajax({
            url: '<?php echo admin_url("legalservices/sessions/print_report/"); ?>' + task_id,
            success: function (data) {
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    if (value == '') {
                        value = '<?php echo _l('smtp_encryption_none') ?>';
                    }
                    $(tag + key).html(value);
                });
            }
        });
        $.ajax({
            url: '<?php echo admin_url("legalservices/sessions/checklist_items_description/"); ?>' + task_id,
            success: function (data) {
                arr = JSON.parse(data);
                if (arr.length == 0) {
                    $("#tbl9").html(
                        '<?php echo _l('session_no_checklist_items_found') ?>'
                    );
                }else {
                    $.each(arr, function (row, item) {
                        $("#tbl9").append(
                            '<p>- ' + item.description + '</p>'
                        );
                    });
                }
            }
        });
        setTimeout(function(){
            var printContents = document.getElementById("session_report_data").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        },2000);
    }

    function send_report(task_id) {
        $.ajax({
            url: '<?php echo admin_url("legalservices/sessions/send_report_to_customer/"); ?>' + task_id,
            success: function (data) {
                if(data == 1){
                    alert_float('success', '<?php echo _l('Done').' '._l('Send_to_customer'); ?>');
                    reload_tasks_tables();
                }else if (data == 2){
                    alert_float('danger', '<?php echo _l('no_primary_contact'); ?>');
                }else {
                    alert_float('danger', '<?php echo _l('Faild'); ?>');
                }
            }
        });
    }
</script>
