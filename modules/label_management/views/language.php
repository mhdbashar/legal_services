<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>

<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel_s">
               <div class="panel-body">

                <a class="btn btn-info" href="<?php echo base_url() . "label_management/language/"?>">English</a>
                <a class="btn btn-info" href="<?php echo base_url() . "label_management/language/index/arabic"?>">Arabic</a>

                <h2 class="m-5"><?php echo ucfirst($language) ?></h2>
                <button type="button" class="btn btn-success m-2" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Add New</button>


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
                        <form>
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
                        </form>
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
                        <form>
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
                        </form>
                      </div>
                      
                    </div>
                  </div>
                </div>
    
      <table class="table">
      <thead>

        <tr>
          <th scope="col">Label</th>
          <th scope="col"><?php echo ucfirst($language) ?></th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>

      </thead>
      <tbody>
<?php $i = 0; foreach($lang as $key => $value): $i++ ?>
    <?php if ($offset > $i)continue; ?>
        <tr>
          <td><?php echo $key ?></td>
          <td><?php echo htmlspecialchars($value) ?></td>
          <td>
<button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#EditModal" data-key="<?php echo $key ?>" data-value="<?php echo htmlspecialchars($value) ?>">Edit</button>
          </td>
          <td><a class="btn btn-danger" href="<?php echo base_url() . "label_management/language/delete/" . $key . "/" . $language?>" role="button">Delete</a></td>
        </tr>
    <?php if ($i >= $start) break; ?>
<?php endforeach; ?>        
      </tbody>
    </table>


<?php 
  $offset--;
  $count = count($lang);
  $f = round($count/$per_page);
  if ($count/$per_page > round($count/$per_page))
  $f += 1;
?>

<ul class="pagination">

<?php for ($i = 1; $i <= $f; $i++): ?>

  <?php if ($offset == ($i - 1) * $per_page) $active  = 'active'; else $active = '' ?>

  <li class="<?php echo $active ?>"><a href="<?php echo base_url() . 'label_management/language/index/' . $language . '/' . ($i - 1) * $per_page?>"><?php echo $i ?></a></li>

<?php endfor; ?>

</ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<?php init_tail(); ?>
<script type="text/javascript">
$('#EditModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var key = button.data('key') // Extract info from data-* attributes
  var value = button.data('value');
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-body input').val(key);
  modal.find('.modal-body textarea').val(value);
})
</script>
  </body>
</html>