<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<p><?php echo _l('written_reports'); ?></p>
<?php if (has_permission('written_reports', '', 'create')) { ?>
<hr />
<?php echo form_open(admin_url('written_reports/add/'.$ServID), array('id' => 'written-reports-form')); ?>
<div class="row">
    <div class="col-md-4">
        <?php echo render_datetime_input('available_until','auto_close_edit_written_reports_after'); ?>
    </div>
    <div class="col-md-12">
        <?php echo render_input('rel_id','',$ServID == 1 || $ServID == 22 ? $id : $project_id,'hidden'); ?>
        <?php echo render_input('rel_type','',$slug,'hidden'); ?>
        <?php echo render_textarea('report','','',array(),array(),'','tinymce'); ?>
        <button type="submit" data-form="#written-reports-form" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>" class="btn btn-info"><?php echo _l('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>
<?php } ?>
<?php if(isset($reports)): ?>
<hr />
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php $i=1; foreach ($reports as $report): ?>
        <?php
        $available_until = $report['available_until'];
        $today = date('Y-m-d H:i:s');
        $timestamp1 = strtotime($available_until);
        $timestamp2 = strtotime($today);
        if($timestamp1 > $timestamp2){
            $editable = true;
            $style = "text-success";
        }else{
            $editable = false;
            $style = "text-danger";
        }
        ?>
        <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="head_<?php echo $i; ?>">
            <h4 class="panel-title collapsed" role="button" data-toggle="collapse" href="#report-<?php echo $i; ?>" aria-expanded="false" aria-controls="collapseOne">
                <?php echo _l('report'); ?> - <?php echo $i; ?>
            </h4>
        </div>
        <?php echo form_open(admin_url('written_reports/edit/'.$ServID.'/'.$report['id'])); ?>
        <div id="report-<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="head_<?php echo $i; ?>">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10">
                <b>- <?php echo _l('added_from').' '._l('staff_member_lowercase'); ?></b>
                <a href="<?php echo admin_url('profile/' . $report['addedfrom']); ?>" target="_blank"><?php echo get_staff_full_name($report['addedfrom']); ?></a>
                <br>
                <br>
                <b>- <?php echo _l('date_created'); ?></b>
                <small>
                <span class="text-has-action" data-toggle="tooltip" data-title="<?php echo _dt($report['created_at']); ?>">
                      <?php echo time_ago($report['created_at']); ?>
                </span>
                    <br>
                    <br>
                </small>
                        <b>- <?php echo _l('editable_until'); ?></b>
                        <b class="<?php echo $style; ?>">

                      <?php echo _dt($report['available_until']); ?>

                        </b>
                <?php if(isset($report['updatedfrom'])): ?>
                <br>
                <br>
                <b>- <?php echo _l('updated_by_staff'); ?></b>
                <a href="<?php echo admin_url('profile/' . $report['updatedfrom']); ?>" target="_blank"><?php echo get_staff_full_name($report['updatedfrom']); ?></a>
                <br>
                <br>
                <b>- <?php echo _l('date_updated'); ?></b>
                <small>
                <span class="text-has-action" data-toggle="tooltip" data-title="<?php echo _l($report['updated_at']); ?>">
                      <?php echo time_ago($report['updated_at']); ?>
                </span>
                </small>
                <?php endif; ?>
                    </div>
                    <div class="col-md-2">
                        <?php if (has_permission('written_reports', '', 'delete')) { ?>
                            <?php $rel_id = $ServID == 1 || $ServID == 22 ? $id : $project_id; ?>
                            <a href="<?php echo admin_url("written_reports/delete/".$ServID.'/'.$rel_id.'/'.$report['id']); ?>" class="btn btn-danger btn-icon _delete" data-toggle="tooltip" data-title="<?php echo _l('delete'); ?>"><i class="fa fa-trash"></i></a>
                        <?php } ?>
                        <?php if (has_permission('written_reports', '', 'send_to_customer')) { ?>
                        <button type="button" data-toggle="tooltip" data-title="<?php echo _l('Send_to_customer'); ?>" class="btn btn-info btn-icon pull-left" onclick="send_written_report(<?php echo $report['id'].','.$ServID.','; ?>'<?php echo _l('confirm_action_prompt'); ?>')"><i class="fa fa-envelope"></i></button>
                        <?php } ?>
                        <div class="btn-group pull-right">
                            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-pdf-o"></i>
                                <?php echo _l('more'); ?>
                                <?php if(is_mobile()){echo ' PDF';} ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="hidden-xs"><a href="<?php echo admin_url('written_reports/pdf/'.$report['id'].'?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a></li>
                                <li class="hidden-xs"><a href="<?php echo admin_url('written_reports/pdf/'.$report['id'].'?output_type=I'); ?>" target="_blank"><?php echo _l('view_pdf_in_new_window'); ?></a></li>
                                <li>
                                    <a href="<?php echo admin_url('written_reports/pdf/'.$report['id']); ?>">
                                        <?php echo _l('download'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo admin_url('written_reports/pdf/'.$report['id'].'?print=true'); ?>" target="_blank">
                                        <?php echo _l('print'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php echo render_input('rel_id','',$ServID == 1 || $ServID == 22 ? $id : $project_id,'hidden'); ?>
                <?php if (has_permission('written_reports', '', 'edit')) { ?>
                <?php if($editable):
                echo render_textarea('report','',$report['report'],array(),array(),'','tinymce'); ?>
                <button type="submit" class="btn btn-info"><?php echo _l('edit'); ?></button>
                <?php else:
                echo '<textarea class="form-control" rows="8" readonly data-toggle="tooltip" data-title="'._l('written_reports_cant_edit').'">'.strip_tags($report["report"]).'</textarea>';
                endif; ?>
                <?php }else{
                    echo '<textarea class="form-control" rows="8" readonly data-toggle="tooltip" data-title="'._l('dont_have_edit_permission').'">'.strip_tags($report["report"]).'</textarea>';
                } ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <?php $i++; endforeach; ?>
</div>
<?php endif; ?>
