<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php echo form_open($this->uri->uri_string(),array('id'=>'category-form')); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php $value = (isset($category) ? $category->name : ''); ?>
                        <?php echo render_input('name','name',$value); ?>
                        <?php
                        $staff_language = get_staff_default_language(get_staff_user_id());
                        if($staff_language == 'arabic'){
                            $field = 'short_name_ar';
                            $field_city = 'Name_ar';
                        }else{
                            $field = 'short_name';
                            $field_city = 'Name_en';
                        }
                        ?>
                        <?php $value = (isset($category) ? $category->country : ''); ?>
                        <?php echo render_select( 'country', get_cases_countries($field),array( 'country_id',array($field)), 'lead_country',$value); ?>
                        <?php $value = (isset($category) ? $category->cat_description : ''); ?>
                        <p class="bold"><?php echo _l('category_description'); ?></p>
                        <?php echo render_textarea('cat_description', '', $value, array(), array(), '', 'tinymce'); ?>

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
        _validate_form($('#category-form'),{name:'required'});
        _validate_form($('#category-form'),{country:'required'});

    });
</script>
</body>
</html>