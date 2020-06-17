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
                            <?php 
                                if(get_staff_default_language() == 'arabic'){
                                    $title = 'title_ar';
                                    $value = (isset($branch) ? $branch->title_ar : '');
                                }else{
                                    $title = 'title_en';
                                    $value = (isset($branch) ? $branch->title_en : '');
                                }
                            echo render_input($title,'branch_title_en',$value); ?>

                        <!-- <?php $value = (isset($branch) ? $branch->title_ar : ''); ?>
                        <?php echo render_input('title_ar','branch_title_ar',$value); ?>

                        <?php $value = (isset($branch) ? $branch->legal_traning_name : ''); ?>
                        <?php echo render_input('legal_traning_name','legal_traning_name',$value); ?> -->

                        <?php $value = (isset($branch) ? $branch->registraion_number : ''); ?>
                        <?php echo render_input('registraion_number','registraion_number',$value); ?>

                        <?php $value = (isset($branch) ? $branch->phone : ''); ?>
                        <?php echo render_input('phone','branch_phone',$value); ?>

                        <?php $value = (isset($branch) ? $branch->branch_email : ''); ?>
                        <?php echo render_input('branch_email','branch_email',$value); ?>

                        <?php $value = (isset($branch) ? $branch->website : ''); ?>
                        <?php echo render_input('website','website',$value); ?>

                        <?php $value = (isset($branch) ? $branch->address : ''); ?>
                        <?php echo render_input('address','address',$value); ?>
                        
                        <?php $countries= my_get_all_countries();
                            $customer_default_country = get_option('customer_default_country');
                            $selected =( isset($branch) ? $branch->country_id : $customer_default_country);
                            if(get_option('active_language') == 'arabic'){
                                echo render_select( 'country_id',$countries,array( 'country_id',array( 'short_name_ar')), 'branch_country_id',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex')));
                            } else {
                                echo render_select( 'country_id',$countries,array( 'country_id',array( 'short_name')), 'branch_country_id',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex')));
                            }
                            ?>

                        <div class="form-group" app-field-wrapper="city"><label for="city" class="control-label"><?= _l('city')?></label>
                        <?php 
                            $options = ( isset($branch) ? my_get_cities($branch->country_id) : my_get_cities($customer_default_country));
                            $selected=( isset($branch) ? $branch->city_id : '');
                            echo form_dropdown('city_id', $options, $selected, ' id="city_id" class="form-control" ');
                        ?>
                        </div>

                        <!-- <?php $value = (isset($branch) ? $branch->country_id : ''); ?>
                        <?php echo render_select('country_id',(isset($countries)?$countries:[]),['key','value'],'branch_country_id',$value); ?>

                        <?php $value = (isset($branch) ? $branch->city_id : ''); ?>
                        <?php echo render_select('city_id',(isset($city)?$city:[]),['key','value'],'branch_city_id',$value); ?>

                        <?php $value = (isset($branch) ? $branch->state_province : ''); ?>
                        <?php echo render_input('state_province','state_province',$value); ?> -->

                        <?php $value = (isset($branch) ? $branch->zip_code : ''); ?>
                        <?php echo render_input('zip_code','zip_code',$value); ?>


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
        // title_en: 'required',
        city_id: 'required',
        country_id: 'required',
        address: 'required',
        phone: 'required',
    });
});

$(document).on('change','#country_id',function () {

  
        /*dropdown post *///
        $.ajax({
            url:"<?php echo admin_url('Countries/build_dropdown_cities'); ?>",
            data: {country:
            $(this).val()},
            type: "POST",
            success:function(data){
                $('#city_id').prop('disabled', false);
                $("#city_id").html(data);
            }
        });
  
});
</script>
</body>
</html>
