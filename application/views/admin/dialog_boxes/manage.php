<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();  ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <div class="_buttons">
                                <a href="#" data-toggle="modal" data-target="#add" class="btn btn-info pull-left display-block">
                                    <?php echo _l('add_dialog_box'); ?>
                                </a>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                            </div>
                            <table class="table dt-table scroll-responsive">
                                <thead>
                                <th>#</th>
                                <th><?php echo _l('name'); ?></th>
                                <th><?php echo _l('desc_ar'); ?></th>
                                <th><?php echo _l('desc_en'); ?></th>
                                <th><?php echo _l('link'); ?></th>
                                <th><?php echo _l('disable'); ?></th>
                                <th><?php echo _l('options'); ?></th>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach($results as $row){ ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php echo $row['title']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['desc_ar']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['desc_en']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['page_url']; ?>
                                        </td>
                                        <td>
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="is_primary" class="onoffswitch-checkbox" onchange="disable(this.id)" id="<?php echo $row['id']; ?>" value="<?php echo $row['disable']; ?>" data-id="<?php echo $row['id']; ?>" <?php if($row['disable'] == 1) echo "checked" ;?>>
                                                <label class="onoffswitch-label" for="<?php echo $row['id']; ?>"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#edit<?php echo $row['id']; ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>
                                            <div class="modal fade" id="edit<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                <span class="add-title"><?php echo _l('edit_dialog_box'); ?></span>
                                                            </h4>
                                                        </div>
                                                        <?php echo form_open(admin_url('add_dialog_box'),array('id'=>'edit-dialog-form')); ?>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <?php echo render_input('title','title', $row['title']); ?>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <?php echo render_textarea('desc_ar','desc_ar', $row['desc_ar']); ?>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <?php echo render_textarea('desc_en','desc_en', $row['desc_en']); ?>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="bs_column"><span><i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('link_for_page'); ?>"></i></span> <?php echo _l('link'); ?></label>
                                                                        <?php $dir = is_rtl(true) ? 'direction: ltr' : 'direction: rtl' ?>
                                                                        <div class="input-group" style="<?php echo $dir; ?>">
                                                                            <span class="input-group-addon"><?php echo base_url(); ?></span>
                                                                            <input type="text" class="form-control" name="page_url" id="page_url" value="<?php echo $row['page_url']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                                                            <button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                                                        </div>
                                                        <?php echo form_close(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="<?php echo admin_url("delete_service/".$row['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                                        </td>
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
</div>
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('add_dialog_box'); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url('add_dialog_box'),array('id'=>'add-dialog-form')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('title','title'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_textarea('desc_ar','desc_ar'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_textarea('desc_en','desc_en'); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bs_column"><span><i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('link_for_page'); ?>"></i></span> <?php echo _l('link'); ?></label>
                            <?php $dir = is_rtl(true) ? 'direction: ltr' : 'direction: rtl' ?>
                            <div class="input-group" style="<?php echo $dir; ?>">
                                <span class="input-group-addon"><?php echo base_url(); ?></span>
                                <input type="text" class="form-control" name="page_url" id="page_url">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script type="text/javascript">
    $(function(){
        _validate_form($('#add-dialog-form'),{title:'required',desc_ar:'required',desc_en:'required',page_url:'required'});
        _validate_form($('#edit-dialog-form'),{title:'required',desc_ar:'required',desc_en:'required',page_url:'required'});
    });

    function disable(id) {
        $.ajax({
            url: '<?php echo admin_url('dialog_boxes/disable_dialog/'); ?>' + id,
            success: function (data) {
                if(data == 1){
                    alert_float('success', '<?php echo _l('Done'); ?>');
                }else {
                    alert_float('danger', '<?php echo _l('faild'); ?>');
                }
            }
        });
    }
</script>
</body>
</html>