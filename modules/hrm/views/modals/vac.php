


<div class="modal fade" id="add_vac" tabindex="-1" role="dialog" aria-labelledby="add_vac" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Add New Vaction</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_transout" method="get" action="<?php echo base_url() . 'hrm/Vac/update' ?>">
                   <div class="form-group">
                            <label for="staff_id" class="col-form-label">Staff</label>
                            <div class="row-fluid">
                            <select name="staff_id" id="staff_id" class="selectpicker" data-show-subtext="true" data-live-search="true">
                              <?php foreach ($staff as $key => $value){ ?>

                                <option value="<?php echo $value['staffid'] ?>"><?php echo $value['firstname'] ?></option>
                                
                              <?php } ?>
                            </select>
                            
                          </div>
                          </div>

                          <div class="form-group">
                            <label for="description" class="col-form-label">Description</label>
                            <textarea type="textarea" class="form-control" id="description" name="description"></textarea>
                          </div>

                          <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group" app-field-wrapper="date">
                              <label for="date" class="control-label">Start Date</label>
                              <div class="input-group date">
                                <input type="text" id="date" name="start_date" class="form-control datepicker" value="2019-05-23" autocomplete="off" aria-invalid="false">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar calendar-icon"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group" app-field-wrapper="date">
                              <label for="date" class="control-label">End Date</label>
                              <div class="input-group date">
                                <input type="text" id="date" name="end_date" class="form-control datepicker" value="2019-05-23" autocomplete="off" aria-invalid="false">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar calendar-icon"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="edit_vac" tabindex="-1" role="dialog" aria-labelledby="edit_vac" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Edit Vaction</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_transout" method="get" action="<?php echo base_url() . 'hrm/Vac/update' ?>">

                            <input aria-hidden="true" type="hidden" class="form-control" id="id" name="id">

                          <div class="form-group">
                            <label for="description" class="col-form-label">Description</label>
                            <textarea type="textarea" class="form-control" id="description" name="description"></textarea>
                          </div>

                          <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group" app-field-wrapper="date">
                              <label for="date" class="control-label">Start Date</label>
                              <div class="input-group date">
                                <input type="text" id="date" name="start_date" class="form-control datepicker" value="2019-05-23" autocomplete="off" aria-invalid="false">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar calendar-icon"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group" app-field-wrapper="date">
                              <label for="date" class="control-label">End Date</label>
                              <div class="input-group date">
                                <input type="text" id="date" name="end_date" class="form-control datepicker" value="2019-05-23" autocomplete="off" aria-invalid="false">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar calendar-icon"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                          </div>
        </form>
      </div>
    </div>
  </div>
</div>
                

                