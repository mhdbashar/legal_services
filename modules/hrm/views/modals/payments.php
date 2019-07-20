<div class="modal fade" id="edit_payment" tabindex="-1" role="dialog" aria-labelledby="edit_payment" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Edit Payment</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_transout" method="get" action="<?php echo base_url() . 'hrm/payments/update' ?>">

                            <input aria-hidden="true" type="hidden" class="form-control" id="id" name="id">
                            <input aria-hidden="true" type="hidden" class="form-control" id="payment_month" name="payment_month">

                        <div class="form-group">
                            <label for="ammount" class="col-form-label">Ammount</label>
                            <input type="number" step="any" class="form-control" id="ammount" name="ammount">
                        </div>      
                        <div class="form-group">
                            <label for="comments" class="col-form-label">Comment</label>
                            <textarea type="text" class="form-control" id="comments" name="comments"></textarea>
                          </div>
                    
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Edit</button>
                          </div>
        </form>
      </div>
    </div>
  </div>
</div>