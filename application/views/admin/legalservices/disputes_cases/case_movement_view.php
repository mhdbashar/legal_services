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
                                $this->load->model('legalservices/Disputes_cases_movement_model', 'Dmovement');
                                $data['members'] = $this->Dmovement->GetMembersCasesMovement($movement['id']);
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
                                <?php echo isset($movement['court_name']) && $movement['court_name'] != '' ?  maybe_translate(_l('nothing_was_specified'), $movement['court_name']) :  _l('nothing_was_specified'); ?>
                            </p>
                            <p class="mtop10 no-mbot">
                                <?php echo _l('NumJudicialDept') . ' :'; $Jud = get_judicialdept_by_id($movement['jud_num']);?>
                                <?php echo isset($movement['jud_num']) && $movement['jud_num'] != '0' ?  maybe_translate(_l('nothing_was_specified'), $Jud->Jud_number ):  _l('nothing_was_specified'); ?>
                            </p>
                            <p class="mtop10 no-mbot">
                                <?php echo _l('Categories') . ' :'; ?>
                                <?php echo isset($movement['cat_id']) && $movement['cat_id'] != '' ?  maybe_translate(_l('nothing_was_specified'), get_cat_name_by_id($movement['cat_id'])) :  _l('nothing_was_specified'); ?>
                            </p>
                            <p class="mtop10 no-mbot">
                                <?php echo _l('SubCategories') . ' :'; ?>
                                <?php echo isset($movement['subcat_id']) && $movement['subcat_id'] != '' ?  maybe_translate(_l('nothing_was_specified'), get_cat_name_by_id($movement['subcat_id'])) :  _l('nothing_was_specified'); ?>
                            </p>
                            <p class="mtop10 no-mbot">
                                <?php echo _l('child_sub_categories') . ' :'; ?>
                                <?php echo isset($movement['childsubcat_id']) && $movement['childsubcat_id'] != '0' ?  maybe_translate(_l('nothing_was_specified'), get_cat_name_by_id($movement['childsubcat_id'])) :  _l('nothing_was_specified'); ?>
                            </p>
                            <p class="mtop10 no-mbot">
                                <?php
                                $judges = $this->Dmovement->GetJudgesCasesMovement($movement['id']);
                                echo _l('judge').' :';
                                if(isset($judges)){
                                foreach ($judges as $judge){
                                    echo ' &nbsp; <span class="label label-success inline-block mbot5">' . $judge['name']. '</span>';
                                }
                                }else
                                    echo  _l('nothing_was_specified');
                                ?>
                            </p>
                            <p class="mtop10 no-mbot">
                                <?php echo _l('CaseCode') . ' : <b>' . $movement['code'] . '</b>'; ?>
                            </p>

                            <?php $i = 1;
                            $opponent_data = $this->Dmovement->get_case_mov_opponents($movement['id']);
                            if(isset($opponent_data)){
                            foreach ($opponent_data as $opponent){
                                if($opponent['opponent_id'] != 0){
                                    echo _l('opponent').' '.$i.' :';
                                    echo ' &nbsp; <span class="label label-success inline-block mbot5">' . $opponent['company']. '</span><br>';

                                    ?>
<!--                                    <p class="mtop10 no-mbot">-->
<!--                                        <td class="bold">--><?php //echo _l('opponent').' '.$i; ?><!--</td>-->
<!--                                        <td><a href="--><?php //echo admin_url(); ?><!--opponents/client/--><?php //echo isset($opponent->opponent_id) ? $opponent->opponent_id : ''; ?><!--">--><?php //echo isset($opponent->company) ? $opponent->company : ''; ?><!--</a>-->
<!--                                        </td>-->
<!--                                    </tr>-->
                                <?php }$i++;} }?>

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
                            <a href="<?php echo admin_url("legalservices/disputes_case_movement/delete/22/" . '/' . $project->id . '/' . $movement['id']); ?>"
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