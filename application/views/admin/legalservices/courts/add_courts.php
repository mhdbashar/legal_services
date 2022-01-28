<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php echo form_open($this->uri->uri_string(),array('id'=>'court-form')); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
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
                        <?php echo render_select('country', get_cases_countries($field), array('country_id', array($field)), 'lead_country', get_option('company_country')); ?>
                        <div class="form-group">
                            <label class="control-label" for="city"><?php echo _l('client_city'); ?></label>
                            <?php $data = get_relation_data('build_dropdown_cities',''); ?>
                            <select id="city" name="city" class="form-control custom_select_arrow">
                                <option selected disabled></option>
                                <?php
                                if(get_option('company_city') != ''){
                                    foreach ($data as $row): ?>
                                        <option value="<?php echo $row->$field_city; ?>" <?php echo get_option('company_city') == $row->Name_en ? 'selected' : (get_option('company_city') == $row->Name_ar ? 'selected' : '') ?>><?php echo $row->$field_city; ?></option>
                                    <?php endforeach;
                                } ?>
                            </select>
                        </div>
                        <div id="cat">
                            <div class="form-group">
                                <?php
                                if(get_option('company_city') != '')
                                    $country['country'] = get_option('company_country');
                                else
                                    $country['country'] = '';?>
                                    <label for="cat_id"><?php echo _l('Categories'); ?></label>
                                <?php
                                $categories = build_dropdown_category($country);
                                $checked = '';
                                foreach($categories as $category){ ?>
                                    <div class="checkbox checkbox-primary">
                                        <input type="checkbox" id="cat_<?php echo $category['id']; ?>" name="cat_id[]" value="<?php echo $category['id']; ?>"<?php echo $checked; ?>>
                                        <label for="cat_<?php echo $category['id']; ?>"><?php echo $category['name']; ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php echo render_input('court_name','name'); ?>
                        <p class="bold"><?php echo _l('_description'); ?></p>
                        <?php echo render_textarea('court_description', '', '', array(), array(), '', 'tinymce'); ?>
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
        _validate_form($('#court-form'),{court_name:'required',country:'required',city:'required'});
    });

    $("#country").change(function () {
        $.ajax({
            url: "<?php echo admin_url('Countries/build_dropdown_cities'); ?>",
            data: {country: $(this).val()},
            type: "POST",
            success: function (data) {
                $("#city").html(data);
            }
        });
        $.ajax({
            url: "<?php echo admin_url('legalservices/Courts/build_dropdown_category_by_country'); ?>",
            data: {country: $(this).val()},
            type: "POST",
            success: function (data) {
                $("#cat").html('');
                $("#cat").html(data);
            }
        });
    });
</script>
</body>
</html>