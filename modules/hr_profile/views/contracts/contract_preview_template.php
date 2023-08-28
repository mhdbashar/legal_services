<div class="row tab-left-0">
    <div class="col-md-12">
        <div class="horizontal-scrollable-tabs preview-tabs-top">
            <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
            <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
            <div class="horizontal-tabs">
                <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#contract_infor" aria-controls="contract_infor" role="tab" data-toggle="tab">
                            <?php echo _l('hr_contract_information'); ?>
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#contract" aria-controls="contract" role="tab" data-toggle="tab">
                            <?php echo _l('contract_content'); ?>
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#notes" aria-controls="notes" role="tab" data-toggle="tab">
                            <?php echo _l('notes'); ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">
                            <?php echo _l('comments'); ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">
                            <?php echo _l('attachments'); ?>
                        </a>
                    </li>
                    <li role="presentation" class="tab-separator">
                        <a href="#tab_tasks" aria-controls="tab_tasks" role="tab" data-toggle="tab"
                           onclick="init_rel_tasks_table(<?php echo $contracts->id_contract; ?>,'hr_contract'); return false;">
                            <?php echo _l('tasks'); ?>
                        </a>
                    </li>
                    <li role="presentation" class="tab-separator">
                        <a href="#tab_templates"
                           onclick="get_templates('hr_contracts', <?php echo $contracts->id_contract ?>); return false"
                           aria-controls="tab_templates" role="tab" data-toggle="tab">
                            <?php echo _l('templates'); ?>
                        </a>
                    </li>
                    <li role="presentation" class="<?php if ($this->input->get('tab') == 'renewals') {
                        echo 'active';
                    } ?>">
                        <a href="#renewals" aria-controls="renewals" role="tab" data-toggle="tab">
                            <?php echo _l('no_contract_renewals_history_heading'); ?>
                            <!--                            --><?php //if($totalRenewals = count($contract_renewal_history)) { ?>
                            <!--                                <span class="badge">-->
                            <?php //echo $totalRenewals; ?><!--</span>-->
                            <!--                            --><?php //} ?>
                        </a>
                    </li>


                    <li role="presentation" class="tab-separator toggle_view">
                        <a href="#" onclick="contract_full_view(); return false;" data-toggle="tooltip"
                           data-title="<?php echo _l('toggle_full_view'); ?>">
                            <i class="fa fa-expand"></i></a>
                    </li>


                </ul>
            </div>
        </div>
    </div>
</div>


<div class="tab-content">
    <div role="tabpanel"
         class="tab-pane<?php if (!$this->input->get('tab') || $this->input->get('tab') == 'contract_infor') {
             echo ' active';
         } ?>" id="contract_infor">

        <div class="">
            <div class="">
                <?php
                $contract_status = (isset($contracts) ? $contracts->contract_status : '');
                ?>

                <?php if ($contract_status == 'draft') { ?>
                    <div class="wrap">
                        <div class="ribbonc contract-ribbonc-warning"><span><?php echo _l('hr_hr_draft'); ?></span>
                        </div>
                    </div>
                <?php } elseif ($contract_status == 'valid') { ?>
                    <div class="wrap">
                        <div class="ribbonc contract-ribbonc-success"><span><?php echo _l('hr_hr_valid'); ?></span>
                        </div>
                    </div>
                <?php } elseif ($contract_status == 'invalid') { ?>
                    <div class="wrap">
                        <div class="ribbonc contract-ribbonc-danger"><span><?php echo _l('hr_hr_expired'); ?></span>
                        </div>
                    </div>
                <?php } elseif ($contract_status == 'finish') { ?>
                    <div class="wrap">
                        <div class="ribbonc contract-ribbonc-primary"><span><?php echo _l('hr_hr_finish'); ?></span>
                        </div>
                    </div>
                <?php } ?>


                <?php $value = (isset($contracts) ? $contracts->name_contract : ''); ?>
                <?php $attrs = (isset($contracts) ? array() : array('autofocus' => true)); ?>

            </div>

            <div class="col-md-12">
                <h5 class="h5-color"><?php echo _l('general_info') ?></h5>
                <hr class="hr-color">
            </div>

            <div class="col-md-6">
                <table class="table border table-striped ">
                    <tbody>
                    <?php
                    $contract_code = (isset($contracts) ? $contracts->contract_code : ''); ?>

                    <tr class="project-overview">
                        <td class="bold" width="30%"><?php echo _l('hr_contract_code'); ?></td>
                        <td class="text-right"><?php echo html_entity_decode($contract_code); ?></td>
                    </tr>
                    <tr class="project-overview">
                        <td class="bold" width="30%"><?php echo _l('hr_name_contract'); ?></td>
                        <?php foreach ($contract_type as $c) {
                            if (isset($contracts) && $contracts->name_contract == $c['id_contracttype']) {
                                ?>
                                <td class="text-right"><?php echo html_entity_decode($c['name_contracttype']); ?></td>
                            <?php } ?>
                        <?php } ?>
                    </tr>

                    </tbody>
                </table>

            </div>

            <div class="col-md-6">
                <table class="table table-striped">

                    <tbody>
                    <tr class="project-overview">
                        <td class="bold" width="40%"><?php echo _l('staff'); ?></td>
                        <?php foreach ($staff as $s) {
                            if (isset($contracts) && $contracts->staff == $s['staffid']) {
                                ?>
                                <td class="text-right">
                                    <a href="<?php echo admin_url('profile/' . $s['staffid']); ?>">
                                        <?php echo staff_profile_image($s['staffid'], [
                                            'staff-profile-image-small mright5',
                                        ], 'small', [
                                            'data-toggle' => 'tooltip',
                                            'data-title' => get_staff_full_name($s['staffid']),
                                        ]); ?>
                                    </a><?php echo html_entity_decode($s['firstname'] . ' ' . $s['lastname']); ?></td>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                    <tr class="project-overview">
                        <?php $start_valid = (isset($contracts) ? $contracts->start_valid : '');
                        ?>
                        <?php $end_valid = (isset($contracts) ? $contracts->end_valid : '');
                        ?>
                        <td class="bold"><?php echo _l('hr_hr_time'); ?></td>
                        <td class="text-right"><?php echo _d($start_valid) . " - " . _d($end_valid); ?></td>
                    </tr>
                    <tr class="project-overview">
                        <td class="bold" width="30%"><?php echo _l('hr_hourly_rate_month'); ?></td>
                        <td class="text-right"><?php echo _l($contracts->hourly_or_month); ?></td>
                    </tr>
                    <tr class="project-overview hide">
                        <?php
                        $contract_status = (isset($contracts) ? $contracts->contract_status : '');
                        $_data = '';
                        ?>
                        <td class="bold"><?php echo _l('hr_status_label'); ?></td>
                        <td class="text-right">
                            <?php if ($contract_status == 'draft') {
                                $_data .= ' <span class="label label-warning" > ' . _l('hr_hr_draft') . ' </span>';
                            } elseif ($contract_status == 'valid') {
                                $_data .= ' <span class="label label-success"> ' . _l('hr_hr_valid') . ' </span>';
                            } elseif ($contract_status == 'invalid') {
                                $_data .= ' <span class="label label-danger"> ' . _l('hr_hr_expired') . ' </span>';
                            } elseif ($contract_status == 'finish') {
                                $_data .= ' <span class="label label-primary"> ' . _l('hr_hr_finish') . ' </span>';
                            }

                            echo html_entity_decode($_data);
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <h5 class="h5-color"><?php echo _l('hr_wages_allowances') ?></h5>
                <hr class="hr-color">
            </div>

            <div class="col-md-12">
                <table class="table border table-striped ">
                    <thead>
                    <th class="th-color"><?php echo _l('hr_hr_contract_rel_type'); ?></th>
                    <th class="text-center th-color"><?php echo _l('hr_hr_contract_rel_value'); ?></th>
                    <th class="th-color"><?php echo _l('hr_start_month'); ?></th>
                    <th class="th-color"><?php echo _l('note'); ?></th>
                    </thead>
                    <tbody>
                    <?php foreach ($contract_details as $contract_detail) { ?>
                        <?php
                        $type_name = '';
                        if (preg_match('/^st_/', $contract_detail['rel_type'])) {
                            $rel_value = str_replace('st_', '', $contract_detail['rel_type']);
                            $salary_type = $this->hr_profile_model->get_salary_form($rel_value);

                            $type = 'salary';
                            if ($salary_type) {
                                $type_name = $salary_type->form_name;
                            }

                        } elseif (preg_match('/^al_/', $contract_detail['rel_type'])) {
                            $rel_value = str_replace('al_', '', $contract_detail['rel_type']);
                            $allowance_type = $this->hr_profile_model->get_allowance_type($rel_value);

                            $type = 'allowance';
                            if ($allowance_type) {
                                $type_name = $allowance_type->type_name;
                            }
                        }
                        ?>
                        <tr>
                            <td><?php echo html_entity_decode($type_name); ?></td>
                            <td class="text-right"><?php echo app_format_money((float)$contract_detail['rel_value'], ''); ?></td>
                            <td><?php echo _d($contract_detail['since_date']); ?></td>
                            <td><?php echo html_entity_decode($contract_detail['contract_note']); ?></td>

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <h5 class="h5-color"><?php echo _l('hr_sign_day') ?></h5>
                <hr class="hr-color">
            </div>

            <div class="col-md-6">
                <table class="table border table-striped ">
                    <tbody>
                    <?php
                    $sign_day = (isset($contracts) ? $contracts->sign_day : '');
                    ?>
                    <tr class="project-overview">
                        <td class="bold" width="30%"><?php echo _l('hr_sign_day'); ?></td>
                        <td class="text-right"><?php echo _d($sign_day); ?></td>
                    </tr>
                    <tr class="project-overview">
                        <?php
                        if (isset($staff_delegate_role) && $staff_delegate_role != null) {
                            $staff_role = $staff_delegate_role->name;
                        } else {
                            $staff_role = '';
                        } ?>

                        <td class="bold" width="30%"><?php echo _l('hr_hr_job_position'); ?></td>
                        <td class="text-right"><?php echo html_entity_decode($staff_role); ?></td>

                    </tr>
                    </tbody>
                </table>

            </div>

            <div class="col-md-6">
                <table class="table table-striped">

                    <tbody>
                    <tr class="project-overview">
                        <td class="bold" width="40%"><?php echo _l('hr_staff_delegate'); ?></td>
                        <?php foreach ($staff as $s) {
                            if (isset($contracts) && $contracts->staff_delegate == $s['staffid']) {
                                ?>
                                <td class="text-right">
                                    <a href="<?php echo admin_url('profile/' . $s['staffid']); ?>">
                                        <?php echo staff_profile_image($s['staffid'], [
                                            'staff-profile-image-small mright5',
                                        ], 'small', [
                                            'data-toggle' => 'tooltip',
                                            'data-title' => get_staff_full_name($s['staffid']),
                                        ]); ?>
                                    </a><?php echo html_entity_decode($s['firstname'] . '' . $s['lastname']); ?></td>
                            <?php } ?>
                        <?php } ?>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>
        <div id="contract_file_data"></div>
    </div>

    <div role="tabpanel" class="tab-pane " id="notes">


        <div class="form-group" app-field-wrapper="description">
            <textarea id="description_id" name="description" class="form-control" rows="4"></textarea>
        </div>
        <div class="text-right" id="button_note">
            <button onclick="add_node()" type="button" class="btn btn-info mtop15 mbot15">إضافة ملاحظة</button>
        </div>
        <div class="mtop15">
            <table class="table dt-table" data-order-col="2" data-order-type="desc">
                <thead>
                <tr>
                    <th width="80%">
                        <?php echo _l('clients_notes_table_description_heading'); ?>
                    </th>
                    <!--                    <th>-->
                    <!--                        --><?php //echo _l( 'clients_notes_table_addedfrom_heading'); ?>
                    <!--                    </th>-->
                    <!--                    <th>-->
                    <!--                        --><?php //echo _l( 'clients_notes_table_dateadded_heading'); ?>
                    <!--                    </th>-->
                    <th>
                        <?php echo _l('options'); ?>
                    </th>
                </tr>
                </thead>
                <tbody id="tbody-notes">
                <?php foreach ($notes as $note) { //$user_notes?>
                    <tr id="note-<?php echo $note['id']; ?>">
                        <td width="80%">
                            <?php echo $note['content']; ?>
                        </td>
                        <td>
                            <a href="#" class="btn btn-default btn-icon"
                               onclick="get_update_note(<?php echo $note['id']; ?>);return false;"><i
                                        class="fa fa-pencil-square-o"></i></a>
                            <a href="#" onclick="delete_note(<?php echo $note['id']; ?>);return false;"
                               class="btn btn-danger btn-icon"><i class="fa fa-remove"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
    <div role="tabpanel" class="tab-pane " id="comments">


        <div class="form-group" app-field-wrapper="comment content">
            <textarea id="comment_content_id" name="comment content" class="form-control" rows="4"></textarea>
        </div>
        <div class="text-right" id="button_comment">
            <button onclick="add_comment()" type="button" class="btn btn-info mtop15 mbot15">إضافة تعليق</button>
        </div>
        <div class="mtop15">
            <table class="table dt-table" data-order-col="2" data-order-type="desc">
                <thead>
                <tr>
                    <th width="80%">
                        <?php echo _l('clients_notes_table_description_heading'); ?>
                    </th>
                    <!--                    <th>-->
                    <!--                        --><?php //echo _l( 'clients_notes_table_addedfrom_heading'); ?>
                    <!--                    </th>-->
                    <!--                    <th>-->
                    <!--                        --><?php //echo _l( 'clients_notes_table_dateadded_heading'); ?>
                    <!--                    </th>-->
                    <th>
                        <?php echo _l('options'); ?>
                    </th>
                </tr>
                </thead>
                <tbody id="tbody-comments">
                <?php foreach ($comments as $comment) { //$user_comments?>
                    <tr id="comment-<?php echo $comment['id']; ?>">
                        <td width="80%">
                            <?php echo $comment['content']; ?>
                        </td>
                        <td>
                            <a href="#" class="btn btn-default btn-icon"
                               onclick="get_update_comment(<?php echo $comment['id']; ?>);return false;"><i
                                        class="fa fa-pencil-square-o"></i></a>
                            <a href="#" onclick="delete_comment(<?php echo $comment['id']; ?>);return false;"
                               class="btn btn-danger btn-icon "><i class="fa fa-remove"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>


    </div>
    <div role="tabpanel" class="tab-pane" id="attachments">
        <?php echo form_open(admin_url('hr_profile/add_contract_attachment/' . $contracts->id_contract), array('id' => 'contract-attachments-form', 'class' => 'dropzone mtop15')); ?>
        <?php echo form_close(); ?>
        <!--        <div class="text-right mtop15">-->
        <!--            <button class="gpicker" data-on-pick="contractGoogleDriveSave">-->
        <!--                <i class="fa fa-google" aria-hidden="true"></i>-->
        <!--                --><?php //echo _l('choose_from_google_drive'); ?>
        <!--            </button>-->
        <!--            <div id="dropbox-chooser"></div>-->
        <!--            <div class="clearfix"></div>-->
        <!--        </div>-->
        <!-- <img src="https://drive.google.com/uc?id=14mZI6xBjf-KjZzVuQe8-rjtv_wXEbDTw" /> -->

        <div id="hr_contract_attachments" class="mtop30">
            <?php
            $data = '<div class="row">';
            foreach ($attachments as $attachment) {
                $href_url = site_url('download/file/hr_contract/' . $attachment['attachment_key']);
                if (!empty($attachment['external'])) {
                    $href_url = $attachment['external_link'];
                }
                $data .= '<div class="display-block contract-attachment-wrapper">';
                $data .= '<div class="col-md-10">';
                $data .= '<div class="pull-left"><i class="' . get_mime_class($attachment['filetype']) . '"></i></div>';
                $data .= '<a href="' . $href_url . '"' . (!empty($attachment['external']) ? ' target="_blank"' : '') . '>' . $attachment['file_name'] . '</a>';
                $data .= '<p class="text-muted">' . $attachment["filetype"] . '</p>';
                $data .= '</div>';
                $data .= '<div class="col-md-2 text-right">';
                if ($attachment['staffid'] == get_staff_user_id() || is_admin()) {
                    $data .= '<a href="#" class="text-danger" onclick="delete_contract_attachment(this,' . $attachment['id'] . '); return false;"><i class="fa fa fa-times"></i></a>';
                }
                $data .= '</div>';
                $data .= '<div class="clearfix"></div><hr/>';
                $data .= '</div>';
            }
            $data .= '</div>';
            echo $data;
            ?>


        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab_tasks">
        <?php init_relation_tasks_table(array('data-new-rel-id' => $contracts->id_contract, 'data-new-rel-type' => 'hr_contract')); ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab_templates">
        <div class="row contract-templates">
            <div class="col-md-12">
                <button type="button" class="btn btn-info"
                        onclick="add_template('hr_contracts', <?php echo $contracts->id_contract ?>);"><?php echo _l('add_template'); ?></button>

                <hr>
            </div>
            <div class="col-md-12">
                <div id="hr_contract-templates" class="contract-templates-wrapper"></div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane<?php if ($this->input->get('tab') == 'renewals') {
        echo ' active';
    } ?>" id="renewals">
        <?php if (has_permission('hr_profile', '', 'create') || has_permission('contracts', '', 'edit')) { ?>
            <div class="_buttons">
                <button onclick="add_template_renew(<?php echo $contracts->id_contract ?>)" class="btn btn-default"
                        data-toggle="modal" data-target="#renew_contract_modal">
                    <i class="fa fa-refresh"></i> <?php echo _l('contract_renew_heading'); ?>
                </button>
            </div>
            <div class="col-md-12">

            </div>
            <hr/>
        <?php } ?>
        <div class="clearfix"></div>
        <div id="hr-contract-renews">
        <?php
        if (count($contract_renewal_history) == 0) {
            echo _l('no_contract_renewals_found');
        }
        foreach ($contract_renewal_history as $renewal) { ?>
            <div id="renewl-<?=$renewal['id']?>)" class="display-block">
                <div class="media-body">
                    <div class="display-block">
                        <b>
                            <?php
                            echo _l('contract_renewed_by', get_staff_full_name($renewal['renewed_by']))
                            ?>
                        </b>
                        <?php if ($renewal['renewed_by'] == get_staff_user_id() || is_admin()) { ?>
                            <button onclick="delete_renewal(<?php echo $renewal['id']?>)"
                               class="pull-right text-danger"><i class="fa fa-remove"></i></button>
                            <br/>
                        <?php } ?>
                        <small class="text-muted"><?php echo _dt($renewal['date_renewed']); ?></small>
                        <hr class="hr-10"/>
                        <span class="text-success bold" data-toggle="tooltip"
                              title="<?php echo _l('contract_renewal_old_start_date', _d($renewal['new_start_date'])); ?>">
                              <?php echo _l('contract_renewal_new_start_date', _d($renewal['new_start_date'])); ?>
                              </span>
                        <br/>
                        <span class="text-success bold" data-toggle="tooltip"
                              title="<?php echo _l('contract_renewal_old_end_date', _d($renewal['new_end_date'])); ?>">
                              <?php echo _l('contract_renewal_new_end_date', _d($renewal['new_end_date'])); ?>
                              </span>
                        <br/>

                    </div>
                </div>
                <hr/>
            </div>
        <?php } ?>
        </div>
    </div>


    <div role="tabpanel" class="tab-pane " id="contract">
        <div class="row">

            <div class="col-md-12 text-right _buttons">
                <div class="btn-group">
                    <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"><i class="fa fa-file-pdf-o"></i><?php if (is_mobile()) {
                            echo ' PDF';
                        } ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="hidden-xs"><a
                                    href="<?php echo admin_url('hr_profile/contract_pdf/' . $contracts->id_contract . '?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a>
                        </li>
                        <li class="hidden-xs"><a
                                    href="<?php echo admin_url('hr_profile/contract_pdf/' . $contracts->id_contract . '?output_type=I'); ?>"
                                    target="_blank"><?php echo _l('view_pdf_in_new_window'); ?></a></li>
                        <li>
                            <a href="<?php echo admin_url('hr_profile/contract_pdf/' . $contracts->id_contract); ?>"><?php echo _l('download'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo admin_url('hr_profile/contract_pdf/' . $contracts->id_contract . '?print=true'); ?>"
                               target="_blank">
                                <?php echo _l('print'); ?>
                            </a>
                        </li>
                    </ul>
                </div>

                <a href="#" class="btn btn-default hide" data-target="#contract_send_to_client_modal"
                   data-toggle="modal"><span class="btn-with-tooltip" data-toggle="tooltip"
                                             data-title="<?php echo _l('contract_send_to_email'); ?>"
                                             data-placement="bottom">
					<i class="fa fa-envelope"></i></span>
                </a>

                <a href="<?php echo admin_url('hr_profile/contract_sign/' . $contracts->id_contract); ?>"
                   class="btn btn-default "><span class="btn-with-tooltip" data-toggle="tooltip"
                                                  data-title="<?php echo _l('View'); ?>" data-placement="bottom">
					<i class="fa fa-view"></i>View</span>
                </a>


            </div>
            <div class="col-md-12">
                <?php if (isset($contract_merge_fields)) { ?>
                    <hr class="hr-panel-heading"/>
                    <p class="bold mtop10 text-right"><a href="#"
                                                         onclick="slideToggle('.avilable_merge_fields'); return false;"><?php echo _l('available_merge_fields'); ?></a>
                    </p>
                    <div class=" avilable_merge_fields mtop15 hide">
                        <ul class="list-group">
                            <?php
                            foreach ($contract_merge_fields as $field) {
                                foreach ($field as $f) {
                                    echo '<li class="list-group-item"><b>' . $f['name'] . '</b>  <a href="javascript:void(0)" class="pull-right" onclick="insert_merge_field(this); return false">' . $f['key'] . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
        <hr class="hr-panel-heading"/>
        <?php if (!has_permission('hrm_contract', '', 'edit')) { ?>
            <div class="alert alert-warning contract-edit-permissions">
                <?php echo _l('contract_content_permission_edit_warning'); ?>
            </div>
        <?php } ?>
        <div class="tc-content<?php if (has_permission('hrm_contract', '', 'edit')) {
            echo ' editable';
        } ?>"
             style="border:1px solid #d2d2d2;min-height:70px; border-radius:4px;">
            <?php
            if (empty($contracts->content) && has_permission('hrm_contract', '', 'edit')) {
                echo hooks()->apply_filters('new_contract_default_content', '<span class="text-danger text-uppercase mtop15 editor-add-content-notice"> ' . _l('click_to_add_content') . '</span>');
            } else {
                echo $contracts->content;
            }
            ?>
        </div>

        <div class="row mtop25">

            <div class="col-md-6  text-left">
                <?php if (!empty($contracts->staff_signature)) { ?>
                <p class="bold"><?php echo _l('staff_signature'); ?>

                    <div class="bold">
                        <?php
                        if (is_numeric($contracts->staff)) {
                            $contracts_staff_signer = get_staff_full_name($contracts->staff);
                        } else {
                            $contracts_staff_signer = ' ';
                        }

                        ?>
                <p class="no-mbot"><?php echo _l('contract_signed_by') . ": " . $contracts_staff_signer ?></p>
                <p class="no-mbot"><?php echo _l('contract_signed_date') . ': ' . _d($contracts->staff_sign_day) ?></p>
            </div>
            <p class="bold"><?php echo _l('hr_signature_text'); ?>

            </p>
            <div class="pull-left">
                <img src="<?php echo site_url('download/preview_image?path=' . protected_file_url_by_path(HR_PROFILE_CONTRACT_SIGN . $contracts->id_contract . '/' . $contracts->staff_signature)); ?>"
                     class="img-responsive" alt="">
            </div>
            <?php } ?>
        </div>

        <div class="col-md-6  text-right">
            <?php if (!empty($contracts->signature)) { ?>
            <p class="bold"><?php echo _l('company_signature'); ?>

                <div class="bold">
                    <?php
                    if (is_numeric($contracts->signer)) {
                        $contracts_signer = get_staff_full_name($contracts->signer);
                    } else {
                        $contracts_signer = ' ';
                    }

                    ?>
            <p class="no-mbot"><?php echo _l('contract_signed_by') . ": " . $contracts_signer ?></p>
            <p class="no-mbot"><?php echo _l('contract_signed_date') . ': ' . _d($contracts->sign_day) ?></p>
        </div>
        <p class="bold"><?php echo _l('hr_signature_text'); ?>
            <?php if ($contracts->staff_delegate == get_staff_user_id() || $contracts->signer == get_staff_user_id() || has_permission('hrm_contract', '', 'delete')) { ?>
                <a href="<?php echo admin_url('hr_profile/hr_clear_signature/' . $contracts->id_contract); ?>"
                   data-toggle="tooltip" title="<?php echo _l('clear_signature'); ?>" class="_delete text-danger">
                    <i class="fa fa-remove"></i>
                </a>
            <?php } ?>
        </p>
        <div class="pull-right">
            <img src="<?php echo site_url('download/preview_image?path=' . protected_file_url_by_path(HR_PROFILE_CONTRACT_SIGN . $contracts->id_contract . '/' . $contracts->signature)); ?>"
                 class="img-responsive" alt="">
        </div>
    <?php } ?>
    </div>


</div>


</div>

</div>
<div id="modal-wrapper"></div>
<div id="modal-renew"></div>


<?php
require('modules/hr_profile/assets/js/contracts/preview_contract_file_js.php');
?>

