<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php if(has_permission('projects','','create')){ ?>
                                <?php $route = $ServID == 1 ?  admin_url("Case/add/$ServID") : admin_url("SOther/add/$ServID") ?>
                                <a href="<?php echo $route; ?>" class="btn btn-info mright5 test pull-left display-block">
                                    <?php echo _l('permission_create').' '.$service->name; ?>
                                </a>
                            <?php }

                            $TableStaff = $ServID == 1 ? 'my_members_cases' : 'my_members_services';
                            $TableService = $ServID == 1 ? 'my_cases' : 'my_other_services';
                            $field = $ServID == 1 ? 'project_id' : 'oservice_id';
                            $class = $ServID == 1 ? '.table-cases' : '.table-my_other_services';
                            $render_class = $ServID == 1 ? 'cases' : 'my_other_services';

                            ?>


                            <div class="btn-group pull-right mleft4 btn-with-tooltip-group _filter_data" data-toggle="tooltip" data-title="<?php echo _l('filter_by'); ?>">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right width300">
                                    <li>
                                        <a href="#" data-cview="all" onclick="dt_custom_view('','<?php echo $class; ?>',''); return false;">
                                            <?php echo _l('expenses_list_all'); ?>
                                        </a>
                                    </li>
                                    <?php
                                    // Only show this filter if user has permission for projects view otherwise wont need this becuase by default this filter will be applied
                                    if(has_permission('projects','','view')){ ?>
                                        <li>
                                            <a href="#" data-cview="my_projects" onclick="dt_custom_view('','<?php echo $class; ?>',''); return false;">
                                                <?php echo _l('home_my_projects'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li class="divider"></li>
                                    <?php foreach($statuses as $status){ ?>
                                        <li class="<?php if($status['filter_default'] == true && !$this->input->get('status') || $this->input->get('status') == $status['id']){echo 'active';} ?>">
                                            <a href="#" data-cview="<?php echo 'project_status_'.$status['id']; ?>" onclick="dt_custom_view('project_status_<?php echo $status['id']; ?>','<?php echo $class; ?>','project_status_<?php echo $status['id']; ?>'); return false;">
                                                <?php echo $status['name']; ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php hooks()->apply_filters('services_filter', $class); ?>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading" />
                        </div>
                            <div class="row mbot15">
                            <div class="col-md-12">
                                <h4 class="no-margin"><?php echo _l('summary').' '.$service->name ; ?></h4>
                                <?php
                                $_where = '';
                                if(!has_permission('projects','','view')){
                                    $_where = 'id IN (SELECT '.$field.' FROM '.db_prefix().$TableStaff.' WHERE staff_id='.get_staff_user_id().')';
                                }
                                ?>
                            </div>
                            <div class="_filters _hidden_inputs">
                                <?php
                                echo form_hidden('my_projects');
                                foreach($statuses as $status){
                                    $value = $status['id'];
                                    if($status['filter_default'] == false && !$this->input->get('status')){
                                        $value = '';
                                    } else if($this->input->get('status')) {
                                        $value = ($this->input->get('status') == $status['id'] ? $status['id'] : "");
                                    }
                                    echo form_hidden('project_status_'.$status['id'],$value);
                                    ?>
                                    <div class="col-md-2 col-xs-6 border-right">
                                        <?php $where = ($_where == '' ? '' : $_where.' AND ').'status = '.$status['id']; ?>
                                        <?php $where .= ($ServID == 1 ? '' : ' AND '.db_prefix().$TableService.'.service_id = '.$ServID);
                                              $where .= (' AND '.db_prefix().$TableService.'.deleted = 0'); ?>
                                        <a href="#" onclick="dt_custom_view('project_status_<?php echo $status['id']; ?>','<?php echo $class; ?>','project_status_<?php echo $status['id']; ?>',true); return false;">
                                            <h3 class="bold"><?php echo total_rows(db_prefix().$TableService,$where); ?></h3>
                                            <span style="color:<?php echo $status['color']; ?>" project-status-<?php echo $status['id']; ?>">
                                            <?php echo $status['name']; ?>
                                            </span>
                                        </a>
                                    </div>
                                <?php } ?>
                                <?php hooks()->apply_filters('services_hidden_filter', [
                                        '_where' => $_where,
                                        'ServID' => $ServID,
                                        'TableService' => $TableService,
                                        'class' => $class
                                ]); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                            <?php
                            $table_data = array();
                            $TitleText = $ServID == 1 ? 'CaseTitle' : 'cf_translate_input_link_title';
                            $_table_data = array(
                                array(
                                    'name' => _l('the_number_sign'),
                                ),
                                array(
                                    'name' => _l($TitleText),
                                ),
                                array(
                                    'name' => _l('proposal_for_customer'),
                                ),
                                array(
                                    'name' => _l('tags'),
                                ),
                                array(
                                    'name' => _l('project_start_date'),
                                ),
                                array(
                                    'name' => _l('project_deadline'),
                                ),
                                array(
                                    'name' => _l('project_members'),
                                ),
                                array(
                                    'name' => _l('project_status'),
                                )
                            );
                            foreach($_table_data as $_t){
                                array_push($table_data,$_t);
                            }
                            $custom_fields = get_custom_fields($service->slug,array('show_on_table'=>1));
                            foreach($custom_fields as $field){
                                array_push($table_data,$field['name']);
                            }

                            $table_data = hooks()->apply_filters('services_table_columns', $table_data);
                            render_datatable($table_data,$render_class);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>

<script>
    $(function(){
        var ProjectsServerParams = {};
        $.each($('._hidden_inputs._filters input'),function(){
            ProjectsServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
        });
        initDataTable('<?php echo $class ?>', admin_url + 'Service/<?php echo $ServID ?>', undefined, undefined, ProjectsServerParams, <?php echo hooks()->apply_filters('projects_table_default_order', json_encode(array(5,'asc'))); ?>);
    });
</script>
</body>
</html>