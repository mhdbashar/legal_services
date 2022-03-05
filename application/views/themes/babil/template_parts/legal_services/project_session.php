<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($project->settings->view_session_logs == 1) : ?>
   <?php // Subject ?>
   <div class="modal-header task-single-header" id="modal-header" data-task-single-id="<?php echo $view_task->id; ?>" data-status="<?php echo $view_task->status; ?>">
      <h4 class="modal-title"><?php echo $view_task->name; ?></h4>
   </div>
   <div id="session" class="modal-body">
      <div class="row">
         <div class="col-md-8 task-single-col-left" id="session-left">
            <div class="row">
               <div class="col-md-9">
                  <?php //  Milestones ?>
                  <?php if (!empty($view_task->rel_id)) {
                     echo '<div class="task-single-related-wrapper">';
                     $task_rel_data = get_relation_data($view_task->rel_type, $view_task->rel_id);
                     $task_rel_value = get_relation_values($task_rel_data, $view_task->rel_type);
                     echo '<h4 class="bold font-medium mbot15 mb-5">' . _l('task_single_related') . ': <div class="mtop5">' . $task_rel_value['name'] . '</div></h4>';
                     if ($view_task->rel_type == 'project' && $view_task->milestone != 0) {
                        echo '<div class="mtop5 mbot20 font-normal">' . _l('task_milestone') . ': ';
                        $milestones = get_project_milestones($view_task->rel_id);
                        if (count($milestones) > 1) { ?>
                           <span class="task-single-menu task-menu-milestones">
                              <span class="trigger pointer manual-popover text-has-action">
                                 <?php echo $view_task->milestone_name; ?>
                              </span>
                              <span class="content-menu hide">
                                 <ul>
                                    <?php
                                    foreach ($milestones as $milestone) { ?>
                                       <?php if ($view_task->milestone != $milestone['id']) { ?>
                                          <li>
                                             <a href="#" onclick="task_change_milestone(<?php echo $milestone['id']; ?>,<?php echo $view_task->id; ?>); return false;">
                                                <?php echo $milestone['name']; ?>
                                             </a>
                                          </li>
                                       <?php } ?>
                                    <?php } ?>
                                 </ul>
                              </span>
                           </span>
                  <?php } else {
                           echo $view_task->milestone_name;
                        }
                        echo '</div>';
                     }
                     echo '</h4>';
                     echo '</div>';
                  } ?>
               </div>
               <?php // Status Session ?>
               <div class="col-md-3">
                  <span class="task-single-status pull-right mright5 mtop15"><?php echo format_task_status($view_task->status); ?></span>
               </div>
            </div>
            <hr>
            <?php // Court Decision ?>
            <h4 class="th font-medium mbot15 pull-left"><?php echo _l('Court_decision'); ?></h4>
            <div class="clearfix"></div>
            <?php if (!empty($court_decision)) {
               echo '<div class="tc-content"><div id="court_decision">' . check_for_links($court_decision) . '</div></div>';
            } else {
               echo '<div class="no-margin tc-content task-no-description" id="court_decision"><span class="text-muted">' . _l('smtp_encryption_none') . '</span></div>';
            } ?>
            <div class="clearfix"></div>
            <hr />
            <?php // Session Info ?>
            <h4 class="th font-medium mbot15 pull-left"><?php echo _l('session_info'); ?></h4>
            <div class="clearfix"></div>
            <?php if (!empty($session_information)) {
               echo '<div class="tc-content"><div id="session_information">' . check_for_links($session_information) . '</div></div>';
            } else {
               echo '<div class="no-margin tc-content task-no-description" id="session_information"><span class="text-muted">' . _l('smtp_encryption_none') . '</span></div>';
            } ?>
            <?php // Description ?>
               <hr />
               <h4 class="bold"><?php echo _l('session_view_description'); ?></h4>
               <div class="tc-content">
                  <?php if ($view_task->description != null) : ?>
                     <?php echo $view_task->description; ?>
                  <?php else : ?>
                     <?php echo '<p class="text-muted no-mbot">'._l('no_description_provided').'</p>'; ?>
                  <?php endif; ?>
               </div>
            <?php // Checklist Items ?>
            <?php if ($project->settings->view_session_checklist_items == 1) { ?>
               <?php if (count($view_task->checklist_items) > 0) { ?>
                  <hr />
                  <h4 class="bold mbot15"><?php echo _l('task_checklist_items'); ?></h4>
               <?php } ?>
               <?php foreach ($view_task->checklist_items as $list) { ?>
                  <p class="<?php if ($list['finished'] == 1) {
                                 echo 'line-throught';
                              } ?>">
                     <span class="session-checklist-indicator <?php if ($list['finished'] == 1) {
                                                                  echo 'text-success';
                                                               } else {
                                                                  echo 'text-muted';
                                                               } ?>"><i class="fa fa-check"></i></span>&nbsp;
                     <?php echo $list['description']; ?>
                  </p>
                  <?php if ($list['finished'] == 1 || $list['addedfrom'] != get_staff_user_id() || !empty($list['assigned'])) { ?>
                     <p class="font-medium-xs mtop15 text-muted checklist-item-info">
                        <?php
                        if ($list['addedfrom'] != get_staff_user_id()) {
                           echo _l('task_created_by', get_staff_full_name($list['addedfrom']));
                        }
                        if ($list['addedfrom'] != get_staff_user_id() && $list['finished'] == 1) {
                           echo ' - ';
                        }
                        if ($list['finished'] == 1) {
                           echo _l('task_checklist_item_completed_by', get_staff_full_name($list['finished_from']));
                        }
                        if (($list['addedfrom'] != get_staff_user_id() || $list['finished'] == 1) && !empty($list['assigned'])) {
                           echo ' - ';
                        }
                        if (!empty($list['assigned'])) {
                           echo _l('task_checklist_assigned', get_staff_full_name($list['assigned']));
                        }

                        ?>
                     </p>
                  <?php } ?>
               <?php } ?>
            <?php } ?>
            <?php // View Attachments ?>
            <?php if ($project->settings->view_session_attachments == 1) { ?>
               <?php
               $attachments_data = array();
               $comments_attachments = array();
               $i = 1;
               $show_more_link_task_attachments = hooks()->apply_filters('show_more_link_task_attachments_customers_area', 3);
               if (count($view_task->attachments) > 0) { ?>
                  <hr />
                  <div class="row task_attachments_wrapper">
                     <div class="col-md-12">
                        <h4 class="bold font-medium"><?php echo _l('task_view_attachments'); ?></h4>
                        <div class="row">
                           <?php foreach ($view_task->attachments as $attachment) {
                              ob_start(); ?>
                              <div class="col-md-4 task-attachment-col<?php if ($i > $show_more_link_task_attachments) {
                                                                           echo ' task-attachment-col-more';
                                                                        } ?>" data-num="<?php echo $i; ?>" <?php if ($i > $show_more_link_task_attachments) {
                                                                                                               echo 'style="display:none;"';
                                                                                                            } ?>>
                                 <ul class="list-unstyled">
                                    <li class="mbot10 task-attachment">
                                       <div class="mbot10 pull-right task-attachment-user">
                                          <?php
                                          echo _l('project_file_uploaded_by') . ' ' . ($attachment['staffid'] != 0
                                             ? get_staff_full_name($attachment['staffid'])
                                             : get_contact_full_name($attachment['contact_id'])
                                          );
                                          ?>
                                          <?php if (get_option('allow_contact_to_delete_files') == 1 && $attachment['contact_id'] == get_contact_user_id()) { ?>
                                             <a href="<?php echo site_url('clients/delete_file/' . $attachment['id'] . '/task?project_id=' . $project->id); ?>" class="text-danger _delete pull-right"><i class="fa fa-remove"></i></a>
                                          <?php } ?>
                                       </div>
                                       <?php
                                       $externalPreview = false;
                                       $is_image = false;
                                       $path = get_upload_path_by_type('task') . $view_task->id . '/' . $attachment['file_name'];
                                       $href_url = site_url('download/file/taskattachment/' . $attachment['attachment_key']);
                                       $isHtml5Video = is_html5_video($path);
                                       if (empty($attachment['external'])) {
                                          $is_image = is_image($path);
                                          $img_url = site_url('download/preview_image?path=' . protected_file_url_by_path($path, true) . '&type=' . $attachment['filetype']);
                                       } else if ((!empty($attachment['thumbnail_link']) || !empty($attachment['external']))
                                          && !empty($attachment['thumbnail_link'])
                                       ) {
                                          $is_image = true;
                                          $img_url = optimize_dropbox_thumbnail($attachment['thumbnail_link']);
                                          $externalPreview = $img_url;
                                          $href_url = $attachment['external_link'];
                                       } else if (!empty($attachment['external']) && empty($attachment['thumbnail_link'])) {
                                          $href_url = $attachment['external_link'];
                                       }
                                       if (!empty($attachment['external']) && $attachment['external'] == 'dropbox' && $is_image) { ?>
                                          <a href="<?php echo $href_url; ?>" target="_blank" class="open-in-external" data-toggle="tooltip" data-title="<?php echo _l('open_in_dropbox'); ?>"><i class="fa fa-dropbox" aria-hidden="true"></i></a>
                                       <?php } else if (!empty($attachment['external']) && $attachment['external'] == 'gdrive') { ?>
                                          <a href="<?php echo $href_url; ?>" target="_blank" class="open-in-external" data-toggle="tooltip" data-title="<?php echo _l('open_in_google'); ?>"><i class="fa fa-google" aria-hidden="true"></i></a>
                                       <?php }
                                       ?>
                                       <div class="<?php if ($is_image) {
                                                      echo 'preview-image';
                                                   } else if (!$isHtml5Video) {
                                                      echo 'task-attachment-no-preview';
                                                   } ?>">
                                          <?php if (!$isHtml5Video) { ?>
                                             <a href="<?php echo (!$externalPreview ? $href_url : $externalPreview); ?>" target="_blank" <?php if ($is_image) { ?> data-lightbox="task-attachment" <?php } ?> class="<?php if ($isHtml5Video) {
                                                                                                                                                                                                                        echo 'video-preview';
                                                                                                                                                                                                                     } ?>">
                                             <?php } ?>
                                             <?php if ($is_image) { ?>
                                                <img src="<?php echo $img_url; ?>" class="img img-responsive">
                                             <?php } else if ($isHtml5Video) { ?>
                                                <video width="100%" height="100%" src="<?php echo site_url('download/preview_video?path=' . protected_file_url_by_path($path) . '&type=' . $attachment['filetype']); ?>" controls>
                                                   Your browser does not support the video tag.
                                                </video>
                                             <?php } else { ?>
                                                <i class="<?php echo get_mime_class($attachment['filetype']); ?>"></i> <?php echo $attachment['file_name']; ?>
                                             <?php } ?>
                                             <?php if (!$isHtml5Video) { ?>
                                             </a>
                                          <?php } ?>
                                       </div>
                                       <div class="clearfix"></div>
                                    </li>
                                 </ul>
                              </div>
                              <?php
                              $attachments_data[$attachment['id']] = ob_get_contents();
                              if ($attachment['task_comment_id'] != 0) {
                                 $comments_attachments[$attachment['task_comment_id']][$attachment['id']] = $attachments_data[$attachment['id']];
                              }
                              ob_end_clean();
                              echo $attachments_data[$attachment['id']];
                              $i++;
                              ?>
                           <?php } ?>
                        </div>
                        <?php if (($i - 1) > $show_more_link_task_attachments) { ?>
                           <div id="show-more-less-task-attachments-col">
                              <a href="#" class="task-attachments-more" id="more" onclick="slideToggle('.task_attachments_wrapper .task-attachment-col-more', task_attachments_toggle); return false;"><?php echo _l('show_more'); ?></a>
                              <a href="#" class="task-attachments-less hide" id="less" onclick="slideToggle('.task_attachments_wrapper .task-attachment-col-more', task_attachments_toggle); return false;"><?php echo _l('show_less'); ?></a>
                           </div>
                        <?php } ?>
                     </div>
                     <div class="col-md-12 text-center">
                        <hr />
                        <a href="<?php echo admin_url('legalservices/sessions/download_files/'.$view_task->id); ?>" class="bold">
                        <?php echo _l('download_all'); ?> (.zip)
                        </a>
                     </div>
                  </div>
               <?php } ?>
            <?php } ?>
            <?php // View Comments ?>
            <?php if ($project->settings->view_session_comments == 1) { ?>
               <hr />
               <h4 class="bold mbot15"><?php echo _l('task_view_comments'); ?></h4>
               <?php
               if (count($view_task->comments) > 0) {
                  echo '<div id="task-comments">';
                  foreach ($view_task->comments as $comment) { ?>
                     <div class="mbot10 mtop10 task-comment" data-commentid="<?php echo $comment['id']; ?>" id="comment_<?php echo $comment['id']; ?>">
                        <?php if ($comment['staffid'] != 0) { ?>
                           <?php echo staff_profile_image($comment['staffid'], array(
                              'staff-profile-image-small',
                              'media-object img-circle pull-left mright10'
                           )); ?>
                        <?php } else { ?>
                           <img src="<?php echo contact_profile_image_url($comment['contact_id']); ?>" class="client-profile-image-small media-object img-circle pull-left mright10">
                        <?php } ?>
                        <div class="media-body">
                           <?php if ($comment['staffid'] != 0) { ?>
                              <span class="bold"><?php echo $comment['staff_full_name']; ?></span><br />
                           <?php } else { ?>
                              <span class="pull-left bold">
                                 <?php echo get_contact_full_name($comment['contact_id']); ?></span>
                              <br />
                           <?php } ?>
                           <small class="mtop10 text-muted"><?php echo _dt($comment['dateadded']); ?></small><br />
                           <?php if ($comment['contact_id'] != 0) { ?>
                              <?php
                              $comment_added = strtotime($comment['dateadded']);
                              $minus_1_hour = strtotime('-1 hours');
                              if (get_option('client_staff_add_edit_delete_task_comments_first_hour') == 0 || (get_option('client_staff_add_edit_delete_task_comments_first_hour') == 1 && $comment_added >= $minus_1_hour)) { ?>
                                 <a href="#" onclick="remove_task_comment(<?php echo $comment['id']; ?>); return false;" class="pull-right">
                                    <i class="fa fa-times text-danger"></i>
                                 </a>
                                 <a href="#" onclick="edit_task_comment(<?php echo $comment['id']; ?>); return false;" class="pull-right mright5">
                                    <i class="fa fa-pencil-square-o"></i>
                                 </a>
                                 <div data-edit-comment="<?php echo $comment['id']; ?>" class="hide">
                                    <textarea rows="5" class="form-control mtop10 mbot10"><?php echo clear_textarea_breaks($comment['content']); ?></textarea>
                                    <button type="button" class="btn btn-info pull-right" onclick="save_edited_comment(<?php echo $comment['id']; ?>)">
                                       <?php echo _l('submit'); ?>
                                    </button>
                                    <button type="button" class="btn btn-default pull-right mright5" onclick="cancel_edit_comment(<?php echo $comment['id']; ?>)">
                                       <?php echo _l('cancel'); ?>
                                    </button>
                                 </div>
                              <?php } ?>
                           <?php } ?>
                           <!-- Show the Attachment Files -->
                           <div class="comment-content" data-comment-content="<?php echo $comment['id']; ?>">
                              <?php
                              if ($comment['file_id'] != 0 && $project->settings->view_session_attachments == 1) {
                                 $comment['content'] = str_replace('[task_attachment]', '<br />' . $attachments_data[$comment['file_id']], $comment['content']);
                                 // Replace lightbox to prevent loading the image twice
                                 $comment['content'] = str_replace('data-lightbox="task-attachment"', 'data-lightbox="task-attachment-comment-' . $comment['id'] . '"', $comment['content']);
                              } else if (count($comment['attachments']) > 0 && isset($comments_attachments[$comment['id']])) {
                                 $comment_attachments_html = '';
                                 foreach ($comments_attachments[$comment['id']] as $comment_attachment) {
                                    $comment_attachments_html .= trim($comment_attachment);
                                 }
                                 $comment['content'] = str_replace('[task_attachment]', '<div class="clearfix"></div>' . $comment_attachments_html, $comment['content']);
                                 // Replace lightbox to prevent loading the image twice
                                 $comment['content'] = str_replace('data-lightbox="task-attachment"', 'data-lightbox="task-comment-files-' . $comment['id'] . '"', $comment['content']);
                                 $comment['content'] .= '<div class="clearfix"></div>';
                              }
                              echo check_for_links($comment['content']); ?>
                           </div>
                        </div>
                        <hr />
                     </div>
               <?php }
                  echo '</div>';
               } ?>
            <?php } ?>
         </div>
         <div class="col-md-4 col-sm-12 task-single-col-right" id="session-right">
            <?php // Proceedings of Session ?>
            <h5 class="task-info-heading"><?php echo _l('session_information'); ?>
               <?php
               if ($view_task->recurring == 1) {
                  echo '<span class="label label-info inline-block mleft5">' . _l('recurring_session') . '</span>';
               }
               ?>
            </h5>
            <div class="clearfix"></div>
            <h5 class="no-mtop task-info-created">
               <?php if (($view_task->addedfrom != 0 && $view_task->addedfrom != get_staff_user_id()) || $view_task->is_added_from_contact == 1) { ?>
                  <h6 class="text-dark"><?php echo _l('task_created_by', '<span class="text-dark">' . ($view_task->is_added_from_contact == 0 ? get_staff_full_name($view_task->addedfrom) : get_contact_full_name($view_task->addedfrom)) . '</span>'); ?> <i class="fa fa-clock-o" data-toggle="tooltip" data-title="<?php echo _l('task_created_at', _dt($view_task->dateadded)); ?>"></i></h6>
               <?php } else { ?>
                  <h6 class="text-dark"><?php echo _l('task_created_at', '<span class="text-dark">' . _dt($view_task->dateadded) . '</span>'); ?></h6>
               <?php } ?>
            </h5>
            <hr />
            <?php // Finished ?>
            <?php if ($view_task->status == Sessions_model::STATUS_COMPLETE) { ?>
               <div class="task-info task-info-finished">
                  <h5><i class="fa task-info-icon fa-fw fa-lg pull-left fa-check"></i>
                     <?php echo _l('task_single_finished'); ?>: <span data-toggle="tooltip" data-title="<?php echo _dt($view_task->datefinished); ?>" data-placement="bottom" class="text-has-action"><?php echo time_ago($view_task->datefinished); ?></span>
                  </h5>
               </div>
            <?php } ?>
            <?php // Start Date ?>
            <div class="task-info task-single-inline-wrap task-info-start-date">
               <h5><i class="fa task-info-icon fa-fw fa-lg fa-calendar-plus-o pull-left fa-margin"></i>
                  <?php echo _l('task_single_start_date'); ?>:
                  <?php echo _d($view_task->startdate); ?>
               </h5>
            </div>
            <?php // Due Date ?>
            <div class="task-info task-info-due-date task-single-inline-wrap" <?php if (!$view_task->duedate) {
                                                                                 echo ' style="opacity:0.5;"';
                                                                              } ?>>
               <h5>
                  <i class="fa fa-calendar-check-o task-info-icon fa-fw fa-lg pull-left"></i>
                  <?php echo _l('task_single_due_date'); ?>:
                  <?php echo _d($view_task->duedate); ?>
               </h5>
            </div>
            <?php // Hourly Rate ?>
            <div class="task-info task-info-hourly-rate">
               <h5><i class="fa task-info-icon fa-fw fa-lg pull-left fa-clock-o"></i>
                  <?php echo _l('task_hourly_rate'); ?>: <?php if ($view_task->rel_type == 'project' && $view_task->project_data->billing_type == 2) {
                                                            echo app_format_number($view_task->project_data->project_rate_per_hour);
                                                         } else {
                                                            echo app_format_number($view_task->hourly_rate);
                                                         }
                                                         ?>
               </h5>
            </div>
            <?php // Billable ?>
            <div class="task-info task-info-billable">
               <h5><i class="fa task-info-icon fa-fw fa-lg pull-left fa fa-credit-card"></i>
                  <?php echo _l('task_billable'); ?>: <?php echo ($view_task->billable == 1 ? _l('task_billable_yes') : _l('task_billable_no')) ?>
                  <?php if ($view_task->billable == 1) { ?>
                     <b>(<?php echo ($view_task->billed == 1 ? _l('task_billed_yes') : _l('task_billed_no')) ?>)</b>
                  <?php } ?>
                  <?php if ($view_task->rel_type == 'project' && $view_task->project_data->billing_type == 1) {
                     echo '<small>(' . _l('project') . ' ' . _l('project_billing_type_fixed_cost') . ')</small>';
                  } ?>
               </h5>
            </div>
            <?php if (
               $view_task->billable == 1
               && $view_task->billed == 0
               && ($view_task->rel_type != 'project' || ($view_task->rel_type == 'project' && $taview_tasksk->project_data->billing_type != 1))
               && staff_can('create', 'invoices')
            ) { ?>
               <div class="task-info task-billable-amount">
                  <h5><i class="fa task-info-icon fa-fw fa-lg pull-left fa fa-file-text-o"></i>
                     <?php echo _l('billable_amount'); ?>:
                     <span class="bold">
                        <?php echo $this->sessions_model->get_billable_amount($view_task->id); ?>
                     </span>
                  </h5>
               </div>
            <?php } ?>
            <?php // Your Logged Time ?>
            <?php if ($view_task->current_user_is_assigned || total_rows(db_prefix() . 'taskstimers', array('task_id' => $view_task->id, 'staff_id' => get_staff_user_id())) > 0) { ?>
               <div class="task-info task-info-user-logged-time">
                  <h5>
                     <i class="fa fa-asterisk task-info-icon fa-fw fa-lg" aria-hidden="true"></i><?php echo _l('task_user_logged_time'); ?>
                     <?php echo seconds_to_time_format($this->sessions_model->calc_task_total_time($view_task->id, ' AND staff_id=' . get_staff_user_id())); ?>
                  </h5>
               </div>
            <?php } ?>
            <?php // Total Logged Time ?>
            <?php if ($project->settings->view_session_total_logged_time == 1) { ?>
               <div class="task-info task-info-total-logged-time">
                  <h5>
                     <i class="fa task-info-icon fa-fw fa-lg fa-clock-o"></i><?php echo _l('task_total_logged_time'); ?>
                     <span class="text-success">
                        <?php echo seconds_to_time_format($this->sessions_model->calc_task_total_time($view_task->id)); ?>
                     </span>
                  </h5>
               </div>
            <?php } ?>
            <?php // !?? ?>
            <?php $custom_fields = get_custom_fields('sessions');
            foreach ($custom_fields as $field) { ?>
               <?php $value = get_custom_field_value($view_task->id, $field['id'], 'sessions');
               if ($value == '') {
                  continue;
               } ?>
               <div class="task-info">
                  <h5 class="task-info-custom-field task-info-custom-field-<?php echo $field['id']; ?>">
                     <i class="fa task-info-icon fa-fw fa-lg fa-square-o"></i>
                     <?php echo $field['name']; ?>: <?php echo $value; ?>
                  </h5>
               </div>
            <?php } ?>
            <?php // Tags ?>
            <div class="mtop5 clearfix"></div>
            <h5>
               <i class="fa task-info-icon fa-fw fa-lg fa-tag"></i><?php echo _l('tags') ?>:
               <?php if (prep_tags_input(get_tags_in($view_task->id, 'task'))) : ?>
                  <br />
                  <span class="bold h5 col-md-9">
                     <?php $tags = ' ' . prep_tags_input(get_tags_in($view_task->id, 'task')) . ' ';
                     echo str_replace(',', ' |' . PHP_EOL, $tags); ?>
                  </span>
               <?php else : ?>
                  <span class="h5" style="opacity:0.5">
                     <br /><br />
                     <?php echo _l('no_tags') ?>
                  </span>
               <?php endif; ?>

            </h5>
            <div class="clearfix"></div>
            <hr class="task-info-separator" />
            <div class="clearfix"></div>
            <?php // Reminders ?>
            <h5 class="task-info-heading font-normal font-medium-xs">
               <i class="fa fa-bell-o" aria-hidden="true"></i>
               <?php echo _l('reminders'); ?>
            </h5>
            <?php
            $reminders = $this->sessions_model->get_reminders($view_task->id); ?>
            <?php if (count($reminders) == 0) { ?>
               <div class="display-block text-muted mtop10">
                  <?php echo _l('no_reminders_for_this_session'); ?>
               </div>
            <?php } else { ?>
               <ul class="mtop10">
                  <?php foreach ($reminders as $rKey => $reminder) {
                  ?>
                     <li class="<?php if ($reminder['isnotified'] == '1') {
                                    echo 'text-throught';
                                 } ?>" data-id="<?php echo $reminder['id']; ?>">
                        <div class="mbot15">
                           <div>
                              <p class="bold">
                                 <?php echo _l('reminder_for', [
                                    get_staff_full_name($reminder['staff']),
                                    _dt($reminder['date'])
                                 ]); ?>
                              </p>
                              <?php
                              if (!empty($reminder['description'])) {
                                 echo $reminder['description'];
                              } else {
                                 echo '<p class="text-muted no-mbot">' . _l('no_description_provided') . '</p>';
                              }
                              ?>
                           </div>
                           <?php if (count($reminders) - 1 != $rKey) { ?>
                              <hr class="hr-10" />
                           <?php } ?>
                        </div>
                     </li>
                  <?php } ?>
               </ul>
            <?php } ?>
            <div class="clearfix"></div>
            <hr class="task-info-separator" />
            <?php // Team Members ?>
            <?php if ($project->settings->view_team_members == 1) { ?>
               <div class="clearfix"></div>
               <div class="mbot20">
                  <div class="row col-md-12 mbot20">
                     <i class="fa fa-user-o"></i> <span class="bold"><?php echo _l('task_single_assignees'); ?></span>
                  </div>
                  <div class="row col-md-12 mbot20" id="assignees">
                     <?php
                     $_assignees = '';
                     foreach ($view_task->assignees as $assignee) {
                        $_assignees .= '
                     <div data-toggle="tooltip" class="pull-left mleft5 session-user" data-title="' . get_staff_full_name($assignee['assigneeid']) . '">'
                           . staff_profile_image($assignee['assigneeid'], array(
                              'staff-profile-image-small'
                           )) . '</div>';
                     }
                     if ($_assignees == '') {
                        $_assignees = '<div class="session-connectors-no-indicator display-block">' . _l('session_no_assignees') . '</div>';
                     }
                     echo $_assignees;
                     ?>
                  </div>
               </div>
               <div class="clearfix"></div>
               <hr class="task-info-separator" />
               <div class="mbot20">
                  <div class="row col-md-12 mbot20">
                     <i class="fa fa-user-o" aria-hidden="true"></i>
                     <span class="bold"><?php echo _l('task_single_followers'); ?></span>
                  </div>
                  <div class="row col-md-12 mbot20">
                     <div class="task_users_wrapper">
                        <?php
                        $_followers        = '';
                        foreach ($view_task->followers as $follower) {
                           $_followers .= '
                           <span class="task-user" data-toggle="tooltip" data-title="' . html_escape($follower['full_name']) . '">
                              <div >' . staff_profile_image($follower['followerid'], array(
                              'staff-profile-image-small'
                           )) . '</div> ' .
                              '</span>';
                        }
                        if ($_followers == '') {
                           $_followers = '<div class="display-block text-muted mbot15">' . _l('session_no_followers') . '</div>';
                        }
                        echo $_followers;
                        ?>
                     </div>
                  </div>
               </div>
            <?php } ?>
         </div>
      </div>
   </div>
   <script>
      var session_comment_temp = window.location.href.split('#');
      if (session_comment_temp[1]) {
         var session_comment_id = session_comment_temp[session_comment_temp.length - 1];
         $('html,body').animate({
               scrollTop: $('#' + session_comment_id).offset().top
            },
            'slow');
      }

      $(document).ready(function() {
         
         function responsive(maxWidth) {
            if (maxWidth.matches) { 
               $('#session-right').css({
                  'background-color': '#F0F5F7',
                  'padding': '13px 20px',
                  'border-bottom-right-radius': '6px',
                  'position': 'unset',
               });
               
            } else {
               $('#session-right').css({
                  'background-color': '#F0F5F7',
                  'padding': '13px 20px',
                  'border-bottom-right-radius': '6px',
                  'position': 'absolute',
                  'margin-top': '8px',
                  'right': '0px',
                  'padding-top': '20px'
               });
            }
         }
         var maxWidth = window.matchMedia("(max-width: 768px)");
         
         responsive(maxWidth);
         maxWidth.addListener(responsive);
         

         // Height of the Side bar
         var height = $("#session-right").height();

         $('#session-left').css({
            'background': '#fff',
            'min-height': height+7+"px",
            'border-bottom-left-radius': '6px',
            'bottom': '-9px',
            'padding-top': '20px'

         });

         $('#modal-header').css({
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#226faa+0,2989d8+37,72c0d3+100 */
            'background': '#226faa',
            /* Old browsers */
            /* FF3.6-15 */
            /* Chrome10-25,Safari5.1-6 */
            'background': '-webkit-gradient(linear, left top, right top, from(#226faa), color-stop(37%, #2989d8), to(#72c0d3))',
            'background': 'linear-gradient(to right, #226faa 0%, #2989d8 37%, #72c0d3 100%)',
            /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            'filter': 'progid:DXImageTransform.Microsoft.gradient(startColorstr="#226faa", endColorstr="#72c0d3", GradientType=1)',
            /* IE6-9 */
            'border-radius': '6px',
            'color': '#fff',
            'padding': '18px',
            'border-bottom-left-radius': '0',
            'border-bottom-right-radius': '0',
            'border-color': 'transparent',
            'position': 'relative',
            'top': '23px'

         })

         $('#more').click(function() {
            $('#less').removeClass('hide');
            $('#more').addClass('hide');
   
         });

         $('#less').click(function() {
            $('#more').removeClass('hide');
            $('#less').addClass('hide');
   
         });
      });
      
   </script>
<?php else : ?>
   <?php get_template_part('legal_services/project_task'); ?>
<?php endif; ?>