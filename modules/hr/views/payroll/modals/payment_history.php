<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="make_payment" tabindex="-1" role="dialog" aria-labelledby="make_payment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l("view"); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('hr/payroll/make_payment'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('staff_id'); ?>
            <?php echo form_hidden('type'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('staff','staff', '0', 'text', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_input('payment_date','payment_date', '0', 'text', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('allowances','total_allowance', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('commissions','total_commissions', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('loan','total_loan', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('overtime','total_overtime', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('deductions','statutory_deductions', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo render_input('other_payment','other_payment', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('net_salary','net_salary', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('payment_amount','payment_amount', '0', 'number', ['required' => 'required', 'readonly' => 'true']); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo 'Close'; ?></button>
            </div>
        </div>
    </div>
</div>

<script>

    function payment(id, month, year){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hr/payroll/payment_json') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                $('[name="staff"]').val(data.full_name);

                $('[name="type"]').val(data.type);

                $('[name="other_payment"]').val(data.other_payment);
                
                $('[name="overtime"]').val(data.overtime);

                $('[name="commissions"]').val(data.commissions);

                $('[name="net_salary"]').val(data.net_salary);

                $('[name="deductions"]').val(data.deductions);

                $('[name="allowances"]').val(data.allowances);

                $('[name="loan"]').val(data.loan);

                $('[name="payment_amount"]').val(data.amount);

                $('[name="amount"]').val(data.payment_amount);

                $('[name="payment_date"]').val(data.created);

                $('#make_payment').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
