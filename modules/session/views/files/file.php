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
                                 Session Information
                              </a>
                           </li>
                           <li role="presentation" class="tab-separator">
                              <a href="#tab_next_action" aria-controls="tab_next_action" role="tab" data-toggle="tab" onclick="init_rel_tasks_table(<?php echo $contract[$id]; ?>,'contract'); return false;">
                                 Next Action
                              </a>
                           </li>
                           <li role="presentation" class="tab-separator">
                              <a href="#tab_next_date" aria-controls="tab_next_date" role="tab" data-toggle="tab" onclick="init_rel_tasks_table(<?php echo $contract[$id]; ?>,'contract'); return false;">
                                 Next Date
                              </a>
                           </li>
                           <li role="presentation" class="tab-separator">
                              <a href="#tab_status" aria-controls="tab_status" role="tab" data-toggle="tab" onclick="init_rel_tasks_table(<?php echo $contract[$id]; ?>,'contract'); return false;">
                                 Status
                              </a>
                           </li>

                           <li role="presentation" class="tab-separator">
                              <a href="#tab_result" aria-controls="tab_result" role="tab" data-toggle="tab" onclick="init_rel_tasks_table(<?php echo $contract[$id]; ?>,'contract'); return false;">
                                 Result
                              </a>
                           </li>
                           <li role="presentation" class="tab-separator">
                              <a href="#tab_discussion" aria-controls="tab_discussion" role="tab" data-toggle="tab" onclick="init_rel_tasks_table(<?php echo $contract[$id]; ?>,'contract'); return false;">
                                 Discussions
                              </a>
                           </li>

                           <li role="presentation" class="tab-separator">
                              <a href="#tab_detail" aria-controls="tab_detail" role="tab" data-toggle="tab" onclick="init_rel_tasks_table(<?php echo $contract[$id]; ?>,'contract'); return false;">
                                 Session Detail
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
                     <div role="tabpanel" class="tab-pane" id="tab_information">
                        <?php 
                           function statusName($id){
                              switch ($id) {
                                 case 0:
                                    return "جلسة أولى";
                                    break;
                                 case 1:
                                    return "جلسة استماع";
                                    break;
                                 case 2:
                                    return "جلسة رد";
                                    break;
                                 case 3:
                                    return "النطق  بالحكم";
                                    break;
                                 
                                 default:
                                    return "جلسة أولى";
                                    break;
                              }
                           }
                           function resultName($id){
                              switch ($id) {
                                 case 0:
                                    return "تم الحكم لصالح المدعي";
                                    break;
                                 case 1:
                                    return "تم الحكم لصالح المدعي عليه";
                                    break;
                                 case 2:
                                    return "تم إقفال القضية";
                                    break;
                                
                                 
                                 default:
                                    return "تم الحكم لصالح المدعي";
                                    break;
                              }
                           }
                        ?>
                        <div class="row well ">
                            <div class="col-md-12" style="font-size: 17px">
                                    <div class="col-md-6">
                                        <?php echo '<b>Service Id</b>' ?> : <?php echo $session->service_id ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php echo '<b>Subject</b>' ?> : <?php echo $session->subject ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>Court</b>' ?> : <?php echo ($court_name->court_name) ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>Judge</b>' ?> : <?php echo $judge_name->name ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>Date</b>' ?> : <?php echo $session->date ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>Status</b>' ?> : <?php echo statusName($session->status) ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>Result</b>' ?> : <?php echo resultName($session->result) ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php echo '<b>Added By</b>' ?> : <?php echo $this->Service_sessions_model->getStaff($session->staff)['firstname'] . ' ' . $this->Service_sessions_model->getStaff($session->staff)['lastname'] ?>
                                    </div>

                                <?php if ($session->details){ ?>
                                    <div class="col-md-6">
                                        <?php echo '<b>Details</b>' ?> : <?php echo $session->details ?>
                                    </div>
                                <?php } ?>
                                <?php if ($session->next_action){ ?>
                                    <div class="col-md-6">
                                        <?php echo '<b>Next Action</b>' ?> : <?php echo $session->next_action ?>
                                    </div>
                                <?php } ?>
                                <?php if ($session->next_date){ ?>
                                    <div class="col-md-6">
                                        <?php echo '<b>Next Date</b>' ?> : <?php echo $session->next_date ?>
                                    </div>
                                <?php } ?>
                                <?php if ($session->report){ ?>
                                    <div class="col-md-6">
                                        <?php echo '<b>Report</b>' ?> : <?php echo $session->report ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                     </div>
                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'detail'){echo ' active';} ?>" id="tab_detail">
                              <?php $detail = ($session->details) ? $session->details : '' ;  ?>
                        <form id="form_transout" method="get" action="<?php echo base_url() . 'session/' . $controllerName . '/edit_detail/' ?><?php echo $session->id ?>">
                           <div class="form-group">
                             <label for="details" class="col-form-label">Session Detail</label>
                             <textarea type="text" class="form-control" id="details" name="details" value="<?php echo $detail ?>"></textarea>
                           </div>
                           <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                     </div>
                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'next_action'){echo ' active';} ?>" id="tab_next_action">
                              <?php $detail = ($session->next_action) ? $session->next_action : '' ;  ?>
                        <form id="form_transout" method="get" action="<?php echo base_url() . 'session/' . $controllerName . '/edit_next_action/' ?><?php echo $session->id ?>">
                           <div class="form-group">
                             <label for="subject" class="col-form-label">Next Action</label>
                             <textarea type="text" class="form-control" id="subject" name="next_action" value="<?php echo $detail ?>"></textarea>
                           </div>
                           <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                     </div>
                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'next_date'){echo ' active';} ?>" id="tab_next_date">
                              <?php $detail = ($session->next_date) ? $session->next_date : '' ;  ?>
                        <form id="form_transout" method="get" action="<?php echo base_url() . 'session/' . $controllerName . '/edit_next_date/' ?><?php echo $session->id ?>">
                           <div class="form-group" app-field-wrapper="date">
                            <label for="date" class="control-label">Date</label>
                              <div class="input-group date">
                                 <input type="text" id="date" name="next_date" class="form-control datepicker" value="<?php echo $detail ?>" autocomplete="off" aria-invalid="false">
                                 <div class="input-group-addon">
                                    <i class="fa fa-calendar calendar-icon"></i>
                                 </div>
                              </div>
                           </div>
                           <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                     </div>
                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'status'){echo ' active';} ?>" id="tab_status">
                        
                        <form id="form_transout" method="get" action="<?php echo base_url() . 'session/' . $controllerName . '/edit_status/' ?><?php echo $session->id ?>">
                           <div class="form-group">
                            <label for="staff_id" class="col-form-label"><h4>Status : <?php echo statusName($session->status) ?></h4></label>
                            <div class="row-fluid">
                              <select name="status" id="status" class="selectpicker" data-show-subtext="true" data-live-search="true" value="3">

                                  <option value="0">جلسة أولى</option>
                                  <option value="1">جلسة استماع</option>
                                  <option value="2">جلسة رد</option>
                                  <option value="3">النطق  بالحكم</option>
                                  
                              </select>
                            
                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary">Save</button>
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
                        <p><?php echo _l('project_discussion_total_comments'); ?>: <?php echo total_rows(db_prefix().'projectdiscussioncomments',array('discussion_id'=>$discussion->id)); ?>
                        <p class="text-muted"><?php echo $discussion->description; ?></p>
                        <hr />
                        <div id="discussion-comments"></div>
                        <?php } ?>

                     </div>
                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'result'){echo ' active';} ?>" id="tab_result">
                        <form id="form_transout" method="get" action="<?php echo base_url() . 'session/' . $controllerName . '/edit_result/' ?><?php echo $session->id ?>">
                           <div class="form-group">
                            <label for="staff_id" class="col-form-label"><h4>Result : <?php echo resultName($session->result) ?></h4></label>
                            <div class="row-fluid">
                              <select name="result" id="result" class="selectpicker" data-show-subtext="true" data-live-search="true" value="3">

                                  <option value="0">تم الحكم لصالح المدعي</option>
                                  <option value="1">تم الحكم لصالح المدعي عليه</option>
                                  <option value="2">تم إقفال القضية</option>
                                  
                              </select>
                            
                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                        
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

    appValidateForm($('#contract-form'), {
       client: 'required',
       datestart: 'required',
       subject: 'required'
    });

    appValidateForm($('#renew-contract-form'), {
       new_start_date: 'required'
    });

    var _templates = [];
    $.each(contractsTemplates, function (i, template) {
       _templates.push({
          url: admin_url + 'contracts/get_template?name=' + template,
          title: template
       });
    });

    var editor_settings = {
       selector: 'div.editable',
       inline: true,
       theme: 'inlite',
       relative_urls: false,
       remove_script_host: false,
       inline_styles: true,
       verify_html: false,
       cleanup: false,
       apply_source_formatting: false,
       valid_elements: '+*[*]',
       valid_children: "+body[style], +style[type]",
       file_browser_callback: elFinderBrowser,
       table_default_styles: {
          width: '100%'
       },
       fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
       pagebreak_separator: '<p pagebreak="true"></p>',
       plugins: [
          'advlist pagebreak autolink autoresize lists link image charmap hr',
          'searchreplace visualblocks visualchars code',
          'media nonbreaking table contextmenu',
          'paste textcolor colorpicker'
       ],
       autoresize_bottom_margin: 50,
       insert_toolbar: 'image media quicktable | bullist numlist | h2 h3 | hr',
       selection_toolbar: 'save_button bold italic underline superscript | forecolor backcolor link | alignleft aligncenter alignright alignjustify | fontselect fontsizeselect h2 h3',
       contextmenu: "image media inserttable | cell row column deletetable | paste pastetext searchreplace | visualblocks pagebreak charmap | code",
       setup: function (editor) {

          editor.addCommand('mceSave', function () {
             save_contract_content(true);
          });

          editor.addShortcut('Meta+S', '', 'mceSave');

          editor.on('MouseLeave blur', function () {
             if (tinymce.activeEditor.isDirty()) {
                save_contract_content();
             }
          });

          editor.on('MouseDown ContextMenu', function () {
             if (!is_mobile() && !$('.left-column').hasClass('hide')) {
                contract_full_view();
             }
          });

          editor.on('blur', function () {
             $.Shortcuts.start();
          });

          editor.on('focus', function () {
             $.Shortcuts.stop();
          });

       }
    }

    if (_templates.length > 0) {
       editor_settings.templates = _templates;
       editor_settings.plugins[3] = 'template ' + editor_settings.plugins[3];
       editor_settings.contextmenu = editor_settings.contextmenu.replace('inserttable', 'inserttable template');
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
