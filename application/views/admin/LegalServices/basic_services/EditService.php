<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php echo form_open($this->uri->uri_string(),array('id'=>'service-form')); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php $value = (isset($service) ? $service->name : ''); ?>
                        <?php echo render_input('name','name',$value); ?>
                        <?php $value = (isset($service) ? $service->prefix : ''); ?>
                        <?php echo render_input('prefix','prefix',$value); ?>
                        <?php $value = (isset($service) ? $service->numbering : ''); ?>
                        <?php echo render_input('numbering','numbering',$value,'number'); ?>
                    </div>
                </div>
            </div>
            <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
                <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        _validate_form($('#service-form'),{prefix:'required',numbering:'required',name:'required'});
    });
</script>
</body>
</html>