<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<p><?php echo _l('written_reports'); ?></p>
<hr />
<?php echo form_open(admin_url('Written_reports/add/'.$ServID)); ?>
<?php echo render_input('rel_id','',$id,'hidden'); ?>
<?php echo render_input('rel_type','',$slug,'hidden'); ?>
<?php echo render_textarea('report','','',array(),array(),'','tinymce'); ?>
<button type="submit" class="btn btn-info"><?php echo _l('save'); ?></button>
<?php echo form_close(); ?>
<hr />
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php $i=1; foreach ($reports as $report): ?>
        <?php
        $setting_hour = get_option('auto_close_edit_written_reports_after');
        $created_at = $report['created_at'];
        $today = date('Y-m-d H:i:s');
        $timestamp1 = strtotime($created_at);
        $timestamp2 = strtotime($today);
        $hour = abs($timestamp2 - $timestamp1)/(60*60);
        if($hour < $setting_hour){
            $editable = true;
        }else{
            $editable = false;
        }
        ?>
        <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="head_<?php echo $i; ?>">
            <h4 class="panel-title collapsed" role="button" data-toggle="collapse" href="#report-<?php echo $i; ?>" aria-expanded="false" aria-controls="collapseOne">
                <?php echo _l('report'); ?> - <?php echo $i; ?>
            </h4>
        </div>
        <?php echo form_open(admin_url('Written_reports/edit/'.$ServID.'/'.$report['id'])); ?>
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
                </small>
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
                        <button type="button" data-toggle="tooltip" data-title="<?php echo _l('Send_to_customer'); ?>" class="btn btn-info btn-icon pull-left" onclick="send_written_report(<?php echo $report['id'].','.$ServID.','; ?>'<?php echo _l('confirm_action_prompt'); ?>')"><i class="fa fa-envelope"></i></button>
                        <div class="btn-group pull-right">
                            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-pdf-o"></i>
                                <?php echo _l('more'); ?>
                                <?php if(is_mobile()){echo ' PDF';} ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="hidden-xs"><a href="<?php echo admin_url('Written_reports/pdf/'.$report['id'].'?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a></li>
                                <li class="hidden-xs"><a href="<?php echo admin_url('Written_reports/pdf/'.$report['id'].'?output_type=I'); ?>" target="_blank"><?php echo _l('view_pdf_in_new_window'); ?></a></li>
                                <li>
                                    <a href="<?php echo admin_url('Written_reports/pdf/'.$report['id']); ?>">
                                        <?php echo _l('download'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo admin_url('Written_reports/pdf/'.$report['id'].'?print=true'); ?>" target="_blank">
                                        <?php echo _l('print'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php echo render_input('rel_id','',$id,'hidden'); ?>
                <?php
                if($editable):
                echo render_textarea('report','',$report['report'],array(),array(),'','tinymce'); ?>
                <button type="submit" class="btn btn-info"><?php echo _l('edit'); ?></button>
                <?php else:
                echo '<textarea class="form-control" rows="8" readonly data-toggle="tooltip" data-title="'._l('written_reports_cant_edit').'">'.$report["report"].'</textarea>';
                endif; ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <?php $i++; endforeach; ?>
</div>

