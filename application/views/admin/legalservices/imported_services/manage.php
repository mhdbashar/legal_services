<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php 

                            $TableStaff = $ServID == 1 ? 'my_members_cases' : 'my_members_services';
                            $TableService = $ServID == 1 ? 'my_cases' : 'my_imported_services';
                            $field = $ServID == 1 ? 'project_id' : 'oservice_id';
                            $class = $ServID == 1 ? '.table-cases' : '.table-my_imported_services';
                            $render_class = $ServID == 1 ? 'cases' : 'my_imported_services';

                            ?>

                            
                        </div>
                            <div class="row mbot15">
                            <div class="col-md-12">
                                <h4 class="no-margin"><?php echo _l('summary').' '._l('imported_services') ; ?></h4>
                                <hr>
                                <?php
                                $_where = '';
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
                                        <?php $where = '1 = 1'; ?>
                                        <?php

                                        $where2 = '1 = 1';

                                        if($status['id'] == 2){
                                            $where2 .= ($_where.' AND '.db_prefix().$TableService.'.imported = 1'); 
                                        }elseif($status['id'] == 3){
                                            $where2 .= ($_where.' AND '.db_prefix().$TableService.'.deleted = 1');
                                            $where2 .= ($_where.' AND '.db_prefix().$TableService.'.imported = 0');
                                            $where2 .= ($_where.' AND '.db_prefix().$TableService.'.exported_service_id = 0');
                                        }else{
                                            $where2 .= ($_where.' AND '.db_prefix().$TableService.'.deleted = 0'); 
                                        }
                                        $where .= ($_where.' AND '.db_prefix().$TableService.'.deleted = 0');
                                        

                                        ?>
                                        <a>
                                            <h3 class="bold"><?php echo total_rows(db_prefix().$TableService,$where2); ?></h3>
                                            <span style="color:<?php echo $status['color']; ?>" project-status-<?php echo $status['id']; ?>">
                                            <?php echo $status['name']; ?>
                                            </span>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if(!$this->app_modules->is_active('api') or get_option('office_name_in_center') == ''){?>
                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading" />
                            <h4 class="no-margin">
                            <a class=" text-danger" href="<?php echo site_url('admin/settings') ?>"><?php echo _l('to_make_imported_services_work_properly_please_active_api_module_from_here') ?></a></h4>
                        <?php } ?>
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
                                    'name' => _l('project_start_date'),
                                ),
                                array(
                                    'name' => _l('project_deadline'),
                                )
                            );
                            if($this->app_modules->is_active('branches')){
                                $_table_data[] = array(
                                   'name' => _l('branch_name'),
                                   'th_attrs' => array('class'=>'toggleable', 'id'=>'th-individual')
                                );
                            }
                            foreach($_table_data as $_t){
                                array_push($table_data,$_t);
                            }
                            $custom_fields = get_custom_fields($service->slug,array('show_on_table'=>1));
                            foreach($custom_fields as $field){
                                array_push($table_data,$field['name']);
                            }
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
        initDataTable('<?php echo $class ?>', window.location.href, undefined, undefined, ProjectsServerParams, <?php echo hooks()->apply_filters('projects_table_default_order', json_encode(array(1,'asc'))); ?>);
    });
</script>
</body>
</html>