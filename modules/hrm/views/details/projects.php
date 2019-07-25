
<div class="col-md-9">
		<div class="panel_s">
            <div class="panel-body">
               <h4 class="no-margin">
                  <?php echo _l('projects'); ?>
               </h4>
               <hr class="hr-panel-heading" />
               <div class="_filters _hidden_inputs hidden staff_projects_filter">
                  <?php echo form_hidden('staff_id',$member->staffid); ?>
               </div>
               <?php render_datatable(array(
                  _l('project_name'),
                  _l('project_start_date'),
                  _l('project_deadline'),
                  _l('project_status'),
                  ),'staff-projects'); ?>
            </div>
         </div>
</div>
