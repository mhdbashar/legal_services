<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>



<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php if (has_permission('projects', '', 'create')) { ?>
                                <?php $route = $ServID == 1 ? admin_url("Case/add/$ServID") : admin_url("SOther/add/$ServID") ?>
                                <a href="<?php echo $route; ?>" class="btn btn-info mright5 test pull-left display-block">
                                    <?php echo _l('permission_create') . ' ' . $service->name; ?>
                                </a>
                                <?php
                            }

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
                                        <a href="#" data-cview="all" onclick="dt_custom_view('', '<?php echo $class; ?>', ''); return false;">
                                            <?php echo _l('expenses_list_all'); ?>
                                        </a>
                                    </li>
                                    <?php
                                    // Only show this filter if user has permission for projects view otherwise wont need this becuase by default this filter will be applied
                                    if (has_permission('projects', '', 'view')) {
                                        ?>
                                        <li>
                                            <a href="#" data-cview="my_projects" onclick="dt_custom_view('', '<?php echo $class; ?>', ''); return false;">
                                                <?php echo _l('home_my_projects'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li class="divider"></li>
                                    <?php foreach ($statuses as $status) { ?>
                                        <li class="<?php
                                        if ($status['filter_default'] == true && !$this->input->get('status') || $this->input->get('status') == $status['id']) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <a href="#" data-cview="<?php echo 'project_status_' . $status['id']; ?>" onclick="dt_custom_view('project_status_<?php echo $status['id']; ?>', '<?php echo $class; ?>', 'project_status_<?php echo $status['id']; ?>');
                                                        return false;">
                                                   <?php echo $status['name']; ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading" />
                        </div>
                        <div class="row mbot15">
                            <div class="col-md-12">
                                <h4 class="no-margin"><?php echo _l('summary') . ' ' . $service->name; ?></h4>
                                <?php
                                $_where = '';
                                if (!has_permission('projects', '', 'view')) {
                                    $_where = 'id IN (SELECT ' . $field . ' FROM ' . db_prefix() . $TableStaff . ' WHERE staff_id=' . get_staff_user_id() . ')';
                                }
                                ?>
                            </div>
                            <div class="_filters _hidden_inputs">
                                <?php
                                echo form_hidden('my_projects');
                                foreach ($statuses as $status) {
                                    $value = $status['id'];
                                    if ($status['filter_default'] == false && !$this->input->get('status')) {
                                        $value = '';
                                    } else if ($this->input->get('status')) {
                                        $value = ($this->input->get('status') == $status['id'] ? $status['id'] : "");
                                    }
                                    echo form_hidden('project_status_' . $status['id'], $value);
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
                    if ($this->app_modules->is_active('branches')) {
                        $_table_data[] = array(
                            'name' => _l('branch_name'),
                            'th_attrs' => array('class' => 'toggleable', 'id' => 'th-individual')
                        );
                    }
                    foreach ($_table_data as $_t) {
                        array_push($table_data, $_t);
                    }
                    $custom_fields = get_custom_fields($service->slug, array('show_on_table' => 1));
                    foreach ($custom_fields as $field) {
                        array_push($table_data, $field['name']);
                    }
                    render_datatable($table_data, $render_class);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php init_tail(); ?>
<script src="<?php echo base_url('modules/api/assets/main.js'); ?>"></script>
<script>
                                            $(function () {
                                                var ProjectsServerParams = {};
                                                $.each($('._hidden_inputs._filters input'), function () {
                                                    ProjectsServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
                                                });
                                                initDataTable('<?php echo $class ?>', admin_url + 'Service/<?php echo $ServID ?>', undefined, undefined, ProjectsServerParams, <?php echo hooks()->apply_filters('projects_table_default_order', json_encode(array(5, 'asc'))); ?>);


                                            });




</script>



<div class="modal fade" id="office_name" tabindex="-1" role="dialog">
    <div class="modal-dialog">

<!--       <php $route = $ServID == 1 ? admin_url("Case/add/$ServID") : admin_url("SOther/add/$ServID") ?>  -->

        <?php
        $attributes = array('id' => 'myform');
        echo form_open(admin_url('LegalServices/Other_services_controller'), $attributes);
        ?>


        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">

                    <span class="add-title"><?php echo _l('office_name'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>

                        <?php echo render_input('office_name', 'office_name'); ?>

                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button id="close" type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('send'); ?></button>
            </div>
        </div><!-- /.modal-content -->


        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="login_details" tabindex="-1" role="dialog">
    <div class="modal-dialog">

<!--       <php $route = $ServID == 1 ? admin_url("Case/add/$ServID") : admin_url("SOther/add/$ServID") ?>  -->

        <!-- <?php
        $attributes = array('id' => 'myform');
        echo form_open(admin_url('LegalServices/Other_services_controller'), $attributes);
        ?> -->


        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">

                    <span class="add-title"><?php echo _l('login_details'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>

                        <!-- <?php echo render_input('email', 'email', '', 'text', ['readonly' => 'true', 'id' => 'email']); ?>-->
                        <div style="
                            display: flex;
                            justify-content: 'space-between';
                            align-items: 'center';
                            flex-direction: 'row';
                        "> 
                            <div style="font-size: 20px; flex: 1">
                                <?php echo _l('client_email') ?>:
                            </div>
                            <div style="font-size: 20px; flex: 1; color: #0e80bd" id="email"></div>
                        </div>
                        <div style="
                            display: flex;
                            justify-content: 'space-between';
                            align-items: 'center';
                            flex-direction: 'row';
                            margin-top: 10px
                        "> 
                            <div style="font-size: 20px; flex: 1">
                                <?php echo _l('password') ?>:
                            </div>
                            <div style="font-size: 20px; flex: 1; color: #0e80bd" id="password"></div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button id="close_login_details" type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <a href="" target="_blank" id="go" class="btn btn-info"><?php echo _l('go'); ?></a>
            </div>
        </div><!-- /.modal-content -->


        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</html>

<script>


    function office_name_other_services(x, y) {
        appValidateForm($('form'), {
            office_name: 'required',

        });
        var action = $('#myform').attr('action');


        action += '/export_service';

        $('#myform').attr('action', action + "/" + y + "/" + x);


        $('#office_name').modal('show');
        $("#close").click(function () {

            window.location.reload();

        });

    }
    function office_name(x) {

        var action_a = '';
        appValidateForm($('form'), {
            office_name: 'required',

        });

        action_a = $('#myform').attr('action');


        action_a += '/export_case';
        $('#myform').attr('action', action_a + "/" + x);


        $('#office_name').modal('show');
        $("#close").click(function () {

            window.location.reload();

        });

    }

    function login_details(email, password, url) {

        $('#email').html(email);
        $('#password').html(password);
        $('#go').attr('href', url);


        $('#login_details').modal('show');
        $("#close_login_details").click(function () {

            window.location.reload();

        });

    }
</script>