<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <?php if(isset($contract)) { ?>
         <div class="col-md-12 right-column">
            <div class="panel_s">
               <div class="panel-body">
                   <div class="pull-right">
                       <?php
                       if($service_type_id == 1){
                           $redirect_url = "Case/view/$service_type_id/$service_id?group=Procedures";
                       }else{
                           $redirect_url = "SOther/view/$service_type_id/$service_id?group=Procedures";
                       }
                       ?>
                       <a href="<?php echo admin_url().$redirect_url; ?>" class="btn btn-default pull-right"><i class="fa fa-reply"></i> <?php echo _l('go_back'); ?></a>
                   </div>
                  <h4 class="no-margin"><?php echo $contract->subject; ?></h4>

                   <?php /* <a href="<?php echo site_url('contract/'.$contract->id.'/'.$contract->hash); ?>" target="_blank">
                     <?php echo _l('view_procedure'); ?>
                  </a> */ ?>
                  <hr class="hr-panel-heading" />
                  <?php /*if($contract->trash > 0){
                     echo '<div class="ribbon default"><span>'._l('contract_trash').'</span></div>';
                     }*/ ?>
                  <div class="horizontal-scrollable-tabs preview-tabs-top">
                     <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                     <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                     <div class="horizontal-tabs">
                        <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
                           <li role="presentation" class="<?php if(!$this->input->get('tab') || $this->input->get('tab') == 'tab_content'){echo 'active';} ?>">
                              <a href="#tab_content" aria-controls="tab_content" role="tab" data-toggle="tab">
                              <?php echo _l('legal_procedure'); ?>
                              </a>
                           </li>
                            <?php /*<li role="presentation" class="<?php if($this->input->get('tab') == 'log'){echo 'active';} ?>">
                                <a href="#log" aria-controls="log" role="tab" data-toggle="tab">
                                    <?php echo _l('procedure_previous_text'); ?>
                                </a>
                            </li> */?>
                           <li role="presentation" class="<?php if($this->input->get('tab') == 'attachments'){echo 'active';} ?>">
                              <a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">
                              <?php echo _l('contract_attachments'); ?>
                              <?php if($totalAttachments = count($contract->attachments)) { ?>
                                  <span class="badge attachments-indicator"><?php echo $totalAttachments; ?></span>
                              <?php } ?>
                              </a>
                           </li>
                           <li role="presentation">
                              <a href="#tab_comments" aria-controls="tab_comments" role="tab" data-toggle="tab" onclick="get_contract_comments(); return false;">
                              <?php echo _l('contract_comments'); ?>
                              <?php
                              $totalComments = total_rows(db_prefix().'contract_comments','contract_id='.$contract->id)
                              ?>
                              <span class="badge comments-indicator<?php echo $totalComments == 0 ? ' hide' : ''; ?>"><?php echo $totalComments; ?></span>
                              </a>
                           </li>
                           <?php /*<li role="presentation" class="<?php if($this->input->get('tab') == 'renewals'){echo 'active';} ?>">
                              <a href="#renewals" aria-controls="renewals" role="tab" data-toggle="tab">
                              <?php echo _l('no_contract_renewals_history_heading'); ?>
                              <?php if($totalRenewals = count($contract_renewal_history)) { ?>
                                 <span class="badge"><?php echo $totalRenewals; ?></span>
                              <?php } ?>
                              </a>
                           </li> */ ?>
                           <li role="presentation" class="tab-separator">
                              <a href="#tab_tasks" aria-controls="tab_tasks" role="tab" data-toggle="tab" onclick="init_rel_tasks_table(<?php echo $contract->id; ?>,'contract'); return false;">
                              <?php echo _l('tasks'); ?>
                              </a>
                           </li>
                           <li role="presentation" class="tab-separator">
                              <a href="#tab_notes" onclick="get_sales_notes(<?php echo $contract->id; ?>,'contracts'); return false" aria-controls="tab_notes" role="tab" data-toggle="tab">
                                 <?php echo _l('contract_notes'); ?>
                                 <span class="notes-total">
                                    <?php if($totalNotes > 0){ ?>
                                       <span class="badge"><?php echo $totalNotes; ?></span>
                                    <?php } ?>
                                 </span>
                              </a>
                           </li>
                            <?php /* <li role="presentation" data-toggle="tooltip" title="<?php echo _l('emails_tracking'); ?>" class="tab-separator">
                              <a href="#tab_emails_tracking" aria-controls="tab_emails_tracking" role="tab" data-toggle="tab">
                                 <?php if(!is_mobile()){ ?>
                                 <i class="fa fa-envelope-open-o" aria-hidden="true"></i>
                                 <?php } else { ?>
                                 <?php echo _l('emails_tracking'); ?>
                                 <?php } ?>
                              </a>
                           </li>*/ ?>
                        </ul>
                     </div>
                  </div>
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane<?php if(!$this->input->get('tab') || $this->input->get('tab') == 'tab_content'){echo ' active';} ?>" id="tab_content">
                        <div class="row">
                           <?php /*if($contract->signed == 1){ ?>
                           <div class="col-md-12">
                              <div class="alert alert-success">
                                 <?php echo _l('document_signed_info',array(
                                    '<b>'.$contract->acceptance_firstname . ' ' . $contract->acceptance_lastname . '</b> (<a href="mailto:'.$contract->acceptance_email.'">'.$contract->acceptance_email.'</a>)',
                                    '<b>'. _dt($contract->acceptance_date).'</b>',
                                    '<b>'.$contract->acceptance_ip.'</b>')
                                    ); ?>
                              </div>
                           </div>
                           <?php } else if($contract->marked_as_signed == 1) { ?>
                              <div class="col-md-12">
                                 <div class="alert alert-info">
                                    <?php echo _l('contract_marked_as_signed_info'); ?>
                                 </div>
                              </div>
                           <?php }*/ ?>
                           <div class="col-md-12 text-right _buttons">
                              <div class="btn-group">
                                 <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i><?php if(is_mobile()){echo ' PDF';} ?> <span class="caret"></span></a>
                                 <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="hidden-xs"><a href="<?php echo admin_url('LegalServices/legal_procedures/pdf/'.$contract->id.'?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a></li>
                                    <li class="hidden-xs"><a href="<?php echo admin_url('LegalServices/legal_procedures/pdf/'.$contract->id.'?output_type=I'); ?>" target="_blank"><?php echo _l('view_pdf_in_new_window'); ?></a></li>
                                    <li><a href="<?php echo admin_url('LegalServices/legal_procedures/pdf/'.$contract->id); ?>"><?php echo _l('download'); ?></a></li>
                                    <li>
                                       <a href="<?php echo admin_url('LegalServices/legal_procedures/pdf/'.$contract->id.'?print=true'); ?>" target="_blank">
                                       <?php echo _l('print'); ?>
                                       </a>
                                    </li>
                                 </ul>
                              </div>
                               <?php  /* <a href="#" class="btn btn-default" data-target="#contract_send_to_client_modal" data-toggle="modal"><span class="btn-with-tooltip" data-toggle="tooltip" data-title="<?php echo _l('contract_send_to_email'); ?>" data-placement="bottom">
                              <i class="fa fa-envelope"></i></span>
                              </a> */?>
                              <div class="btn-group">
                                 <button type="button" class="btn btn-default pull-left dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 <?php echo _l('more'); ?> <span class="caret"></span>
                                 </button>
                                 <ul class="dropdown-menu dropdown-menu-right">
                                     <?php /* <li>
                                       <a href="<?php echo site_url('contract/'.$contract->id.'/'.$contract->hash); ?>" target="_blank">
                                       <?php echo _l('view_procedure'); ?>
                                       </a>
                                    </li> */ ?>
                                    <?php
                                    //if($contract->signed == 0 && $contract->marked_as_signed == 0 && staff_can('edit', 'contracts')) { ?>
                                     <li>
                                       <a href="#" data-toggle="modal" data-target="#save_as_template">
                                          <?php echo _l('procedure_save_as_template'); ?>
                                       </a>
                                    </li>
                                 <?php /*} else if($contract->signed == 0 && $contract->marked_as_signed == 1 && staff_can('edit', 'contracts')) { ?>
                                       <li>
                                       <a href="<?php echo admin_url('contracts/unmark_as_signed/'.$contract->id); ?>">
                                          <?php echo _l('unmark_as_signed'); ?>
                                       </a>
                                    </li>
                                 <?php }*/ ?>
                                    <?php /*hooks()->do_action('after_contract_view_as_client_link', $contract); ?>
                                    <?php if(has_permission('contracts','','create')){ ?>
                                    <li>
                                       <a href="<?php echo admin_url('contracts/copy/'.$contract->id); ?>">
                                       <?php echo _l('contract_copy'); ?>
                                       </a>
                                    </li>
                                    <?php }*/ ?>
                                    <?php /*if($contract->signed == 1 && has_permission('contracts','','delete')){ ?>
                                    <li>
                                       <a href="<?php echo admin_url('contracts/clear_signature/'.$contract->id); ?>" class="_delete">
                                       <?php echo _l('clear_signature'); ?>
                                       </a>
                                    </li>
                                    <?php }*/ ?>
                                    <?php /*if(has_permission('contracts','','delete')){*/ ?>
                                    <li>
                                       <a href="<?php echo admin_url('LegalServices/legal_procedures/delete_contract/'.$contract->id.'/'.$service_type_id.'/'.$service_id); ?>" class="_delete">
                                       <?php echo _l('delete'); ?></a>
                                    </li>
                                    <?php /*}*/ ?>
                                 </ul>
                              </div>
                           </div>
                         <?php  /*<div class="col-md-12">
                              <?php if(isset($contract_merge_fields)){ ?>
                              <hr class="hr-panel-heading" />
                              <p class="bold mtop10 text-right"><a href="#" onclick="slideToggle('.avilable_merge_fields'); return false;"><?php echo _l('available_merge_fields'); ?></a></p>
                              <div class=" avilable_merge_fields mtop15 hide">
                                 <ul class="list-group">
                                    <?php
                                       foreach($contract_merge_fields as $field){
                                           foreach($field as $f){
                                              echo '<li class="list-group-item"><b>'.$f['name'].'</b>  <a href="#" class="pull-right" onclick="insert_merge_field(this); return false">'.$f['key'].'</a></li>';
                                          }
                                       }
                                    ?>
                                 </ul>
                              </div>
                              <?php } ?>
                           </div> */?>
                        </div>
                        <hr class="hr-panel-heading" />
                         <?php echo form_open($this->uri->uri_string(),array('id'=>'contract-form')); ?>
                         <?php $value = (isset($contract) ? $contract->subject : ''); ?>
                         <?php echo render_input('subject','procedure_subject',$value); ?>
                         <div class="text-right">
                             <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                         </div>
                         <?php echo form_close(); ?>
                         <hr class="hr-panel-heading" />
                        <?php /*if(!staff_can('edit','contracts')) { ?>
                           <div class="alert alert-warning contract-edit-permissions">
                              <?php echo _l('contract_content_permission_edit_warning'); ?>
                           </div>
                        <?php }*/ ?>
                        <div class="tc-content<?php if(staff_can('edit','contracts')){echo ' editable';} ?>" style="border:1px solid #d2d2d2;min-height:70px; border-radius:4px;">
                           <?php
                              if(empty($contract->content) && staff_can('edit','contracts')){
                               echo hooks()->apply_filters('new_contract_default_content', '<span class="text-uppercase mtop15 editor-add-content-notice"> ' . _l('click_to_add_content') . '</span>');
                              } else {
                               echo $contract->content;
                              }
                              ?>
                        </div>
                         <div class="row mtop25">
                             <div class="col-md-12 text-left">
                         <?php if(!empty($contract->content) && staff_can('edit','contracts')): ?>
                             <h4 class="bold"><?php echo _l('procedure_editor').' '.get_staff_full_name(get_staff_user_id()) ?></h4>
                             <h5 class="bold"><?php echo _l('procedure_copy_date').' '._dt($contract->dateadded); ?> </h5>
                         <?php endif ?>
                             </div>
                         </div>
                        <?php /*if(!empty($contract->signature)) { ?>
                        <div class="row mtop25">
                           <div class="col-md-6 col-md-offset-6 text-right">
                              <p class="bold"><?php echo _l('document_customer_signature_text'); ?>
                                 <?php if($contract->signed == 1 && has_permission('contracts','','delete')){ ?>
                                 <a href="<?php echo admin_url('contracts/clear_signature/'.$contract->id); ?>" data-toggle="tooltip" title="<?php echo _l('clear_signature'); ?>" class="_delete text-danger">
                                 <i class="fa fa-remove"></i>
                                 </a>
                                 <?php } ?>
                              </p>
                              <div class="pull-right">
                                 <img src="<?php echo site_url('download/preview_image?path='.protected_file_url_by_path(get_upload_path_by_type('contract').$contract->id.'/'.$contract->signature)); ?>" class="img-responsive" alt="">
                              </div>
                           </div>
                        </div>
                        <?php }*/ ?>
                     </div>
                      <div role="tabpanel" class="tab-pane" id="log">
                      </div>
                      <div role="tabpanel" class="tab-pane" id="tab_notes">
                        <?php echo form_open(admin_url('contracts/add_note/'.$contract->id),array('id'=>'sales-notes','class'=>'contract-notes-form')); ?>
                        <?php echo render_textarea('description'); ?>
                        <div class="text-right">
                           <button type="submit" class="btn btn-info mtop15 mbot15"><?php echo _l('contract_add_note'); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                        <hr />
                        <div class="panel_s mtop20 no-shadow" id="sales_notes_area">
                        </div>
                     </div>
                     <div role="tabpanel" class="tab-pane" id="tab_comments">
                        <div class="row contract-comments mtop15">
                           <div class="col-md-12">
                              <div id="contract-comments"></div>
                              <div class="clearfix"></div>
                              <textarea name="content" id="comment" rows="4" class="form-control mtop15 contract-comment"></textarea>
                              <button type="button" class="btn btn-info mtop10 pull-right" onclick="add_contract_comment();"><?php echo _l('proposal_add_comment'); ?></button>
                           </div>
                        </div>
                     </div>
                     <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'attachments'){echo ' active';} ?>" id="attachments">
                        <?php echo form_open(admin_url('contracts/add_contract_attachment/'.$contract->id),array('id'=>'contract-attachments-form','class'=>'dropzone')); ?>
                        <?php echo form_close(); ?>
                        <div class="text-right mtop15">
                           <?php /*<button class="gpicker" data-on-pick="contractGoogleDriveSave">
                              <i class="fa fa-google" aria-hidden="true"></i>
                              <?php echo _l('choose_from_google_drive'); ?>
                           </button>
                           <div id="dropbox-chooser"></div> */?>
                           <div class="clearfix"></div>
                        </div>
                        <!-- <img src="https://drive.google.com/uc?id=14mZI6xBjf-KjZzVuQe8-rjtv_wXEbDTw" /> -->

                        <div id="contract_attachments" class="mtop30">
                           <?php
                              $data = '<div class="row">';
                              foreach($contract->attachments as $attachment) {
                                $href_url = site_url('download/file/contract/'.$attachment['attachment_key']);
                                if(!empty($attachment['external'])){
                                  $href_url = $attachment['external_link'];
                                }
                                $data .= '<div class="display-block contract-attachment-wrapper">';
                                $data .= '<div class="col-md-10">';
                                $data .= '<div class="pull-left"><i class="'.get_mime_class($attachment['filetype']).'"></i></div>';
                                $data .= '<a href="'.$href_url.'"'.(!empty($attachment['external']) ? ' target="_blank"' : '').'>'.$attachment['file_name'].'</a>';
                                $data .= '<p class="text-muted">'.$attachment["filetype"].'</p>';
                                $data .= '</div>';
                                $data .= '<div class="col-md-2 text-right">';
                                if($attachment['staffid'] == get_staff_user_id() || is_admin()){
                                 $data .= '<a href="#" class="text-danger" onclick="delete_contract_attachment(this,'.$attachment['id'].'); return false;"><i class="fa fa fa-times"></i></a>';
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
                      <?php /* <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'renewals'){echo ' active';} ?>" id="renewals">
                        <?php if(has_permission('contracts', '', 'create') || has_permission('contracts', '', 'edit')){ ?>
                        <div class="_buttons">
                           <a href="#" class="btn btn-default" data-toggle="modal" data-target="#renew_contract_modal">
                           <i class="fa fa-refresh"></i> <?php echo _l('contract_renew_heading'); ?>
                           </a>
                        </div>
                        <hr />
                        <?php } ?>
                        <div class="clearfix"></div>
                        <?php
                           if(count($contract_renewal_history) == 0){
                            echo _l('no_contract_renewals_found');
                           }
                           foreach($contract_renewal_history as $renewal){ ?>
                        <div class="display-block">
                           <div class="media-body">
                              <div class="display-block">
                                 <b>
                                 <?php
                                    echo _l('contract_renewed_by',$renewal['renewed_by']);
                                    ?>
                                 </b>
                                 <?php if($renewal['renewed_by_staff_id'] == get_staff_user_id() || is_admin()){ ?>
                                 <a href="<?php echo admin_url('contracts/delete_renewal/'.$renewal['id'] . '/'.$renewal['contractid']); ?>" class="pull-right _delete text-danger"><i class="fa fa-remove"></i></a>
                                 <br />
                                 <?php } ?>
                                 <small class="text-muted"><?php echo _dt($renewal['date_renewed']); ?></small>
                                 <hr class="hr-10" />
                                 <span class="text-success bold" data-toggle="tooltip" title="<?php echo _l('contract_renewal_old_start_date',_d($renewal['old_start_date'])); ?>">
                                 <?php echo _l('contract_renewal_new_start_date',_d($renewal['new_start_date'])); ?>
                                 </span>
                                 <br />
                                 <?php if(is_date($renewal['new_end_date'])){
                                    $tooltip = '';
                                    if(is_date($renewal['old_end_date'])){
                                     $tooltip = _l('contract_renewal_old_end_date',_d($renewal['old_end_date']));
                                    }
                                    ?>
                                 <span class="text-success bold" data-toggle="tooltip" title="<?php echo $tooltip; ?>">
                                 <?php echo _l('contract_renewal_new_end_date',_d($renewal['new_end_date'])); ?>
                                 </span>
                                 <br/>
                                 <?php } ?>
                                 <?php if($renewal['new_value'] > 0){
                                    $contract_renewal_value_tooltip = '';
                                    if($renewal['old_value'] > 0){
                                     $contract_renewal_value_tooltip = ' data-toggle="tooltip" data-title="'._l('contract_renewal_old_value', app_format_money($renewal['old_value'], $base_currency)).'"';
                                    } ?>
                                 <span class="text-success bold"<?php echo $contract_renewal_value_tooltip; ?>>
                                 <?php echo _l('contract_renewal_new_value', app_format_money($renewal['new_value'], $base_currency)); ?>
                                 </span>
                                 <br />
                                 <?php } ?>
                              </div>
                           </div>
                           <hr />
                        </div>
                        <?php } ?>
                     </div>
                     <div role="tabpanel" class="tab-pane" id="tab_emails_tracking">
                        <?php
                           $this->load->view('admin/includes/emails_tracking',array(
                             'tracked_emails'=>
                             get_tracked_emails($contract->id, 'contract'))
                           );
                           ?>
                     </div>*/ ?>
                     <div role="tabpanel" class="tab-pane" id="tab_tasks">
                        <?php init_relation_tasks_table(array('data-new-rel-id'=>$contract->id,'data-new-rel-type'=>'legal_procedures')); ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php } ?>
      </div>

       <div class="modal fade" id="save_as_template" tabindex="-1" role="dialog">
           <div class="modal-dialog">
               <?php echo form_open(admin_url('LegalServices/legal_procedures/save_as_template'),array('id'=>'save-as-template-form')); ?>
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title">
                           <span class="add-title"><?php echo _l('procedure_save_as_template'); ?></span>
                       </h4>
                   </div>
                   <div class="modal-body">
                       <div class="row">
                           <div class="col-md-12">
                               <?php
                               $proc_data = legal_procedure_by_ref_id($contract->id);
                               $list_data = list_procedure_by_id($proc_data->list_id);
                               ?>
                               <?php echo render_input('list_id','',$proc_data->list_id,'hidden'); ?>
                               <?php echo render_input('subcat_id','',$proc_data->subcat_id,'hidden'); ?>
                               <?php echo render_input('cat_id','',$list_data->cat_id,'hidden'); ?>
                               <?php echo render_input('content','',$contract->content,'hidden'); ?>
                               <div class="form-group">
                                   <label for="rel_type" class="control-label"><?php echo _l('select_legal_services'); ?></label>
                                   <select name="rel_type" class="selectpicker" id="rel_type" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                       <option value=""></option>
                                       <?php foreach ($legal_services as $service): ?>
                                           <option value="<?php echo $service['slug']; ?>"><?php echo $service['name']; ?></option>
                                       <?php endforeach; ?>
                                   </select>
                               </div>
                               <div class="form-group" id="rel_id_wrapper">
                                   <label for="rel_id" class="control-label"><span class="rel_id_label"></span></label>
                                   <div id="rel_id_select">
                                       <select name="rel_id" id="rel_id" class="ajax-sesarch" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                           <?php
                                               $rel_data = get_relation_data($rel_type,$rel_id);
                                               $rel_val = get_relation_values($rel_data,$rel_type);
                                               if(!$rel_data){
                                                   echo '<option value="'.$rel_id.'" selected>'.$rel_id.'</option>';
                                               }else{
                                                   echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                                               }
                                            ?>
                                       </select>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                       <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                   </div>
               </div>
               <!-- /.modal-content -->
               <?php echo form_close(); ?>
           </div>
           <!-- /.modal-dialog -->
       </div>
       <!-- /.modal -->
   </div>
</div>
<?php init_tail(); ?>
<?php if(isset($contract)){ ?>
<!-- init table tasks -->
<script>
   var contract_id = '<?php echo $contract->id; ?>';
</script>
<?php //$this->load->view('admin/contracts/send_to_client'); ?>
<?php //$this->load->view('admin/contracts/renew_contract'); ?>
<?php } ?>
<?php //$this->load->view('admin/contracts/contract_type'); ?>
<script>
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

    // appValidateForm($('#contract-form'), {
    //    client: 'required',
    //    datestart: 'required',
    //    subject: 'required'
    // });
    //
    // appValidateForm($('#renew-contract-form'), {
    //    new_start_date: 'required'
    // });

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

          // editor.on('MouseDown ContextMenu', function () {
          //    if (!is_mobile() && !$('.left-column').hasClass('hide')) {
          //       contract_full_view();
          //    }
          // });

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

   function save_contract_content(manual) {
    var editor = tinyMCE.activeEditor;
    var data = {};
    data.contract_id = contract_id;
    data.content = editor.getContent();
    $.post(admin_url + 'LegalServices/legal_procedures/save_contract_data', data).done(function (response) {
       response = JSON.parse(response);
       if (typeof (manual) != 'undefined') {
          // Show some message to the user if saved via CTRL + S
          alert_float('success', response.message);
       }
       // Invokes to set dirty to false
       editor.save();
    }).fail(function (error) {
       var response = JSON.parse(error.responseText);
       alert_float('danger', response.message);
    });
   }

   function delete_contract_attachment(wrapper, id) {
    if (confirm_delete()) {
       $.get(admin_url + 'contracts/delete_contract_attachment/' + id, function (response) {
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

   // function insert_merge_field(field) {
   //  var key = $(field).text();
   //  tinymce.activeEditor.execCommand('mceInsertContent', false, key);
   // }

   // function contract_full_view() {
   //  $('.left-column').toggleClass('hide');
   //  $('.right-column').toggleClass('col-md-7');
   //  $('.right-column').toggleClass('col-md-12');
   //  $(window).trigger('resize');
   // }

   function add_contract_comment() {
    var comment = $('#comment').val();
    if (comment == '') {
       return;
    }
    var data = {};
    data.content = comment;
    data.contract_id = contract_id;
    $('body').append('<div class="dt-loader"></div>');
    $.post(admin_url + 'LegalServices/legal_procedures/add_comment', data).done(function (response) {
       response = JSON.parse(response);
       $('body').find('.dt-loader').remove();
       if (response.success == true) {
          $('#comment').val('');
          get_contract_comments();
       }
    });
   }

   function get_contract_comments() {
    if (typeof (contract_id) == 'undefined') {
       return;
    }
    requestGet('contracts/get_comments/' + contract_id).done(function (response) {
       $('#contract-comments').html(response);
       var totalComments = $('[data-commentid]').length;
       var commentsIndicator = $('.comments-indicator');
       if(totalComments == 0) {
            commentsIndicator.addClass('hide');
       } else {
         commentsIndicator.removeClass('hide');
         commentsIndicator.text(totalComments);
       }
    });
   }

   function remove_contract_comment(commentid) {
    if (confirm_delete()) {
       requestGetJSON('contracts/remove_comment/' + commentid).done(function (response) {
          if (response.success == true) {

            var totalComments = $('[data-commentid]').length;

             $('[data-commentid="' + commentid + '"]').remove();

             var commentsIndicator = $('.comments-indicator');
             if(totalComments-1 == 0) {
               commentsIndicator.addClass('hide');
            } else {
               commentsIndicator.removeClass('hide');
               commentsIndicator.text(totalComments-1);
            }
          }
       });
    }
   }

   function edit_contract_comment(id) {
    var content = $('body').find('[data-contract-comment-edit-textarea="' + id + '"] textarea').val();
    if (content != '') {
       $.post(admin_url + 'contracts/edit_comment/' + id, {
          content: content
       }).done(function (response) {
          response = JSON.parse(response);
          if (response.success == true) {
             alert_float('success', response.message);
             $('body').find('[data-contract-comment="' + id + '"]').html(nl2br(content));
          }
       });
       toggle_contract_comment_edit(id);
    }
   }

   function toggle_contract_comment_edit(id) {
       $('body').find('[data-contract-comment="' + id + '"]').toggleClass('hide');
       $('body').find('[data-contract-comment-edit-textarea="' + id + '"]').toggleClass('hide');
   }

   // function contractGoogleDriveSave(pickData) {
   //    var data = {};
   //    data.contract_id = contract_id;
   //    data.external = 'gdrive';
   //    data.files = pickData;
   //    $.post(admin_url + 'contracts/add_external_attachment', data).done(function () {
   //      var location = window.location.href;
   //      window.location.href = location.split('?')[0] + '?tab=attachments';
   //   });
   // }
   var _rel_id = $('#rel_id'),
       _rel_type = $('#rel_type'),
       _rel_id_wrapper = $('#rel_id_wrapper'),
       data = {};
   $(function(){

       appValidateForm($('#save-as-template-form'), {
           rel_type: 'required',
           rel_id: 'required',
       });

   task_rel_select();

   _rel_type.on('change', function() {

       var clonedSelect = _rel_id.html('').clone();
       _rel_id.selectpicker('destroy').remove();
       _rel_id = clonedSelect;
       $('#rel_id_select').append(clonedSelect);
       $('.rel_id_label').html(_rel_type.find('option:selected').text());

       task_rel_select();
       if($(this).val() != ''){
           _rel_id_wrapper.removeClass('hide');
       } else {
           _rel_id_wrapper.addClass('hide');
       }
       //init_project_details(_rel_type.val());
   });
   });
   function task_rel_select(){
       var serverData = {};
       serverData.rel_id = _rel_id.val();
       data.type = _rel_type.val();
       init_ajax_search(_rel_type.val(),_rel_id,serverData);
   }

</script>
</body>
</html>