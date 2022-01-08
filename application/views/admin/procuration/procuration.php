<?php


$attr = [];
if ( get_option('wathq_api_key') )
    $attr['readonly'] = 'readonly';

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
    $name = '';
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
    $name = $procuration->name;
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
            <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'','class'=>'')) ;?>

            <!-- enable language edit -->
              <div class="NO">
                  <?php echo render_input('NO', _l('procuration_number'), $NO != 0 ? $NO : '', 'text'); ?>
                  <?php echo render_input('principalId', _l('principalId'), $principalId != 0 ? $principalId : '', 'text'); ?>
                  <?php echo render_input('agentId', _l('agentId'), $agentId != 0 ? $agentId : '', 'text'); ?>


              </div>
            <div id="loading" class="hide" >
              <p class="text-center">
                <?php echo _l('loading') ?> ...
              </p>
            </div>
            <div class="row">
              <div class="col-md-6" id="start-date">
                <?php echo render_date_input('start_date', _l('start_date'), _d($start_date), $attr); ?>
              </div>
              <div class="col-md-6" id="end-date">
                <?php
                echo render_date_input('end_date', _l('end_date'), _d($end_date), $attr); ?>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6" id="name">
                <?php echo render_input('name', _l('come_from'), ($name), 'text', $attr); ?>
              </div>
                <?php if(get_option('wathq_api_key')){ ?>
              <div class="col-md-6">


                <?php

                  $status_name = '';
                  if($status == 1){
                    $status_name = _l('active');
                  }
                  elseif($status === ''){
                    $status_name = '';
                  }else{
                    $status_name = _l('inactive');
                  }
                ?>

                <?php echo render_input('status_name', _l('status'), ($status_name), 'text', $attr); ?>
              </div>
              <?php echo form_hidden('status', $status); ?>
                <?php } ?>
            </div>
            <?php echo render_textarea('description', 'gdpr_description', $description, $attr) ?>
            <?php echo render_input('come_from', _l('name'), $come_from, 'text', []); ?>

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
                            <select <?php echo $disabled ?> id="clientid" name="client" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
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
                             <?php if(!get_option('wathq_api_key')){ ?>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label"><?php echo _l('status') ?>:</label>
                                        <div class="row-fluid">
                                        <select name="status" data-width="100%" id="status" class="selectpicker" data-show-subtext="true" data-live-search="true">
                                            <option value=""><?php echo _l('not_selected') ?></option>
                                            <?php foreach ($states as $key => $value){ ?>

                                            <option <?php if($status == $value['id']) echo "selected" ?> value="<?php echo $value['id'] ?>"><?php echo $value['procurationstate'] ?></option>

                                          <?php } ?>
                                        </select>

                                        </div>
                                      </div>
                                  </div>
                             <?php } ?>

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
                                $cases = [];
                                // echo render_select('cases[]',$cases,array('id',array('name')),'cases',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
                               
                            ?>
                            <div class="form-group">
                                <label class="control-label" for="cases[]"><?php echo _l('cases'); ?></label>
                                <?php $data = get_relation_data('client_cases',$client); ?>
                                <select data-live-search="true" multiple="true" id="city" name="cases[]" class="form-control custom_select_arrow">

                                </select>
                            </div>
              <?php if(!get_option('wathq_api_key')){ ?>
              <div class="form-group">
                  <label class="control-label" for="file"><?php echo _l('file'); ?></label>
                  <input class="form-control" type="file" id="file" name="file" />
              </div>
              <?php } ?>
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
  var clientid = '<?php echo $client ?>';
  var selected_cases = [];
  <?php foreach ($selected_cases as $case) { ?>
    selected_cases.push('<?php echo $case["id"] ?>');
  <?php } ?>
$(document).on('change','#clientid',function () {
    $.get(admin_url +'procuration/build_dropdown_cases/' + $(this).val(), function(response) {
        if (response.success == true) {
          console.log(response)
            $('#city').empty();
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#city').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#city').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});
  $(function() {
    $.get(admin_url +'procuration/build_dropdown_cases/' + clientid, function(response) {
        if (response.success == true) {
            $('#city').empty();
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                let selected = false;
                if(selected_cases.includes(key))
                  selected = true;
                $('#city').append($('<option>', {
                    value: key,
                    text: value,
                    selected
                }));
                $('#city').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
    // $("#clientid").change(function () {
    //     $.ajax({
    //         url: "<?php //echo admin_url('procuration/build_dropdown_cases'); ?>",
    //         data: {select: $(this).val()},
    //         type: "POST",
    //         success: function (response) {
    //          // console.log(response.length );
    //             for(let i = 0; i < response.length; i++) {
    //                 let key = response[i].key;
    //                 let value = response[i].value;
    //                 let select = false;
    //                 // if(response.clientid == key)
    //                 //     select = true;
    //                 $('#city').append($('<option>', {
    //                     value: key,
    //                     text: value,
    //                     selected: select
    //                 }));
    //                 $('#city').selectpicker('refresh');
    //             }
    //         }
    //     });
    // });
<?php if(get_option('wathq_api_key')){ ?>
    $('body').on('change','.NO', async function(){
      var procuration_number = $('input[name=NO]').val();
      var principalId = $('input[name=principalId]').val();
      var agentId = $('input[name=agentId]').val();
      var active = '<?php echo _l('active') ?>';
      var inactive = '<?php echo _l('inactive') ?>';
      if(procuration_number != '' && (principalId != '' || agentId != ''))
      {
          $('#loading').removeClass('hide');
          $('#loading').removeClass('text-danger');
          $('#loading').addClass('text-center');
          $('#loading').html("<?php echo _l('loading') ?> ...")
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
                      $('input[name=start_date]').val(data.issueHijriDate);
                      $('input[name=end_date]').val(data.expiryHijriDate);
                      $('textarea[name=description]').val(data.text);
                      $('input[name=name]').val(data.location.name);

                      let status = '';
                      let status_name = '';
                      if(data.status === 'active'){
                        status = 1;
                        status_name = active;
                      }else{
                        status = 0;
                        status_name = inactive;
                      }
                      $('input[name=status_name]').val(status_name);
                      $('input[name=status]').val(status);
                      $('#loading').addClass('hide');
                  }else{
                      console.log(data)
                      $('input[name=start_date]').val('');//.val(moment(data.issueHijriDate, 'iYYYY/iM/iD').endOf('Month').format('YYYY-MM-DD'));
                      $('input[name=end_date]').val('');//.val(moment(data.expiryHijriDate, 'iYYYY/iM/iD').endOf('Month').format('YYYY-MM-DD'));
                      $('input[name=name]').val('');
                      $('textarea[name=description]').val('');
                      $('#loading').addClass('text-danger text-center');
                      $('#loading').html(data.message);
                  }


              })
              .catch(function(error) {
                  console.log(error);
                  $('input[name=start_date]').val('');
                  $('input[name=end_date]').val('');
                  $('textarea[name=description]').val('');
                  $('input[name=name]').val('');
                  $('#loading').addClass('text-danger text-center');
                  $('#loading').html('something went wrong!');
              });

          
      }

    });
      <?php } ?>
  })

</script>