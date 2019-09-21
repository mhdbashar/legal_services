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
        initDataTable('.table-holiday', window.location.href);
   });
    
</script>