<div class="col-md-9">
	<div class="panel_s">
        <div class="panel-body pull-center">
        				<h4 class="no-margin">
                          <?php echo 'Payments'; ?>
                       </h4>
                       <hr>
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
                     render_datatable($_table_data, 'make_payment');
                     $this->load->view('modals/payments'); ?>

        </div>
     </div>
</div>
