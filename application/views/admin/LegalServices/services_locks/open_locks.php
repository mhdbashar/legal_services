<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php echo form_open($this->uri->uri_string(),array('id'=>'lock-form')); ?>
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <i class="fa fa-lock" aria-hidden="true"></i> <?php echo $title; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <div class="input-group">
                            <input type="password" class="form-control password" name="password" autocomplete="off">
                            <span class="input-group-addon">
                            <a href="#password" class="show_password" onclick="showPassword('password'); return false;"><i class="fa fa-eye"></i></a>
                            </span>
                        </div>
                        <button type="submit" class="btn btn-danger mtop10"><?php echo _l('open_lock'); ?> <i class="fa fa-unlock" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        _validate_form($('#lock-form'),{password:'required'});
    });
</script>
</body>
</html>