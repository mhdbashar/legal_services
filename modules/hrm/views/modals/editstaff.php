<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Modal Contact -->
<div class="modal fade" id="basic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open("hrm/basic/edit/" . $info['staffid'], array('id' => 'basic-form', 'autocomplete' => 'off')); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo 'Edit Staff Account'; ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo form_hidden('employee_id', $info['staffid']); ?>
                        <?php $value = ( isset($info['firstname']) ? $info['firstname'] : ''); ?>
                        <?php echo render_input('firstname', 'First Name', $value); ?>
                    </div>
                    <div class="col-md-6">
                        <?php $value = ( isset($info['lastname']) ? $info['lastname'] : ''); ?>
                        <?php echo render_input('lastname', 'Last Name', $value); ?>
                    </div>
                    <div class="col-md-6">
                        <?php $value = ( isset($info['facebook']) ? $info['facebook'] : ''); ?>
                        <?php echo render_input('facebook', 'Facebook', $value); ?>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender"><?php echo _l('gender'); ?></label>
                            <select class="selectpicker" data-none-selected-text="<?php echo _l('system_default_string'); ?>" data-width="100%" name="gender" id="direction">
                                <option value="" <?php if (isset($info['gender']) && empty($info['gender'])) {
                            echo 'selected';
                        } ?>></option>
                                <option value="male" <?php if (isset($info['gender']) && $info['gender'] == 'male') {
                            echo 'selected';
                        } ?>>Male</option>
                                <option value="female" <?php if (isset($info['gender']) && $info['gender'] == 'female') {
                            echo 'selected';
                        } ?>>Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <?php $value = ( isset($info['job_title']) ? $info['job_title'] : ''); ?>
                        <?php echo render_input('job_title', 'Job Title', $value); ?>
                    </div>

                    <div class="col-md-6">
                        <?php $value = ( isset($info['email']) ? $info['email'] : ''); ?>
                        <?php echo render_input('email', 'Email', $value); ?>
                    </div>
                    <div class="col-md-6">
                        <?php $value = ( isset($info['phonenumber']) ? $info['phonenumber'] : ''); ?>
                        <?php echo render_input('phonenumber', 'Phone Number', $value); ?>
                    </div>

                    <div class="col-md-6">
                        <?php $value = ( isset($info['skype']) ? $info['skype'] : ''); ?>
                        <?php echo render_input('skype', 'Skype', $value); ?>
                    </div>
                    <div class="col-md-6">
                        <?php $value = ( isset($info['hourly_rate']) ? $info['hourly_rate'] : ''); ?>
                        <?php echo render_input('hourly_rate', 'Hourly Rate', $value); ?>
                    </div>
                    <div class="col-md-6">
                        <?php $value = ( isset($info['main_salary']) ? $info['main_salary'] : ''); ?>
                        <?php echo render_input('main_salary', 'Main Salary', $value); ?>
                    </div>
                    <div class="col-md-6">
                        <?php $value = ( isset($info['transportation_expenses']) ? $info['transportation_expenses'] : ''); ?>
                        <?php echo render_input('transportation_expenses', 'Transportation Expenses', $value); ?>
                    </div>
                    <div class="col-md-6">
                        <?php $value = ( isset($info['other_expenses']) ? $info['other_expenses'] : ''); ?>
                        <?php echo render_input('other_expenses', 'Other Expenses', $value); ?>
                    </div>
                    <div class="col-md-6">
                        <?php $value = ( isset($info['created']) ? $info['created'] : ''); ?>
                        <div class="form-group" app-field-wrapper="date">
                              <label for="date" class="control-label">Create at</label>
                              <div class="input-group date">
                                <input type="text" id="created" name="created" class="form-control datepicker" value="<?php echo $value ?>" autocomplete="off" aria-invalid="false">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar calendar-icon"></i>
                                </div>
                              </div>
                            </div>
                    </div>
                    
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info" data-loading-text="<?php echo _l('wait_text'); ?>" autocomplete="off" data-form="#basic-form"><?php echo _l('submit'); ?></button>
            </div>
<?php echo form_close(); ?>
        </div>
    </div>
</div>
