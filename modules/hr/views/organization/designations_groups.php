<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php if (has_permission('hr', '', 'create')){ ?> <a href="#" class="btn btn-info pull-left" onclick="add()" data-toggle="modal" data-target="#add_designation_group"><?php echo _l('new_designation_group'); ?></a><?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php
                        $data = array(
                            _l('designation_group'),
                        );
                        if (has_permission('hr', '', 'edit') || has_permission('hr', '', 'delete') )
                            $data[] = _l('control');
                        render_datatable($data,'designation_group'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('organization/modals/designation_group_modal'); ?>
<?php init_tail(); ?>
<script>
    $(function(){
        initDataTable('.table-designation_group', window.location.href);
    });
</script>
</body>
</html>
