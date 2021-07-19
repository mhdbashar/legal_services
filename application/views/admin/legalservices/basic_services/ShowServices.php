<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();  ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php if (has_permission('judges_manage', '', 'create')) { ?>
                            <div class="_buttons">
                                <a href="#" data-toggle="modal" data-target="#add-services" class="btn btn-info pull-left display-block">
                                    <?php echo _l('AddLegalService'); ?>
                                </a>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                            </div>
                        <?php } ?>
                        <table class="table dt-table scroll-responsive">
                            <thead>
                            <th>#</th>
                            <th><?php echo _l('name'); ?></th>
                            <?php if (has_permission('legal_services', '', 'active')): ?>
                                <th><?php echo _l('MakePrimary'); ?></th>
                            <?php endif; ?>
                            <?php if (has_permission('legal_services', '', 'active') || has_permission('legal_services', '', 'delete') || has_permission('legal_services', '', 'categories')): ?>
                                <th><?php echo _l('options'); ?></th>
                            <?php endif; ?>
                            </thead>
                            <tbody>
                            <?php $i=1; foreach($services as $service){ ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <?php echo $service->name; ?>
                                    </td>
                                    <?php if (has_permission('legal_services', '', 'active')): ?>
                                        <td>
                                            <?php if ($service->show_on_sidebar == 1 && $service->is_module == 0): ?>
                                                <div class="onoffswitch">
                                                    <input type="checkbox" name="is_primary" class="onoffswitch-checkbox" onchange="MakePrimary(this.id)" id="<?php echo $service->id; ?>" value="<?php echo $service->is_primary; ?>" data-id="<?php echo $service->id; ?>" <?php if($service->is_primary == 1) echo "checked" ;?>>
                                                    <label class="onoffswitch-label" for="<?php echo $service->id; ?>"></label>
                                                </div>
                                            <?php else: ?>
                                                <a href="<?php echo admin_url('modules'); ?>" target="_blank"><?php echo _l('modify_module'); ?></a>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php if (has_permission('legal_services', '', 'edit') || has_permission('legal_services', '', 'delete') || has_permission('legal_services', '', 'categories')): ?>
                                        <td>
                                            <?php
                                            if ($service->show_on_sidebar == 1 && $service->is_module == 0):
                                                if (has_permission('legal_services', '', 'edit')): ?>
                                                    <a href="<?php echo admin_url("edit_service/$service->id"); ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>
                                                <?php endif; ?>
                                                <?php if (has_permission('legal_services', '', 'delete')): ?>
                                                <?php if ($service->id != 1): ?>
                                                    <a href="<?php echo admin_url("delete_service/$service->id"); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if (has_permission('legal_services', '', 'categories')): ?>
                                                <a href="<?php echo admin_url("CategoryControl/$service->id"); ?>" class="btn btn-info btn-icon">
                                                    <?php echo _l('Categories'); ?>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-services" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('AddLegalService'); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('add_service'),array('id'=>'service-form')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-center text-danger"><?php echo _l('Legalnote'); ?></h4>
                        <?php echo render_input('name','name'); ?>
                        <?php echo render_input('prefix','prefix'); ?>
                        <?php echo render_input('numbering','numbering','','number'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script type="text/javascript">
    $(function(){
        _validate_form($('#service-form'),{prefix:'required',numbering:'required',name:'required'});
    });

    function MakePrimary(id) {
        $.ajax({
            url: '<?php echo admin_url('MkPrimary'); ?>/' + id,
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