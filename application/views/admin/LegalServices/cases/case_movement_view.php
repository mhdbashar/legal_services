<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="activity-feed">
    <?php
    $i=0;
    if(!empty($movements)){
    foreach ($movements as $movement) { ?>
        <div class="feed-item">
            <div class="row">
                <div class="alert alert-<?php echo $i % 2 == 0 ? 'info' : 'success' ?> random_background">
                    <div class="col-md-8">
                        <div class="date"><span class="text-has-action" data-toggle="tooltip" data-title="<?php echo $movement['inserted_date']; ?>"><?php echo _d($movement['project_created']); ?></span>
                        </div>
                        <div class="text">
                            <p class="mtop10 no-mbot">
                                <?php
                                $this->load->model('LegalServices/Case_movement_model', 'movement');
                                $data['members'] = $this->movement->GetMembersCasesMovement($movement['id']);
                                ?>
                                <?php echo _l('staff') . ' :'; ?>
                                <?php if (isset($data['members'])) {
                                    foreach ($data['members'] as $member) { ?>
                                        <a href="<?php echo admin_url('profile/' . $member["staff_id"]); ?>">
                                            <img src="<?php echo contact_profile_image_url($member['staff_id']); ?>" class="staff-profile-xs-image mright10">
                                            <span class="label label-info inline-block mbot5 mright10"><?php echo get_staff_full_name($member['staff_id']); ?></span>
                                        </a>
                                    <?php }
                                } ?>
                            </p>
                            <p class="mtop10 no-mbot">
                                <?php echo _l('Court') . ' :'; ?>
                                <?php echo isset($movement['court_name']) && $movement['court_name'] != '' ? $movement['court_name'] : _l('nothing_was_specified'); ?>
                            </p>
                            <p class="mtop10 no-mbot">
                                <?php
                                $this->load->model('LegalServices/Case_movement_model', 'movement');
                                $data['judges_case_mov'] = $this->movement->GetJudgesCasesMovement($movement['id']);
                                echo _l('judge').' :';
                                if(isset($movement['judges_case_mov'])):
                                foreach ($data['judges_case_mov'] as $judge){
                                    echo ' &nbsp; <span class="label label-success inline-block mbot5">' . $judge->name. '</span>';
                                }
                                else:
                                    echo  _l('nothing_was_specified');
                                endif;
                                ?>
                            </p>
                            <p class="mtop10 no-mbot">
                                <?php echo _l('CaseCode') . ' : <b>' . $movement['code'] . '</b>'; ?>
                            </p>
                            <p class="mtop10 no-mbot">
                                <?php echo _l('customer_description') . ' :'; ?>
                                <?php echo isset($movement['Representative']) && $movement['Representative'] != '' ? maybe_translate(_l('nothing_was_specified'), $movement['Representative']) : _l('nothing_was_specified'); ?>
                            </p>
                            <p class="mtop10 no-mbot"><?php echo _l('project_description'). ' :'; ?></p>
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
        </div>
    <?php $i++; } }else{ ?>
    <div class="alert alert-danger bold project-due-notice mbot15">
        <?php echo _l('empty_case_mov'); ?>
    </div>
    <?php } ?>
</div>