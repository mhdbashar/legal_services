<div class="col-md-9">
	<div class="panel_s">
        <div class="panel-body pull-center">
<?php

                    $_table_data = array(
                         array(
                         'name'=>'Staff',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-staff_id')
                        ),
                         array(
                         'name'=>'Description',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-desc')
                        ),
                         array(
                         'name'=>'Start Date',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-start_date')
                        ),
                         array(
                         'name'=>'End Date',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-end_date')
                        ),
                         array(
                         'name'=>'Controll',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-id')
                        ),
                      );
                    if($this->input->get('group') == 'leave')
                     render_datatable($_table_data, 'leave'); ?>
</div>
     </div>
</div>
