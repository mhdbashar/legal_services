<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s section-heading section-projects">
    <div class="panel-body">
        <h4 class="no-margin section-text"><?php echo _l('clients_my_legal'); ?></h4>
    </div>
</div>
<div class="panel_s">
    <div class="panel-body">
        <div class="_buttons">
                <a href="<?php echo site_url('clients/imported_add'); ?>" class="btn btn-info pull-left display-block mright5">
                    <?php echo _l('new_project'); ?>
                </a>
        </div>
<!--        <div class="row mbot15">-->
<!--            <div class="col-md-12">-->
<!--                <h3 class="text-success projects-summary-heading no-mtop mbot15">--><?php //echo _l('legal_summary'); ?><!--</h3>-->
<!--            </div>-->
<!--            --><?php //get_template_part('legal_services/project_summary',['ServID' => $ServID]); ?>
<!--        </div>-->
        <div class="clearfix"></div>
        <hr class="hr-panel-heading" />
        <table class="table dt-table table-projects" data-order-col="2" data-order-type="desc">
            <thead>
            <tr>
                <th class="th-project-name"><?php echo _l('service_name'); ?></th>
                <th class="th-project-start-date"><?php echo _l('project_start_date'); ?></th>
                <th class="th-project-deadline"><?php echo _l('project_deadline'); ?></th>
<!--                <th class="th-project-billing-type">--><?php //echo _l('project_billing_type'); ?><!--</th>-->
                <?php
                $custom_fields = get_custom_fields($slug,array('show_on_client_portal'=>1));
                foreach($custom_fields as $field){ ?>
                    <th><?php echo $field['name']; ?></th>
                <?php } ?>
                <th class="th-project-deadline"><?php echo _l('project_status'); ?></th>
<!--                <th>--><?php //echo _l('project_status'); ?><!--</th>-->
            </tr>
            </thead>
            <tbody>
            <?php foreach($projects as $project){ 

                $url = site_url('clients/legal_services/'.$project['exported_rel_id'].'/'.$project['exported_service_id']);
                
                if($project['deleted'] == 0 && $project['imported'] == 0)
                    $url = $project['deleted'] == 1 && $project['imported'] == 0 ? '#' : site_url('clients/imported_service/'.$project['id']);
                elseif($project['deleted'] == 1 && $project['imported'] == 0)
                    $url = '#';

                
            ?>
                <tr>
                    <td><a href="<?php echo $url; ?>"><?php echo $project['name']; ?></a></td>
                    <td data-order="<?php echo $project['start_date']; ?>"><?php echo _d($project['start_date']); ?></td>
                    <td data-order="<?php echo $project['deadline']; ?>"><?php echo _d($project['deadline']); ?></td>
<!--                    <td>-->
<!--                        --><?php
//                        if($project['billing_type'] == 1){
//                            $type_name = 'project_billing_type_fixed_cost';
//                        } else if($project['billing_type'] == 2){
//                            $type_name = 'project_billing_type_project_hours';
//                        } else {
//                            $type_name = 'project_billing_type_project_task_hours';
//                        }
//                        echo _l($type_name);
//                        ?>
<!--                    </td>-->
                    <?php foreach($custom_fields as $field){ ?>
                        <td><?php echo get_custom_field_value($project['id'],$field['id'],$slug); ?></td>
                    <?php } ?>
                    <td>
                        <?php
                        $color = ''; $status = '';
                            if($project['deleted'] == 0 && $project['imported'] == 0){
                                $status = _l('waiting');
                                $color = 'blue';
                                echo '<span class="label inline-block" style="color:'.$color.';border:1px solid '.$color.'">'.$status.'</span>';
                            }
                            elseif($project['deleted'] == 1 && $project['imported'] == 1){
                                $status = _l('imported');
                                $color = 'green';
                                echo '<a href="'.site_url('clients/legal_services/'.$project['exported_rel_id'].'/'.$project['exported_service_id']).'"><span class="label inline-block" style="color:'.$color.';border:1px solid '.$color.'">'.$status.'</span></a>';
                            }
                            elseif($project['deleted'] == 1 && $project['imported'] == 0){
                                $status = _l('rejected');
                                $color = 'red';
                                echo '<span class="label inline-block" style="color:'.$color.';border:1px solid '.$color.'">'.$status.'</span>';
                            }
                            
                        ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>