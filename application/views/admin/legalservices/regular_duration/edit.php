<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        <?php echo form_open($this->uri->uri_string(),array('id'=>'regular_duration-form')); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo _l("edit_regular_duration") ; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php echo render_input('name','name',$regular_duration->name); ?>
                        <?php echo render_input('number_of_days','number_of_days',$regular_duration->number_of_days); ?>
                        <div class="form-group">
                            <label for="court_id" class="control-label"><?php echo _l('Court'); ?></label>
                            <select class="selectpicker custom_select_arrow" id="court_id" onchange="GetCourtJad()" name="court_id" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                <option value="<?php if($regular_duration->court_id) echo $regular_duration->court_id ?>"> <?php  if($regular_duration->court_id) echo _l(get_court_by_id($regular_duration->court_id)->court_name); ?></option>
                                <?php $data = get_courts_by_country_city(get_option('company_country'),get_option('company_city'));
                                foreach ($data as $row): ?>
                                    <option value="<?php echo $row->c_id; ?>"><?php echo $row->court_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cat_id" class="control-label"><?php echo _l('Categories'); ?></label>
                                        <select class="form-control custom_select_arrow" id="cat_id" onchange="GetSubCat()" name="categories"
                                                placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                            <option value="<?php echo $regular_duration->categories; ?>"> <?php echo _l(get_cat_name_by_id($regular_duration->categories))  ;  ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subcat_id" class="control-label"><?php echo _l('SubCategories'); ?></label>
                                        <select class="form-control custom_select_arrow" id="subcat_id" name="sub_categories"
                                                placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                            <option value="<?php echo $regular_duration->sub_categories ?>"> <?php echo _l(get_cat_name_by_id($regular_duration->sub_categories)); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="childsubcat_id" class="control-label"><?php echo _l('child_sub_categories'); ?></label>
                                        <select class="form-control custom_select_arrow" id="childsubcat_id" name="childsubcat_id"
                                                placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                            <option value="<?php echo $regular_duration->childsubcat_id ?>"> <?php echo _l(get_cat_name_by_id($regular_duration->childsubcat_id)); ?></option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>

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
        _validate_form($('#regular_duration-form'),{name:'required',number_of_days:'required'});
    });

    function GetCourtJad() {

        $('#cat_id').empty();
        $('#subcat_id').html('');
        $('#childsubcat_id').html('');
        id = $('#court_id').val();

        $.ajax({
            url: "<?php echo admin_url('legalservices/Courts/build_dropdown_court_category'); ?>",
            data: {c_id: $("#court_id").val()},
            type: "POST",
            success: function (data) {
                $('#cat_id').append($('<option>', {
                    value: '',
                    text: '<?php echo _l('dropdown_non_selected_tex'); ?>'
                }));
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    $('#cat_id').append($('<option>', {
                        value: value['id'],
                        text: value['name']
                    }));
                });
            }
        });
    }
    function GetSubCat() {
        $('#subcat_id').html('');
        id = $('#cat_id').val();
        $.ajax({
            url: '<?php echo admin_url("ChildCategory/1/"); ?>' + id,
            success: function (data) {
                response = JSON.parse(data);
                $('#subcat_id').append('<option value=""></option>');
                $.each(response, function (key, value) {
                    $('#subcat_id').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
                    $('#subcat_id').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
                });
            }
        });

        $("#subcat_id").change(function () {
            $('#childsubcat').html('');
            id = $('#subcat_id').val();
            $.ajax({
                url: '<?php echo admin_url("ChildCategory/1/"); ?>' + id,
                success: function (data) {
                    response = JSON.parse(data);
                    if(response.length != 0) {

                        $('#childsubcat_id').append('<option value=""></option>');
                        $.each(response, function (key, value) {
                            $('#childsubcat_id').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
                        });
                    }
                    else {
                        $('#childsubcat').html('');
                    }
                }
            });
        });

    }
</script>
</body>
</html>

