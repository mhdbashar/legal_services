<?php init_head() ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <nav class="navbar navbar-light bg-light">
                          <form class="form-inline">
                            <a href="<?php echo base_url() ?>hrm/workdays" class="btn btn-outline-success" type="button">Work Days</a>
                            <a href="<?php echo base_url() ?>hrm/holidays" class="btn btn-outline-secondary" type="button">Holidays</a>
                            <a href="<?php echo base_url() ?>hrm/vac" class="btn btn-outline-secondary" type="button">Vaction</a>
                          </form>
                        </nav>


                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_vac" data-title="New Holiday" data-readonly="">
                        Add New Vaction
                    </button>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php
                    $_table_data = array(
                         array(
                         'name'=>'Staff',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-staff_id')
                        ),
                         array(
                         'name'=>'Description',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-desc')
                        ),
                         array(
                         'name'=>'Start Date',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-start_date')
                        ),
                         array(
                         'name'=>'End Date',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-end_date')
                        ),
                         array(
                         'name'=>'Controll',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-id')
                        ),
                      );
                     render_datatable($_table_data, 'holiday'); ?>

                     <?php
                     $data['staff'] = $this->vaction->getStaff();
                     ?>

                    <?php $this->load->view('modals/vac', $data) ?>
</div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php init_tail() ?>
<script type="text/javascript">
    $(function(){
        initDataTable('.table-holiday', window.location.href, [1], [1]);
   });

// $('#edit_holiday').on('show.bs.modal', function (event) {
//   var button = $(event.relatedTarget) // Button that triggered the modal
//   var event = button.data('event_name')
//   var description = button.data('description')
//   var start_date = button.data('start_date')
//   var end_date = button.data('end_date')
//   var title = button.data('title')
//   var readonly = button.data('readonly') // Extract info from data-* attributes
//   // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
//   // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
//   var modal = $(this)

  
//   modal.find('.modal-title').text(title)
//   modal.find('.modal-body input[name="event_name"]').val(event)
//   modal.find('.modal-body textarea').val(description)
//   modal.find('.modal-body input[name="start_date"]').val(start_date)
//   modal.find('.modal-body input[name="end_date"]').val(end_date)
// })
</script>

<script type="text/javascript">
    $(function(){
        initDataTable('.table-holiday', window.location.href, [1], [1]);
   });

    function edit_vac_json(id){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hrm/vac/get') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {

                $('[name="id"]').val(data.id);
                $('[name="description"]').val(data.description);
                $('[name="start_date"]').val(data.start_date);
                $('[name="end_date"]').val(data.end_date);
                
                
                // $('[name="dob"]').datepicker('update',data.dob);
                $('#edit_vac').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

</script>