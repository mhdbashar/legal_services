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
                            'name'=>'Full Name',
                            'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-staff_id')
                           ),
                         array(
                         'name'=>'Ammount',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-staff_id')
                        ),
                         array(
                         'name'=>'Paid Date',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-desc')
                        ),
                         array(
                         'name'=>'Paid Month',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-start_date')
                        ),
                         array(
                         'name'=>'Comments',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-end_date')
                        ),
                         array(
                         'name'=>'Control',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-id')
                        ),
                      );
                     render_datatable($_table_data, 'holiday'); ?>

                     <?php $this->load->view('modals/payments') ?>

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
    function edit_payment_json(id){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hrm/payments/get') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="ammount"]').val(data.ammount);
                $('[name="id"]').val((data.id));
                $('[name="staff_id"]').val((data.staff_id));
                $('[name="comments"]').val((data.comments));
                $('[name="payment_month"]').val((data.payment_month));
                
                
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