<?php echo form_open(admin_url('hr/general/change_password'),array('id'=>'form_transout')); ?>
<?php echo form_hidden('staffid', $staff_id); ?>
<div class="row">
   <div class="col-md-12">
      <?php if(!isset($member) || is_admin() || !is_admin() && $member->admin == 0) { ?>
         <!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
         <input  type="text" class="fake-autofill-field" name="fakeusernameremembered" value='' tabindex="-1"/>
         <input  type="password" class="fake-autofill-field" name="fakepasswordremembered" value='' tabindex="-1"/>
         <div class="clearfix form-group"></div>
         <label for="password" class="control-label"><?php echo _l('staff_add_edit_password'); ?></label>
         <div class="input-group">
            <input type="password" class="form-control password" name="password" autocomplete="off">
            <span class="input-group-addon">
            <a href="#password" class="show_password" onclick="showPassword('password'); return false;"><i class="fa fa-eye"></i></a>
            </span>
            <span class="input-group-addon">
            <a href="#" class="generate_password" onclick="generatePassword(this);return false;"><i class="fa fa-refresh"></i></a>
            </span>
         </div>
         <?php if(isset($member)){ ?>
         <p class="text-muted"><?php echo _l('staff_add_edit_password_note'); ?></p>
         <?php if($member->last_password_change != NULL){ ?>
         <?php echo _l('staff_add_edit_password_last_changed'); ?>:
         <span class="text-has-action" data-toggle="tooltip" data-title="<?php echo _dt($member->last_password_change); ?>">
            <?php echo time_ago($member->last_password_change); ?>
         </span>
         <?php } } ?>
      <?php } ?>
   </div>
</div>
<button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
<?php echo form_close(); ?>