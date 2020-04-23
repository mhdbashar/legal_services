<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="attendance_date" tabindex="-1" role="dialog" aria-labelledby="attendance_date" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("attendance_date"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('hr/timesheet/date_wise_attendance'),array('id'=>'form_transout', 'method' => 'get')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="staff_id" class="control-label"><?php echo _l('staff') ?></label>
                            <select required="required" class="form-control" id="staff_id" name="staff_id" placeholder="<?php echo _l('staff') ?>" aria-invalid="false">
                                <option></option>
                                <?php  
                                    foreach ($staff_members as $staff){
                                        echo "<option value=".$staff['staffid'].'">'.$staff['firstname'].'</option>';
                                    }
                                ?>
                            </select>     
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('start_date','start_date', date("Y-m-d"), ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_date_input('end_date','end_date', date("Y-m-d"), ['required' => 'required']); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
                <button onclick="required_file()" group="submit" class="btn btn-info"><?php echo _l("submit"); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>