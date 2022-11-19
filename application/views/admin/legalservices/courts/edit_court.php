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
                        <?php $form_group_class = (isset($court) && $court->is_basic == 1 ? 'hide' : ''); ?>

                        <?php $value = (isset($court) ? $court->country : ''); ?>
                        <?php echo render_select( 'country', get_cases_countries($field),array( 'country_id',array($field)), 'lead_country',$value,[],[],$form_group_class); ?>
                            <div class="form-group <?php echo $form_group_class?>">
                                <label class="control-label" for="city"><?php echo _l('client_city'); ?></label>
                                <?php $data = get_relation_data('build_dropdown_cities',''); ?>
                                <select id="city" name="city" class="form-control custom_select_arrow">
                                    <option selected disabled></option>
                                    <?php foreach ($data as $row): ?>
                                        <option value="<?php echo $row->$field_city; ?>" <?php echo $court->city == $row->Name_en ? 'selected' : ($court->city == $row->Name_ar ?  'selected' : '') ?>><?php echo $row->$field_city; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        <?php $value = (isset($court) ? $court->court_name : ''); ?>
                        <?php $input_attrs = (isset($court) && $court->is_basic == 1 ? ['readonly' => true] : []); ?>
                        <?php echo render_input('court_name','name',$value,'',$input_attrs); ?>
                        <?php $value = (isset($court) ? $court->court_description : ''); ?>
                        <p class="bold"><?php echo _l('_description'); ?></p>
                        <?php echo render_textarea('court_description', '', $value, array(), array(), '', 'tinymce'); ?>
                        <div id="cat" class="form-group"></div>
                        <div class="form-group"><h5 style="color: red"><?php echo _l('ملاحظة : يمكن ان تتأثر القضايا المرتبطة عند تعديل التصنيف'); ?></h5></div>
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
        $.ajax({
            url: "<?php echo admin_url('legalservices/Courts/build_dropdown_edit_category'); ?>",
            data: {country: $("#country").val(),c_id:<?php echo $court->c_id ?>},
            type: "POST",
            success: function (data) {
                $("#cat").html(data);
            }
        });
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