<?php init_head() ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">

                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_holiday" data-title="New Holiday" data-readonly="">
                        <?php echo _l('add_new_holiday') ?>
                    </button>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php
                    $_table_data = array(
                       
                         array(
                         'name'=>_l('event_name'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-event_name')
                        ),
                         array(
                         'name'=>_l('description'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-desc')
                        ),
                         array(
                         'name'=>_l('start_date'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-start_date')
                        ),
                         array(
                         'name'=>_l('end_date'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-end_date')
                        ),
                         array(
                         'name'=>_l('control'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-id')
                        ),
                      );
                     render_datatable($_table_data, 'holiday'); ?>
                    <?php $this->load->view('timesheet/holidays/modals/holiday_modal') ?>

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

    function edit_holiday_json(id){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hrm/Holidays/get') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {

                console.log(data);
                $('[name="id"]').val(data.id);
                $('[name="branch_id"]').val(data.branch_id);
                $('[name="event_name"]').val(data.event_name);
                $('[name="description"]').val(data.description);
                $('[name="start_date"]').val(data.start_date);
                $('[name="end_date"]').val(data.end_date);
                $('[name="status"]').val(data.status);
                
                
                // $('[name="dob"]').datepicker('update',data.dob);
                $('#edit_holiday').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

</script>