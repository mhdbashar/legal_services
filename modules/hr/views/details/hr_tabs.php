
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
					  			$group == 'loan' or
					  			$group == 'statutory_deductions' or
					  			$group == 'other_payments' or
					  			$group == 'overtime'
					  		){
					  			$salary = $group;
					  		}
					  		$general = '';
					  		if (
					  			$group == 'basic_information' or
					  			$group == 'immigration' or
					  			$group == 'emergency_contacts' or
					  			$group == 'social_networking' or
					  			$group == 'document' or
					  			$group == 'qualification' or
					  			$group == 'work_experience' or
					  			$group == 'bank_account' or
					  			$group == 'change_password' or
					  			$group == 'security_level'
					  		){
					  			$general = $group;
					  		}
					  	?>
					    <ul class="nav nav-tabs no-margin project-tabs nav-tabs-horizontal" role="tablist">
				                    <li class="project_tab_project_overview">
				                <a data-group="<?php echo $general ?>" role="tab" href="<?php echo admin_url('hr/general/general/'.$staff_id.'?group=basic_information') ?>">
				                    <i class="fa fa-th" aria-hidden="true"></i>
				                    <?php echo _l('general') ?>                                   </a>
				                            </li>
				                    <li class="project_tab_project_tasks">
				                <a data-group="<?php echo $salary ?>" role="tab" href="<?php echo admin_url('hr/details/salary/'.$staff_id.'?group=update_salary') ?>">
				                    <i class="fa fa-check-circle" aria-hidden="true"></i>
				                    <?php echo _l('set_salary') ?>                                    </a>
				                            </li>
<!--				                    <li class="project_tab_project_timesheets">-->
<!--				                <a data-group="leaves" role="tab" href="--><?php //echo admin_url('hr/details/leaves/'.$staff_id.'?group=leaves') ?><!--">-->
<!--				                    <i class="fa fa-clock-o" aria-hidden="true"></i>-->
<!--				                    --><?php //echo _l('leaves') ?><!--                                    </a>-->
<!--				                            </li>-->
<!--				                    <li class="project_tab_project_milestones">-->
<!--				                <a data-group="projects" role="tab" href="--><?php //echo admin_url('hr/details/projects/'.$staff_id.'?group=projects') ?><!--">-->
<!--				                    <i class="fa fa-rocket" aria-hidden="true"></i>-->
<!--				                    --><?php //echo _l('projects') ?><!--                                     </a>-->
<!--				                            </li>-->
<!--				                    <li class="project_tab_project_files">-->
<!--				                <a data-group="project_files" role="tab" href="--><?php //echo admin_url('hr/details/tasks/'.$staff_id.'?group=tasks') ?><!--">-->
<!--				                    <i class="fa fa-files-o" aria-hidden="true"></i>-->
<!--				                    --><?php //echo _l('tasks') ?><!--                                     </a>-->
<!--				                            </li>-->
<!--				                    <li class="project_tab_project_discussions">-->
<!--				                <a data-group="project_discussions" role="tab" href="--><?php //echo admin_url('hr/details/payslips/'.$staff_id.'?group=payslips') ?><!--">-->
<!--				                    <i class="fa fa-commenting" aria-hidden="true"></i>-->
<!--				                    --><?php //echo _l('payslips') ?><!--                                     </a>-->
<!--				                            </li>-->
					                
					            </ul>
						</div>
				</div>

           </div>
        </div>