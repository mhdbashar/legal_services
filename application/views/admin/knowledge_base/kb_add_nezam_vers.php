<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php $id = (isset($vers) ? $vers->id : ''); ?>
        <?php echo form_open(admin_url('knowledge_base/knowlege_nezam_vers/' . $id), array('id' => 'knowlege_nezam_vers-form')); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                        </h4>
                        <hr class="hr-panel-heading"/>
                        <div class="clearfix"></div>

                        <?php $value = (isset($vers) ? $vers->name : ''); ?>
                        <?php $attrs = (isset($vers) ? array() : array('autofocus' => true)); ?>
                        <?php echo render_input('name', 'kb_nezam_vers_name', $value, 'text', array_merge($attrs, ['required' => 'required'])); ?>
                        <?php
                        $staff_language = get_staff_default_language(get_staff_user_id());
                        if($staff_language == 'arabic'){
                            $field = 'short_name_ar';
                        }else{
                            $field = 'short_name';
                        }
                        ?>
                        <?php echo render_select('country', get_cases_countries($field), array('country_id', array($field)), 'lead_country', isset($vers) ? $vers->country : get_option('company_country')); ?>
                        <div id="nezams" class="form-group"></div>
                    </div>

                </div>
            </div>
            <?php if ((has_permission('knowledge_base', '', 'create') && !isset($vers)) || has_permission('knowledge_base', '', 'edit') && isset($vers)) { ?>
                <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
                    <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
                </div>
            <?php } ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php init_tail(); ?>
<script>
        $(function(){
        $.ajax({
            url: "<?php echo admin_url('knowledge_base/build_dropdown_nezams'); ?>",
            data: {country: $("#country").val(), vers_id :<?php echo isset($vers) ? $vers->id : 0 ?>},
            type: "POST",
            success: function (data) {
                $("#nezams").html(data);
            }
        });
        _validate_form($('#court-form'),{country:'required',name:'required'});
    });
</script>
</body>
</html>
