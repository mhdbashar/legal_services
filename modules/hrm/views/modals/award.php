


<div class="modal fade" id="add_award" tabindex="-1" role="dialog" aria-labelledby="add_award" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Add New Award</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_transout" method="get" action="<?php echo base_url() . 'hrm/award/addnew' ?>">
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
                            <label for="award" class="col-form-label">Award Ammount</label>
                            <input type="number" step="any" class="form-control" id="award" name="award">
                          </div>

                          <div class="form-group">
                            <label for="reason" class="col-form-label">reason</label>
                            <textarea type="textarea" class="form-control" id="reason" name="reason"></textarea>
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


<div class="modal fade" id="edit_award" tabindex="-1" role="dialog" aria-labelledby="edit_award" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Edit Vaction</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_transout" method="get" action="<?php echo base_url() . 'hrm/award/update' ?>">

                            <input aria-hidden="true" type="hidden" class="form-control" id="id" name="id">

                          <div class="form-group">
                            <label for="award" class="col-form-label">Award Ammount</label>
                            <input type="number" step="any" class="form-control" id="award" name="award">
                          </div>

                          <div class="form-group">
                            <label for="reason" class="col-form-label">reason</label>
                            <textarea type="textarea" class="form-control" id="reason" name="reason"></textarea>
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
                

                