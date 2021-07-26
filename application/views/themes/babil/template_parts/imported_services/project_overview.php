<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row mtop15">

    <div class="col-md-12">

        <div class="panel-heading project-info-bg no-radius"><?php echo _l('project_name'); ?></div>
        <div class="panel-body no-radius tc-content project-description">
            <?php echo check_for_links($project->name); ?>
        </div>
        <div class="clearfix"></div>
         <hr class="hr-panel-heading" />
        <div class="panel-heading project-info-bg no-radius"><?php echo _l('project_description'); ?></div>
        <div class="panel-body no-radius tc-content project-description">
            <?php if(empty($project->description)){
                echo '<p class="text-muted text-center no-mbot">' . _l('no_description_project') . '</p>';
            }
            echo check_for_links($project->description); ?>
        </div>
    </div>
<!--        <div class="col-md-6 team-members project-overview-column">-->
<!--            <div class="panel-heading project-info-bg no-radius">--><?php //echo _l('project_members'); ?><!--</div>-->
<!--            <div class="panel-body">-->
<!--                --><?php
//                if(count($members) == 0){
//                    echo '<div class="media-body text-center text-muted"><p>'._l('no_project_members').'</p></div>';
//                }
//                foreach($members as $member){ ?>
<!--                    <div class="media">-->
<!--                        <div class="media-left">-->
<!--                            --><?php //echo staff_profile_image($member['staff_id'],array('staff-profile-image-small','media-object')); ?>
<!--                        </div>-->
<!--                        <div class="media-body">-->
<!--                            <h5 class="media-heading mtop5">--><?php //echo get_staff_full_name($member['staff_id']); ?><!--</h5>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                --><?php //} ?>
<!--            </div>-->
<!--        </div>-->
</div>
