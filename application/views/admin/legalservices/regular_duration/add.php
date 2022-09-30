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
                            <?php echo _l("new_regular_duration") ; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php echo render_input('name','name'); ?>
                        <?php echo render_input('number_of_days','number_of_days'); ?>

                        <?php
                        $company_country = get_option('company_country');
                        $this->db->where('parent_id', 0);
                        $this->db->where('country', $company_country);
                        $categories = $this->db->get(db_prefix() . 'my_categories')->result_array();

                        ?>

                        <div class="form-group">
                            <label class="control-label"><?php echo _l("categories") ; ?></label>
                            <select id="cat_id" onchange="GetSubCat()" name="categories" class="form-control custom_select_arrow">
                                <option> selected disabled </option>
                                <?php foreach($categories as $category){ ?>
                                    <option value="<?php echo $category['id']; ?>"> <?php echo $category['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo _l("sub_categories") ; ?></label>
                            <select class="form-control custom_select_arrow" id="sub_categories" name="sub_categories"
                                    placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                <option> selected disabled</option>
                            </select>
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

    function GetSubCat() {
        $('#sub_categories').html('');
        id = $('#cat_id').val();
        $.ajax({
            url: '<?php echo admin_url("ChildCategory/1/"); ?>' + id,
            success: function (data) {
                response = JSON.parse(data);
                $('#sub_categories').append('<option value=""></option>');
                $.each(response, function (key, value) {
                    $('#sub_categories').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
                });
            }
        });
    }
</script>
</body>
</html>

