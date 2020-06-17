<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo base_url() . 'hr/payroll/index/' ?>">
                    <select id="themes" name="month" style="padding: 6px 70px; border-radius: 3px;" onchange="submitForm();">
                    <?php for($i = 1; $i < 12; $i++){ ?>
                        <?php $date = $i ; ?>
                        <?php $select = ($date == $month) ? 'selected' : '' ; ?>
                        <option <?php echo $select ?> value="<?php echo($date) ?>"><?php echo($date) ?></option>
                    <?php } ?>

                    </select><select id="themes" name="year" style="padding: 6px 70px; border-radius: 3px;" onchange="submitForm();">
                    <?php for($i = date('Y'); $i >=date('Y')-12; $i--){ ?>
                        <?php $date = $i ; ?>
                        <?php $select = ($date == $year) ? 'selected' : '' ; ?>
                        <option <?php echo $select ?> value="<?php echo($date) ?>"><?php echo($date) ?></option>
                    <?php } ?>
                    </select>
                    <input type="submit" class="btn btn-primary" value="GO">
                </form>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                    <?php render_datatable(array(
                        _l('full_name'),
                        _l('payroll_type'),
                        _l('salary'),
                        _l('status'),
                        _l('control'),
                        ),'payroll'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('payroll/modals/make_payment'); ?>
<?php $this->load->view('payroll/modals/payment_history'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-payroll', window.location.href);
   });
</script>
</body>
</html>