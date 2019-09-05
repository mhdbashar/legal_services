<?php

  if(empty($id)){
    $start_date = '';
    $end_date = '';
    $NO = '';
    $come_from = '';
    $client = '';
    $status = '';
    $type = '';
  }else{
    $start_date = $procuration->start_date;
    $end_date = $procuration->end_date;
    $NO = $procuration->NO;
    $come_from = $procuration->come_from;
    $client = $procuration->client;
    $status = $procuration->status;
    $type = $procuration->type;
  }

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
            <div class="row">
              <div class="col-md-6">
                <?php echo render_date_input('start_date','Start Date', $start_date, ['required' => 'required']); ?>
              </div>
              <div class="col-md-6">
                <?php echo render_date_input('end_date','End Date', $end_date, ['required' => 'required']); ?>
              </div>
            </div>
            <?php echo render_input('NO','Procuration Number', $NO, 'text', ['required' => 'required']); ?>
            <?php echo render_input('come_from','Come From', $come_from, 'text', ['required' => 'required']); ?>
            
            <div class="form-group select-placeholder">
                            <label for="clientid" class="control-label"><?php echo _l('project_customer'); ?></label>
                            <select id="clientid" required="required" name="client" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                               <?php $selected = ((isset($client)) ? $client : '');
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
                                <label for="status" class="col-form-label">Status</label>
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
                                <label for="type" class="col-form-label">Type</label>
                                <div class="row-fluid">
                                <select name="type" data-width="100%" id="type" class="selectpicker" data-show-subtext="true" data-live-search="true">
                                  <?php foreach ($types as $key => $value){ ?>

                                    <option <?php if($type == $value['id']) echo "selected" ?> value="<?php echo $value['id'] ?>"><?php echo $value['procurationtype'] ?></option>
                                    
                                  <?php } ?>
                                </select>
                                
                                </div>
                            </div>
                          </div>
                  <div style="padding-right: 15px; padding-left: 15px">
                    <div class="clearfix"></div>
                    <label class="col-form-label">
                      <?php echo _l('procuration_file') ?>
                    </label>
                  <?php if(isset($procuration) && $procuration->attachment !== ''){ ?>
                    <div class="row">
                     <div class="col-md-10">
                        <i class="<?php echo get_mime_class($procuration->filetype); ?>"></i> <a href="<?php echo site_url('download/file/procuration/'.$procuration->id); ?>"><?php echo $procuration->attachment; ?></a>
                     </div>
                     <?php if($procuration->attachment_added_from == get_staff_user_id() || is_admin()){ ?>
                     <div class="col-md-2 text-right">
                        <a href="<?php echo admin_url('procuration/delete_procuration_attachment/'.$procuration->id); ?>" class="text-danger _delete"><i class="fa fa fa-times"></i></a>
                     </div>
                     <?php } ?>
                  </div>
                  <?php } ?>
                  <?php if(!isset($procuration) || (isset($procuration) && $procuration->attachment == '')){ ?>
                  <div id="dropzoneDragArea" class="dz-default dz-message">
                     <span><?php echo _l('expense_add_edit_attach_receipt'); ?></span>
                  </div>
                  <div class="dropzone-previews"></div>
                  <?php } ?>
                  </div>
                            
                         </div>
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
      repeat_every_custom: { min: 1},
    },expenseSubmitHandler);

     $('input[name="billable"]').on('change',function(){
       do_billable_checkbox();
     });

      $('#repeat_every').on('change',function(){
         if($(this).selectpicker('val') != '' && $('input[name="billable"]').prop('checked') == true){
            $('.billable_recurring_options').removeClass('hide');
          } else {
            $('.billable_recurring_options').addClass('hide');
          }
     });

     // hide invoice recurring options on page load
     $('#repeat_every').trigger('change');

      $('select[name="clientid"]').on('change',function(){
       customer_init();
       do_billable_checkbox();
       $('input[name="billable"]').trigger('change');
     });

     <?php if(!isset($expense)) { ?>
        $('select[name="tax"], select[name="tax2"]').on('change', function () {

            delay(function(){
                var $amount = $('#amount'),
                taxDropdown1 = $('select[name="tax"]'),
                taxDropdown2 = $('select[name="tax2"]'),
                taxPercent1 = parseFloat(taxDropdown1.find('option[value="'+taxDropdown1.val()+'"]').attr('data-percent')),
                taxPercent2 = parseFloat(taxDropdown2.find('option[value="'+taxDropdown2.val()+'"]').attr('data-percent')),
                total = $amount.val();

                if(total == 0 || total == '') {
                    return;
                }

                if($amount.attr('data-original-amount')) {
                  total = $amount.attr('data-original-amount');
                }

                total = parseFloat(total);

                if(taxDropdown1.val() || taxDropdown2.val()) {

                    $('#tax_subtract').removeClass('hide');

                    var totalTaxPercentExclude = taxPercent1;
                    if(taxDropdown2.val()){
                      totalTaxPercentExclude += taxPercent2;
                    }

                    var totalExclude = accounting.toFixed(total - exclude_tax_from_amount(totalTaxPercentExclude, total), app.options.decimal_places);
                    $('#tax_subtract_total').html(accounting.toFixed(totalExclude, app.options.decimal_places));
                } else {
                   $('#tax_subtract').addClass('hide');
                }
                if($('#tax1_included').prop('checked') == true) {
                    subtract_tax_amount_from_expense_total();
                }
              }, 200);
        });

        $('#amount').on('blur', function(){
          $(this).removeAttr('data-original-amount');
          if($(this).val() == '' || $(this).val() == '') {
              $('#tax1_included').prop('checked', false);
              $('#tax_subtract').addClass('hide');
          } else {
            var tax1 = $('select[name="tax"]').val();
            var tax2 = $('select[name="tax2"]').val();
            if(tax1 || tax2) {
                setTimeout(function(){
                    $('select[name="tax2"]').trigger('change');
                }, 100);
            }
          }
        })

        $('#tax1_included').on('change', function() {

          var $amount = $('#amount'),
          total = parseFloat($amount.val());

          // da pokazuva total za 2 taxes  Subtract TAX total (136.36) from expense amount
          if(total == 0) {
              return;
          }

          if($(this).prop('checked') == false) {
              $amount.val($amount.attr('data-original-amount'));
              return;
          }

          subtract_tax_amount_from_expense_total();
        });
      <?php } ?>
    });

    function subtract_tax_amount_from_expense_total(){
         var $amount = $('#amount'),
         total = parseFloat($amount.val()),
         taxDropdown1 = $('select[name="tax"]'),
         taxDropdown2 = $('select[name="tax2"]'),
         taxRate1 = parseFloat(taxDropdown1.find('option[value="'+taxDropdown1.val()+'"]').attr('data-percent')),
         taxRate2 = parseFloat(taxDropdown2.find('option[value="'+taxDropdown2.val()+'"]').attr('data-percent'));

         var totalTaxPercentExclude = taxRate1;
         if(taxRate2) {
          totalTaxPercentExclude+= taxRate2;
        }

        if($amount.attr('data-original-amount')) {
          total = parseFloat($amount.attr('data-original-amount'));
        }

        $amount.val(exclude_tax_from_amount(totalTaxPercentExclude, total));

        if($amount.attr('data-original-amount') == undefined) {
          $amount.attr('data-original-amount', total);
        }
    }

     function expenseSubmitHandler(form){


      $.post(form.action, $(form).serialize()).done(function(response) {
        <?php if(empty($id)) $id = $last_id ?>;
        if (expenseDropzone.getQueuedFiles().length > 0) {
        expenseDropzone.options.url = admin_url + 'procuration/add_procuration_attachment/' + <?php echo $id ?>;
            expenseDropzone.processQueue();
        }else {
          window.location.assign(response.url);
        }
    });
      return false;
    }
    function do_billable_checkbox(){
      var val = $('select[name="clientid"]').val();
      if(val != ''){
        $('.billable').removeClass('hide');
        if ($('input[name="billable"]').prop('checked') == true) {
          if($('#repeat_every').selectpicker('val') != ''){
            $('.billable_recurring_options').removeClass('hide');
          } else {
            $('.billable_recurring_options').addClass('hide');
          }
          if(customer_currency != ''){
            selectCurrency.val(customer_currency);
            selectCurrency.selectpicker('refresh');
          } else {
            set_base_currency();
         }
       } else {
        $('.billable_recurring_options').addClass('hide');
        // When project is selected, the project currency will be used, either customer currency or base currency
        if($('#project_id').selectpicker('val') == ''){
            set_base_currency();
        }
      }
    } else {
      set_base_currency();
      $('.billable').addClass('hide');
      $('.billable_recurring_options').addClass('hide');
    }
   }
   function set_base_currency(){
    selectCurrency.val(selectCurrency.data('base'));
    selectCurrency.selectpicker('refresh');
   }
</script>
</body>
</html>
