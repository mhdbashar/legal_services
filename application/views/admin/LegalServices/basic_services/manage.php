<?php  defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php  init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php $route = $ServID == 1 ?  admin_url("Case/add/$ServID") : admin_url("SOther/add/$ServID") ?>
                            <a href="<?php echo $route; ?>" class="btn btn-info pull-left display-block">
                                <?php echo _l('permission_create').' '.$service->name; ?>
                            </a>
                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading" />
                            <div class="row mbot15">
                            <div class="col-md-12">
                                <h4 class="no-margin"><?php echo _l('summary').' '.$service->name ; ?></h4>
                                <?php
                                $_where = '';
                                if(!has_permission('projects','','view')){
                                    $_where = 'id IN (SELECT project_id FROM '.db_prefix().'my_members_cases WHERE staff_id='.get_staff_user_id().')';
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
                                        <a href="#" onclick="dt_custom_view('project_status_<?php echo $status['id']; ?>','.table-cases','project_status_<?php echo $status['id']; ?>',true); return false;">
                                            <h3 class="bold"><?php echo total_rows(db_prefix().'my_cases',$where); ?></h3>
                                            <span style="color:<?php echo $status['color']; ?>" project-status-<?php echo $status['id']; ?>">
                                            <?php echo $status['name']; ?>
                                            </span>
                                        </a>
                                    </div>
                                <?php } ?>
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
                            render_datatable($table_data,'cases');
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
        initDataTable('.table-cases', admin_url + 'Service/<?php echo $ServID ?>', undefined, undefined, 'undefined', [0, 'asc']);
    });
</script>
</body>
</html>