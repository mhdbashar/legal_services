<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="activity-feed">
    <?php
    if(!empty($movements)){
    foreach ($movements as $movement) { ?>
        <div class="feed-item">
            <div class="row">
                <div class="col-md-8">
                    <div class="date"><span class="text-has-action" data-toggle="tooltip" data-title="<?php echo $movement['project_created']; ?>"><?php echo time_ago($movement['project_created']); ?></span>
                    </div>
                    <div class="text">
                        <p class="mtop10 no-mbot">
                            <?php echo _l('staff') . ' :'; ?>
                            <?php if (isset($members)) {
                                foreach ($members as $member) { ?>
                                    <a href="<?php echo admin_url('profile/' . $member["staff_id"]); ?>">
                                        <img src="<?php echo contact_profile_image_url($member['staff_id']); ?>" class="staff-profile-xs-image mright10">
                                        <span class="label label-info inline-block mbot5 mright10"><?php echo get_staff_full_name($member['staff_id']); ?></span>
                                    </a>
                                <?php }
                            } ?>
                        </p>
                        <p class="mtop10 no-mbot">
                            <?php echo _l('Court') . ' : <b>' . $movement['court_name'] . '</b>'; ?>
                        </p>
                        <p class="mtop10 no-mbot">
                            <?php
                            $this->load->model('LegalServices/Case_movement_model', 'movement');
                            $data['judges_case_mov'] = $this->movement->GetJudgesCasesMovement($movement['id']);
                            echo _l('judge').' :';
                            foreach ($data['judges_case_mov'] as $judge){
                                echo ' &nbsp; <span class="label label-success inline-block mbot5">' . $judge->name. '</span>';
                            }
                            ?>
                        </p>
                        <p class="mtop10 no-mbot">
                            <?php echo _l('CaseCode') . ' : <b>' . $movement['code'] . '</b>'; ?>
                        </p>
                        <p class="mtop10 no-mbot">
                            <?php echo _l('customer_description') . ' : <b>' . $movement['Representative'] . '</b>'; ?>
                        </p>
                        <p class="mtop10 no-mbot"><?php echo _l('project_description'); ?></p>
                        <p class="no-mbot text-muted mleft30 mtop5"><?php echo $movement['description']; ?></p>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <div class="pull-right">
                        <a href="<?php echo admin_url("LegalServices/case_movement_controller/delete/" . $ServID . '/' . $project->id . '/' . $movement['id']); ?>"
                           class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i> <?php echo _l('delete'); ?></a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <hr class="hr-10"/>
                </div>
            </div>
        </div>
    <?php } }else{ ?>
    <div class="alert alert-danger bold project-due-notice mbot15">
        <?php echo _l('empty_case_mov'); ?>
    </div>
    <?php } ?>
</div>