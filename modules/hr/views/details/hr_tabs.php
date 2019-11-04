
    	<div class="panel_s project-menu-panel">
           <div class="panel-body">
                <div class="horizontal-scrollable-tabs">
					  <div class="scroller arrow-left disabled" style="display: block;"><i class="fa fa-angle-left"></i></div>
					  <div class="scroller arrow-right" style="display: block;"><i class="fa fa-angle-right"></i></div>
					  <div class="horizontal-tabs">
					  	<?php 
					  		$group = $this->input->get('group');
					  		$salary = '';
					  		if (
					  			$group == 'update_salary' or
					  			$group == 'allowances' or
					  			$group == 'commissions' or
					  			$group == 'lean' or
					  			$group == 'statutory_deductions' or
					  			$group == 'other_payments' or
					  			$group == 'overtime'
					  		){
					  			$salary = $group;
					  		}
					  	?>
					    <ul class="nav nav-tabs no-margin project-tabs nav-tabs-horizontal" role="tablist">
				                    <li class="project_tab_project_overview">
				                <a data-group="general" role="tab" href="<?php echo admin_url('hr/details/general/'.$staff_id.'?group=general') ?>">
				                    <i class="fa fa-th" aria-hidden="true"></i>
				                    General                                   </a>
				                            </li>
				                    <li class="project_tab_project_tasks">
				                <a data-group="<?php echo $salary ?>" role="tab" href="<?php echo admin_url('hr/details/salary/'.$staff_id.'?group=update_salary') ?>">
				                    <i class="fa fa-check-circle" aria-hidden="true"></i>
				                    Set Salary                                    </a>
				                            </li>
				                    <li class="project_tab_project_timesheets">
				                <a data-group="leaves" role="tab" href="<?php echo admin_url('hr/details/leaves/'.$staff_id.'?group=leaves') ?>">
				                    <i class="fa fa-clock-o" aria-hidden="true"></i>
				                    Leaves                                    </a>
				                            </li>
				                    <li class="project_tab_project_milestones">
				                <a data-group="projects" role="tab" href="<?php echo admin_url('hr/details/projects/'.$staff_id.'?group=projects') ?>">
				                    <i class="fa fa-rocket" aria-hidden="true"></i>
				                    Projects                                    </a>
				                            </li>
				                    <li class="project_tab_project_files">
				                <a data-group="project_files" role="tab" href="<?php echo admin_url('hr/details/tasks/'.$staff_id.'?group=tasks') ?>">
				                    <i class="fa fa-files-o" aria-hidden="true"></i>
				                    Tasks                                    </a>
				                            </li>
				                    <li class="project_tab_project_discussions">
				                <a data-group="project_discussions" role="tab" href="<?php echo admin_url('hr/details/payslips/'.$staff_id.'?group=payslips') ?>">
				                    <i class="fa fa-commenting" aria-hidden="true"></i>
				                    Payslips                                    </a>
				                            </li>
					                
					            </ul>
						</div>
				</div>

           </div>
        </div>