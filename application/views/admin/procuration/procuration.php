<?php
  if(!is_numeric($id)){
    $id = null;
    $procuration = null;
    $start_date = '';
    $end_date = '';
    $NO = '';
    $come_from = '';
    $client = '';
    $status = '';
    $selected_cases = [];
    if(is_numeric($case_r)){
      $code = $this->case->get($case_r)->code;
      $selected_cases[] = ['id' => $case_r, 'code' => $code];
    }
    $type = '';
    $case = '';
    $principalId = '';
    $agentId = '';
    $description = '';
  }else{
    $selected_cases = $procuration->cases;
    $start_date = $procuration->start_date;
    $end_date = $procuration->end_date;
    $NO = $procuration->NO;
    $come_from = $procuration->come_from;
    $client = $procuration->client;
    $status = $procuration->status;
    $type = $procuration->type;
    $case = $procuration->case_id;
    $description = $procuration->description;
    $principalId = $procuration->principalId;
    $agentId = $procuration->agentId;
  }
// add_option('wathq_api_key', 'eaQFFTW5oOLH5a908nkCcK78Z1PQ1FAx');
?>

<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel_s">
          <div class="panel-body">
          <h4 class="no-margin">
          <?php echo $title; ?>
          </h4>
          <hr class="hr-panel-heading" />
            <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'expense-form','class'=>'dropzone dropzone-manual')) ;?>

            <!-- enable language edit -->
              <div class="NO">
                  <?php echo render_input('NO', _l('procuration_number'), $NO, 'text', ['required' => 'required']); ?>
                  <?php echo render_input('principalId', _l('principalId'), $principalId, 'text'); ?>
                  <?php echo render_input('agentId', _l('agentId'), $agentId, 'text'); ?>


              </div>
            <div id="loading" class="hide">
              <p class="text-center">
                <?php echo _l('loading') ?> ...
              </p>
            </div>
            <div class="row">
              <div class="col-md-6" id="start-date">
                <?php echo render_input('start_date', _l('start_date'), _d($start_date), 'text', [
                  'required' => 'required',
                  'readonly' => 'true'
                ]); ?>
              </div>
              <div class="col-md-6" id="end-date">
                <?php echo render_input('end_date', _l('end_date'), _d($end_date), 'text', [
                  'required' => 'required',
                  'readonly' => 'true'
                ]); ?>
              </div>
            </div>
            <?php echo render_textarea('description', 'gdpr_description', $description, [
              'required' => 'required',
              'readonly' => 'true'
            ]) ?>
            <?php echo render_input('come_from', _l('come_from'), $come_from, 'text', ['required' => 'required']); ?>

            <div class="form-group select-placeholder">
                            <label for="clientid" class="control-label"><?php echo _l('project_customer'); ?></label>
                            <?php
                            if(is_numeric($request)) {
                              $disabled =  'disabled';
                              echo form_hidden('client', $request);
                            }
                            else {
                              $request = '';
                              $disabled = '';
                            }
                            ?>
                            <select <?php echo $disabled ?> id="clientid" required="required" name="client" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                               <?php $selected = ((!empty($client)) ? $client : $request);
                               if($selected == ''){
                                   $selected = (isset($customer_id) ? $customer_id: '');
                               }
                               if($selected != ''){
                                  $rel_data = get_relation_data('customer',$selected);
                                  $rel_val = get_relation_values($rel_data,'customer');
                                  echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                              } ?>
                          </select>
                      </div>

                         <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="col-form-label"><?php echo _l('status') ?>:</label>
                                <div class="row-fluid">
                                <select name="status" data-width="100%" id="status" class="selectpicker" data-show-subtext="true" data-live-search="true">
                                  <?php foreach ($states as $key => $value){ ?>

                                    <option <?php if($status == $value['id']) echo "selected" ?> value="<?php echo $value['id'] ?>"><?php echo $value['procurationstate'] ?></option>

                                  <?php } ?>
                                </select>

                                </div>
                              </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="type" class="col-form-label"><?php echo _l('procurationtype') ?>:</label>
                                <div class="row-fluid">
                                <select name="type" data-width="100%" id="type" class="selectpicker" data-show-subtext="true" data-live-search="true">
                                  <option value=""><?php echo _l('not_selected') ?></option>
                                  <?php foreach ($types as $key => $value){ ?>

                                    <option <?php if($type == $value['id']) echo "selected" ?> value="<?php echo $value['id'] ?>"><?php echo $value['procurationtype'] ?></option>

                                  <?php } ?>
                                </select>

                                </div>
                            </div>
                          </div>
                        </div>
                            <?php
                                $selected = array();
                                if($selected_cases != ''){
                                    foreach($selected_cases as $row){
                                        array_push($selected,$row['id']);
                                    }
                                }
                                echo render_select('cases[]',$cases,array('id',array('name')),'cases',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
                            ?>
<!--                  <div>-->
<!--                    <div class="clearfix"></div>-->
<!--                    <label class="col-form-label">-->
<!--                      --><?php //echo _l('procuration_file') ?>
<!--                    </label>-->
<!--                  --><?php //if(isset($procuration) && $procuration->attachment !== ''){ ?>
<!--                    <div class="row">-->
<!--                     <div class="col-md-10">-->
<!--                        <i class="--><?php //echo get_mime_class($procuration->filetype); ?><!--"></i> <a href="--><?php //echo site_url('uploads/procurations/'.$procuration->id.'/'.$procuration->attachment); ?><!--">--><?php //echo $procuration->attachment; ?><!--</a>-->
<!--                     </div>-->
<!--                     --><?php //if($procuration->attachment_added_from == get_staff_user_id() || is_admin()){ ?>
<!--                     <div class="col-md-2 text-right">-->
<!--                        <a href="--><?php //echo admin_url('procuration/delete_procuration_attachment/'.$procuration->id); ?><!--" class="text-danger _delete"><i class="fa fa fa-times"></i></a>-->
<!--                     </div>-->
<!--                     --><?php //} ?>
<!--                  </div>-->
<!--                  --><?php //} ?>
<!--                  --><?php //if(!isset($procuration) || (isset($procuration) && $procuration->attachment == '')){ ?>
<!--                  <div id="dropzoneDragArea" class="dz-default dz-message">-->
<!--                     <span>--><?php //echo _l('expense_add_edit_attach_receipt'); ?><!--</span>-->
<!--                  </div>-->
<!--                  <div class="dropzone-previews"></div>-->
<!--                  --><?php //} ?>
<!--                  </div>-->


                  <hr class="hr-panel-heading" />


                        <!-- for testing -->

            <!-- <p class="bold"><?php echo _l('procuration_message'); ?></p> -->
            <!-- <?php $contents = ''; if(isset($procuration)){$contents = $procuration->message;} ?> -->
            <!-- <?php echo render_textarea('message','',$contents,array(),array(),'','tinymce'); ?> -->


            <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>
<script>
  $(function(){
    _validate_form($('form'),{procuration:'required'});
  });

</script>
<script>
  $(function() {
    $('body').on('change','.NO', async function(){
      var procuration_number = $('input[name=NO]').val();
      var principalId = $('input[name=principalId]').val();
      var agentId = $('input[name=agentId]').val();
      if(procuration_number != '' && (principalId != '' || agentId != ''))
      {
          $('#loading').removeClass('hide');
          let url = `https://api.wathq.sa/v1/attorney/info/${procuration_number}?principalId=${principalId}&agentId=${agentId}`;
          await fetch(url, {
              method: 'GET', // or 'PUT'
              headers: {
                  'Accept': 'application/json',
                  'apiKey': "<?php echo get_option("wathq_api_key") ?>"
              }
          })
              .then(response => response.json())
              .then(data => {
                  if(data.text)
                  {
                      $('input[name=start_date]').val(data.issueHijriDate);//.val(moment(data.issueHijriDate, 'iYYYY/iM/iD').endOf('Month').format('YYYY-MM-DD'));
                      $('input[name=end_date]').val(data.expiryHijriDate);//.val(moment(data.expiryHijriDate, 'iYYYY/iM/iD').endOf('Month').format('YYYY-MM-DD'));
                      $('textarea[name=description]').val(data.text);
                  }else{
                      $('input[name=start_date]').val('');//.val(moment(data.issueHijriDate, 'iYYYY/iM/iD').endOf('Month').format('YYYY-MM-DD'));
                      $('input[name=end_date]').val('');//.val(moment(data.expiryHijriDate, 'iYYYY/iM/iD').endOf('Month').format('YYYY-MM-DD'));
                      $('textarea[name=description]').val('');
                  }


              })
              .catch(function(error) {
                  console.log(error);
                  $('input[name=start_date]').val('');//.val(moment(data.issueHijriDate, 'iYYYY/iM/iD').endOf('Month').format('YYYY-MM-DD'));
                  $('input[name=end_date]').val('');//.val(moment(data.expiryHijriDate, 'iYYYY/iM/iD').endOf('Month').format('YYYY-MM-DD'));
                  $('textarea[name=description]').val('');
              });

          $('#loading').addClass('hide');
      }

    });
  })
</script>
<script>
   var customer_currency = '';
   Dropzone.options.expenseForm = false;
   var expenseDropzone;
   init_ajax_project_search_by_customer_id();
   var selectCurrency = $('select[name="currency"]');
   <?php if(isset($customer_currency)){ ?>
     var customer_currency = '<?php echo $customer_currency; ?>';
   <?php } ?>
     $(function(){
        $('body').on('change','#project_id', function(){
          var project_id = $(this).val();
          if(project_id != '') {
           if (customer_currency != 0) {
             selectCurrency.val(customer_currency);
             selectCurrency.selectpicker('refresh');
           } else {
             set_base_currency();
           }
         } else {
          do_billable_checkbox();
        }
      });

     if($('#dropzoneDragArea').length > 0){
        expenseDropzone = new Dropzone("#expense-form", appCreateDropzoneOptions({
          autoProcessQueue: false,
          clickable: '#dropzoneDragArea',
          previewsContainer: '.dropzone-previews',
          addRemoveLinks: true,
          maxFiles: 1,
          success:function(file,response){
           response = JSON.parse(response);
           if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
             window.location.assign(response.url);
           }
         },
       }));
     }

     appValidateForm($('#expense-form'),{
      end_date:'required',
      start_date:'required',
      client: 'required',
    },expenseSubmitHandler);


     function expenseSubmitHandler(form){


        $.post(form.action, $(form).serialize()).done(function(response) {
          <?php
          $redirect = admin_url('procuration/all');
          if(is_numeric($request)){
              // URL Example : http://localhost/legal/admin/clients/client/3?group=procurations
              $redirect = admin_url('clients/client/' . $request) . '?group=procurations';
          }
          if(is_numeric($case_r)){
              // URL Example : http://localhost/legal/admin/Case/view/1/4?group=procuration
              $redirect = admin_url('Case/view/1/' . $case_r) . '?group=procuration';
          }
          ?>
          var response = '<?php echo $redirect ?>'
          if(typeof(expenseDropzone) !== 'undefined'){
            <?php if(empty($id)) $id = $last_id ?>;
            if (expenseDropzone.getQueuedFiles().length > 0) {
              expenseDropzone.options.url = admin_url + 'procuration/add_procuration_attachment/' + <?php echo $id ?>;
              expenseDropzone.processQueue();
            }else {
              window.location.assign(response);
            }
          } else {
            window.location.assign(response);
          }
      });
      return false;
    }
  })

</script>
</body>
</html>
