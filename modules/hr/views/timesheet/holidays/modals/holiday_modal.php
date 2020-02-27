


<div class="modal fade" id="add_holiday" tabindex="-1" role="dialog" aria-labelledby="add_holiday" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><?php echo _l('add_new_holiday') ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_transout" method="get" action="<?php echo base_url() . 'hr/Holidays/add' ?>">
                          <?php  if($this->app_modules->is_active('branches')){  ?>
                                  <div class="form-group">
                                      <label for="branch_id" class="control-label"><?php echo _l('branch') ?></label>
                                      <select required="required" class="form-control" id="a_branch_id" name="branch_id" placeholder="<?php echo _l('branch') ?>" aria-invalid="false">
                                          <option></option>
                                      <?php foreach ($branches as $value) { ?>
                                          <option value="<?php echo $value['key'] ?>"><?php echo $value['value'] ?></option>
                                      <?php } ?>
                                      </select>     
                                  </div>
                          <?php } ?>
                          <div class="form-group">
                            <label for="event_name" class="col-form-label"><?php echo _l('event_name') ?></label>
                            <input type="text" class="form-control" id="event_name" name="event_name">
                          </div>

                          <div class="form-group">
                            <label for="description" class="col-form-label"><?php echo _l('description') ?></label>
                            <textarea type="textarea" class="form-control" id="description" name="description"></textarea>
                          </div>

                          <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group" app-field-wrapper="date">
                              <label for="date" class="control-label"><?php echo _l('start_date') ?></label>
                              <div class="input-group date">
                                <input type="text" id="date" name="start_date" class="form-control datepicker" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" aria-invalid="false">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar calendar-icon"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group" app-field-wrapper="date">
                              <label for="date" class="control-label"><?php echo _l('end_date') ?></label>
                              <div class="input-group date">
                                <input type="text" id="date" name="end_date" class="form-control datepicker" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" aria-invalid="false">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar calendar-icon"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          </div>

                          <div class="form-group">
                              <label for="status" class="control-label"><?php echo _l('status') ?></label>
                              <select required="required" class="form-control" id="status" name="status" placeholder="<?php echo _l('status') ?>" aria-invalid="false">
                                <option value="Published">Published</option>
                                <option value="Un Published">Un Published</option>
                              </select>     
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _l('close') ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo _l('save') ?></button>
                          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="edit_holiday" tabindex="-1" role="dialog" aria-labelledby="edit_holiday" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Edit Holiday</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_transout" method="get" action="<?php echo base_url() . 'hr/Holidays/update' ?>">

                            
                            <input aria-hidden="true" type="hidden" class="form-control" id="id" name="id">

                          <?php  if($this->app_modules->is_active('branches')){  ?>
                                  <div class="form-group">
                                      <label for="branch_id" class="control-label"><?php echo _l('branch') ?></label>
                                      <select required="required" class="form-control" id="a_branch_id" name="branch_id" placeholder="<?php echo _l('branch') ?>" aria-invalid="false">
                                          <option></option>
                                      <?php foreach ($branches as $value) { ?>
                                          <option value="<?php echo $value['key'] ?>"><?php echo $value['value'] ?></option>
                                      <?php } ?>
                                      </select>     
                                  </div>
                          <?php } ?>

                          <div class="form-group">
                            <label for="event_name" class="col-form-label"><?php echo _l('event_name') ?></label>
                            <input type="text" class="form-control" id="event_name" name="event_name">
                          </div>

                          <div class="form-group">
                            <label for="description" class="col-form-label"><?php echo _l('description') ?></label>
                            <textarea type="textarea" class="form-control" id="description" name="description"></textarea>
                          </div>

                          <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group" app-field-wrapper="date">
                              <label for="date" class="control-label"><?php echo _l('start_date') ?></label>
                              <div class="input-group date">
                                <input type="text" id="date" name="start_date" class="form-control datepicker" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" aria-invalid="false">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar calendar-icon"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group" app-field-wrapper="date">
                              <label for="date" class="control-label"><?php echo _l('end_date') ?></label>
                              <div class="input-group date">
                                <input type="text" id="date" name="end_date" class="form-control datepicker" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" aria-invalid="false">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar calendar-icon"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          </div>
                          <div class="form-group">
                              <label for="status" class="control-label"><?php echo _l('status') ?></label>
                              <select required="required" class="form-control" id="status" name="status" placeholder="<?php echo _l('status') ?>" aria-invalid="false">
                                <option value="Published">Published</option>
                                <option value="Un Published">Un Published</option>
                              </select>     
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _l('close') ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo _l('save') ?></button>
                          </div>
        </form>
      </div>
    </div>
  </div>
</div>
                

                