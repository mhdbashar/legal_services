<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#attendance_date"><?php echo _l('attendance_date'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        _l('staff_name'),
                        _l('employee_id'),
                        _l('branch_name'),
                        _l('date'),
                        _l('hr_status'),
                        _l('in_time'),
                        _l('out_time'),
                        _l('late'),
                        _l('early_leaving'),
                        _l('over_time'),
                        _l('total_work'),
                    ),'attendance'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('timesheet/attendance/modals/date_wise_attendance_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-attendance', window.location.href);
   });
</script>
</body>
</html>
