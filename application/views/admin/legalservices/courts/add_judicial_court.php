<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php echo form_open($this->uri->uri_string(),array('id'=>'Judicial-form')); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php echo render_input('Jud_number','NumJudicialDept',''); ?>
                        <?php echo render_input('Jud_email','_email',''); ?>
                        <p class="bold"><?php echo _l('_description'); ?></p>
                        <?php echo render_textarea('Jud_description', '', '', array(), array(), '', 'tinymce'); ?>
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
        _validate_form($('#Judicial-form'),{Jud_number:'required',Jud_email:'required'});
    });
</script>
</body>
</html>