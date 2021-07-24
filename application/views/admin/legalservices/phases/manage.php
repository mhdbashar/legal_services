<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php if (has_permission('legal_services_phases', '', 'create')) { ?>
                        <div class="_buttons">
                            <a href="<?php echo admin_url('legalservices/phases/add_edit_phase'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_phase'); ?></a>
                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading" />
                        </div>
                        <div class="clearfix"></div>
                        <?php } ?>
                        <?php
                        $active_array = '';
                        if (has_permission('legal_services_phases', '', 'active')) {
                            $active_array = array(
                                'name'=>  _l('active_phase'),
                                'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-name')
                            );
                        }
                        $table_data = array();
                        $_table_data = array(
                            array(
                                'name'=> _l('the_number_sign'),
                                'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-number')
                            ),
                            array(
                                'name'=> _l('name'),
                                'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-name')
                            ),
                            array(
                                'name'=> _l('phase_belongs_to'),
                                'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-name')
                            ),
                            $active_array
                        );
                        foreach($_table_data as $_t){
                            array_push($table_data,$_t);
                        }
                        render_datatable($table_data,'legal_services_phases');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script type="text/javascript">
    $(function(){
        initDataTable('.table-legal_services_phases', admin_url + 'legalservices/phases', undefined, undefined, 'undefined', [0, 'asc']);
    });

    function active(id) {
        $.ajax({
            url: '<?php echo admin_url('legalservices/phases/activeStatus/'); ?>/' + id,
            success: function (data) {
                if(data == 1){
                    alert_float('success', '<?php echo _l('Done'); ?>');
                }else {
                    alert_float('danger', '<?php echo _l('Faild'); ?>');
                }
            }
        });
    }
</script>
</body>
</html>
