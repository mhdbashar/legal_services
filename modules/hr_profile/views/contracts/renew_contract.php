<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="renew_contract_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <?php echo form_open_multipart(admin_url('hr_profile/add_renew'),array('id'=>'renew-contract-form')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo _l('contract_renew_heading');?>
                </h4>
            </div>
            <div class="modal-body">
                <?php
                $new_end_date_assume = '';
//                if(!empty($contract->dateend)){
//                    $dStart                      = new DateTime($contract->datestart);
//                    $dEnd                        = new DateTime($contract->dateend);
//                    $dDiff                       = $dStart->diff($dEnd);
//                    $new_end_date_assume = date('Y-m-d', strtotime(date('Y-m-d', strtotime('+' . $dDiff->days . 'DAY'))));
//                }
                ?>
                <?php echo render_date_input('new_start_date','contract_start_date',_d(date('Y-m-d'))); ?>
                <?php echo render_date_input('new_end_date','contract_end_date'); ?>
<!--                --><?php //echo render_input('new_value','contract_value',isset($contract->contract_value)?$contract->contract_value:'','number'); ?>
<!--                --><?php //if($contract->signed == 1) { ?>
<!--                <div class="checkbox">-->
<!--                  <input type="checkbox" name="renew_keep_signature" id="renew_keep_signature">-->
<!--                  <label for="renew_keep_signature">--><?php //echo _l('keep_signature'); ?><!--</label>-->
<!--              </div>-->
<!--              --><?php //} ?>
              <?php echo form_hidden('contract_id',$contract->id_contract); ?>
<!--              --><?php //echo form_hidden('old_start_date',$contract->datestart); ?>
<!--              --><?php //echo form_hidden('old_end_date',$contract->dateend); ?>
<!--              --><?php //echo form_hidden('old_value',$contract->contract_value); ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
              <button   onclick="add_renew()" type="button" class="btn btn-info mtop15 mbot15">حفظ</button>        </div>
        </div>ظ
    <?php echo form_close(); ?>
</div>
</div>
<script>
    init_datepicker();
</script>
