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
                            'name'=>'#id',
                            'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-staff_id')
                        ),
                        array(
                            'name'=>'Staff',
                            'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-staff_id')
                        ),
                         array(
                         'name'=>'Full Salary',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-desc')
                        ),
                         array(
                         'name'=>'Job Title',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-start_date')
                        ),
                         
                         array(
                         'name'=>'Status',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-end_date')
                        ),
                    
                      );
                     render_datatable($_table_data, 'holiday'); ?>


                    <?php $this->load->view('modals/make_payment') ?>

</div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php init_tail() ?>

</script>

<script type="text/javascript">
    $(function(){
        initDataTable('.table-holiday', window.location.href, [1], [1]);
   });
        $(function(){
        initDataTable('.table-holiday', window.location.href, [1], [1]);
   });

    function make_payment_json(user_id){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hrm/makepayment/get') ?>/" + user_id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="ammount"]').val(Number(data.main_salary) + Number(data.transportation_expenses) + Number(data.other_expenses) + Number(data.award));
                $('[name="staff_id"]').val((data.staff_id));
                $('[name="payment_month"]').val("<?php echo $month ?>")
                
                
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
