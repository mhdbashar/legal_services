<div class="row mtop15">
    <div class="col-md-12">
        <?php
        if(has_permission('additional_timesheets_management', '', 'view') || has_permission('additional_timesheets_management', '', 'view_own') || is_admin()) {
            ?>
            <a href="#" onclick="type_of_leave_timesheets(); return false;" class="btn mright5 btn-info pull-left display-block" >
                <?php echo _l('add'); ?>
            </a>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
    <br>
    <br>
</div>
<?php
$table_data = array(
    _l('id'),
    _l('name'),
    _l('options'),

);
render_datatable($table_data,'table_type_of_leave');
?>
<div class="modal fade view_type_of_leave_modal" id="view_type_of_leave_modal" >
</div>

<div class="modal fade" id="type_of_leave_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog"  style="width: 70%">
        <?php echo form_open(admin_url('hr_profile/type_of_leave'),array('id'=>'edit_timesheets-form')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>
                    <?php echo _l('type_of_leave'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <?php echo  _l('who_can_take_this_leave')?>
                        </p>
                        <br />
                        <div class="checkbox checkbox-inline checkbox-primary">
                            <input checked  type="checkbox" name="male" id="male" value="1" ?>
                            <label for="male"><?php echo _l('male'); ?></label>
                        </div>
                        <div class="checkbox checkbox-inline checkbox-primary">
                            <input checked  type="checkbox" name="female" id="female" value="1" ?>
                            <label for="female"><?php echo _l('female'); ?></label>
                        </div>
                        <hr />
                        <br />
                        <div class="checkbox checkbox-inline checkbox-primary">
                            <input  checked type="checkbox" name="muslim" id="muslim" value="1" ?>
                            <label for="muslim"><?php echo _l('muslim'); ?></label>
                        </div>
                        <div class="checkbox checkbox-inline checkbox-primary">
                            <input checked  type="checkbox" name="not_muslim" id="not_muslim" value="1" ?>
                            <label for="not_muslim"><?php echo _l('not_muslim'); ?></label>
                        </div>
                        <hr />
                        <br />
                        <div class="checkbox checkbox-inline checkbox-primary">
                            <input checked  type="checkbox" name="citizen" id="citizen" value="1" ?>
                            <label for="citizen"><?php echo _l('citizen'); ?></label>
                        </div>
                        <div class="checkbox checkbox-inline checkbox-primary">
                            <input checked  type="checkbox" name="not_citizen" id="not_citizen" value="1" ?>
                            <label for="not_citizen"><?php echo _l('not_citizen'); ?></label>
                        </div>
                        <hr/>
                        <br/>
                        <div class="checkbox checkbox-block checkbox-primary">
                            <input checked  type="checkbox" name="accumulative" id="accumulative" value="yes" ?>
                            <label for="accumulative"><?php echo _l('accumulative'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('name','name','', '', ['required' => true]); ?>
                        <?php echo render_input('code', 'code', '', '', ['required' => true]); ?>
                        <?php echo render_input('number_of_days','number_of_days',1, 'number'); ?>
                        <?php echo render_input('entitlement_in_months','entitlement_in_months',1, 'number'); ?>
                        <?php echo render_input('deserving_in_years','deserving_in_years',0, 'number'); ?>
                        <?php echo render_input('deserving_before_days','deserving_before_days',0, 'number', [], [], 'hide'); ?>
                        <?php echo render_input('deserving_after_days','deserving_after_days',0, 'number', [], [], 'hide'); ?>
                        <div class="form-group">
                            <label for="repeat_leave" class="control-label"><?php echo _l('repeat_leave'); ?></label>
                            <select name="repeat_leave" class="selectpicker" id="repeat_leave" data-width="100%" data-none-selected-text="<?php echo _l('none_type'); ?>">
                            <option></option>
                                <option value="year"><?php echo _l('year') ?></option>
                                <option value="once"><?php echo _l('once_during_contract') ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="col-md-12">
                    <?php echo render_input('notify_manager_before_deserving_days','notify_manager_before_deserving_days','', 'number', [], [], 'hide'); ?>
                    <?php echo render_input('notify_staff_before_deserving_days','notify_staff_before_deserving_days','', 'number', [], [], 'hide'); ?>
                    <div class="form-group">
                        <label for="repeat_leave" class="control-label"><?php echo _l('conflict_with_holidays'); ?></label>
                        <select name="repeat_leave" class="selectpicker" id="repeat_leave" data-width="100%" data-none-selected-text="<?php echo _l('default'); ?>">
                            <option></option>
                            <option selected value="extend"><?php echo _l('leave_extend') ?></option>
                            <option value="include"><?php echo _l('leave_include') ?></option>
                        </select>
                    </div>
                    <div class="text-center">
                        <h3>
                            <?php echo _l('deserving_salary') ?>
                        </h3>
                        <div class="checkbox checkbox-inline checkbox-primary">
                            <input checked  type="checkbox" name="is_deserving_salary" id="is_deserving_salary" value="1" >
                            <label for="is_deserving_salary"><?php echo _l('is_deserving_salary'); ?></label>
                        </div>
                    </div>
                    <div id="deserving-salary">
                        <div id="deserving_salary" style="margin: 0 70px;">
                            <br />
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="radio-primary radio-inline">
                                            <input type="radio" id="basic_salary" name="salary_type" value="basic_salary" />
                                            <label for="basic_salary" class="control-label clearfix"><?php echo _l('basic_salary'); ?></label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="radio-primary radio-inline">
                                            <input checked type="radio" id="total_salary" name="salary_type" value="total_salary" />
                                            <label for="total_salary" class="control-label clearfix"><?php echo _l('total_salary'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="allocation">
                            <div class="text-center" id="salary-allocation-checkbox">
                                <br />
                                <div class="checkbox checkbox-inline checkbox-primary">
                                    <input type="checkbox" name="salary_allocation" id="salary_allocation" value="1" >
                                    <label for="salary_allocation"><?php echo _l('salary_allocation'); ?></label>
                                </div>
                            </div>
                            <div id="salary-allocation-container" class="hidden">
                                <div class="row mtop15">
                                    <h4 class="col-md-3 text-center">Percent</h4>
                                    <h4 class="col-md-6 text-center">Number of days</h4>
                                </div>
                                <div id="salary-allocation">

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="text-center" id="allow-substitute-employee">
                        <br />
                        <div class="checkbox checkbox-inline checkbox-primary">
                            <input type="checkbox" name="allow_substitute_employee" id="allow_substitute_employee" value="1" >
                            <label for="allow_substitute_employee"><?php echo _l('allow_substitute_employee'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                
              <div id="draggable" class="drag-sort-enable" style="margin: auto; text-align:center ;width: 60%; "
                   ondrop="drop(event)" ondragover="allowDrop(event)">
            
                  <div  class="row" draggable="true" ondragstart="drag(event) ">
                      <div class="col-md-6">
            
                          <?php echo  render_select('staff_id_manage_depart', $pro, array('staffid', array('firstname', 'lastname')), '', '',['required' => true],['required' => true], '', '',true); ?>
                      </div>
            
                      <div class="col-md-6">
            
                      <div data-id="0" id="manage_depart" class="item"
                       style="margin-bottom: 10px; border: thin solid black ;padding: 5px;border-radius: 8px; cursor: move" >
                      <i style="padding-right: 45%" class="fa fa-bars"></i><?= _l('manage_depart') ?>  </div>
                      </div>
                  </div>
                  <div class="row" draggable="true" ondragstart="drag(event) ">
                      <div class="col-md-6">
            
                          <?php echo render_select('staff_id_manager_hr', $pro, array('staffid', array('firstname', 'lastname')), '', '', ['required' => true],['required' => true], '', '', true); ?>
                      </div>
            
                      <div class="col-md-6">
            
                          <div data-id="1" id="manager_hr" class="item" draggable="true" ondragstart="drag(event) "
                               style="margin-bottom: 10px; border: thin solid black ;border-radius: 8px;padding: 5px;cursor: move">
                              <i style="padding-right: 30%" class="fa fa-bars"></i><?= _l('manager_hr') ?></div>
                      </div>
                  </div>
                  <div class="row" draggable="true" ondragstart="drag(event) ">
                      <div class="col-md-6">
            
                          <?php echo render_select('staff_id_director_general', $pro, array('staffid', array('firstname', 'lastname')), '', '',['required' => true],['required' => true], '', '', true); ?>
                      </div>
            
                      <div class="col-md-6">
            
                          <div data-id="2" id="director_general" class="item" draggable="true" ondragstart="drag(event)"
                               style="margin-bottom: 10px;border: thin solid black ;border-radius: 8px;padding: 5px;cursor: move">
                              <i style="padding-right: 30%" class="fa fa-bars"></i><?= _l('director_general') ?></div>
                      </div>
                  </div>
            </div>
          
            
            
            
            
          </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button id="submit-type" class="btn btn-info btn-additional-timesheets"><?php echo _l('submit'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
        
    </div><!-- /.modal-dialog -->



    
</div>

<script>
    function type_of_leave_timesheets(){
        "use strict";
        $('#type_of_leave_modal').modal();
    }



    function view_type_of_leave(id){
        "use strict";
        $.post(admin_url+'hr_profile/get_data_type_of_leave/'+id).done(function(response){
            response = JSON.parse(response);
            $('#view_type_of_leave_modal').html('');

            $('#view_type_of_leave_modal').append(response.html);

            $('#view_type_of_leave_modal').modal('show');
        });
    }
</script>