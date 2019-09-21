<?php
   $id = 'id';           // Your table id like session_id, staffid ...etc
   $subject = 'subject'; // Your table title like subject, title, name ...etc
   $controllerName = "session_info";
?>



<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/plugins/jquery-comments/css/jquery-comments.css'?>">
<div id="wrapper">
   <div class="content">
      <div class="row">
         
         <?php if(isset($contract)) { ?>
         <div class="col-md-12 right-column">
            <div class="panel_s">
               <div class="panel-body">
                  <h4 class="no-margin"><?php echo $contract[$subject]; ?></h4>
                  <hr class="hr-panel-heading" />
                  <div class="horizontal-scrollable-tabs preview-tabs-top">
                     <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                     <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                     <div class="horizontal-tabs">
                        <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
                           
                           <li role="presentation" class="<?php if(!$this->input->get('tab') || $this->input->get('tab') == 'tab_content'){echo 'active';} ?>">
                              <a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">
                              <?php echo _l('contract_attachments'); ?>
                              <?php if($totalAttachments = count($contract['attachment'])) { ?>
                                  <span class="badge attachments-indicator"><?php echo $totalAttachments; ?></span>
                              <?php } ?>
                              </a>
                           </li>
                           <li role="presentation" class="tab-separator">
                              <a href="#tab_information" aria-controls="tab_information" role="tab" data-toggle="tab" onclick="init_rel_tasks_table(<?php echo $contract[$id]; ?>,'contract'); return false;">
                                 <?php echo _l('session_info') ?>
                              </a>
                           </li>
                           <li role="presentation" class="tab-separator">
                              <a href="#tab_next_action" aria-controls="tab_next_action" role="tab" data-toggle="tab" onclick="init_rel_tasks_table(<?php echo $contract[$id]; ?>,'contract'); return false;">
                                 <?php echo _l('next_action') ?>
                              </a>
                           </li>
                           <li role="presentation" class="tab-separator">
                              <a href="<?php base_url() . 'session/session_info/session_detail'.$session->id.'/' . $service_id . '/' . $rel_id ?>?tab=discussion">
                                 <?php echo _l('discussion') ?>
                              </a>
                           </li>
                           <li role="presentation" class="tab-separator">
                              <a href="<?php base_url() . 'session/session_info/session_detail'.$session->id.'/' . $service_id . '/' . $rel_id ?>?tab=reminders">
                                 <?php echo _l('reminders') ?>
                              </a>
                           </li>

                           <li role="presentation" class="tab-separator">
                              <a href="#tab_detail" aria-controls="tab_detail" role="tab" data-toggle="tab" onclick="init_rel_tasks_table(<?php echo $contract[$id]; ?>,'contract'); return false;">
                                 <?php echo _l('session_detail') ?>
                              </a>
                           </li>
                           <li role="presentation" class="tab-separator toggle_view">
                              <a href="#" onclick="contract_full_view(); return false;" data-toggle="tooltip" data-title="<?php echo _l('toggle_full_view'); ?>">
                              <i class="fa fa-expand"></i></a>
                           </li>
                        </ul>
                     </div>
                  </div>

                  
                  <div class="tab-content">
                     
                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'attachments'){echo ' active';} ?>" id="attachments">
                        <?php echo form_open(admin_url('session/' . $controllerName . '/add_contract_attachment/'.$contract[$id]),array('id'=>'contract-attachments-form','class'=>'dropzone')); ?>
                        <?php echo form_close(); ?>
                        <div class="text-right mtop15">
                           <button class="gpicker" data-on-pick="contractGoogleDriveSave">
                              <i class="fa fa-google" aria-hidden="true"></i>
                              <?php echo _l('choose_from_google_drive'); ?>
                           </button>
                           <div id="dropbox-chooser"></div>
                           <div class="clearfix"></div>
                        </div>
                        <!-- <img src="https://drive.google.com/uc?id=14mZI6xBjf-KjZzVuQe8-rjtv_wXEbDTw" /> -->

                        <div id="contract_attachments" class="mtop30">
                           <?php
                              $data = '<div class="row">';
                              foreach($contract['attachment'] as $attachment) {
                                $href_url = site_url('download/file/sessions/'.$attachment['attachment_key']);
                                if(!empty($attachment['external'])){
                                  $href_url = $attachment['external_link'];
                                }
                                $data .= '<div class="display-block contract-attachment-wrapper">';
                                $data .= '<div class="col-md-10">';
                                $data .= '<div class="pull-left"><i class="'.get_mime_class($attachment['filetype']).'"></i></div>';
                                $data .= '<a href="'.$href_url.'"'.(!empty($attachment['external']) ? ' target="_blank"' : '').'>'.$attachment['file_name'].'</a>';
                                $data .= '<div class="text-muted">'.$attachment["filetype"].'</div>';
                                $data .= '<div class="text-muted">'.$this->Service_sessions_model->getStaffName($attachment['id'])['firstname'] . ' ' . $this->Service_sessions_model->getStaffName($attachment['id'])['lastname'] .'</div>';
                                $data .= '<div class="text-muted">'.$this->Service_sessions_model->getStaffName($attachment['id'])['dateadded'] .'</div>';
                                $data .= '</div>';
                                $data .= '<div class="col-md-2 text-right">';
                                if($attachment['staffid'] == get_staff_user_id() || is_admin()){
                                 $data .= '<a href="#" class="text-danger" onclick="delete_session_attachment(this,'.$attachment['id'].'); return false;"><i class="fa fa fa-times"></i></a>';
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
                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'info'){echo ' active';} ?>" id="tab_information">
                        <?php 
                           function statusName($id){
                              switch ($id) {
                                 case 1:
                                    return "جلسة أولى";
                                    break;
                                 case 2:
                                    return "جلسة استماع";
                                    break;
                                 case 3:
                                    return "جلسة رد";
                                    break;
                                 case 4:
                                    return "النطق  بالحكم";
                                    break;
                                 
                                 default:
                                    return "غير محدد";
                                    break;
                              }
                           }
                           function resultName($id){
                              switch ($id) {
                                 case 1:
                                    return "تم الحكم لصالح المدعي";
                                    break;
                                 case 2:
                                    return "تم الحكم لصالح المدعي عليه";
                                    break;
                                 case 3:
                                    return "تم إقفال القضية";
                                    break;
                                
                                 
                                 default:
                                    return "غير محدد";
                                    break;
                              }
                           }
                        ?>
                        <div class="row well ">
                            <div class="col-md-12" style="font-size: 17px">
                                    <div class="col-md-6">
                                        <?php echo '<b>'._l('service_id').'</b>' ?> : <?php echo $session->service_id ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php echo '<b>'._l('subject').'</b>' ?> : <?php echo $session->subject ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>'._l('court').'</b>' ?> : <?php echo ($court_name->court_name) ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>'._l('judge').'</b>' ?> : <?php echo $judge_name->name ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>'._l('start_at').'</b>' ?> : <?php echo $session->date . " " . $session->time ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>'._l('created_at').'</b>' ?> : <?php echo $session->created ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>'._l('status').'</b>' ?> : <?php echo statusName($session->status) ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>'._l('result').'</b>' ?> : <?php echo resultName($session->result) ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>Added By</b>' ?> : <?php echo $this->Service_sessions_model->getStaff($session->staff)['firstname'] . ' ' . $this->Service_sessions_model->getStaff($session->staff)['lastname'] ?>
                                    </div>

                                <?php if ($session->details){ ?>
                                    <div class="col-md-6">
                                        <?php echo '<b>'._l('detail').'</b>' ?> : <?php echo $session->details ?>
                                    </div>
                                <?php } ?>
                                <?php if ($session->next_action){ ?>
                                    <div class="col-md-6">
                                        <?php echo '<b>'._l('next_action').'</b>' ?> : <?php echo $session->next_action ?>
                                    </div>
                                <?php } ?>
                                <?php if ($session->report){ ?>
                                    <div class="col-md-6">
                                        <?php echo '<b>'._l('report').'</b>' ?> : <?php echo $session->report ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                     </div>
                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'detail'){echo ' active';} ?>" id="tab_detail">
                              <?php $detail = ($session->details) ? $session->details : '' ;  ?>
                        <form id="form_transout" method="get" action="<?php echo base_url() . 'session/' . $controllerName . '/edit_detail/' ?><?php echo $session->id ?>">
                           <div class="form-group">
                             <label for="details" class="col-form-label"><?php echo _l('session_detail') ?></label>
                             <?php $contents = ''; if(isset($detail)){$contents = $detail;} ?>
                            <?php echo render_textarea('details','',$contents,array(),array(),'','tinymce'); ?>
                           </div>
                           <button type="submit" class="btn btn-primary"><?php echo _l('save') ?></button>
                        </form>
                     </div>

                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'reminders'){echo ' active';} ?>" id="tab_reminders">

                        <a href="#" data-toggle="modal" data-target=".reminder-modal-<?php echo $service_id . '-' . $rel_id ?>" class="btn btn-info mbot25"><i class="fa fa-bell-o"></i> Set Reminder</a>
                        
                      <?php
                        $this->load->view('admin/includes/modals/reminder', [
                            'id' => $rel_id,
                            'name' => $service_id,
                            'reminder_title' => 'Session reminders',
                            'members' => $members
                        ]);
                            render_datatable(array(
                              'Description',
                              'Date',
                              'Remind',
                              'Is Notified',
                              ),'reminder');  
                      ?>
                     </div>
                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'next_action'){echo ' active';} ?>" id="tab_next_action">
                              <?php $detail = ($session->next_action) ? $session->next_action : '' ;  ?>
                        <form id="form_transout" method="get" action="<?php echo base_url() . 'session/' . $controllerName . '/edit_next_action/' ?><?php echo $session->id ?>">
                           <div class="form-group">
                             <label for="subject" class="col-form-label"><?php echo _l('next_action') ?></label>
                             <?php $contents = ''; if(isset($detail)){$contents = $detail;} ?>
                            <?php echo render_textarea('next_action','',$contents,array(),array(),'','tinymce'); ?>
                           </div>
                           <button type="submit" class="btn btn-primary"><?php echo _l('save') ?></button>
                        </form>
                     </div>
                     
                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'discussion'){echo ' active';} ?>" id="tab_discussion">



                        <?php if(!isset($discussion)){ ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#discussion" data-title="New Holiday" data-readonly="">
                        Create Discussion
                        </button>
                        <hr>
                        <?php
                            $this->load->view('modals/discussion', ['session_id' => $session_id]);
                            render_datatable(array(
                              'Subject',
                              'Last Activity',
                              'Total Comments',
                              'Visible To Customer',
                              ),'customer-groups');  ?>
                        <?php } else { ?>
                        <h3 class="bold no-margin"><?php echo $discussion->subject; ?></h3>
                        <hr />
                        <p class="no-margin"><?php echo _l('project_discussion_posted_on',_d($discussion->datecreated)); ?></p>
                        <p class="no-margin">
                            <?php if($discussion->staff_id == 0){
                                echo _l('project_discussion_posted_by',get_contact_full_name($discussion->contact_id)) . ' <span class="label label-info inline-block">'._l('is_customer_indicator').'</span>';
                                } else {
                                echo _l('project_discussion_posted_by',get_staff_full_name($discussion->staff_id));
                                }

                                ?>
                        </p>
                        <p><?php echo _l('project_discussion_total_comments'); ?>: <?php echo total_rows(db_prefix().'my_sessiondiscussioncomments',array('discussion_id'=>$discussion->id)); ?>
                        <p class="text-muted"><?php echo $discussion->description; ?></p>
                        <hr />
                        <div id="discussion-comments"></div>
                        <?php } ?>

                     </div>
                           
                  </div>
               </div>

            </div>
         </div>
         <?php } ?>
      </div>
   </div>
</div>
<?php if(isset($discussion)){
   echo form_hidden('discussion_id',$discussion->id);
   echo form_hidden('discussion_user_profile_image_url',$discussion_user_profile_image_url);
   echo form_hidden('current_user_is_admin',$current_user_is_admin);
   }
   ?>
<div id="invoice_project"></div>
<div id="pre_invoice_project"></div>
<?php init_tail(); ?>
<script>
   taskid = '<?php echo $this->input->get('taskid'); ?>';
</script>
<script>

   var gantt_data = {};
   <?php if(isset($gantt_data)){ ?>
   gantt_data = <?php echo json_encode($gantt_data); ?>;
   <?php } ?>
   var discussion_id = $('input[name="discussion_id"]').val();
   var discussion_user_profile_image_url = $('input[name="discussion_user_profile_image_url"]').val();
   var current_user_is_admin = $('input[name="current_user_is_admin"]').val();
   var session_id = $('input[name="session_id"]').val();
   if(typeof(discussion_id) != 'undefined'){
     discussion_comments('#discussion-comments',discussion_id,'regular');
   }
   $(function(){
    var project_progress_color = '<?php echo hooks()->apply_filters('admin_project_progress_color','#84c529'); ?>';
    var circle = $('.project-progress').circleProgress({fill: {
     gradient: [project_progress_color, project_progress_color]
   }}).on('circle-animation-progress', function(event, progress, stepValue) {
     $(this).find('strong.project-percent').html(parseInt(100 * stepValue) + '<i>%</i>');
   });
   });

   function discussion_comments(selector,discussion_id,discussion_type){
     var defaults = _get_jquery_comments_default_config(<?php echo json_encode(get_project_discussions_language_array()); ?>);
     var options = {
      currentUserIsAdmin:current_user_is_admin,
      getComments: function(success, error) {
        $.get('<?php echo  base_url() ?>' + 'session/session_info/get_discussion_comments/'+discussion_id+'/'+discussion_type,function(response){
          success(response);
        },'json');
      },
      postComment: function(commentJSON, success, error) {
        $.ajax({
          type: 'post',
          url: '<?php echo  base_url() ?>' + 'session/session_info/add_discussion_comment/'+discussion_id+'/'+discussion_type,
          data: commentJSON,
          success: function(comment) {
            comment = JSON.parse(comment);
            success(comment)
          },
          error: error
        });
      },
      putComment: function(commentJSON, success, error) {
        $.ajax({
          type: 'post',
          url: '<?php echo  base_url() ?>' + 'session/session_info/update_discussion_comment',
          data: commentJSON,
          success: function(comment) {
            comment = JSON.parse(comment);
            success(comment)
          },
          error: error
        });
      },
      deleteComment: function(commentJSON, success, error) {
        $.ajax({
          type: 'post',
          url: '<?php echo  base_url() ?>' + 'session/session_info/delete_discussion_comment/'+commentJSON.id,
          success: success,
          error: error
        });
      },
      uploadAttachments: function(commentArray, success, error) {
        var responses = 0;
        var successfulUploads = [];
        var serverResponded = function() {
          responses++;
            // Check if all requests have finished
            if(responses == commentArray.length) {
                // Case: all failed
                if(successfulUploads.length == 0) {
                  error();
                // Case: some succeeded
              } else {
                successfulUploads = JSON.parse(successfulUploads);
                success(successfulUploads)
              }
            }
          }
          $(commentArray).each(function(index, commentJSON) {
            // Create form data
            var formData = new FormData();
            if(commentJSON.file.size && commentJSON.file.size > app.max_php_ini_upload_size_bytes){
             alert_float('danger',"<?php echo _l("file_exceeds_max_filesize"); ?>");
             serverResponded();
           } else {
            $(Object.keys(commentJSON)).each(function(index, key) {
              var value = commentJSON[key];
              if(value) formData.append(key, value);
            });

            if (typeof(csrfData) !== 'undefined') {
               formData.append(csrfData['token_name'], csrfData['hash']);
            }
            $.ajax({
              url: '<?php echo  base_url() ?>' + 'session/session_info/add_discussion_comment/'+discussion_id+'/'+discussion_type,
              type: 'POST',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function(commentJSON) {
                successfulUploads.push(commentJSON);
                serverResponded();
              },
              error: function(data) {
               var error = JSON.parse(data.responseText);
               alert_float('danger',error.message);
               serverResponded();
             },
           });
          }
        });
        }
      
      }
      var settings = $.extend({}, defaults, options);
    $(selector).comments(settings);
   }
</script>
<script>

   $(function(){
        initDataTable('.table-customer-groups', window.location.href, [1], [1]);
   });

   $(function(){
        initDataTable('.table-reminder', window.location.href, [1], [1]);
   });
   function edit_session_json(id){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('session/session_info/get_discussion') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               function escapeHtml(text) {
                 var map = {
                   '&': '&amp;',
                   '<': '&lt;',
                   '>': '&gt;',
                   '"': '&quot;',
                   "'": '&#039;'
                 };
                 return text.replace(/[&<>"']/g, function(m) { return map[m]; });
               }
               var display = '';
               if (data.show_to_customer == 1)
                  $('[name="show_to_customer"]').prop('checked', true);
               else
                  $('[name="show_to_customer"]').prop('checked', false);
               
               console.log(escapeHtml(data.description));
                $('[name="subject"]').val(data.subject);
                
                $('[name="description"]').val(escapeHtml(data.description));
                $('[name="session_id"]').val(data.session_id);
                $('[name="id"]').val(data.id);
                // $('[name="dob"]').datepicker('update',data.dob);
                $('#edit_discussion').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
   Dropzone.autoDiscover = false;
   $(function () {

    if ($('#contract-attachments-form').length > 0) {
       new Dropzone("#contract-attachments-form",appCreateDropzoneOptions({
          success: function (file) {
             if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                var location = window.location.href;
                window.location.href = location.split('?')[0] + '?tab=attachments';
             }
          }
       }));
    }

    // In case user expect the submit btn to save the contract content
    $('#contract-form').on('submit', function () {
       $('#inline-editor-save-btn').click();
       return true;
    });

    if (typeof (Dropbox) != 'undefined' && $('#dropbox-chooser').length > 0) {
       document.getElementById("dropbox-chooser").appendChild(Dropbox.createChooseButton({
          success: function (files) {
             $.post(admin_url + 'contracts/add_external_attachment', {
                files: files,
                contract_id: contract_id,
                external: 'dropbox'
             }).done(function () {
                var location = window.location.href;
                window.location.href = location.split('?')[0] + '?tab=attachments';
             });
          },
          linkType: "preview",
          extensions: app.options.allowed_files.split(','),
       }));
    }


     if(is_mobile()) {

          editor_settings.theme = 'modern';
          editor_settings.mobile    = {};
          editor_settings.mobile.theme = 'mobile';
          editor_settings.mobile.toolbar = _tinymce_mobile_toolbar();

          editor_settings.inline = false;
          window.addEventListener("beforeunload", function (event) {
            if (tinymce.activeEditor.isDirty()) {
               save_contract_content();
            }
         });
     }

    tinymce.init(editor_settings);

   });


   function delete_session_attachment(wrapper, id) {
    if (confirm_delete()) {
       $.get(admin_url + 'session/<?php echo $controllerName ?>/delete_session_attachment/' + id, function (response) {
          if (response.success == true) {
             $(wrapper).parents('.contract-attachment-wrapper').remove();

             var totalAttachmentsIndicator = $('.attachments-indicator');
             var totalAttachments = totalAttachmentsIndicator.text().trim();
             if(totalAttachments == 1) {
               totalAttachmentsIndicator.remove();
             } else {
               totalAttachmentsIndicator.text(totalAttachments-1);
             }
          } else {
             alert_float('danger', response.message);
          }
       }, 'json');
    }
    return false;
   }

   function insert_merge_field(field) {
    var key = $(field).text();
    tinymce.activeEditor.execCommand('mceInsertContent', false, key);
   }

   function contract_full_view() {
    $('.left-column').toggleClass('hide');
    $('.right-column').toggleClass('col-md-7');
    $('.right-column').toggleClass('col-md-12');
    $(window).trigger('resize');
   }



   function contractGoogleDriveSave(pickData) {
      var data = {};
      data.contract_id = contract_id;
      data.external = 'gdrive';
      data.files = pickData;
      $.post(admin_url + 'session/<?php echo $controllerName ?>/add_external_attachment', data).done(function () {
        var location = window.location.href;
        window.location.href = location.split('?')[0] + '?tab=attachments';
     });
   }



</script>
</body>
</html>
