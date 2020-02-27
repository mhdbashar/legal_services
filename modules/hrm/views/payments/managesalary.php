<?php init_head() ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">

                        <nav class="navbar navbar-light bg-light">
                          <form class="form-inline">
                            <a href="<?php echo base_url() ?>hrm/makepayment" class="btn btn-outline-success" type="button">Make Payment</a>
                            <a href="<?php echo base_url() ?>hrm/payments" class="btn btn-outline-secondary" type="button">Payments</a>
                            <a href="<?php echo base_url() ?>hrm/managesalary" class="btn btn-outline-secondary" type="button">Manage Salary</a>
                          </form>
                        </nav>

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
                         'name'=>'Main Salary',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-desc')
                        ),
                         array(
                         'name'=>'Transportation Expenses',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-reson')
                        ),
                         array(
                         'name'=>'Other Expenses',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-date')
                        ),
                        array(
                            'name'=>'Full Salary',
                            'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-id')
                           ),
                        array(
                            'name'=>'Controll',
                            'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-id')
                        ),
                      );
                     render_datatable($_table_data, 'holiday'); ?>

                     <?php
                     $data['staff'] = $this->manage_salary->getStaff();
                     ?>

                    <?php $this->load->view('modals/managesalary', $data) ?>
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

    function edit_managesalary_json(user_id){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hrm/managesalary/get') ?>/" + user_id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {

                console.log(data);
                $('[name="user_id"]').val(data.user_id);
                $('[name="main_salary"]').val(data.main_salary);
                $('[name="transportation_expenses"]').val(data.transportation_expenses);
                $('[name="other_expenses"]').val(data.other_expenses);
                
                
                // $('[name="dob"]').datepicker('update',data.dob);
                $('#make_payment').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

</script>