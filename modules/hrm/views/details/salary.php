<div class="col-md-9">
	<div class="panel_s">
        <div class="panel-body pull-center">
        				<form action="<?php admin_url('hrm/employees/member/1?group=salary') ?>">
        					<input name="group" value="salary" hidden="hidden">
	                    	<select class="btn" name="month">
	                              <option selected><?php echo date('m') ?></option>
	                            <?php for($i = 1; $i <= 12; $i++){ ?>
	                                <?php $date = ($i < 10) ? "0".$i : $i ; ?>
	                                <option value="<?php echo($date) ?>"><?php echo($date) ?></option>
	                            <?php } ?>
	                            </select>

	                            <select class="btn" name="year">
	                              <option selected><?php echo("20".date('y')) ?></option>
	                            <?php for($i = date('y'); $i <= date('y')+12; $i++){ ?>
	                                <option value="<?php echo("20".$i) ?>"><?php echo("20".$i) ?></option>
	                            <?php } ?>
                            </select>
                            <input type="submit" class="btn btn-primary" value="GO">
                    	</form>
                    	<hr>

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
                    if($this->input->get('month'))
                     render_datatable($_table_data, 'make_payment'); ?>
        </div>
     </div>
</div>
