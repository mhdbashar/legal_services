<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="make_payment" tabindex="-1" role="dialog" aria-labelledby="make_payment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo "Make Payment"; ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/payroll/make_payment'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('staff_id'); ?>
            <?php echo form_hidden('type'); ?>
            <?php echo form_hidden('payment_date'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('amount','Monthly Payslip', '0', 'number', ['required' => 'required']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('allowances','Total Allowance', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('commissions','Total Commissions', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('loan','Total loan', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('overtime','Total Overtime', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('deductions','Statutory Deductions', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('other_payment','Other Payment', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('net_salary','Net Salary', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('payment_amount','Payment Amount', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo 'Close'; ?></button>
                <button group="submit" class="btn btn-info"><?php echo 'Submit'; ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>

    function make_payment(id, month, year){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hr/payroll/count_result') ?>/" + id + "/" + year + "/" + month,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="staff_id"]').val(data.staff_id);

                $('[name="type"]').val(data.type);

                $('[name="other_payment"]').val(data.total_other_payments);
                
                $('[name="overtime"]').val(data.total_overtime);

                $('[name="commissions"]').val(data.total_commissions);

                $('[name="net_salary"]').val(data.salary);

                $('[name="deductions"]').val(data.total_deductions);

                $('[name="allowances"]').val(data.total_allowances);

                $('[name="loan"]').val(data.total_loans);

                $('[name="payment_amount"]').val(data.payment_amount);

                $('[name="amount"]').val(data.payment_amount);

                $('[name="payment_date"]').val(year + '-' + month + '-' + 1);

                $('#make_payment').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
