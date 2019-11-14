<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">New Label</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open(admin_url('label_management/language/cu/'.$language.'/'.$custom),array('id'=>'form_transout', 'method'=>'get')); ?>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Label:</label>
            <input type="text" class="form-control" id="recipient-name" name="key">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Transulation :</label>
            <input type="text" class="form-control" id="recipient-name" name="value">
          </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Label</button>
      </div>
        <?php echo form_close(); ?>
      </div>
      
    </div>
  </div>
</div>


                <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel">Edit Label</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo form_open(admin_url('label_management/language/cu/'.$language.'/'.$custom),array('id'=>'form_transout', 'method'=>'get')); ?>
                          <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Label:</label>
                            <input type="text" class="form-control" id="recipient-name" name="key" readonly>
                          </div>
                          <div class="form-group">
                            <label for="message-text" class="col-form-label">Transulation :</label>
                            <textarea type="text" class="form-control" id="recipient-name" name="value"></textarea>
                          </div>
                          <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                      </div>
                       <?php echo form_close(); ?>
                      </div>
                      
                    </div>
                  </div>
                </div>

