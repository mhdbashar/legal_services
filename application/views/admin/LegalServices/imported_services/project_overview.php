<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
   <div class="col-md-12 border-right project-overview-left">
<div class="tc-content project-overview-description">
   <p class="bold font-size-14 project-info"><?php echo _l('project_description'); ?></p>
   <?php if(empty($project->description)){
      echo '<p class="text-muted no-mbot mtop15">' . _l('no_description_project') . '</p>';
   }
   echo check_for_links($project->description); ?>
</div>
<!--
<div class="team-members project-overview-team-members">
   <hr class="hr-panel-heading project-area-separation" />
   <?php if(has_permission('projects','','edit') || has_permission('projects','','create')){ ?>
   <div class="inline-block pull-right mright10 project-member-settings" data-toggle="tooltip" data-title="<?php echo _l('add_edit_members'); ?>">
      <a href="#" data-toggle="modal" class="pull-right" data-target="#add-edit-members"><i class="fa fa-cog"></i></a>
   </div>
   <?php } ?>
   <p class="bold font-size-14 project-info">
      <?php echo _l('project_members'); ?>
   </p>
   <div class="clearfix"></div>

   <?php
   if(count($members) == 0){
      echo '<p class="text-muted mtop10 no-mbot">'._l('no_project_members').'</p>';
   }
   foreach($members as $member){ ?>
   <div class="media">
      <div class="media-left">
         <a href="<?php echo admin_url('profile/'.$member["staff_id"]); ?>">
            <?php echo staff_profile_image($member['staff_id'],array('staff-profile-image-small','media-object')); ?>
         </a>
      </div>
      <div class="media-body">
         <?php if(has_permission('projects','','edit') || has_permission('projects','','create')){ ?>
         <a href="<?php echo admin_url('LegalServices/Imported_services_controller/remove_team_member/'.$project->id.'/'.$member['staff_id']); ?>" class="pull-right text-danger _delete"><i class="fa fa fa-times"></i></a>
         <?php } ?>
         <h5 class="media-heading mtop5"><a href="<?php echo admin_url('profile/'.$member["staff_id"]); ?>"><?php echo get_staff_full_name($member['staff_id']); ?></a>
            <?php if(has_permission('projects','','create') || $member['staff_id'] == get_staff_user_id()){ ?>
            <br /><small class="text-muted"><?php echo _l('total_logged_hours_by_staff') .': '.seconds_to_time_format($member['total_logged_time']); ?></small>
            <?php } ?>
         </h5>
      </div>
   </div>
   <?php } ?>

</div>
-->
</div>

</div>
<div class="modal fade" id="add-edit-members" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <?php echo form_open(admin_url('LegalServices/Other_services_controller/add_edit_members/' .$project->id)); ?>
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo _l('project_members'); ?></h4>
         </div>
         <div class="modal-body">
            <?php
            $selected = array();
            foreach($members as $member){
              array_push($selected,$member['staff_id']);
           }
           echo render_select('project_members[]',$staff,array('staffid',array('firstname','lastname')),'project_members',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
           ?>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
         <button type="submit" class="btn btn-info" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
      </div>
   </div>
   <!-- /.modal-content -->
   <?php echo form_close(); ?>
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php if(isset($project_overview_chart)){ ?>
<script>
   var project_overview_chart = <?php echo json_encode($project_overview_chart); ?>;
</script>
<?php } ?>
