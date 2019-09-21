<?php
init_head();
$staff = $this->Train->getStaff();
?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                

                    <h2>Edit Training</h2>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>

                <?php echo form_open_multipart(base_url() . 'hrm/Training/addnew',array('id'=>'form_transout')) ;?>
                      <div class="col-md-6">

                          <div class="form-group">
                            <label for="staff_id" class="col-form-label">Staff</label>
                            <div class="row-fluid">
                            <select name="staff_id" id="staff_id" class="selectpicker" data-show-subtext="true" data-live-search="true">
                              <?php foreach ($staff as $key => $value){ ?>

                                <option value="<?php echo $value['staffid'] ?>" <?php echo($staff_id==$value['staffid']?'selected':'') ?>><?php echo $value['firstname'] ?></option>
                                
                              <?php } ?>
                            </select>
                            
                          </div>
                          </div>

                          <div class="form-group">
                            <label for="training" class="col-form-label">Course / Training</label>
                            <input type="text" step="any" class="form-control" id="training" name="training" value="<?php echo $training ?>">
                          </div>

                          <div class="form-group">
                            <label for="vendor" class="col-form-label">Vendor</label>
                            <input type="text" step="any" class="form-control" id="vendor" name="vendor" value="<?php echo $vendor ?>">
                          </div>

                          <div class="form-group" app-field-wrapper="date">
                            <label for="start_date" class="control-label">Start Date</label>
                            <div class="input-group date">
                              <input type="text" id="start_date" name="start_date" class="form-control datepicker" autocomplete="off" value="<?php echo $start_date ?>">
                              <div class="input-group-addon"> <i class="fa fa-calendar calendar-icon"></i></div>
                            </div>
                          </div>

                          <div class="form-group" app-field-wrapper="date">
                            <label for="end_date" class="control-label">Start Date</label>
                            <div class="input-group date">
                              <input type="text" id="end_date" name="end_date" class="form-control datepicker" autocomplete="off" value="<?php echo $end_date ?>">
                              <div class="input-group-addon"> <i class="fa fa-calendar calendar-icon"></i></div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="cost" class="col-form-label">Training Cost</label>
                            <input type="number" step="any" class="form-control" id="cost" name="cost" value="<?php echo $cost ?>">
                          </div>

                          
                    </div>
                    <div class="col-md-6">
                          <div class="form-group">
                            <label for="status" class="col-form-label">Status</label>
                            <div class="row-fluid">
                            <select name="status" id="status" class="selectpicker" >  
                              <?php foreach ($statuses as $key => $value){ ?>

                                <option value="<?php echo $key ?>" <?php echo($status==$key?'selected':'') ?>><?php echo $value ?></option>
                                
                              <?php } ?>
                            </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="performance" class="col-form-label">Performance</label>
                            <div class="row-fluid">
                            <select name="performance" id="performance" class="selectpicker" >  
                              <?php foreach ($performances as $key => $value){ ?>

                                <option value="<?php echo $key ?>" <?php echo($performance==$key?'selected':'') ?>><?php echo $value ?></option>
                                
                              <?php } ?>
                            </select>
                            </div>
                          </div>

                          <div class="form-group" app-field-wrapper="remarks">
                            <label for="remarks" class="col-form-label">Remarks</label>
                            <textarea id="remarks" name="remarks" class="form-control tinymce" rows="4"><?php echo $remarks ?></textarea>
                          </div>


                        <div class="panel-footer attachments_area" style="background-color:unset;">
                            <div class="row attachments">
                                <label for="attachment" class="control-label"><?php echo _l('ticket_add_attachments'); ?></label>
                                <div class="attachment">
                                    <div class="form-group">
                                        
                                        <div class="input-group">
                                            <input type="file" extension="<?php echo str_replace('.','',get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachments[0]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success add_more_attachments p8-half" data-max="10" type="button"><i class="fa fa-plus"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                          

                    </div>


                    <div class="clearfix"></div>
                    
                    <input aria-hidden="true" type="hidden" class="form-control" id="id" name="id" value="<?php echo $id ?>">


        <?php if(isset($attachments) && count($attachments) > 0){
            echo '<hr />';
            foreach($attachments as $attachment){

              echo '<div class="col-md-3">';

              $path = TRAINING_ATTACHMENTS_FOLDER.$id.'/'.$attachment['file_name'];
              $is_image = is_image($path);

              if($is_image){
                echo '<div class="preview_image col-md-3">';
              }
              ?>
              <a href="<?php echo site_url(protected_file_url_by_path($path)); ?>" class="display-block mbot5"<?php if($is_image){ ?> data-lightbox="attachment-reply-<?php echo $attachment['id']; ?>" <?php } ?>>
              <i class="<?php echo get_mime_class($attachment['filetype']); ?>"></i> <?php echo $attachment['file_name']; ?>
              <?php if($is_image){ ?>
               <img class="mtop5" src="<?php echo site_url('download/preview_image?path='.protected_file_url_by_path($path).'&type='.$attachment['filetype']); ?>">
              <?php } ?>
              </a>
             <?php if($is_image){
                echo '</div>';
              }
              if(is_admin() || (!is_admin() && get_option('allow_non_admin_staff_to_delete_ticket_attachments') == '1')){
                echo '<a href="'.admin_url('hrm/training/delete_attachment/'.$attachment['id']).'" class="text-danger _delete">'._l('delete').'</a>';
              }

              echo '</div>';
            }
        }
        ?>


                    <div class="clearfix"></div>
                    <div class="modal-footer">
                      <a type="button" class="btn btn-secondary" href="<?php echo base_url() . 'hrm/Training' ?>">Back</a>
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>

        <?php echo form_close(); ?>

                </div>
            </div>

        </div>
    </div>
</div>


<?php init_tail() ?>