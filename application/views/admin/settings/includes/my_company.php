<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div role="tabpanel" class="tab-pane" id="company_info">
    <p class="text-muted">
        <?php echo _l('settings_sales_company_info_note'); ?>
    </p>
    <?php echo render_input('settings[invoice_company_name]','settings_sales_company_name',get_option('invoice_company_name')); ?>
    <?php echo render_input('settings[invoice_company_address]','settings_sales_address',get_option('invoice_company_address')); ?>
    <?php //echo render_input('settings[invoice_company_city]','settings_sales_city',get_option('invoice_company_city')); ?>
    <?php //echo render_input('settings[company_state]','billing_state',get_option('company_state')); ?>
    <div class="row">
        <div class="col-md-6">
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
            <?php echo render_select('settings[company_country]', get_cases_countries($field), array('country_id', array($field)), 'clients_country', get_option('company_country'), array('onchange' => 'get_city()')); ?>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="city"><?php echo _l('clients_city'); ?></label>
                <?php $data = get_relation_data('build_dropdown_cities',''); ?>
                <select id="city" name="settings[company_city]" class="form-control custom_select_arrow">
                    <option selected disabled></option>
                    <?php foreach ($data as $row): ?>
                        <option value="<?php echo $row->$field_city; ?>" <?php echo get_option('company_city') == $row->Name_en ? 'selected' : (get_option('company_city') == $row->Name_ar ? 'selected' : '') ?>><?php echo $row->$field_city; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <?php echo render_input('settings[invoice_company_country_code]','settings_sales_bo_box',get_option('invoice_company_country_code')); ?>
    <?php echo render_input('settings[invoice_company_postal_code]','settings_sales_postal_code',get_option('invoice_company_postal_code')); ?>
    <?php echo render_input('settings[invoice_company_commercial_register]','commercial_register',get_option('invoice_company_commercial_register')); ?>
    <?php echo render_input('settings[invoice_company_phonenumber]','settings_sales_phonenumber',get_option('invoice_company_phonenumber')); ?>
    <?php echo render_input('settings[company_vat]','company_vat_number',get_option('company_vat')); ?>

    <?php echo render_input('settings[district_name]','district_name',get_option('district_name')); ?>
    <?php echo render_input('settings[building_number]','building_number',get_option('building_number')); ?>
    <?php echo render_input('settings[street_name]','street_name',get_option('street_name')); ?>
    <?php echo render_input('settings[additional_number]','additional_number',get_option('additional_number')); ?>
    <?php echo render_input('settings[unit_number]','unit_number',get_option('unit_number')); ?>
    <?php echo render_input('settings[other_number]','other_number',get_option('other_number')); ?>




    <?php echo render_custom_fields('company',0); ?>
    <hr />
    <?php echo render_textarea('settings[company_info_format]','company_info_format',clear_textarea_breaks(get_option('company_info_format')),array('rows'=>8,'style'=>'line-height:20px;')); ?>
    <p>
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{company_name}</a>
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{address}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{bo_box}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{city}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{country}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{state}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{zip_code}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{commercial_register}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{phone}</a>,


        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{district_name}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{building_number}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{street_name}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{additional_number}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{unit_number}</a>,
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{other_number}</a>,
        <?php /*        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{vat_number}</a>,*/ ?>
        <a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{vat_number}</a>
    </p>
    <?php $custom_company_fields = get_company_custom_fields();
    if(count($custom_company_fields) > 0){
        echo '<hr />';
        echo '<p class="font-medium"><b>'._l('custom_fields').'</b></p>';
        echo '<ul class="list-group">';
        foreach($custom_company_fields as $field){
            echo '<li class="list-group-item"><b>'.$field['name']. '</b>: ' . '<a href="#" class="settings-textarea-merge-field" data-to="company_info_format">{cf_'.$field['id'].'}</a></li>';
        }
        echo '</ul>';
        echo '<hr />';
    }
    ?>
</div>
