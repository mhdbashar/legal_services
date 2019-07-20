


<div class="modal fade" id="add_holiday" tabindex="-1" role="dialog" aria-labelledby="add_holiday" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Add New Holiday</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_transout" method="get" action="<?php echo base_url() . 'hrm/Holidays/add' ?>">
                          <div class="form-group">
                            <label for="event_name" class="col-form-label">Event Name</label>
                            <input type="text" class="form-control" id="event_name" name="event_name">
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
        <form id="form_transout" method="get" action="<?php echo base_url() . 'hrm/Holidays/update' ?>">

                            <input aria-hidden="true" type="hidden" class="form-control" id="id" name="id">

                          <div class="form-group">
                            <label for="event_name" class="col-form-label">Event Name</label>
                            <input type="text" class="form-control" id="event_name" name="event_name">
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
                

                