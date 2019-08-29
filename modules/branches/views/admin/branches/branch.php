<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                            <?php if(isset($branch)){ ?>
                            <a href="<?php echo admin_url('branches/field'); ?>" class="btn btn-success pull-right"><?php echo _l('new_branch'); ?></a>
                            <div class="clearfix"></div>
                            <?php } ?>
                        </h4>
                        <hr class="hr-panel-heading" />

                                <?php echo form_open($this->uri->uri_string()); ?>
                                <?php
                                $disable = '';
                                if(isset($branch)){
                                  if(total_rows('tblcustomfieldsvalues',array('fieldid'=>$branch->id)) > 0){
                                    $disable = 'disabled';
                                }
                            }
                            ?>

                            <?php $value = (isset($branch) ? $branch->title_en : ''); ?>
                            <?php echo render_input('title_en','branch_title_en',$value); ?>

                        <?php $value = (isset($branch) ? $branch->title_ar : ''); ?>
                        <?php echo render_input('title_ar','branch_title_ar',$value); ?>

                        <?php $value = (isset($branch) ? $branch->country_id : ''); ?>
                        <?php echo render_select('country_id',(isset($countries)?$countries:[]),['key','value'],'branch_country_id',$value); ?>

                        <?php $value = (isset($branch) ? $branch->city_id : ''); ?>
                        <?php echo render_select('city_id',(isset($city)?$city:[]),['key','value'],'branch_city_id',$value); ?>

                        <?php $value = (isset($branch) ? $branch->address : ''); ?>
                        <?php echo render_input('address','branch_address',$value); ?>

                        <?php $value = (isset($branch) ? $branch->phone : ''); ?>
                        <?php echo render_input('phone','branch_phone',$value); ?>


                            <div class="clearfix"></div>
                            <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php init_tail(); ?>
<script>
var pdf_fields = <?php echo json_encode($pdf_fields); ?>;
var client_portal_fields = <?php echo json_encode($client_portal_fields); ?>;
var client_editable_fields = <?php echo json_encode($client_editable_fields); ?>;
$(function () {
    _validate_form($('form'), {
        title_ar: 'required',
        title_en: 'required',
        city_id: 'required',
        country_id: 'required',
        address: 'required',
        phone: 'required',
    });
});
$(document).on('change','#country_id',function () {
    $.get(admin_url + 'branches/getCities/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#city_id').empty();
            $('#city_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#city_id').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#city_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});
</script>
</body>
</html>