<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();  ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                            <div class="_buttons">
                                <a href="#" data-toggle="modal" data-target="#add" class="btn btn-info pull-left display-block">
                                    <?php echo _l('add_dialog_box'); ?>
                                </a>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                            </div>
                            <?php
                            $table_data = array();
                            $_table_data = array(
                                array(
                                    'name' => _l('the_number_sign'),
                                ),
                                array(
                                    'name' => _l('name'),
                                ),
                                array(
                                    'name' => _l('desc_ar'),
                                ),
                                array(
                                    'name' => _l('desc_en'),
                                ),
                                array(
                                    'name' => _l('link'),
                                ),
                                array(
                                    'name' => _l('enable'),
                                ),
                                array(
                                    'name' => '',
                                ),
                            );
                            foreach($_table_data as $_t){
                                array_push($table_data,$_t);
                            }
                            render_datatable($table_data,'my_dialog_boxes');
                            ?>
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
            <?php echo form_open(admin_url('Dialog_boxes/add'),array('id'=>'add-dialog-form')); ?>
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
        initDataTable('.table-my_dialog_boxes', admin_url + 'Dialog_boxes/table');
        _validate_form($('#add-dialog-form'),{title:'required',desc_ar:'required',desc_en:'required',page_url:'required'});
        $('#DataTables_Table_0_wrapper').removeClass('form-inline');
    });

    function active(id) {
        $.ajax({
            url: '<?php echo admin_url('dialog_boxes/active_dialog/'); ?>' + id,
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