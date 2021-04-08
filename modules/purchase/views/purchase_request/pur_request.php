<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>

<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel_s">
               <div class="panel-body">
                  <h4 class="customer-profile-group-heading"><?php echo _l($title). ' '._l('purchase_request') ; ?></h4>
                  <?php if(isset($pur_request)){
                           echo form_open(admin_url('purchase/pur_request/'.$pur_request->id),array('id'=>'add_edit_pur_request-form'));
                        }else{
                           echo form_open(admin_url('purchase/pur_request'),array('id'=>'add_edit_pur_request-form'));
                        }?>
                <div class="row">
                  <div class="col-md-12">
                    <p class="bold p_style" ><?php echo _l('information'); ?></p>
                    <hr class="hr_style"  />
                  </div>

                  <div class=" col-md-12">
                  <div class="panel panel-success">
                    <div class="panel-heading"><?php echo _l('purchase_request_header'); ?></div>
                    <div class="panel-body">
                      <div class="col-md-4">
                       <?php
                          $prefix = get_purchase_option('pur_request_prefix');
                          $next_number = get_purchase_option('next_pr_number');
                          $number = (isset($pur_request) ? $pur_request->number : $next_number);
                          echo form_hidden('number',$number); ?> 
                           
                      <?php $pur_rq_code = ( isset($pur_request) ? $pur_request->pur_rq_code : $prefix.'-'.str_pad($next_number,5,'0',STR_PAD_LEFT).'-'.date('Y'));
                      echo render_input('pur_rq_code','pur_rq_code',$pur_rq_code ,'text',array('readonly' => '')); ?>
                    </div>
                    <div class="col-md-8">
                      <?php $pur_rq_name = ( isset($pur_request) ? $pur_request->pur_rq_name : '');
                      echo render_input('pur_rq_name','pur_rq_name', $pur_rq_name); ?>
                    </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rel_type" class="control-label"><?php echo _l('task_related_to'); ?></label>
                                <select name="rel_type" class="selectpicker" id="rel_type" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($legal_services as $service): ?>
                                        <option value="<?php echo true ? $service->slug : 'project'; ?>"
                                            <?php if(isset($pur_request) || $this->input->get('rel_type')){
                                                if(true){
                                                    if($pur_request->rel_type == $service->slug){
                                                        echo 'selected';
                                                    }
                                                }else{
                                                    if($rel_type == 'project'){
                                                        echo 'selected';
                                                    }
                                                }
                                            } ?>><?php echo $service->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <?php $rel_id = isset($pur_request)? $pur_request->rel_id : '' ?>
                            <div class="form-group<?php if($rel_id == ''){echo ' hide';} ?>" id="rel_id_wrapper">
                                <label for="rel_id" class="control-label"><span class="rel_id_label"></span></label>
                                <div id="rel_id_select">
                                    <select name="rel_id" id="rel_id" class="ajax-sesarch" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php if(true){ //if($rel_id != '' && $rel_type != ''){
                                            $rel_data = get_relation_data($pur_request->rel_type,$pur_request->rel_id);
                                            $rel_val = get_relation_values($rel_data,$pur_request->rel_type);
                                            if(!$rel_data){
                                                echo '<option value="'.$pur_request->rel_id.'" selected>'.$pur_request->rel_id.'</option>';
                                            }else{
                                                echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    <div class="col-md-6 form-group">
                      <label for="type"><?php echo _l('type'); ?></label>
                        <select name="type" id="type" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                          <option value=""></option>
                          <option value="capex" <?php if(isset($pur_request) && $pur_request->type == 'capex'){ echo 'selected';} ?>><?php echo _l('capex'); ?></option>
                          <option value="opex" <?php if(isset($pur_request) && $pur_request->type == 'opex'){ echo 'selected';} ?>><?php echo _l('opex'); ?></option>
                        </select>
                        <br><br>
                    </div>

                    <div class="col-md-6 form-group">
                      <label for="department"><?php echo _l('department'); ?></label>
                        <select name="department" id="department" class="selectpicker" onchange="department_change(this); return false;" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                          <option value=""></option>
                          <?php foreach($departments as $s) { ?>
                            <option value="<?php echo html_entity_decode($s['departmentid']); ?>" <?php if(isset($pur_request) && $s['departmentid'] == $pur_request->department){ echo 'selected'; } ?>><?php echo html_entity_decode($s['name']); ?></option>
                            <?php } ?>
                        </select>
                        <br><br>
                    </div>

                    <div class="col-md-4 form-group">
                      <label for="requester"><?php echo _l('requester'); ?></label>
                        <select name="requester" id="requester" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                          <option value=""></option>
                          <?php foreach($staffs as $s) { ?>
                            <option value="<?php echo html_entity_decode($s['staffid']); ?>" <?php if(isset($pur_request) && $s['staffid'] == $pur_request->requester){ echo 'selected'; }elseif($s['staffid'] == get_staff_user_id()){ echo 'selected'; } ?>><?php echo html_entity_decode($s['lastname'] . ' '. $s['firstname']); ?></option>
                            <?php } ?>
                        </select>
                        <br><br>
                    </div>

                    <div class="col-md-2">
                      <div class="checkbox checkbox-primary pull-right mtop25">
                        <input onchange="from_list_items(this); return false" type="checkbox" id="from_items" name="from_items" value="1" <?php if(isset($pur_request)){ echo 'disabled';} ?> <?php if(isset($pur_request) && $pur_request->from_items == 0){ echo ''; }else{ echo 'checked'; } ?>>
                        <label for="from_items"><?php echo _l('from_list_items'); ?>
                      
                        </label>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <?php $rq_description = ( isset($pur_request) ? $pur_request->rq_description : '');
                      echo render_textarea('rq_description','rq_description',$rq_description); ?>
                    </div>

                    </div>
                  </div>
                  </div>

                  
                  
                  <div class="col-md-12">
                    <p class="bold p_style"><?php echo _l('pur_detail'); ?></p>
                    <hr class="hr_style"  />
                    <div class="col-md-12 " id="example">
                      <hr>
                    </div>

                  </div>
                  </div>
                  <?php echo form_hidden('request_detail'); ?>
                    <div class="clearfix"></div>
                    <button id="sm_btn" class="btn btn-info save_detail pull-right"><?php echo _l('submit'); ?></button>
                  <?php echo form_close(); ?>
               </div>
            </div>
            
         </div>
        
      </div>
   </div>
</div>

<?php init_tail(); ?>
<script>
    var _rel_id = $('#rel_id'),
        _rel_type = $('#rel_type'),
        _rel_id_wrapper = $('#rel_id_wrapper'),
        data = {};

    $(function (){
        $('.rel_id_label').html(_rel_type.find('option:selected').text());

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
            init_project_details(_rel_type.val());
        });


        $('#time').datetimepicker({
            datepicker:false,
            format:'H:i'
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
<?php require 'modules/purchase/assets/js/pur_request_js.php';?>
