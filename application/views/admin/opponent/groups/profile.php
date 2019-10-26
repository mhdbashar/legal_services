<?php  defined('BASEPATH') or exit('No direct script access allowed'); ?>
    <h4 class="customer-profile-group-heading"><?php echo _l('client_add_edit_profile'); ?></h4>
    <div class="row">
        <?php echo form_open($this->uri->uri_string(),array('class'=>'client-form','autocomplete'=>'off')); ?>
        <div class="additional"></div>
        <div class="col-md-12">
            <div class="horizontal-scrollable-tabs">
                <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                <div class="horizontal-tabs">
                    <ul class="nav nav-tabs profile-tabs row customer-profile-tabs nav-tabs-horizontal" role="tablist">
                        <li role="presentation" class="<?php if(!$this->input->get('tab')){echo 'active';}; ?>">
                            <a href="#contact_info" aria-controls="contact_info" role="tab" data-toggle="tab">
                                <?php echo _l( 'opponent_profile_details'); ?>
                            </a>
                        </li>
                        <?php
                        $customer_custom_fields = false;
                        if(total_rows(db_prefix().'customfields',array('fieldto'=>'customers','active'=>1)) > 0 ){
                            $customer_custom_fields = true;
                            ?>
                            <li role="presentation" class="<?php if($this->input->get('tab') == 'custom_fields'){echo 'active';}; ?>">
                                <a href="#custom_fields" aria-controls="custom_fields" role="tab" data-toggle="tab">
                                    <?php echo hooks()->apply_filters('customer_profile_tab_custom_fields_text', _l( 'custom_fields')); ?>
                                </a>
                            </li>
                        <?php } ?>
                        <?php hooks()->do_action('after_customer_billing_and_shipping_tab', isset($client) ? $client : false); ?>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <?php hooks()->do_action('after_custom_profile_tab_content',isset($client) ? $client : false); ?>
                <?php if($customer_custom_fields) { ?>
                    <div role="tabpanel" class="tab-pane <?php if($this->input->get('tab') == 'custom_fields'){echo ' active';}; ?>" id="custom_fields">
                        <?php $rel_id=( isset($client) ? $client->userid : false); ?>
                        <?php echo render_custom_fields( 'customers',$rel_id); ?>
                    </div>
                <?php } ?>
                <div role="tabpanel" class="tab-pane<?php if(!$this->input->get('tab')){echo ' active';}; ?>" id="contact_info">
                    <div class="row">
                        <div class="col-md-12<?php if(isset($client) && (!is_empty_customer_company($client->userid) && total_rows(db_prefix().'contacts',array('userid'=>$client->userid,'is_primary'=>1)) > 0)) { echo ''; } else {echo ' hide';} ?>" id="client-show-primary-contact-wrapper">
                            <div class="checkbox checkbox-info mbot20 no-mtop">
                                <input type="checkbox" name="show_primary_contact"<?php if(isset($client) && $client->show_primary_contact == 1){echo ' checked';}?> value="1" id="show_primary_contact">
                                <label for="show_primary_contact"><?php echo _l('show_primary_contact',_l('invoices').', '._l('estimates').', '._l('payments').', '._l('credit_notes')); ?></label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mtop10 no-mbot">
                                <p><?php echo _l('individual'); ?></p>
                                <div class="onoffswitch">
                                    <input type="hidden" name="individual" value=<?php if(isset($client)){echo $client->individual;}else{echo '0';}  ?>><input type="checkbox" id="individual" class="onoffswitch-checkbox" <?php if(isset($client)){if($client->individual == '1'){echo 'checked';}}; ?>  onclick="this.previousSibling.value=1-this.previousSibling.value" >
                                    <label class="onoffswitch-label" for="individual" data-toggle="tooltip" title="<?php echo _l('Individual or Company'); ?>"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="<?php echo _l('customer_details'); ?>"></i>
                            <?php $value=( isset($client) ? $client->company : ''); ?>
                            <?php $attrs = (isset($client) ? array() : array('autofocus'=>true)); ?>
                            <?php echo render_input( 'company', 'client_company',$value,'text',$attrs); ?>
                            <div id="company_exists_info" class="hide"></div>
                            <?php $value=( isset($client) ? $client->phonenumber : ''); ?>
                            <?php echo render_input( 'phonenumber', 'client_phonenumber',$value); ?>


                            <div class="individual_select">
                     <?php 
                     $selected = array();
                     if(isset($customer_groups)){
                       foreach($customer_groups as $group){
                          array_push($selected,$group['groupid']);
                       }
                     }
                     if(is_admin() || get_option('staff_members_create_inline_customer_groups') == '1'){
                      echo render_select_with_input_group('groups_in[]',$groups,array('id','name'),'customer_groups',$selected,'<a href="#" data-toggle="modal" data-target="#customer_group_modal"><i class="fa fa-plus"></i></a>',array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
                      } else {
                        echo render_select('groups_in[]',$groups,array('id','name'),'customer_groups',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
                      }

                     ?>
                     </div>
                     <div class="company_select">
                     <?php

                     $selected_company = array();
                     if(isset($customer_company_groups)){
                       foreach($customer_company_groups as $group2){
                          array_push($selected_company,$group2['groupid']);
                       }
                     }
                     if(is_admin() || get_option('staff_members_create_inline_customer_groups') == '1'){
                      echo render_select_with_input_group(
                        'groups_company_in[]',
                        $company_groups,
                        array('id','name'),
                        'customer_company_groups',
                        $selected_company,
                        '<a href="#" data-toggle="modal" data-target="#customer_company_group_modal"><i class="fa fa-plus"></i></a>',
                        array('multiple'=>true,'data-actions-box'=>true),
                        array(),
                        '',
                        '',
                        false
                     );
                      } else {
                        echo render_select('groups_company_in[]',$company_groups,array('id','name'),'customer_company_groups',$selected_company,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
                      }
                     ?>
                 </div>
                            <?php if(!isset($client)){ ?>
                                <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="<?php echo _l('customer_currency_change_notice'); ?>"></i>
                            <?php }
                            $s_attrs = array('data-none-selected-text'=>_l('system_default_string'));
                            $selected = '';
                            if(isset($client) && client_have_transactions($client->userid)){
                                $s_attrs['disabled'] = true;
                            }
                            foreach($currencies as $currency){
                                if(isset($client)){
                                    if($currency['id'] == $client->default_currency){
                                        $selected = $currency['id'];
                                    }
                                }
                            }
                            // Do not remove the currency field from the customer profile!
                            echo render_select('default_currency',$currencies,array('id','name','symbol'),'invoice_add_edit_currency',$selected,$s_attrs); ?>
                            <?php if(get_option('disable_language') == 0){ ?>
                                <div class="form-group select-placeholder">
                                    <label for="default_language" class="control-label"><?php echo _l('localization_default_language'); ?>
                                    </label>
                                    <select name="default_language" id="default_language" class="form-control selectpicker" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option value=""><?php echo _l('system_default_string'); ?></option>
                                        <?php foreach(list_folders(APPPATH .'language') as $language){
                                            $selected = '';
                                            if(isset($client)){
                                                if($client->default_language == $language){
                                                    $selected = 'selected';
                                                }
                                            }
                                            ?>
                                            <option value="<?php echo $language; ?>" <?php echo $selected; ?>><?php echo ucfirst($language); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">
                            <?php $value=( isset($client) ? $client->address : ''); ?>
                            <?php echo render_textarea( 'address', 'client_address',$value); ?>

                            <?php $countries= my_get_all_countries();
                            $customer_default_country = get_option('customer_default_country');
                            $selected =( isset($client) ? $client->country : $customer_default_country);
                            if(get_option('active_language') == 'arabic'){
                                echo render_select( 'country',$countries,array( 'country_id',array( 'short_name_ar')), 'clients_country',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex')));
                            } else {
                                echo render_select( 'country',$countries,array( 'country_id',array( 'short_name')), 'clients_country',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex')));
                            }
                            ?>

                            <label for="city" class="control-label">City</label>
                            <?php
                            $options = ( isset($client) ? my_get_cities($client->country) : '');
                            $selected=set_value('city')  ;

                            echo form_dropdown('city', $options, $selected, 'disabled id="city" class="form-control" ');
                            ?>
                        </div>
                        <div class="col-md-6">
                  <?php if($this->app_modules->is_active('branches')){?>
                        <br/>
                       <?php $value = (isset($branch) ? $branch : ''); ?>
                       <?php echo render_select('branch_id',(isset($branches)?$branches:[]),['key','value'],'Branch Name',$value); ?>
                   <?php } ?>
               </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="billing_and_shipping">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="no-mtop"><?php echo _l('billing_address'); ?> <a href="#" class="pull-right billing-same-as-customer"><small class="font-medium-xs"><?php echo _l('customer_billing_same_as_profile'); ?></small></a></h4>
                                    <hr />
                                    <?php $value=( isset($client) ? $client->billing_street : ''); ?>
                                    <?php echo render_textarea( 'billing_street', 'billing_street',$value); ?>
                                    <?php $value=( isset($client) ? $client->billing_city : ''); ?>
                                    <?php echo render_input( 'billing_city', 'billing_city',$value); ?>
                                    <?php $value=( isset($client) ? $client->billing_state : ''); ?>
                                    <?php echo render_input( 'billing_state', 'billing_state',$value); ?>
                                    <?php $value=( isset($client) ? $client->billing_zip : ''); ?>
                                    <?php echo render_input( 'billing_zip', 'billing_zip',$value); ?>
                                    <?php $selected=( isset($client) ? $client->billing_country : '' ); ?>
                                    <?php echo render_select( 'billing_country',$countries,array( 'country_id',array( 'short_name')), 'billing_country',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="no-mtop">
                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('customer_shipping_address_notice'); ?>"></i>
                                        <?php echo _l('shipping_address'); ?> <a href="#" class="pull-right customer-copy-billing-address"><small class="font-medium-xs"><?php echo _l('customer_billing_copy'); ?></small></a>
                                    </h4>
                                    <hr />
                                    <?php $value=( isset($client) ? $client->shipping_street : ''); ?>
                                    <?php echo render_textarea( 'shipping_street', 'shipping_street',$value); ?>
                                    <?php $value=( isset($client) ? $client->shipping_city : ''); ?>
                                    <?php echo render_input( 'shipping_city', 'shipping_city',$value); ?>
                                    <?php $value=( isset($client) ? $client->shipping_state : ''); ?>
                                    <?php echo render_input( 'shipping_state', 'shipping_state',$value); ?>
                                    <?php $value=( isset($client) ? $client->shipping_zip : ''); ?>
                                    <?php echo render_input( 'shipping_zip', 'shipping_zip',$value); ?>
                                    <?php $selected=( isset($client) ? $client->shipping_country : '' ); ?>
                                    <?php echo render_select( 'shipping_country',$countries,array( 'country_id',array( 'short_name')), 'shipping_country',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?>
                                </div>
                                <?php if(isset($client) &&
                                    (total_rows(db_prefix().'invoices',array('clientid'=>$client->userid)) > 0 || total_rows(db_prefix().'estimates',array('clientid'=>$client->userid)) > 0 || total_rows(db_prefix().'creditnotes',array('clientid'=>$client->userid)) > 0)){ ?>
                                    <div class="col-md-12">
                                        <div class="alert alert-warning">
                                            <div class="checkbox checkbox-default">
                                                <input type="checkbox" name="update_all_other_transactions" id="update_all_other_transactions">
                                                <label for="update_all_other_transactions">
                                                    <?php echo _l('customer_update_address_info_on_invoices'); ?><br />
                                                </label>
                                            </div>
                                            <b><?php echo _l('customer_update_address_info_on_invoices_help'); ?></b>
                                            <div class="checkbox checkbox-default">
                                                <input type="checkbox" name="update_credit_notes" id="update_credit_notes">
                                                <label for="update_credit_notes">
                                                    <?php echo _l('customer_profile_update_credit_notes'); ?><br />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
<?php $this->load->view('admin/opponent/client_group'); ?>
<?php $this->load->view('admin/clients/client_company_group'); ?>