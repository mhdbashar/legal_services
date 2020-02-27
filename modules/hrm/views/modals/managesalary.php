<div class="modal fade" id="managesalary" tabindex="-1" role="dialog" aria-labelledby="managesalary" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Edit Salary</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_transout" method="get" action="<?php echo base_url() . 'hrm/managesalary/update' ?>">

                            <input aria-hidden="true" type="hidden" class="form-control" id="user_id" name="user_id">

                        <div class="form-group">
                            <label for="description" class="col-form-label">Main Salary</label>
                            <input type="number" step="any" class="form-control" id="main_salary" name="main_salary">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-form-label">Transportation Expenses</label>
                            <input type="number" step="any" class="form-control" id="transportation_expenses" name="transportation_expenses">
                        </div>       
                        <div class="form-group">
                            <label for="description" class="col-form-label">Other Expenses</label>
                            <input type="number" step="any" class="form-control" id="other_expenses" name="other_expenses">
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