<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * This class describes a purchase.
 */
class purchase extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_model');
        require_once module_dir_path(PURCHASE_MODULE_NAME) . '/third_party/excel/PHPExcel.php';
    }

    public function index(){
        if(is_staff_logged_in()){
            redirect(admin_url('purchase/reports'));
        }

        if(is_vendor_logged_in()){

            redirect(site_url('purchase/authentication_vendor'));
        }
    }

    /**
     * { vendors }
     */
    public function vendors(){
    	
        $data['title']          = _l('vendor');
        $this->load->model('LegalServices/LegalServicesModel', 'legal');
        $this->load->model('LegalServices/Cases_model', 'case');
        $data['legal_services'] = $this->legal->get_all_services();
        var_dump($data['legal_services']); exit();

        $this->load->view('vendors/manage', $data);
    }

    /**
     * { table vendor }
     */
    public function table_vendor()
    {

        $this->app->get_table_data(module_views_path('purchase', 'vendors/table_vendor'));
    }

    /**
     * { vendor }
     *
     * @param      string  $id     The vendor
     * @return      view
     */
    public function vendor($id = '')
    {
        
        if ($this->input->post() && !$this->input->is_ajax_request()) {
            if ($id == '') {
                

                $data = $this->input->post();

                $save_and_add_contact = false;
                if (isset($data['save_and_add_contact'])) {
                    unset($data['save_and_add_contact']);
                    $save_and_add_contact = true;
                }
                $id = $this->purchase_model->add_vendor($data);
                if (!has_permission('purchase', '', 'view')) {
                    $assign['customer_admins']   = [];
                    $assign['customer_admins'][] = get_staff_user_id();
                    $this->purchase_model->assign_vendor_admins($assign, $id);
                }
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('vendor')));
                    if ($save_and_add_contact == false) {
                        redirect(admin_url('purchase/vendor/' . $id));
                    } else {
                        redirect(admin_url('purchase/vendor/' . $id . '?group=contacts&new_contact=true'));
                    }
                }
            } else {
                
                $success = $this->purchase_model->update_vendor($this->input->post(), $id);
                if ($success == true) {
                    set_alert('success', _l('updated_successfully', _l('vendor')));
                }
                redirect(admin_url('purchase/vendor/' . $id));
            }
        }

        $group         = !$this->input->get('group') ? 'profile' : $this->input->get('group');
        $data['group'] = $group;

        if ($group != 'contacts' && $contact_id = $this->input->get('contactid')) {
            redirect(admin_url('clients/client/' . $id . '?group=contacts&contactid=' . $contact_id));
        }

        
        

        if ($id == '') {
            $title = _l('add_new', _l('vendor_lowercase'));
        } else {
            $client                = $this->purchase_model->get_vendor($id);
            $data['customer_tabs'] = get_customer_profile_tabs();

            if (!$client) {
                show_404();
            }

            $data['contacts'] = $this->purchase_model->get_contacts($id);
            
            $data['payments'] = $this->purchase_model->get_payment_by_vendor($id);

            $data['group'] = $this->input->get('group');

	        $data['title']                 = _l('setting');
	        $data['tab'][] = ['name' => 'profile', 'icon' => '<i class="fa fa-user-circle menu-icon"></i>'];
	        $data['tab'][] = ['name' => 'contacts','icon' => '<i class="fa fa-users menu-icon"></i>'];
            $data['tab'][] = ['name' => 'contracts', 'icon' => '<i class="fa fa-file-text-o menu-icon"></i>'];
            $data['tab'][] = ['name' => 'purchase_order', 'icon' => '<i class="fa fa-cart-plus menu-icon"></i>'];
            $data['tab'][] = ['name' => 'payments', 'icon' => '<i class="fa fa-usd menu-icon"></i>']; 
            $data['tab'][] = ['name' => 'expenses', 'icon' => '<i class="fa fa-money menu-icon"></i>']; 
            $data['tab'][] = ['name' => 'notes', 'icon' => '<i class="fa fa-sticky-note-o menu-icon"></i>'];
            $data['tab'][] = ['name' => 'attachments', 'icon' => '<i class="fa fa-paperclip menu-icon"></i>'];
	        
	        if($data['group'] == ''){
	            $data['group'] = 'profile';
	        }
	        $data['tabs']['view'] = 'vendors/groups/'.$data['group'];
            // Fetch data based on groups
            if ($data['group'] == 'profile') {
               $data['customer_admins'] = $this->purchase_model->get_vendor_admins($id);
            }  elseif ($group == 'estimates') {
                $this->load->model('estimates_model');
                $data['estimate_statuses'] = $this->estimates_model->get_statuses();
            } elseif ($group == 'notes') {
               
                $data['user_notes'] = $this->misc_model->get_notes($id, 'pur_vendor');
            } elseif ($group == 'payments') {
                $this->load->model('payment_modes_model');
                $data['payment_modes'] = $this->payment_modes_model->get();
            } elseif ($group == 'attachments') {
                $data['attachments'] = get_all_pur_vendor_attachments($id);
            } elseif ($group == 'expenses') {
                $this->load->model('expenses_model');
                $data['expenses'] = $this->expenses_model->get('', [ 'vendor' =>  $id ]);
            }

            $data['staff'] = $this->staff_model->get('', ['active' => 1]);

            $data['client'] = $client;
            $title          = $client->company;

            // Get all active staff members (used to add reminder)
            $data['members'] = $data['staff'];

            if (!empty($data['client']->company)) {
                // Check if is realy empty client company so we can set this field to empty
                // The query where fetch the client auto populate firstname and lastname if company is empty
                if (is_empty_vendor_company($data['client']->userid)) {
                    $data['client']->company = '';
                }
            }
        }

        $this->load->model('currencies_model');
        $data['currencies'] = $this->currencies_model->get();

        if ($id != '') {
            $customer_currency = $data['client']->default_currency;

            foreach ($data['currencies'] as $currency) {
                if ($customer_currency != 0) {
                    if ($currency['id'] == $customer_currency) {
                        $customer_currency = $currency;

                        break;
                    }
                } else {
                    if ($currency['isdefault'] == 1) {
                        $customer_currency = $currency;

                        break;
                    }
                }
            }

            if (is_array($customer_currency)) {
                $customer_currency = (object) $customer_currency;
            }

            $data['customer_currency'] = $customer_currency;

            
        }

        $data['bodyclass'] = 'customer-profile dynamic-create-groups';
        $data['vendor_categories'] = $this->purchase_model->get_vendor_category();
        $data['title']     = $title;

        $this->load->view('vendors/vendor', $data);
    }

    /**
     * { setting }
     */
    public function setting(){
    	if (!has_permission('purchase', '', 'edit') && !is_admin()) {
            access_denied('purchase');
        }
        $data['group'] = $this->input->get('group');

        $data['title']                 = _l('setting');
       
		$this->db->where('module_name','warehouse');
        $module = $this->db->get(db_prefix().'modules')->row();
        $data['tab'][] = 'purchase_order_setting';
        $data['tab'][] = 'units';
        $data['tab'][] = 'approval';
        $data['tab'][] = 'commodity_group';
        $data['tab'][] = 'sub_group';
        $data['tab'][] = 'vendor_category';
        if($data['group'] == ''){
            $data['group'] = 'purchase_order_setting';
        }else if($data['group'] == 'units'){
            $data['unit_types'] = $this->purchase_model->get_unit_type();
        }
        $data['tabs']['view'] = 'includes/'.$data['group'];
        $data['commodity_group_types'] = $this->purchase_model->get_commodity_group_type();
        $data['sub_groups'] = $this->purchase_model->get_sub_group();
        $data['item_group'] = $this->purchase_model->get_item_group();
        $data['approval_setting'] = $this->purchase_model->get_approval_setting();
        $data['vendor_categories'] = $this->purchase_model->get_vendor_category();
        $data['staffs'] = $this->staff_model->get(); 
        
        $this->load->view('manage_setting', $data);
    }
    
    /**
     * { assign vendor admins }
     *
     * @param      string  $id     The identifier
     * @return      redirect
     */
    public function assign_vendor_admins($id)
    {
        if (!has_permission('purchase', '', 'create') && !has_permission('purchase', '', 'edit')) {
            access_denied('vendors');
        }
        $success = $this->purchase_model->assign_vendor_admins($this->input->post(), $id);
        if ($success == true) {
            set_alert('success', _l('updated_successfully', _l('vendor')));
        }

        redirect(admin_url('purchase/vendor/' . $id . '?tab=vendor_admins'));
    }

    /**
     * { delete vendor }
     *
     * @param      <type>  $id     The identifier
     * @return      redirect
     */
   	public function delete_vendor($id){
   		if (!has_permission('purchase', '', 'delete')) {
            access_denied('vendors');
        }
        if (!$id) {
            redirect(admin_url('purchase/vendors'));
        }
        $response = $this->purchase_model->delete_vendor($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('customer_delete_transactions_warning', _l('invoices') . ', ' . _l('estimates') . ', ' . _l('credit_notes')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('client')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('client_lowercase')));
        }
        redirect(admin_url('purchase/vendors'));
   	}

    /**
     * { form contact }
     *
     * @param      <type>  $customer_id  The customer identifier
     * @param      string  $contact_id   The contact identifier
     */
   	public function form_contact($customer_id, $contact_id = '')
    {
        if (!has_permission('purchase', '', 'view')) {
            if (!is_customer_admin($customer_id)) {
                echo _l('access_denied');
                die;
            }
        }
        $data['customer_id'] = $customer_id;
        $data['contactid']   = $contact_id;
        if ($this->input->post()) {
            $data             = $this->input->post();
            $data['password'] = $this->input->post('password', false);

            unset($data['contactid']);
            if ($contact_id == '') {
                if (!has_permission('customers', '', 'create')) {
                    if (!is_customer_admin($customer_id)) {
                        header('HTTP/1.0 400 Bad error');
                        echo json_encode([
                            'success' => false,
                            'message' => _l('access_denied'),
                        ]);
                        die;
                    }
                }
                $id      = $this->purchase_model->add_contact($data, $customer_id);
                $message = '';
                $success = false;
                if ($id) {
                   
                    $success = true;
                    $message = _l('added_successfully', _l('contact'));
                }
                echo json_encode([
                    'success'             => $success,
                    'message'             => $message,
                    'has_primary_contact' => (total_rows(db_prefix().'contacts', ['userid' => $customer_id, 'is_primary' => 1]) > 0 ? true : false),
                    'is_individual'       => is_empty_customer_company($customer_id) && total_rows(db_prefix().'pur_contacts', ['userid' => $customer_id]) == 1,
                ]);
                die;
            }
            if (!has_permission('customers', '', 'edit')) {
                if (!is_customer_admin($customer_id)) {
                    header('HTTP/1.0 400 Bad error');
                    echo json_encode([
                            'success' => false,
                            'message' => _l('access_denied'),
                        ]);
                    die;
                }
            }
            $original_contact = $this->purchase_model->get_contact($contact_id);
            $success          = $this->purchase_model->update_contact($data, $contact_id);
            $message          = '';
            $proposal_warning = false;
            $original_email   = '';
            $updated          = false;
            if (is_array($success)) {
                if (isset($success['set_password_email_sent'])) {
                    $message = _l('set_password_email_sent_to_client');
                } elseif (isset($success['set_password_email_sent_and_profile_updated'])) {
                    $updated = true;
                    $message = _l('set_password_email_sent_to_client_and_profile_updated');
                }
            } else {
                if ($success == true) {
                    $updated = true;
                    $message = _l('updated_successfully', _l('contact'));
                }
            }
            if (handle_contact_profile_image_upload($contact_id) && !$updated) {
                $message = _l('updated_successfully', _l('contact'));
                $success = true;
            }
            if ($updated == true) {
                $contact = $this->purchase_model->get_contact($contact_id);
                if (total_rows(db_prefix().'proposals', [
                        'rel_type' => 'customer',
                        'rel_id' => $contact->userid,
                        'email' => $original_contact->email,
                    ]) > 0 && ($original_contact->email != $contact->email)) {
                    $proposal_warning = true;
                    $original_email   = $original_contact->email;
                }
            }
            echo json_encode([
                    'success'             => $success,
                    'proposal_warning'    => $proposal_warning,
                    'message'             => $message,
                    'original_email'      => $original_email,
                    'has_primary_contact' => (total_rows(db_prefix().'contacts', ['userid' => $customer_id, 'is_primary' => 1]) > 0 ? true : false),
                ]);
            die;
        }
        if ($contact_id == '') {
            $title = _l('add_new', _l('contact_lowercase'));
        } else {
            $data['contact'] = $this->purchase_model->get_contact($contact_id);

            if (!$data['contact']) {
                header('HTTP/1.0 400 Bad error');
                echo json_encode([
                    'success' => false,
                    'message' => 'Contact Not Found',
                ]);
                die;
            }
            $title = $data['contact']->firstname . ' ' . $data['contact']->lastname;
        }

        
        $data['title']                = $title;
        $this->load->view('vendors/modals/contact', $data);
    }

    /**
     * { vendor contacts }
     *
     * @param      <type>  $client_id  The client identifier
     */
    public function vendor_contacts($client_id)
    {
        $this->app->get_table_data(module_views_path('purchase', 'vendors/table_contacts'), [
            'client_id' => $client_id,
        ]);
    }

    /**
     * Determines if contact email exists.
     */
    public function contact_email_exists()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                // First we need to check if the email is the same
                $userid = $this->input->post('userid');
                if ($userid != '') {
                    $this->db->where('id', $userid);
                    $_current_email = $this->db->get(db_prefix() . 'pur_contacts')->row();
                    if ($_current_email->email == $this->input->post('email')) {
                        echo json_encode(true);
                        die();
                    }
                }
                $this->db->where('email', $this->input->post('email'));
                $total_rows = $this->db->count_all_results(db_prefix() . 'pur_contacts');
                if ($total_rows > 0) {
                    echo json_encode(false);
                } else {
                    echo json_encode(true);
                }
                die();
            }
        }
    }

    /**
     * { delete vendor contact }
     *
     * @param      string  $customer_id  The customer identifier
     * @param      <type>  $id           The identifier
     * @return     redirect
     */
    public function delete_vendor_contact($customer_id, $id)
    {
        if (!has_permission('purchase', '', 'delete')) {
            if (!is_customer_admin($customer_id)) {
                access_denied('vendors');
            }
        }

        $this->purchase_model->delete_contact($id);
        
        redirect(admin_url('purchase/vendor/' . $customer_id . '?group=contacts'));
    }


    /**
     * { all contacts }
     * @return     view
     */
    public function all_contacts()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('purchase', 'vendors/table_all_contacts'));
        }

        if (is_gdpr() && get_option('gdpr_enable_consent_for_contacts') == '1') {
            $this->load->model('gdpr_model');
            $data['consent_purposes'] = $this->gdpr_model->get_consent_purposes();
        }

        $data['title'] = _l('customer_contacts');
        $this->load->view('vendors/all_contacts', $data);
    }

    /**
     * { purchase request }
     * @return     view
     */
    public function purchase_request(){
    	$data['title'] = _l('purchase_request');
        $data['vendors'] = $this->purchase_model->get_vendor();
        $this->load->view('purchase_request/manage', $data);
    }

    /**
     * { add update purchase request }
     *
     * @param      string  $id     The identifier
     * @return    redirect, view
     */
    public function pur_request($id = ''){
    	$this->load->model('departments_model');
        $this->load->model('staff_model');
        $this->load->model('projects_model');
    	if($id == ''){
    		
    		if($this->input->post()){
    			$add_data = $this->input->post();
    			$id = $this->purchase_model->add_pur_request($add_data);
    			if($id){
    				set_alert('success',_l('added_pur_request'));
    			}
    			redirect(admin_url('purchase/purchase_request'));
    		}

    		$data['title'] = _l('add_new');
    	}else{
    		if($this->input->post()){
    			$edit_data = $this->input->post();
    			$success = $this->purchase_model->update_pur_request($edit_data,$id);
    			if($success == true){
    				set_alert('success',_l('updated_pur_request'));
    			}
    			redirect(admin_url('purchase/purchase_request'));
    		}

    		$data['pur_request_detail'] = json_encode($this->purchase_model->get_pur_request_detail($id));
    		$data['pur_request'] = $this->purchase_model->get_purchase_request($id);
    		$data['title'] = _l('edit');
    	}

        $data['projects'] = $this->projects_model->get();
        $data['staffs'] = $this->staff_model->get();
    	$data['departments'] = $this->departments_model->get();
    	$data['units'] = $this->purchase_model->get_units();
    	$data['items'] = $this->purchase_model->get_items();
    	
        $this->load->view('purchase_request/pur_request', $data);
    }

    /**
     * { view pur request }
     *
     * @param      <type>  $id     The identifier
     * @return view
     */
    public function view_pur_request($id){
    	$this->load->model('departments_model');

        $send_mail_approve = $this->session->userdata("send_mail_approve");
        if((isset($send_mail_approve)) && $send_mail_approve != ''){
            $data['send_mail_approve'] = $send_mail_approve;
            $this->session->unset_userdata("send_mail_approve");
        }
    	$data['pur_request_detail'] = json_encode($this->purchase_model->get_pur_request_detail($id));
		$data['pur_request'] = $this->purchase_model->get_purchase_request($id);
		$data['title'] = $data['pur_request']->pur_rq_name;
		$data['departments'] = $this->departments_model->get();
    	$data['units'] = $this->purchase_model->get_units();
    	$data['items'] = $this->purchase_model->get_items();
    	
        $data['check_appr'] = $this->purchase_model->get_approve_setting('pur_request');
        $data['get_staff_sign'] = $this->purchase_model->get_staff_sign($id,'pur_request');
        $data['check_approve_status'] = $this->purchase_model->check_approval_details($id,'pur_request');
        $data['list_approve_status'] = $this->purchase_model->get_list_approval_details($id,'pur_request');

        $this->load->view('purchase_request/view_pur_request', $data);

    }

    /**
     * { approval setting }
     * @return redirect
     */
    public function approval_setting()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($data['approval_setting_id'] == '') {
                $message = '';
                $success = $this->purchase_model->add_approval_setting($data);
                if ($success) {
                    $message = _l('added_successfully', _l('approval_setting'));
                }
                set_alert('success', $message);
                redirect(admin_url('purchase/setting?group=approval'));
            } else {
                $message = '';
                $id = $data['approval_setting_id'];
                $success = $this->purchase_model->edit_approval_setting($id, $data);
                if ($success) {
                    $message = _l('updated_successfully', _l('approval_setting'));
                }
                set_alert('success', $message);
                redirect(admin_url('purchase/setting?group=approval'));
            }
        }
    }

    /**
     * { delete approval setting }
     *
     * @param      <type>  $id     The identifier
     * @return redirect
     */
    public function delete_approval_setting($id)
    {
        if (!$id) {
            redirect(admin_url('purchase/setting?group=approval'));
        }
        $response = $this->purchase_model->delete_approval_setting($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('approval_setting')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('approval_setting')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('approval_setting')));
        }
        redirect(admin_url('purchase/setting?group=approval'));
    }

    /**
     * { items change event}
     *
     * @param      <type>  $val    The value
     * @return      json
     */
    public function items_change($val){

        $value = $this->purchase_model->items_change($val);
        
        echo json_encode([
            'value' => $value
        ]);
        die;
    }

    /**
     * { table pur request }
     */
    public function table_pur_request(){
    	 $this->app->get_table_data(module_views_path('purchase', 'purchase_request/table_pur_request'));
    }

    /**
     * { delete pur request }
     *
     * @param      <type>  $id     The identifier
     * @return     redirect
     */
    public function delete_pur_request($id){
    	if (!$id) {
            redirect(admin_url('purchase/purchase_request'));
        }
        $response = $this->purchase_model->delete_pur_request($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('purchase_request')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('purchase_request')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('purchase_request')));
        }
        redirect(admin_url('purchase/purchase_request'));
    }

    /**
     * { change status pur request }
     *
     * @param      <type>  $status  The status
     * @param      <type>  $id      The identifier
     * @return     json
     */
    public function change_status_pur_request($status,$id){
    	$change = $this->purchase_model->change_status_pur_request($status,$id);
        if($change == true){
            
            $message = _l('change_status_pur_request').' '._l('successfully');
            echo json_encode([
                'result' => $message,
            ]);
        }else{
            $message = _l('change_status_pur_request').' '._l('fail');
            echo json_encode([
                'result' => $message,
            ]);
        }
    }

    /**
     * { quotations }
     *
     * @param      string  $id     The identifier
     * @return     view
     */
    public function quotations($id = ''){
    	if (!has_permission('purchase', '', 'view') && !has_permission('purchase', '', 'view_own')) {
            access_denied('quotations');
        }

            // Pipeline was initiated but user click from home page and need to show table only to filter
        if ($this->input->get('status') || $this->input->get('filter') && $isPipeline) {
            $this->pipeline(0, true);
        }

        $data['estimateid']            = $id;
        $data['pur_request'] = $this->purchase_model->get_purchase_request();
        $data['vendors'] = $this->purchase_model->get_vendor();
        $data['title']                 = _l('estimates');
        $data['bodyclass']             = 'estimates-total-manual';
        
        $this->load->view('quotations/manage', $data);
    
    }

    /**
     * { function_description }
     *
     * @param      string  $id     The identifier
     * @return     redirect
     */
    public function estimate($id = '')
    {
        if ($this->input->post()) {
            $estimate_data = $this->input->post();
            $estimate_data['terms'] = nl2br($estimate_data['terms']);
            if ($id == '') {
                if (!has_permission('purchase', '', 'create')) {
                    access_denied('quotations');
                }
                $id = $this->purchase_model->add_estimate($estimate_data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('estimate')));
                    
                    redirect(admin_url('purchase/quotations/' . $id));
                    
                }
            } else {
                if (!has_permission('purchase', '', 'edit')) {
                    access_denied('quotations');
                }
                $success = $this->purchase_model->update_estimate($estimate_data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('estimate')));
                }
                redirect(admin_url('purchase/quotations/' . $id));
                
            }
        }
        if ($id == '') {
            $title = _l('create_new_estimate');
        } else {
            $estimate = $this->purchase_model->get_estimate($id);


            $data['estimate_detail'] = json_encode($this->purchase_model->get_pur_estimate_detail($id));
            $data['estimate'] = $estimate;
            $data['edit']     = true;
            $title            = _l('edit', _l('estimate_lowercase'));
        }
        if ($this->input->get('customer_id')) {
            $data['customer_id'] = $this->input->get('customer_id');
        }
        $this->load->model('taxes_model');
        $data['taxes'] = $this->purchase_model->get_taxes();
        $this->load->model('currencies_model');
        $data['currencies'] = $this->currencies_model->get();

        $data['base_currency'] = $this->currencies_model->get_base_currency();

        $this->load->model('invoice_items_model');

        $data['ajaxItems'] = false;
        if (total_rows(db_prefix().'items') <= ajax_on_total_items()) {
            $data['items'] = $this->invoice_items_model->get_grouped();
        } else {
            $data['items']     = [];
            $data['ajaxItems'] = true;
        }
        $data['items_groups'] = $this->invoice_items_model->get_groups();

        $data['staff']             = $this->staff_model->get('', ['active' => 1]);
        $data['vendors'] = $this->purchase_model->get_vendor();
        $data['pur_request'] = $this->purchase_model->get_pur_request_by_status(2);
        $data['units'] = $this->purchase_model->get_units();
        $data['items'] = $this->purchase_model->get_items();
        $data['title']             = $title;
        $this->load->view('quotations/estimate', $data);
    }

    /**
     * { validate estimate number }
     */
    public function validate_estimate_number()
    {
        $isedit          = $this->input->post('isedit');
        $number          = $this->input->post('number');
        $date            = $this->input->post('date');
        $original_number = $this->input->post('original_number');
        $number          = trim($number);
        $number          = ltrim($number, '0');

        if ($isedit == 'true') {
            if ($number == $original_number) {
                echo json_encode(true);
                die;
            }
        }

        if (total_rows(db_prefix().'pur_estimates', [
            'YEAR(date)' => date('Y', strtotime(to_sql_date($date))),
            'number' => $number,
        ]) > 0) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /**
     * { table estimates }
     */
    public function table_estimates(){
        $this->app->get_table_data(module_views_path('purchase', 'quotations/table_estimates'));
    }

    /**
     * Gets the estimate data ajax.
     *
     * @param      <type>   $id         The identifier
     * @param      boolean  $to_return  To return
     *
     * @return     <type>   view.
     */
    public function get_estimate_data_ajax($id, $to_return = false)
    {
        if (!has_permission('purchase', '', 'view') && !has_permission('purchase', '', 'view_own')) {
            echo _l('access_denied');
            die;
        }

        if (!$id) {
            die('No estimate found');
        }

        $estimate = $this->purchase_model->get_estimate($id);

        $estimate->date       = _d($estimate->date);
        $estimate->expirydate = _d($estimate->expirydate);
    

        if ($estimate->sent == 0) {
            $template_name = 'estimate_send_to_customer';
        } else {
            $template_name = 'estimate_send_to_customer_already_sent';
        }

        $data['pur_estimate_attachments'] = $this->purchase_model->get_purchase_estimate_attachments($id);
        $data['estimate_detail'] = $this->purchase_model->get_pur_estimate_detail($id);
        $data['estimate']          = $estimate;
        $data['members']           = $this->staff_model->get('', ['active' => 1]);
        
        $send_mail_approve = $this->session->userdata("send_mail_approve");
        if((isset($send_mail_approve)) && $send_mail_approve != ''){
            $data['send_mail_approve'] = $send_mail_approve;
            $this->session->unset_userdata("send_mail_approve");
        }
        $data['check_appr'] = $this->purchase_model->get_approve_setting('pur_quotation');
        $data['get_staff_sign'] = $this->purchase_model->get_staff_sign($id,'pur_quotation');
        $data['check_approve_status'] = $this->purchase_model->check_approval_details($id,'pur_quotation');
        $data['list_approve_status'] = $this->purchase_model->get_list_approval_details($id,'pur_quotation');
        
        if ($to_return == false) {
            $this->load->view('quotations/estimate_preview_template', $data);
        } else {
            return $this->load->view('quotations/estimate_preview_template', $data, true);
        }
    }

    /**
     * { delete estimate }
     *
     * @param      <type>  $id     The identifier
     * @return     redirect
     */
    public function delete_estimate($id)
    {
        if (!has_permission('purchase', '', 'delete')) {
            access_denied('estimates');
        }
        if (!$id) {
            redirect(admin_url('purchase/quotations'));
        }
        $success = $this->purchase_model->delete_estimate($id);
        if (is_array($success)) {
            set_alert('warning', _l('is_invoiced_estimate_delete_error'));
        } elseif ($success == true) {
            set_alert('success', _l('deleted', _l('estimate')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('estimate_lowercase')));
        }
        redirect(admin_url('purchase/quotations'));
    }

    /**
     * { tax change event }
     *
     * @param      <type>  $tax    The tax
     * @return   json
     */
    public function tax_change($tax){
        $taxes = explode('%7C', $tax);
        $total_tax = $this->purchase_model->get_total_tax($taxes);
        
        echo json_encode([
            'total_tax' => $total_tax,
        ]);
    }

    /**
     * { coppy pur request }
     *
     * @param      <type>  $pur_request  The purchase request id
     * @return json
     */
    public function coppy_pur_request($pur_request){
        $pur_request_detail = $this->purchase_model->get_pur_request_detail_in_estimate($pur_request);
        echo json_encode([
            'result' => $pur_request_detail,
        ]);
    }

    /**
     * { coppy pur estimate }
     *
     * @param      <type>  $pur_estimate  The purchase estimate id
     * @return  json
     */
    public function coppy_pur_estimate($pur_estimate){
        $pur_estimate_detail = $this->purchase_model->get_pur_estimate_detail_in_order($pur_estimate);
        $pur_estimate = $this->purchase_model->get_estimate($pur_estimate);
        echo json_encode([
            'result' => $pur_estimate_detail,
            'dc_percent' => $pur_estimate->discount_percent,
            'dc_total' => $pur_estimate->discount_total,
        ]);
    }

    /**
     * { view purchase order }
     *
     * @param      <type>  $pur_order  The purchase order id
     * @return json
     */
    public function view_pur_order($pur_order){
        $pur_order_detail = $this->purchase_model->get_pur_order_detail($pur_order);
        $pur_order = $this->purchase_model->get_pur_order($pur_order);
        
        echo json_encode([
            'total' => app_format_money($pur_order->total,''),
            'vendor' => $pur_order->vendor,
            'buyer' => $pur_order->buyer,
        ]);
    }

    /**
     * { change status pur estimate }
     *
     * @param      <type>  $status  The status
     * @param      <type>  $id      The identifier
     * @return json
     */
    public function change_status_pur_estimate($status,$id){
        $change = $this->purchase_model->change_status_pur_estimate($status,$id);
        if($change == true){
            
            $message = _l('change_status_pur_estimate').' '._l('successfully');
            echo json_encode([
                'result' => $message,
            ]);
        }else{
            $message = _l('change_status_pur_estimate').' '._l('fail');
            echo json_encode([
                'result' => $message,
            ]);
        }
    }

    /**
     * { change status pur order }
     *
     * @param      <type>  $status  The status
     * @param      <type>  $id      The identifier
     * @return json
     */
    public function change_status_pur_order($status,$id){
        $change = $this->purchase_model->change_status_pur_order($status,$id);
        if($change == true){
            
            $message = _l('change_status_pur_order').' '._l('successfully');
            echo json_encode([
                'result' => $message,
            ]);
        }else{
            $message = _l('change_status_pur_order').' '._l('fail');
            echo json_encode([
                'result' => $message,
            ]);
        }
    }

    /**
     * { purchase order }
     *
     * @param      string  $id     The identifier
     * @return view
     */
    public function purchase_order($id = ''){
        $this->load->model('expenses_model');
        $this->load->model('payment_modes_model');
        $this->load->model('taxes_model');
        $this->load->model('currencies_model');
        $this->load->model('departments_model');
        $this->load->model('projects_model');

        $data['pur_orderid']            = $id;
        $data['title'] = _l('purchase_order');

        $data['departments'] = $this->departments_model->get();
        $data['projects'] = $this->projects_model->get();
        $data['currency'] = $this->currencies_model->get_base_currency();
        $data['payment_modes'] = $this->payment_modes_model->get('', [], true);
        $data['currencies']         = $this->currencies_model->get();
        $data['taxes']              = $this->taxes_model->get();
        $data['vendors'] = $this->purchase_model->get_vendor();
        $data['expense_categories'] = $this->expenses_model->get_category();
        $data['item_tags'] = $this->purchase_model->get_item_tag_filter();
        
        $this->load->view('purchase_order/manage', $data);
    }

    /**
     * Gets the pur order data ajax.
     *
     * @param      <type>   $id         The identifier
     * @param      boolean  $to_return  To return
     *
     * @return     view.
     */
    public function get_pur_order_data_ajax($id, $to_return = false)
    {
        if (!has_permission('purchase', '', 'view') && !has_permission('purchase', '', 'view_own')) {
            echo _l('access_denied');
            die;
        }

        if (!$id) {
            die('No purchase order found');
        }

        $estimate = $this->purchase_model->get_pur_order($id);

        $this->load->model('payment_modes_model');
        $data['payment_modes'] = $this->payment_modes_model->get('', [
            'expenses_only !=' => 1,
        ]);

        $data['payment'] = $this->purchase_model->get_payment_purchase_order($id);
        $data['pur_order_attachments'] = $this->purchase_model->get_purchase_order_attachments($id);
        $data['estimate_detail'] = $this->purchase_model->get_pur_order_detail($id);
        $data['estimate']          = $estimate;
        $data['members']           = $this->staff_model->get('', ['active' => 1]);

        $send_mail_approve = $this->session->userdata("send_mail_approve");
        if((isset($send_mail_approve)) && $send_mail_approve != ''){
            $data['send_mail_approve'] = $send_mail_approve;
            $this->session->unset_userdata("send_mail_approve");
        }
        $data['check_appr'] = $this->purchase_model->get_approve_setting('pur_order');
        $data['get_staff_sign'] = $this->purchase_model->get_staff_sign($id,'pur_order');
        $data['check_approve_status'] = $this->purchase_model->check_approval_details($id,'pur_order');
        $data['list_approve_status'] = $this->purchase_model->get_list_approval_details($id,'pur_order');
        
        if ($to_return == false) {
            $this->load->view('purchase_order/pur_order_preview', $data);
        } else {
            return $this->load->view('purchase_order/pur_order_preview', $data, true);
        }
    }

    /**
     * { purchase order form }
     *
     * @param      string  $id     The identifier
     * @return redirect, view
     */
    public function pur_order($id = ''){
        if ($this->input->post()) {
            $pur_order_data = $this->input->post();
            $pur_order_data['terms'] = nl2br($pur_order_data['terms']);
            if ($id == '') {
                if (!has_permission('purchase', '', 'create')) {
                    access_denied('purchase_order');
                }
                $id = $this->purchase_model->add_pur_order($pur_order_data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('pur_order')));
                    
                    redirect(admin_url('purchase/purchase_order/' . $id));
                    
                }
            } else {
                if (!has_permission('purchase', '', 'edit')) {
                    access_denied('purchase_order');
                }
                $success = $this->purchase_model->update_pur_order($pur_order_data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('pur_order')));
                }
                redirect(admin_url('purchase/purchase_order/' . $id));
                
            }
        }

        if ($id == '') {
            $title = _l('create_new_pur_order');
        } else {
            $data['pur_order_detail'] = json_encode($this->purchase_model->get_pur_order_detail($id));
            $data['pur_order'] = $this->purchase_model->get_pur_order($id);
            $title = _l('pur_order_detail');
        }

        $this->load->model('currencies_model');
        $data['base_currency'] = $this->currencies_model->get_base_currency();

        $this->load->model('clients_model');
        $data['clients'] = $this->clients_model->get();

        $this->load->model('departments_model');
        $data['departments'] = $this->departments_model->get();

        $data['pur_request'] = $this->purchase_model->get_pur_request_by_status(2);
        $data['projects'] = $this->projects_model->get();
        $data['ven'] = $this->input->get('vendor');
        $data['taxes'] = $this->purchase_model->get_taxes();
        $data['staff']             = $this->staff_model->get('', ['active' => 1]);
        $data['vendors'] = $this->purchase_model->get_vendor();
        $data['estimates'] = $this->purchase_model->get_estimates_by_status(2);
        $data['units'] = $this->purchase_model->get_units();
        $data['items'] = $this->purchase_model->get_items();
        $data['title'] = $title;

        $this->load->view('purchase_order/pur_order', $data);
    }

    /**
     * { delete pur order }
     *
     * @param      <type>  $id     The identifier
     * @return redirect
     */
    public function delete_pur_order($id){
        if (!has_permission('purchase', '', 'delete')) {
            access_denied('purchase_order');
        }
        if (!$id) {
            redirect(admin_url('purchase/purchase_order'));
        }
        $success = $this->purchase_model->delete_pur_order($id);
        if (is_array($success)) {
            set_alert('warning', _l('purchase_order'));
        } elseif ($success == true) {
            set_alert('success', _l('deleted', _l('purchase_order')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('purchase_order')));
        }
        redirect(admin_url('purchase/purchase_order'));
    }

    /**
     * { estimate by vendor }
     *
     * @param      <type>  $vendor  The vendor
     * @return json
     */
    public function estimate_by_vendor($vendor){
        $estimate = $this->purchase_model->estimate_by_vendor($vendor);
        $ven = $this->purchase_model->get_vendor($vendor);
        $items = $this->purchase_model->get_items_by_vendor($vendor);
        $vendor_data = '';
        $html = '<option value=""></option>';
        $company = '';
        foreach($estimate as $es){
            $html .= '<option value="'.$es['id'].'">'.format_pur_estimate_number($es['id']).'</option>';
     
        }
        if($ven){
            $vendor_data .= '<div class="col-md-6">';
            $vendor_data .= '<p class="bold p_style">'._l('vendor_detail').'</p>
                            <hr class="hr_style"/>';
            $vendor_data .= '<table class="table table-striped table-bordered"><tbody>';
            $vendor_data .= '<tr><td>'._l('company').'</td><td>'.$ven->company.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('client_vat_number').'</td><td>'.$ven->vat.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('client_phonenumber').'</td><td>'.$ven->phonenumber.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('website').'</td><td>'.$ven->website.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('vendor_category').'</td><td>'.get_vendor_category_html($ven->category).'</td></tr>';
            $vendor_data .= '<tr><td>'._l('client_address').'</td><td>'.$ven->address.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('client_city').'</td><td>'.$ven->city.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('client_state').'</td><td>'.$ven->state.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('client_postal_code').'</td><td>'.$ven->zip.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('clients_country').'</td><td>'.get_country_short_name($ven->country).'</td></tr>';
            $vendor_data .= '<tr><td>'._l('bank_detail').'</td><td>'.$ven->bank_detail.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('payment_terms').'</td><td>'.$ven->payment_terms.'</td></tr>';
            $vendor_data .= '</tbody></table>';                    
            $vendor_data .= '</div>';

            $vendor_data .= '<div class="col-md-6">';
            $vendor_data .= '<p class="bold p_style">'._l('billing_address').'</p>
                            <hr class="hr_style"/>';
            $vendor_data .= '<table class="table table-striped table-bordered"><tbody>';
            $vendor_data .= '<tr><td>'._l('billing_street').'</td><td>'.$ven->billing_street.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('billing_city').'</td><td>'.$ven->billing_city.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('billing_state').'</td><td>'.$ven->billing_state.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('billing_zip').'</td><td>'.$ven->billing_zip.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('billing_country').'</td><td>'.get_country_short_name($ven->billing_country).'</td></tr>';
            $vendor_data .= '</tbody></table>'; 
            $vendor_data .= '<p class="bold p_style">'._l('shipping_address').'</p>
                            <hr class="hr_style"/>';
            $vendor_data .= '<table class="table table-striped table-bordered"><tbody>';
            $vendor_data .= '<tr><td>'._l('shipping_street').'</td><td>'.$ven->shipping_street.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('shipping_city').'</td><td>'.$ven->shipping_city.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('shipping_state').'</td><td>'.$ven->shipping_state.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('shipping_zip').'</td><td>'.$ven->shipping_zip.'</td></tr>';
            $vendor_data .= '<tr><td>'._l('shipping_country').'</td><td>'.get_country_short_name($ven->shipping_country).'</td></tr>';
            $vendor_data .= '</tbody></table>';                  
            $vendor_data .= '</div>';

            if($ven->vendor_code != ''){
               $company = $ven->vendor_code; 
            }
            
        }


        echo json_encode([
            'result' => $html,
            'ven_html' => $vendor_data,
            'company' => $company,
            'items' => $items,
        ]);
    }

    /**
     * { table pur order }
     */
    public function table_pur_order(){
        $this->app->get_table_data(module_views_path('purchase', 'purchase_order/table_pur_order'));
    }

    /**
     * { contracts }
     * @return  view
     */
    public function contracts(){
        $this->load->model('departments_model');
        $data['departments'] = $this->departments_model->get();
        $this->load->model('projects_model');
        $data['projects'] = $this->projects_model->get();
        $data['vendors'] = $this->purchase_model->get_vendor();
        $data['title'] = _l('contracts');
        $this->load->view('contracts/manage',$data);
    }

    /**
     * { contract }
     *
     * @param      string  $id     The identifier
     * @return redirect , view
     */
    public function contract($id = ''){
        if ($this->input->post()) {
            $contract_data = $this->input->post();
            if ($id == '') {
                
                $id = $this->purchase_model->add_contract($contract_data);
                if ($id) {
                    handle_pur_contract_file($id);
                    set_alert('success', _l('added_successfully', _l('contract')));
                    
                    redirect(admin_url('purchase/contracts'));
                    
                }
            } else {
                handle_pur_contract_file($id);
                $success = $this->purchase_model->update_contract($contract_data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('pur_order')));
                }
                redirect(admin_url('purchase/contract/' . $id));                
            }
        }

        if ($id == '') {
            $title = _l('create_new_contract');
        } else {
            $data['contract'] = $this->purchase_model->get_contract($id);
            $data['attachments'] = $this->purchase_model->get_pur_contract_attachment($id);
            $data['payment'] = $this->purchase_model->get_payment_by_contract($id);
            $title = _l('contract_detail');
        }
        $this->load->model('departments_model');
        $data['departments'] = $this->departments_model->get();
        $this->load->model('projects_model');
        $data['projects'] = $this->projects_model->get();
        $data['ven'] = $this->input->get('vendor');
        $data['pur_orders'] = $this->purchase_model->get_pur_order_approved();
        $data['taxes'] = $this->purchase_model->get_taxes();
        $data['staff']             = $this->staff_model->get('', ['active' => 1]);
        $data['members']             = $this->staff_model->get('', ['active' => 1]);
        $data['vendors'] = $this->purchase_model->get_vendor();
        $data['units'] = $this->purchase_model->get_units();
        $data['items'] = $this->purchase_model->get_items();
        $data['title'] = $title;

        $this->load->model('LegalServices/LegalServicesModel', 'legal');
        $this->load->model('LegalServices/Cases_model', 'case');
        $data['legal_services'] = $this->legal->get_all_services();

        $this->load->view('contracts/contract', $data);
    }

    /**
     * { delete contract }
     *
     * @param      <type>  $id     The identifier
     * @return redirect
     */
    public function delete_contract($id){
        if (!has_permission('purchase', '', 'delete')) {
            access_denied('contracts');
        }
        if (!$id) {
            redirect(admin_url('purchase/contracts'));
        }
        $success = $this->purchase_model->delete_contract($id);
        if (is_array($success)) {
            set_alert('warning', _l('contracts'));
        } elseif ($success == true) {
            set_alert('success', _l('deleted', _l('contracts')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('contracts')));
        }
        redirect(admin_url('purchase/contracts'));
    }

    /**
     * Determines if contract number exists.
     */
    public function contract_number_exists()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                // First we need to check if the email is the same
                $contract = $this->input->post('contract');
                if ($contract != '') {
                    $this->db->where('id', $contract);
                    $cd = $this->db->get('tblpur_contracts')->row();
                    if ($cd->contract_number == $this->input->post('contract_number')) {
                        echo json_encode(true);
                        die();
                    }
                }
                $this->db->where('contract_number', $this->input->post('contract_number'));
                $total_rows = $this->db->count_all_results('tblpur_contracts');
                if ($total_rows > 0) {
                    echo json_encode(false);
                } else {
                    echo json_encode(true);
                }
                die();
            }
        }
    }

    /**
     * { table contracts }
     */
    public function table_contracts(){
         $this->app->get_table_data(module_views_path('purchase', 'contracts/table_contracts'));
    }

    /**
     * Saves a contract data.
     * @return  json
     */
    public function save_contract_data()
    {
        if (!has_permission('purchase', '', 'edit') && !has_permission('purchase', '', 'create')) {
            header('HTTP/1.0 400 Bad error');
            echo json_encode([
                'success' => false,
                'message' => _l('access_denied'),
            ]);
            die;
        }

        $success = false;
        $message = '';

        $this->db->where('id', $this->input->post('contract_id'));
        $this->db->update(db_prefix().'pur_contracts', [
                'content' => $this->input->post('content', false),
        ]);

        $success = $this->db->affected_rows() > 0;
        $message = _l('updated_successfully', _l('contract'));

        echo json_encode([
            'success' => $success,
            'message' => $message,
        ]);
    }

    /**
     * { pdf contract }
     *
     * @param      <type>  $id     The identifier
     * @return pdf output
     */
    public function pdf_contract($id)
    {
        if (!has_permission('purchase', '', 'view') && !has_permission('purchase', '', 'view_own')) {
            access_denied('contracts');
        }

        if (!$id) {
            redirect(admin_url('purchase/contracts'));
        }

        $contract = $this->purchase_model->get_contract($id);
        $pdf = pur_contract_pdf($contract);

        $type = 'D';

        if ($this->input->get('output_type')) {
            $type = $this->input->get('output_type');
        }

        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf->Output(slug_it($contract->contract_number) . '.pdf', $type);
    }

    /**
     * { sign contract }
     *
     * @param      <type>  $contract  The contract
     * @return json
     */
    public function sign_contract($contract){
        if($this->input->post()){
            $data = $this->input->post();
            $success = $this->purchase_model->sign_contract($contract, $data['status']);
            $message = '';
            if($success == true){
                process_digital_signature_image($data['signature'], PURCHASE_MODULE_UPLOAD_FOLDER .'/contract_sign/'. $contract);
                $message = _l('sign_successfully');
            }

            echo json_encode([
                'success' => $success,
                'message' => $message,
            ]);
            
        }

    }

    /**
     * Sends a request approve.
     * @return  json
     */
    public function send_request_approve(){
        $data = $this->input->post();
        $message = 'Send request approval fail';
        $success = $this->purchase_model->send_request_approve($data);
        if ($success === true) {                
                $message = 'Send request approval success';
                $data_new = [];
                $data_new['send_mail_approve'] = $data;
                $this->session->set_userdata($data_new);
        }elseif($success === false){
            $message = _l('no_matching_process_found');
            $success = false;
            
        }else{
            $message = _l('could_not_find_approver_with', _l($success));
            $success = false;
        }
        echo json_encode([
            'success' => $success,
            'message' => $message,
        ]); 
        die;
    }

    /**
     * Sends a mail.
     * @return json
     */
    public function send_mail()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->input->post();
            if((isset($data)) && $data != ''){
                $this->purchase_model->send_mail($data);

                $success = 'success';
                echo json_encode([
                'success' => $success,                
            ]); 
            }
        }
    }

    /**
     * { approve request }
     * @return json
     */
    public function approve_request(){
        $data = $this->input->post();
        $data['staff_approve'] = get_staff_user_id();
        $success = false; 
        $code = '';
        $signature = '';

        if(isset($data['signature'])){
            $signature = $data['signature'];
            unset($data['signature']);
        }
        $status_string = 'status_'.$data['approve'];
        $check_approve_status = $this->purchase_model->check_approval_details($data['rel_id'],$data['rel_type']);
        
        if(isset($data['approve']) && in_array(get_staff_user_id(), $check_approve_status['staffid'])){

            $success = $this->purchase_model->update_approval_details($check_approve_status['id'], $data);

            $message = _l('approved_successfully');

            if ($success) {
                if($data['approve'] == 2){
                    $message = _l('approved_successfully');
                    $data_log = [];

                    if($signature != ''){
                        $data_log['note'] = "signed_request";
                    }else{
                        $data_log['note'] = "approve_request";
                    }
                    if($signature != ''){
                        switch ($data['rel_type']) {
                            case 'payment_request':
                                $path = PURCHASE_MODULE_UPLOAD_FOLDER .'/payment_invoice/signature/' .$data['rel_id'];
                                break;
                            case 'pur_order':
                                $path = PURCHASE_MODULE_UPLOAD_FOLDER .'/pur_order/signature/' .$data['rel_id'];
                                break;
                            case 'pur_request':
                                $path = PURCHASE_MODULE_UPLOAD_FOLDER .'/pur_request/signature/' .$data['rel_id'];
                                break;
                            case 'pur_quotation':
                                $path = PURCHASE_MODULE_UPLOAD_FOLDER .'/pur_estimate/signature/' .$data['rel_id'];
                                break;
                            default:
                                $path = PURCHASE_MODULE_UPLOAD_FOLDER;
                                break;
                        }
                        purchase_process_digital_signature_image($signature, $path, 'signature_'.$check_approve_status['id']);
                        $message = _l('sign_successfully');
                    }
                   


                    $check_approve_status = $this->purchase_model->check_approval_details($data['rel_id'],$data['rel_type']);
                    if ($check_approve_status === true){
                        $this->purchase_model->update_approve_request($data['rel_id'],$data['rel_type'], 2);
                    }
                }else{
                    $message = _l('rejected_successfully');
                    
                    $this->purchase_model->update_approve_request($data['rel_id'],$data['rel_type'], '3');
                }
            }
        }

        $data_new = [];
        $data_new['send_mail_approve'] = $data;
        $this->session->set_userdata($data_new);
        echo json_encode([
            'success' => $success,
            'message' => $message,
        ]);
        die();      
    }

    /**
     * Sends a request quotation.
     * @return redirect
     */
    public function send_request_quotation(){
        if($this->input->post()){
            $data = $this->input->post();
            foreach($data['vendor'] as $id){
                $vendor = $this->purchase_model->get_primary_contacts($id);
                $data['email'][] = $vendor->email;
            }

            if(isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != ''){

                if(file_exists(PURCHASE_MODULE_UPLOAD_FOLDER .'/request_quotation/'. $data['pur_request_id'])){
                    $delete_old = delete_dir(PURCHASE_MODULE_UPLOAD_FOLDER .'/request_quotation/'. $data['pur_request_id']);
                }else{
                    $delete_old = true;
                }

                if($delete_old == true){
                    handle_request_quotation($data['pur_request_id']);
                }
            }

            $send = $this->purchase_model->send_request_quotation($data);
            if($send == true){
                set_alert('success',_l('send_request_quotation_successfully'));
                
            }else{
                set_alert('warning',_l('send_request_quotation_fail'));
            }
            redirect(admin_url('purchase/purchase_request'));
            
        }
    }

    /**
     * { purchase request pdf }
     *
     * @param      <type>  $id     The identifier
     * @return pdf output
     */
    public function pur_request_pdf($id)
    {
        if (!$id) {
            redirect(admin_url('purchase/purchase_request'));
        }

        $pur_request = $this->purchase_model->get_pur_request_pdf_html($id);

        try {
            $pdf = $this->purchase_model->pur_request_pdf($pur_request);
        } catch (Exception $e) {
            echo html_entity_decode($e->getMessage());
            die;
        }
        
        $type = 'D';

        if ($this->input->get('output_type')) {
            $type = $this->input->get('output_type');
        }

        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf->Output('purchase_request.pdf', $type);
    }

    /**
     * { request quotation pdf }
     *
     * @param      <type>  $id     The identifier
     * @return pdf output
     */
    public function request_quotation_pdf($id)
    {
        if (!$id) {
            redirect(admin_url('purchase/purchase_request'));
        }

        $pur_request = $this->purchase_model->get_request_quotation_pdf_html($id);

        try {
            $pdf = $this->purchase_model->request_quotation_pdf($pur_request);
        } catch (Exception $e) {
            echo html_entity_decode($e->getMessage());
            die;
        }
        
        $type = 'D';

        if ($this->input->get('output_type')) {
            $type = $this->input->get('output_type');
        }

        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf->Output('request_quotation.pdf', $type);
    }

    /**
     * { purchase order setting }
     * @return  json
     */
    public function purchase_order_setting(){
        $data = $this->input->post();
        if($data != 'null'){
            $value = $this->purchase_model->update_purchase_setting($data);
            if($value){
                $success = true;
                $message = _l('updated_successfully');
            }else{
                $success = false;
                $message = _l('updated_false');
            }
            echo json_encode([
                'message' => $message,
                'success' => $success,
            ]);
            die;
        }
    }

    /**
     * { purchase order setting }
     * @return  json
     */
    public function item_by_vendor(){
        $data = $this->input->post();
        if($data != 'null'){
            $value = $this->purchase_model->update_purchase_setting($data);
            if($value){
                $success = true;
                $message = _l('updated_successfully');
            }else{
                $success = false;
                $message = _l('updated_false');
            }
            echo json_encode([
                'message' => $message,
                'success' => $success,
            ]);
            die;
        }
    }

    /**
     * Gets the notes.
     *
     * @param      <type>  $id     The id of purchase order
     */
    public function get_notes($id)
    {       
        $data['notes'] = $this->misc_model->get_notes($id, 'purchase_order');
        $this->load->view('admin/includes/sales_notes_template', $data);
    }

    /**
     * Gets the purchase contract notes.
     *
     * @param      <type>  $id     The id of purchase order
     */
    public function get_notes_pur_contract($id)
    {
        $data['notes'] = $this->misc_model->get_notes($id, 'pur_contract');
        $this->load->view('admin/includes/sales_notes_template', $data);
    }

     /**
     * Gets the purchase invoice notes.
     *
     * @param      <type>  $id     The id of purchase order
     */
    public function get_notes_pur_invoice($id)
    {
        $data['notes'] = $this->misc_model->get_notes($id, 'pur_invoice');
        $this->load->view('admin/includes/sales_notes_template', $data);
    }

    /**
     * Adds a note.
     *
     * @param        $rel_id  The purchase contract id
     */
    public function add_pur_contract_note($rel_id)
    {
        if ($this->input->post() ) {
            $this->misc_model->add_note($this->input->post(), 'pur_contract', $rel_id);
            echo html_entity_decode($rel_id);
        }
    }

    /**
     * Adds a note.
     *
     * @param        $rel_id  The purchase contract id
     */
    public function add_pur_invoice_note($rel_id)
    {
        if ($this->input->post() ) {
            $this->misc_model->add_note($this->input->post(), 'pur_invoice', $rel_id);
            echo html_entity_decode($rel_id);
        }
    }

    /**
     * Adds a note.
     *
     * @param      <type>  $rel_id  The purchase order id
     */
    public function add_note($rel_id)
    {
        if ($this->input->post() ) {
            $this->misc_model->add_note($this->input->post(), 'purchase_order', $rel_id);
            echo html_entity_decode($rel_id);
        }
    }

    /**
     * Uploads a purchase order attachment.
     *
     * @param      string  $id  The purchase order
     * @return redirect
     */
    public function purchase_order_attachment($id){

        handle_purchase_order_file($id);

        redirect(admin_url('purchase/purchase_order/'.$id));
    }


    /**
     * { preview purchase order file }
     *
     * @param      <type>  $id      The identifier
     * @param      <type>  $rel_id  The relative identifier
     * @return  view
     */
    public function file_purorder($id, $rel_id)
    {
        $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
        $data['current_user_is_admin']             = is_admin();
        $data['file'] = $this->purchase_model->get_file($id, $rel_id);
        if (!$data['file']) {
            header('HTTP/1.0 404 Not Found');
            die;
        }
        $this->load->view('purchase_order/_file', $data);
    }

    /**
     * { delete purchase order attachment }
     *
     * @param      <type>  $id     The identifier
     */
    public function delete_purorder_attachment($id)
    {
        $this->load->model('misc_model');
        $file = $this->misc_model->get_file($id);
        if ($file->staffid == get_staff_user_id() || is_admin()) {
            echo html_entity_decode($this->purchase_model->delete_purorder_attachment($id));
        } else {
            header('HTTP/1.0 400 Bad error');
            echo _l('access_denied');
            die;
        }
    }

    /**
     * Adds a payment.
     *
     * @param      <type>  $pur_order  The purchase order id
     * @return  redirect
     */
    public function add_payment($pur_order){
         if ($this->input->post()) {
            $data = $this->input->post();
            $message = '';
            $success = $this->purchase_model->add_payment($data, $pur_order);
            if ($success) {
                $message = _l('added_successfully', _l('payment'));
            }
            set_alert('success', $message);
            redirect(admin_url('purchase/purchase_order/'.$pur_order));
            
        }
    }

    /**
     * { delete payment }
     *
     * @param      <type>  $id         The identifier
     * @param      <type>  $pur_order  The pur order
     * @return  redirect
     */
    public function delete_payment($id,$pur_order)
    {
        if (!$id) {
            redirect(admin_url('purchase/purchase_order/'.$pur_order));
        }
        $response = $this->purchase_model->delete_payment($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('payment')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('payment')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('payment')));
        }
        redirect(admin_url('purchase/purchase_order/'.$pur_order));
    }

    /**
     * { purchase order pdf }
     *
     * @param      <type>  $id     The identifier
     * @return pdf output
     */
    public function purorder_pdf($id)
    {
        if (!$id) {
            redirect(admin_url('purchase/purchase_request'));
        }

        $pur_request = $this->purchase_model->get_purorder_pdf_html($id);

        try {
            $pdf = $this->purchase_model->purorder_pdf($pur_request);
        } catch (Exception $e) {
            echo html_entity_decode($e->getMessage());
            die;
        }
        
        $type = 'D';

        if ($this->input->get('output_type')) {
            $type = $this->input->get('output_type');
        }

        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf->Output('purchase_order.pdf', $type);
    }

    /**
     * { clear signature }
     *
     * @param      <type>  $id     The identifier
     */
    public function clear_signature($id)
    {
        if (has_permission('purchase', '', 'delete')) {
            $this->purchase_model->clear_signature($id);
        }

        redirect(admin_url('contracts/contract/' . $id));
    }

    /**
     * { Purchase reports }
     * 
     * @return view
     */
    public function reports(){
        if (!is_admin() && !has_permission('purchase','','view')) {
            access_denied('purchase');
        }
        $data['title'] = _l('purchase_reports');
        $data['items'] = $this->purchase_model->get_items();
        $this->load->view('reports/manage_report',$data);
    }

    /**
     *  import goods report
     *  
     *  @return json
     */
    public function import_goods_report()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('currencies_model');

            $select = [
                'tblitems.commodity_code as item_code', 
                'tblitems.description as item_name',
                '(select pur_order_name from ' . db_prefix() . 'pur_orders where ' . db_prefix() . 'pur_orders.id = pur_order) as po_name', 
                'total_money',
            ];
            $where =[];
            $custom_date_select = $this->get_where_report_period(db_prefix() . 'pur_orders.order_date');
            if ($custom_date_select != '') {
                array_push($where, $custom_date_select);
            }

            if ($this->input->post('products_services')) {
                $products_services  = $this->input->post('products_services');
                $_products_services = [];
                if (is_array($products_services)) {
                    foreach ($products_services as $product) {
                        if ($product != '') {
                            array_push($_products_services, $product);
                        }
                    }
                }
                if (count($_products_services) > 0) {
                    array_push($where, 'AND tblitems.id IN (' . implode(', ', $_products_services) . ')');
                }
            }
            $currency = $this->currencies_model->get_base_currency();
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'pur_order_detail';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'items ON ' . db_prefix() . 'items.id = ' . db_prefix() . 'pur_order_detail.item_code',
                'LEFT JOIN ' . db_prefix() . 'pur_orders ON ' . db_prefix() . 'pur_orders.id = ' . db_prefix() . 'pur_order_detail.pur_order',
            ];

            $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
                db_prefix() . 'items.id as item_id',
                db_prefix() . 'pur_order_detail.pur_order as po_id'
            ]);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            $footer_data = [
                'total'           => 0,
            ];

            foreach ($rResult as $aRow) {
                $row = [];

                $row[] = '<a href="' . admin_url('werehouse/commodity_list/' . $aRow['item_id']) . '" target="_blank">' . $aRow['item_code'] . '</a>';

                $row[] = $aRow['item_name'];

                $row[] = '<a href="' . admin_url('purchase/purchase_order/' . $aRow['po_id']) . '" target="_blank">' . $aRow['po_name'] . '</a>';


                

                $row[] = app_format_money($aRow['total_money'], $currency->name);
                $footer_data['total'] += $aRow['total_money'];

                $output['aaData'][] = $row;
            }

            foreach ($footer_data as $key => $total) {
                $footer_data[$key] = app_format_money($total, $currency->name);
            }

            $output['sums'] = $footer_data;
            echo json_encode($output);
            die();
        }
    }

    /**
     * Gets the where report period.
     *
     * @param      string  $field  The field
     *
     * @return     string  The where report period.
     */
    private function get_where_report_period($field = 'date')
    {
        $months_report      = $this->input->post('report_months');
        $custom_date_select = '';
        if ($months_report != '') {
            if (is_numeric($months_report)) {
                // Last month
                if ($months_report == '1') {
                    $beginMonth = date('Y-m-01', strtotime('first day of last month'));
                    $endMonth   = date('Y-m-t', strtotime('last day of last month'));
                } else {
                    $months_report = (int) $months_report;
                    $months_report--;
                    $beginMonth = date('Y-m-01', strtotime("-$months_report MONTH"));
                    $endMonth   = date('Y-m-t');
                }

                $custom_date_select = 'AND (' . $field . ' BETWEEN "' . $beginMonth . '" AND "' . $endMonth . '")';
            } elseif ($months_report == 'this_month') {
                $custom_date_select = 'AND (' . $field . ' BETWEEN "' . date('Y-m-01') . '" AND "' . date('Y-m-t') . '")';
            } elseif ($months_report == 'this_year') {
                $custom_date_select = 'AND (' . $field . ' BETWEEN "' .
                date('Y-m-d', strtotime(date('Y-01-01'))) .
                '" AND "' .
                date('Y-m-d', strtotime(date('Y-12-31'))) . '")';
            } elseif ($months_report == 'last_year') {
                $custom_date_select = 'AND (' . $field . ' BETWEEN "' .
                date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-01-01'))) .
                '" AND "' .
                date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-12-31'))) . '")';
            } elseif ($months_report == 'custom') {
                $from_date = to_sql_date($this->input->post('report_from'));
                $to_date   = to_sql_date($this->input->post('report_to'));
                if ($from_date == $to_date) {
                    $custom_date_select = 'AND ' . $field . ' = "' . $from_date . '"';
                } else {
                    $custom_date_select = 'AND (' . $field . ' BETWEEN "' . $from_date . '" AND "' . $to_date . '")';
                }
            }
        }

        return $custom_date_select;
    }

    /**
     * get data Purchase statistics by number of purchase orders
     * 
     * @return     json
     */
    public function number_of_purchase_orders_analysis(){
        $year_report      = $this->input->post('year');
        echo json_encode($this->purchase_model->number_of_purchase_orders_analysis($year_report));
        die();
    }

    /**
     * get data Purchase statistics by cost
     * 
     * @return     json
     */
    public function cost_of_purchase_orders_analysis(){
        $this->load->model('currencies_model');
        $year_report      = $this->input->post('year');
        $currency = $this->currencies_model->get_base_currency();
        $currency_name = '';
        $currency_unit = '';
        if($currency){
            $currency_name = $currency->name;
            $currency_unit = $currency->symbol;
        }
        echo json_encode([
            'data' => $this->purchase_model->cost_of_purchase_orders_analysis($year_report),
            'unit' => $currency_unit,
            'name' => $currency_name,
        ]);
        die();
    }

    /**
     * { table vendor contracts }
     *
     * @param      <type>  $vendor  The vendor
     */
    public function table_vendor_contracts($vendor){
        $this->app->get_table_data(module_views_path('purchase', 'contracts/table_contracts'),['vendor' => $vendor]);
    }

    /**
     * { table vendor pur order }
     *
     * @param      <type>  $vendor  The vendor
     */
    public function table_vendor_pur_order($vendor){
        $this->app->get_table_data(module_views_path('purchase', 'purchase_order/table_pur_order'),['vendor' => $vendor]);
    }

    /**
     * { delete vendor admin }
     *
     * @param      <type>  $customer_id  The customer identifier
     * @param      <type>  $staff_id     The staff identifier
     */
    public function delete_vendor_admin($customer_id, $staff_id)
    {
        if (!has_permission('customers', '', 'create') && !has_permission('customers', '', 'edit')) {
            access_denied('customers');
        }

        $this->db->where('vendor_id', $customer_id);
        $this->db->where('staff_id', $staff_id);
        $this->db->delete(db_prefix().'pur_vendor_admin');
        redirect(admin_url('purchase/vendor/' . $customer_id) . '?tab=vendor_admins');
    }

/**
     * table commodity list
     * 
     * @return array
     */
    public function table_item_list()
    {
        $this->app->get_table_data(module_views_path('purchase', 'items/table_item_list'));
    }

    /**
     * item list
     * @param  integer $id 
     * @return load view
     */
    public function items($id = ''){
        $this->load->model('departments_model');
        $this->load->model('staff_model');

        
        $data['units'] = $this->purchase_model->get_unit_add_item();
        $data['taxes'] = $this->purchase_model->get_taxes();
        $data['commodity_groups'] = $this->purchase_model->get_commodity_group_add_commodity();
        $data['sub_groups'] = $this->purchase_model->get_sub_group();
        $data['title'] = _l('item_list');

        $data['item_id'] = $id;

        $this->load->view('items/item_list', $data);
    }

    /**
     * get item data ajax
     * @param  integer $id 
     * @return view
     */
    public function get_item_data_ajax($id){
        
        $data['id'] = $id;
        $data['item'] = $this->purchase_model->get_item($id);
        $data['item_file'] = $this->purchase_model->get_item_attachments($id);
        $this->load->view('items/item_detail', $data);
    }

    /**
     * add item list
     * @param  integer $id 
     * @return redirect
     */
    public function add_item_list($id = '')
    {
        if ($this->input->post()) {
            $message          = '';
            $data             = $this->input->post();
            
            if (!$this->input->post('id')) {
           
                $mess = $this->purchase_model->add_item($data);
                if ($mess) {
                    set_alert('success',_l('added_successfully'). _l('item_list'));

                }else{
                    set_alert('warning',_l('Add_item_list_false'));
                }
                redirect(admin_url('purchase/item_list'));
               
            } else {
                $id = $data['id'];
                unset($data['id']);
                $success = $this->purchase_model->add_purchase($data, $id);
                if ($success) {
                    set_alert('success',_l('updated_successfully'). _l('item_list'));
                }else{
                    set_alert('warning',_l('updated_item_list_false'));
                }
                
                redirect(admin_url('purchase/item_list'));
            }
        }
    }

    /**
     * delete item
     * @param  integer $id 
     * @return redirect
     */
    public function delete_item($id){
        if (!$id) {
            redirect(admin_url('purchase/item_list'));
        }
        $response = $this->purchase_model->delete_item($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('item_list')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('item_list')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('item_list')));
        }
        redirect(admin_url('purchase/item_list'));
    }

    /**
     * Gets the commodity barcode.
     */
    public function get_commodity_barcode()
    {
        $commodity_barcode = $this->purchase_model->generate_commodity_barcode();

        echo json_encode([
            $commodity_barcode
        ]);
        die();
    }

    /**
     * commodity list add edit
     * @param  integer $id
     * @return json
     */
    public function commodity_list_add_edit($id=''){
        $data = $this->input->post();
        if($data){
            if(!isset($data['id'])){
                $ids = $this->purchase_model->add_commodity_one_item($data);
                if ($ids) {

                    // handle commodity list add edit file
                    $success = true;
                    $message = _l('added_successfully');
                    set_alert('success', $message);
                    /*upload multifile*/
                    echo json_encode([
                        'url'       => admin_url('purchase/items/' . $ids),
                        'commodityid' => $ids,
                    ]);
                    die;

                }
                echo json_encode([
                    'url' => admin_url('purchase/items'),
                ]);
                die;
               
            }else{
                $id = $data['id'];
                unset($data['id']);
                $success = $this->purchase_model->update_commodity_one_item($data,$id);

                /*update file*/

                if($success == true){
                    
                    $message = _l('updated_successfully');
                    set_alert('success', $message);
                }

                echo json_encode([
                    'url'       => admin_url('purchase/items/' . $id),
                    'commodityid' => $id,
                ]);
                die;

                
            }
        }


    }

    /**
     * add commodity attachment
     * @param  integer $id
     * @return json
     */
    public function add_commodity_attachment($id)
    {

        handle_item_attachments($id);
        echo json_encode([
            'url' => admin_url('purchase/items'),
        ]);
    }

    /**
     * get commodity file url 
     * @param  integer $commodity_id
     * @return json
     */
    public function get_commodity_file_url($commodity_id){
        $arr_commodity_file = $this->purchase_model->get_item_attachments($commodity_id);
        /*get images old*/
        $images_old_value='';


        if(count($arr_commodity_file) > 0){
            foreach ($arr_commodity_file as $key => $value) {
                $images_old_value .='<div class="dz-preview dz-image-preview image_old'.$value["id"].'">';

                    $images_old_value .='<div class="dz-image">';
                    if(file_exists(PURCHASE_MODULE_ITEM_UPLOAD_FOLDER .$value["rel_id"].'/'.$value["file_name"])){
                        $images_old_value .='<img class="image-w-h" data-dz-thumbnail alt="'.$value["file_name"].'" src="'.site_url('modules/purchase/uploads/item_img/'.$value["rel_id"].'/'.$value["file_name"]).'">';
                    }else{
                        $images_old_value .='<img class="image-w-h" data-dz-thumbnail alt="'.$value["file_name"].'" src="'.site_url('modules/warehouse/uploads/item_img/'.$value["rel_id"].'/'.$value["file_name"]).'">';
                    }
                    $images_old_value .='</div>';

                    $images_old_value .='<div class="dz-error-mark">';
                        $images_old_value .='<a class="dz-remove" data-dz-remove>Remove file';
                        $images_old_value .='</a>';
                    $images_old_value .='</div>';

                    $images_old_value .='<div class="remove_file">';
                        $images_old_value .= '<a href="#" class="text-danger" onclick="delete_contract_attachment(this,'.$value["id"].'); return false;"><i class="fa fa fa-times"></i></a>';
                    $images_old_value .='</div>';

                $images_old_value .='</div>';
            }
        }
              
              
            echo json_encode([
                'arr_images' => $images_old_value,
            ]);
            die();

    }

    /**
     * delete commodity file
     * @param  integer $attachment_id
     * @return json
     */
    public function delete_commodity_file($attachment_id)
    {
        if (!has_permission('purchase', '', 'delete') && !is_admin()) {
            access_denied('purchase');
        }

        $file = $this->misc_model->get_file($attachment_id);
            echo json_encode([
                'success' => $this->purchase_model->delete_commodity_file($attachment_id),
            ]);
    }

    /**
     * unit type 
     * @param  integer $id 
     * @return redirect    
     */
    public function unit_type($id = '')
        {
            if ($this->input->post()) {
                $message          = '';
                $data             = $this->input->post();
                
                if (!$this->input->post('id')) {
                    $mess = $this->purchase_model->add_unit_type($data);
                    if ($mess) {
                        set_alert('success',_l('added_successfully').' '. _l('unit_type'));

                    }else{
                        set_alert('warning',_l('Add_unit_type_false'));
                    }
                    redirect(admin_url('purchase/setting?group=units'));
                   
                } else {
                    $id = $data['id'];
                    unset($data['id']);
                    $success = $this->purchase_model->add_unit_type($data, $id);
                    if ($success) {
                        set_alert('success',_l('updated_successfully').' '. _l('unit_type'));
                    }else{
                        set_alert('warning',_l('updated_unit_type_false'));
                    }
                    
                    redirect(admin_url('purchase/setting?group=units'));
                }
            }
        }


        /**
         * delete unit type 
         * @param  integer $id
         * @return redirect
         */
        public function delete_unit_type($id){
            if (!$id) {
                redirect(admin_url('purchase/setting?group=units'));
            }
            $response = $this->purchase_model->delete_unit_type($id);
            if (is_array($response) && isset($response['referenced'])) {
                set_alert('warning', _l('is_referenced', _l('unit_type')));
            } elseif ($response == true) {
                set_alert('success', _l('deleted', _l('unit_type')));
            } else {
                set_alert('warning', _l('problem_deleting', _l('unit_type')));
            }
            redirect(admin_url('purchase/setting?group=units'));
        }

    /**
     * delete commodity
     * @param  integer $id 
     * @return redirect
     */
    public function delete_commodity($id){
        if (!$id) {
            redirect(admin_url('purchase/items'));
        }
        $response = $this->purchase_model->delete_commodity($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('commodity_list')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('commodity_list')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('commodity_list')));
        }
        redirect(admin_url('purchase/items'));
    }

    /**
     * Adds an expense.
     */
    public function add_expense()
    {
        if ($this->input->post()) {
            $this->load->model('expenses_model');
            $data = $this->input->post();

            if(isset($data['pur_order'])){
                $pur_order = $data['pur_order'];
                unset($data['pur_order']);
            }

            $id = $this->expenses_model->add($data);

            if ($id) {

                $this->purchase_model->mark_converted_pur_order($pur_order,$id);

                set_alert('success', _l('converted', _l('expense')));
                echo json_encode([
                    'url'       => admin_url('expenses/list_expenses/' .$id),
                    'expenseid' => $id,
                ]);
                die;

            }
        }
    }

    /**
     * Uploads an attachment.
     *
     * @param      <type>  $id     The identifier
     */
    public function upload_attachment($id)
    {
        handle_pur_vendor_attachments_upload($id);
    }

    /**
     * { function_description }
     *
     * @param      <type>  $id      The identifier
     * @param      <type>  $rel_id  The relative identifier
     */
    public function file_pur_vendor($id, $rel_id)
    {
        $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
        $data['current_user_is_admin']             = is_admin();
        $data['file'] = $this->purchase_model->get_file($id, $rel_id);
        if (!$data['file']) {
            header('HTTP/1.0 404 Not Found');
            die;
        }
        $this->load->view('vendors/_file', $data);
    }

    /**
     * { delete ic attachment }
     *
     * @param      <type>  $id     The identifier
     */
    public function delete_ic_attachment($id)
    {
        $this->load->model('misc_model');
        $file = $this->misc_model->get_file($id);
        if ($file->staffid == get_staff_user_id() || is_admin()) {
            echo html_entity_decode($this->purchase_model->delete_ic_attachment($id));
        } else {
            header('HTTP/1.0 400 Bad error');
            echo _l('access_denied');
            die;
        }
    }

    /* Change client status / active / inactive */
    public function change_contact_status($id, $status)
    {
        if (has_permission('purchase', '', 'edit') || is_vendor_admin(get_user_id_by_contact_id_pur($id)) || is_admin()) {
            if ($this->input->is_ajax_request()) {
                $this->purchase_model->change_contact_status($id, $status);
            }
        }
    }

    /**
     * { vendor items }
     */
    public function vendor_items(){
        if (!has_permission('purchase', '', 'view') && !is_admin() ) {
            access_denied('vendor_items');
        }
            
        $data['title'] = _l('vendor_items');
        $data['vendors'] = $this->purchase_model->get_vendor();
        $data['items'] = $this->purchase_model->get_item();
        $data['commodity_groups'] = $this->purchase_model->get_commodity_group_add_commodity();
        $this->load->view('vendor_items/manage', $data);
    }

    /**
     *  vendor item table
     *  
     *  @return json
     */
    public function vendor_items_table()
    {
        if ($this->input->is_ajax_request()) {
            
            $select = [
                db_prefix() . 'pur_vendor_items.id as vendor_items_id',
                db_prefix() . 'pur_vendor_items.items as items',
                db_prefix() . 'pur_vendor.company as company', 
                db_prefix() . 'pur_vendor_items.add_from as pur_vendor_items_addedfrom', 
               
            ];
            $where = [];
            

            if ($this->input->post('vendor_filter')) {
                $vendor_filter  = $this->input->post('vendor_filter');
                array_push($where, 'AND vendor IN ('. implode(',', $vendor_filter).')');
            }

            if ($this->input->post('group_items_filter')) {
                $group_items_filter  = $this->input->post('group_items_filter');
                array_push($where, 'AND group_items IN ('. implode(',', $group_items_filter).')');
            }

            if ($this->input->post('items_filter')) {
                $items_filter  = $this->input->post('items_filter');
                $staff_where = '';
                foreach ($items_filter as $key => $value) {
                    if($staff_where != ''){
                        $staff_where .= ' or find_in_set('.$value.', items)';
                    }else{
                        $staff_where .= 'find_in_set('.$value.', items)';
                    }
                }

                if($staff_where != ''){
                    array_push($where, 'AND ('.$staff_where.')');
                }
            }

            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'pur_vendor_items';
            $join         = ['LEFT JOIN ' . db_prefix() . 'pur_vendor ON ' . db_prefix() . 'pur_vendor.userid = ' . db_prefix() . 'pur_vendor_items.vendor',
                            'LEFT JOIN ' . db_prefix() . 'items ON ' . db_prefix() . 'items.id = ' . db_prefix() . 'pur_vendor_items.items'
                        ];

            $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where,[db_prefix() . 'pur_vendor.userid as userid','datecreate','description','commodity_code']);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            $footer_data = [
                'total' => 0,
            ];

            foreach ($rResult as $aRow) {
                $row = [];

                $row[] = '<div class="checkbox"><input type="checkbox" value="' . $aRow['vendor_items_id'] . '"><label></label></div>';

                $row[] = '<a href="'.admin_url('purchase/vendor/'.$aRow['userid']).'">'.$aRow['company'].'</a>';

                $row[] = '<a href="'.admin_url('purchase/items/'.$aRow['items']).'" >'.$aRow['commodity_code'].' - '.$aRow['description'].'</a>';

                $row[] = _d($aRow['datecreate']);

                $options = icon_btn('purchase/delete_vendor_items/' . $aRow['vendor_items_id'], 'remove', 'btn-danger', ['title' => _l('delete')]);

                $row[] =  $options;

                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
        }
    }

    /**
     * new vendor items
     */
    public function new_vendor_items(){
        if (!has_permission('purchase', '', 'create') && !is_admin() ) {
            access_denied('vendor_items');
        }
        $this->load->model('staff_model');

        if ($this->input->post()) {
            $data                = $this->input->post();
            if (!has_permission('purchase', '', 'create')) {
                access_denied('vendor_items');
            }
            $success = $this->purchase_model->add_vendor_items($data);
            if ($success) {
                set_alert('success', _l('added_successfully', _l('vendor_items')));
            }
            redirect(admin_url('purchase/vendor_items'));
        }
        $data['title'] = _l('vendor_items');

        $data['vendors'] = $this->purchase_model->get_vendor();
        $data['items'] = $this->purchase_model->get_item();
        $data['commodity_groups'] = $this->purchase_model->get_commodity_group_add_commodity();
    
        $this->load->view('vendor_items/vendor_items', $data);
    }

    /**
     * { group item change }
     */
    public function group_it_change($group = ''){
        if($group != ''){

            $list_items = $this->purchase_model->get_item_by_group($group);

            $html = '';
            if(count($list_items) > 0){
                foreach($list_items as $item){
                    $html .= '<option value="'.$item['id'].'" selected>'.$item['commodity_code'].' - '.$item['description'].'</option>';
                }
            }

            echo json_encode([
                'html' => $html,
            ]);
        }else{
            $items = $this->purchase_model->get_item();
            $html = '';
            if(count($items) > 0){
                foreach($items as $it){
                    $html .= '<option value="'.$it['id'].'">'.$it['commodity_code'].' - '.$it['description'].'</option>';
                }
            }

            echo json_encode([
                'html' => $html,
            ]);
        }   

    }

    /**
     * { delete vendor item  }
     *
     * @param      <type>  $id     The identifier
     */
    public function delete_vendor_items($id){
        if (!has_permission('purchase', '', 'delete') && !is_admin()) {
            access_denied('vendor_items');
        }
        if (!$id) {
            redirect(admin_url('purchase/vendor_items'));
        }
        
        $success = $this->purchase_model->delete_vendor_items($id);
        if ($success == true) {
            set_alert('success', _l('deleted', _l('vendor_items')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('vendor_items')));
        }
        redirect(admin_url('purchase/vendor_items'));
    }

    /**
     * purchase delete bulk action
     * @return
     */
    public function purchase_delete_bulk_action()
    {
        if (!is_staff_member()) {
            ajax_access_denied();
        }
        $total_deleted = 0;
        if ($this->input->post()) {

            $ids                   = $this->input->post('ids');
            $rel_type                   = $this->input->post('rel_type');
            /*check permission*/
            switch ($rel_type) {
                case 'commodity_list':
                    if (!has_permission('purchase', '', 'delete') && !is_admin()) {
                        access_denied('commodity_list');
                    }
                    break;

                case 'vendors':
                    if (!has_permission('purchase', '', 'delete') && !is_admin()) {
                        access_denied('vendors');
                    }
                    break;

                case 'vendor_items':
                    if (!has_permission('purchase', '', 'delete') && !is_admin()) {
                        access_denied('vendor_items');
                    }
                    break;
                
                default:
                    break;
            }

            /*delete data*/
            if ($this->input->post('mass_delete')) {
                if (is_array($ids)) {
                    foreach ($ids as $id) {

                            switch ($rel_type) {
                                case 'commodity_list':
                                    if ($this->purchase_model->delete_commodity($id)) {
                                        $total_deleted++;
                                        break;
                                    }else{
                                        break;
                                    }

                                case 'vendors':
                                    if ($this->purchase_model->delete_vendor($id)) {
                                        $total_deleted++;
                                        break;
                                    }else{
                                        break;
                                    }

                                case 'vendor_items':
                                    if ($this->purchase_model->delete_vendor_items($id)) {
                                        $total_deleted++;
                                        break;
                                    }else{
                                        break;
                                    }
                                
                                default:
                                   
                                    break;
                            }
                        }
                    }
                /*return result*/
                switch ($rel_type) {
                    case 'commodity_list':
                        set_alert('success', _l('total_commodity_list'). ": " .$total_deleted);
                        break;

                    case 'vendors':
                        set_alert('success', _l('total_vendors_list'). ": " .$total_deleted);
                        break;

                    case 'vendor_items':
                        set_alert('success', _l('total_vendor_items_list'). ": " .$total_deleted);
                        break;    
                    
                    default:
                        break;

                }
            }
        }
    }

    /**
     * { pur order setting }
     * @return redirect
     */
    public function pur_order_setting(){
        if(!has_permission('purchase','','edit') && !is_admin()){
            access_denied('purchase');
        }

        if($this->input->post()){
            $data = $this->input->post();
            $update = $this->purchase_model->update_po_number_setting($data);

            if($update == true){
                set_alert('success', _l('updated_successfully'));
            }else{
                set_alert('warning', _l('updated_fail'));
            }

            redirect(admin_url('purchase/setting'));
        }

    }

    public function get_html_approval_setting($id = '')
    {
        $html = '';
        $staffs = $this->staff_model->get();
        $approver = [
                0 => ['id' => 'direct_manager', 'name' => _l('direct_manager')],
                1 => ['id' => 'department_manager', 'name' => _l('department_manager')],
                2 => ['id' => 'staff', 'name' => _l('staff')]];
        $action = [ 
                    1 => ['id' => 'approve', 'name' => _l('approve')],
                    0 => ['id' => 'sign', 'name' => _l('sign')],
                ];
        if(is_numeric($id)){
            $approval_setting = $this->purchase_model->get_approval_setting($id);

            $setting = json_decode($approval_setting->setting);
            
            foreach ($setting as $key => $value) {
                if($key == 0){
                    $html .= '<div id="item_approve">
                                    <div class="col-md-11">
                                    <div class="col-md-1 hide"> '.
                                    render_select('approver['.$key.']',$approver,array('id','name'),'task_single_related', 'staff').'
                                    </div>
                                    <div class="col-md-8">
                                    '. render_select('staff['.$key.']',$staffs,array('staffid','full_name'),'staff', $value->staff).'
                                    </div>
                                    <div class="col-md-4">
                                        '. render_select('action['.$key.']',$action,array('id','name'),'action', $value->action).' 
                                    </div>
                                    </div>
                                    <div class="col-md-1 btn_apr">
                                    <span class="pull-bot">
                                        <button name="add" class="btn new_vendor_requests btn-success" data-ticket="true" type="button"><i class="fa fa-plus"></i></button>
                                        </span>
                                  </div>
                                </div>';
                }else{
                     $html .= '<div id="item_approve">
                                    <div class="col-md-11">
                                    <div class="col-md-1 hide">
                                        '.
                                    render_select('approver['.$key.']',$approver,array('id','name'),'task_single_related', 'staff').' 
                                    </div>
                                    <div class="col-md-8">
                                        '. render_select('staff['.$key.']',$staffs,array('staffid','full_name'),'staff', $value->staff).' 
                                    </div>
                                    <div class="col-md-4">
                                        '. render_select('action['.$key.']',$action,array('id','name'),'action', $value->action).' 
                                    </div>
                                    </div>
                                    <div class="col-md-1 btn_apr">
                                    <span class="pull-bot">
                                        <button name="add" class="btn remove_vendor_requests btn-danger" data-ticket="true" type="button"><i class="fa fa-minus"></i></button>
                                        </span>
                                  </div>
                                </div>';
                }
            }
        }else{
            $html .= '<div id="item_approve">
                        <div class="col-md-11">
                        <div class="col-md-1 hide"> '.
                        render_select('approver[0]',$approver,array('id','name'),'task_single_related', 'staff').'
                        </div>
                        <div class="col-md-8">
                        '. render_select('staff[0]',$staffs,array('staffid','full_name'),'staff').'
                        </div>
                        <div class="col-md-4">
                            '. render_select('action[0]',$action,array('id','name'),'action','approve').' 
                        </div>
                        </div>
                        <div class="col-md-1 btn_apr">
                        <span class="pull-bot">
                            <button name="add" class="btn new_vendor_requests btn-success" data-ticket="true" type="button"><i class="fa fa-plus"></i></button>
                            </span>
                      </div>
                    </div>';
        }

        echo json_encode([
                    $html
                ]);
    }

    /**
     * commodty group type
     * @param  integer $id
     * @return redirect
     */
    public function commodity_group_type($id = '') {
        if ($this->input->post()) {
            $message = '';
            $data = $this->input->post();

            if (!$this->input->post('id')) {

                $mess = $this->purchase_model->add_commodity_group_type($data);
                if ($mess) {
                    set_alert('success', _l('added_successfully') . _l('commodity_group_type'));

                } else {
                    set_alert('warning', _l('Add_commodity_group_type_false'));
                }
                redirect(admin_url('purchase/setting?group=commodity_group'));

            } else {
                $id = $data['id'];
                unset($data['id']);
                $success = $this->purchase_model->add_commodity_group_type($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully') . _l('commodity_group_type'));
                } else {
                    set_alert('warning', _l('updated_commodity_group_type_false'));
                }

                redirect(admin_url('purchase/setting?group=commodity_group'));
            }
        }
    }

    /**
     * delete commodity group type
     * @param  integer $id
     * @return redirect
     */
    public function delete_commodity_group_type($id) {
        if (!$id) {
            redirect(admin_url('purchase/setting?group=commodity_group'));
        }
        $response = $this->purchase_model->delete_commodity_group_type($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('commodity_group_type')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('commodity_group_type')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('commodity_group_type')));
        }
        redirect(admin_url('purchase/setting?group=commodity_group'));
    }

    /**
     * sub group
     * @param  integer $id
     * @return redirect
     */
    public function sub_group($id = '') {
        if ($this->input->post()) {
            $message = '';
            $data = $this->input->post();

            if (!$this->input->post('id')) {

                $mess = $this->purchase_model->add_sub_group($data);
                if ($mess) {
                    set_alert('success', _l('added_successfully') . ' ' . _l('sub_group'));

                } else {
                    set_alert('warning', _l('Add_sub_group_false'));
                }
                redirect(admin_url('purchase/setting?group=sub_group'));

            } else {
                $id = $data['id'];
                unset($data['id']);
                $success = $this->purchase_model->add_sub_group($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully') . ' ' . _l('sub_group'));
                } else {
                    set_alert('warning', _l('updated_sub_group_false'));
                }

                redirect(admin_url('purchase/setting?group=sub_group'));
            }
        }
    }

    /**
     * delete sub group
     * @param  integer $id
     * @return redirect
     */
    public function delete_sub_group($id) {
        if (!$id) {
            redirect(admin_url('purchase/setting?group=sub_group'));
        }
        $response = $this->purchase_model->delete_sub_group($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('sub_group')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('sub_group')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('sub_group')));
        }
        redirect(admin_url('purchase/setting?group=sub_group'));
    }

     /**
     * get subgroup fill data
     * @return html 
     */
    public function get_subgroup_fill_data()
    {
        $data = $this->input->post();

        $subgroup = $this->purchase_model->list_subgroup_by_group($data['group_id']);

        echo json_encode([
        'subgroup' => $subgroup
        ]);

    }

    /**
     * { copy public link }
     *
     * @param      string  $id     The identifier
     */
    public function copy_public_link($id){
        $pur_order = $this->purchase_model->get_pur_order($id);
        $copylink = '';
        if($pur_order){
            if($pur_order->hash != '' && $pur_order->hash != null){
                $copylink = site_url('purchase/vendors_portal/pur_order/'.$id.'/'.$pur_order->hash);
            }else{
                $hash = app_generate_hash();
                $copylink = site_url('purchase/vendors_portal/pur_order/'.$id.'/'.$hash);
                $this->db->where('id',$id);
                $this->db->update(db_prefix().'pur_orders',['hash' => $hash,]);
            }
        }

        echo json_encode([
            'copylink' => $copylink,
        ]);
    }

    /**
     * { copy public link pur request }
     *
     * @param      string  $id     The identifier
     */
    public function copy_public_link_pur_request($id){
        $pur_request = $this->purchase_model->get_purchase_request($id);
        $copylink = '';
        if($pur_request){
            if($pur_request->hash != '' && $pur_request->hash != null){
                $copylink = site_url('purchase/vendors_portal/pur_request/'.$id.'/'.$pur_request->hash);
            }else{
                $hash = app_generate_hash();
                $copylink = site_url('purchase/vendors_portal/pur_request/'.$id.'/'.$hash);
                $this->db->where('id',$id);
                $this->db->update(db_prefix().'pur_request',['hash' => $hash,]);
            }
        }

        echo json_encode([
            'copylink' => $copylink,
        ]);
    }

    /**
     * { file pur vendor }
     *
     * @param       $id      The identifier
     * @param       $rel_id  The relative identifier
     */
    public function file_pur_contract($id, $rel_id)
    {
        $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
        $data['current_user_is_admin']             = is_admin();
        $data['file'] = $this->purchase_model->get_file($id, $rel_id);
        if (!$data['file']) {
            header('HTTP/1.0 404 Not Found');
            die;
        }
        $this->load->view('contracts/_file', $data);
    }

    /**
     * { delete purchase contract attachment }
     *
     * @param        $id     The identifier
     */
    public function delete_pur_contract_attachment($id)
    {
        $this->load->model('misc_model');
        $file = $this->misc_model->get_file($id);
        if ($file->staffid == get_staff_user_id() || is_admin()) {
            echo html_entity_decode($this->purchase_model->delete_pur_contract_attachment($id));
        } else {
            header('HTTP/1.0 400 Bad error');
            echo _l('access_denied');
            die;
        }
    }

    /**
     * { vendor category form }
     * @return redirect
     */
    public function vendor_cate(){
        if ($this->input->post()) {
            $message = '';
            $data = $this->input->post();
            if (!$this->input->post('id')) {
                $id = $this->purchase_model->add_vendor_category($data);
                if ($id) {
                    $success = true;
                    $message = _l('added_successfully', _l('vendor_category'));
                    set_alert('success', $message);
                }
                redirect(admin_url('purchase/setting?group=vendor_category'));
            } else {
                $id = $data['id'];
                unset($data['id']);
                $success = $this->purchase_model->update_vendor_category($data, $id);
                if ($success) {
                    $message = _l('updated_successfully', _l('vendor_category'));
                    set_alert('success', $message);
                }
                redirect(admin_url('purchase/setting?group=vendor_category'));
            }
            die;
        }
    }

    /**
     * delete job_position
     * @param  integer $id
     * @return redirect
     */
    public function delete_vendor_category($id) {
        if (!$id) {
            redirect(admin_url('purchase/setting?group=vendor_category'));
        }
        $response = $this->purchase_model->delete_vendor_category($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('vendor_category')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('vendor_category')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('vendor_category')));
        }
        redirect(admin_url('purchase/setting?group=vendor_category'));
    }

    /**
     * Uploads a purchase estimate attachment.
     *
     * @param      string  $id  The purchase order
     * @return redirect
     */
    public function purchase_estimate_attachment($id){

        handle_purchase_estimate_file($id);

        redirect(admin_url('purchase/quotations/'.$id));
    }

    /**
     * { preview purchase estimate file }
     *
     * @param        $id      The identifier
     * @param        $rel_id  The relative identifier
     * @return  view
     */
    public function file_pur_estimate($id, $rel_id)
    {
        $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
        $data['current_user_is_admin']             = is_admin();
        $data['file'] = $this->purchase_model->get_file($id, $rel_id);
        if (!$data['file']) {
            header('HTTP/1.0 404 Not Found');
            die;
        }
        $this->load->view('quotations/_file', $data);
    }

    /**
     * { delete purchase order attachment }
     *
     * @param      <type>  $id     The identifier
     */
    public function delete_estimate_attachment($id)
    {
        $this->load->model('misc_model');
        $file = $this->misc_model->get_file($id);
        if ($file->staffid == get_staff_user_id() || is_admin()) {
            echo html_entity_decode($this->purchase_model->delete_estimate_attachment($id));
        } else {
            header('HTTP/1.0 400 Bad error');
            echo _l('access_denied');
            die;
        }
    }

    /**
     * Determines if vendor code exists.
     */
    public function vendor_code_exists()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                // First we need to check if the email is the same
                $id = $this->input->post('userid');
                if ($id != '') {
                    $this->db->where('userid', $id);
                    $pur_vendor = $this->db->get(db_prefix().'pur_vendor')->row();
                    if ($pur_vendor->vendor_code == $this->input->post('vendor_code')) {
                        echo json_encode(true);
                        die();
                    }
                }
                $this->db->where('vendor_code', $this->input->post('vendor_code'));
                $total_rows = $this->db->count_all_results(db_prefix().'pur_vendor    ');
                if ($total_rows > 0) {
                    echo json_encode(false);
                } else {
                    echo json_encode(true);
                }
                die();
            }
        }
    }

    /**
     * { dpm name in pur request number }
     *
     * @param        $dpm    The dpm
     */
    public function dpm_name_in_pur_request_number($dpm){
        $this->load->model('departments_model');
        $department = $this->departments_model->get($dpm);
        $name_rs = '';
        if($department){
            $name_repl = str_replace(' ', '', $department->name);
            $name_rs = strtoupper($name_repl);
        }

        echo json_encode([
            'rs' => $name_rs,
        ]);
    }

    /**
     * { update customfield po }
     *
     * @param        $id     The identifier
     */
    public function update_customfield_po($id){
        if($this->input->post()){
            $data = $this->input->post();
            $success = $this->purchase_model->update_customfield_po($id,$data);
            if($success){
                $message = _l('updated_successfully', _l('vendor_category'));
                set_alert('success', $message);
            }
            redirect(admin_url('purchase/purchase_order/'.$id));
        }
    }

    /**
     * { po voucher }
     */
    public function po_voucher(){

        $po_voucher = $this->purchase_model->get_po_voucher_html();

        try {
            $pdf = $this->purchase_model->povoucher_pdf($po_voucher);
        } catch (Exception $e) {
            echo html_entity_decode($e->getMessage());
            die;
        }
        
        $type = 'D';

        if ($this->input->get('output_type')) {
            $type = $this->input->get('output_type');
        }

        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf->Output('PO_voucher.pdf', $type);
    }


    /**
     *  po voucher report
     *  
     *  @return json
     */
    public function po_voucher_report()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('currencies_model');

            $select = [
                'pur_order_number',
                'order_date',
                'type',
                'project',
                'department',
                'vendor',
                'approve_status',
                'delivery_status',
            ];
            $where =[];
            $custom_date_select = $this->get_where_report_period(db_prefix() . 'pur_orders.order_date');
            if ($custom_date_select != '') {
                array_push($where, $custom_date_select);
            }

            

            $currency = $this->currencies_model->get_base_currency();
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'pur_orders';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'departments ON ' . db_prefix() . 'departments.departmentid = ' . db_prefix() . 'pur_orders.department',
                'LEFT JOIN ' . db_prefix() . 'projects ON ' . db_prefix() . 'projects.id = ' . db_prefix() . 'pur_orders.project',
                'LEFT JOIN ' . db_prefix() . 'pur_vendor ON ' . db_prefix() . 'pur_vendor.userid = ' . db_prefix() . 'pur_orders.vendor',
            ];

            $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
                db_prefix().'pur_orders.id as id',
                db_prefix().'departments.name as department_name',
                db_prefix().'projects.name as project_name',
                db_prefix().'pur_vendor.company as vendor_name',
                'total',
            ]);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            foreach ($rResult as $aRow) {
                $row = [];

                $row[] = '<a href="' . admin_url('purchase/purchase_order/' . $aRow['id']) . '" target="_blank">' . $aRow['pur_order_number'] . '</a>';

                $row[] = _d($aRow['order_date']);

                $row[] = _l($aRow['type']);

                $row[] = '<a href="'. admin_url('projects/view/'.$aRow['project']) .'" target="_blank">'.$aRow['project_name'].'</a>';

                $row[] = $aRow['department_name'];

                $row[] = '<a href="'. admin_url('purchase/vendor/'.$aRow['vendor']) .'" target="_blank">'.$aRow['vendor_name'].'</a>';

                $row[] = get_status_approve($aRow['approve_status']);

                $delivery_status = '';
                if($aRow['delivery_status'] == 0){
                    $delivery_status = '<span class="label label-danger">'._l('undelivered').'</span>';
                }elseif($aRow['delivery_status'] == 1){
                    $delivery_status = '<span class="label label-success">'._l('delivered').'</span>';
                }
                $row[] = $delivery_status;

                $paid = $aRow['total'] - purorder_left_to_pay($aRow['id']);
                $percent = 0;
                if($aRow['total'] > 0){
                    $percent = ($paid / $aRow['total'] ) * 100;
                }
                
                $row[] = '<div class="progress">
                              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                              aria-valuemin="0" aria-valuemax="100" style="width:'.round($percent).'%">
                               ' .round($percent).' % 
                              </div>
                            </div>';
              
                $output['aaData'][] = $row;
            }

            echo json_encode($output);
            die();
        }
    }

    /**
     *  po voucher report
     *  
     *  @return json
     */
    public function po_report()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('currencies_model');

            $select = [
                'pur_order_number',
                'order_date',
                'department',
                'vendor',
                'approve_status',
                'subtotal',
                'total_tax',
                'total',
            ];
            $where =[];
            $custom_date_select = $this->get_where_report_period(db_prefix() . 'pur_orders.order_date');
            if ($custom_date_select != '') {
                array_push($where, $custom_date_select);
            }

            

            $currency = $this->currencies_model->get_base_currency();
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'pur_orders';
            $join         = [
                'LEFT JOIN ' . db_prefix() . 'departments ON ' . db_prefix() . 'departments.departmentid = ' . db_prefix() . 'pur_orders.department',
                'LEFT JOIN ' . db_prefix() . 'projects ON ' . db_prefix() . 'projects.id = ' . db_prefix() . 'pur_orders.project',
                'LEFT JOIN ' . db_prefix() . 'pur_vendor ON ' . db_prefix() . 'pur_vendor.userid = ' . db_prefix() . 'pur_orders.vendor',
            ];

            $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
                db_prefix().'pur_orders.id as id',
                db_prefix().'departments.name as department_name',
                db_prefix().'projects.name as project_name',
                db_prefix().'pur_vendor.company as vendor_name',
                'total',
            ]);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            $footer_data = [
                'total'           => 0,
                'total_tax'       => 0,
                'total_value'     => 0,
            ];

            foreach ($rResult as $aRow) {
                $row = [];

                $row[] = '<a href="' . admin_url('purchase/purchase_order/' . $aRow['id']) . '" target="_blank">' . $aRow['pur_order_number'] . '</a>';

                $row[] = _d($aRow['order_date']);

                $row[] = $aRow['department_name'];

                $row[] = '<a href="'. admin_url('purchase/vendor/'.$aRow['vendor']) .'" target="_blank">'.$aRow['vendor_name'].'</a>';

                $row[] = get_status_approve($aRow['approve_status']);

                $row[] = app_format_money($aRow['subtotal'], $currency->name);

                $row[] = app_format_money($aRow['total_tax'], $currency->name);

                $row[] = app_format_money($aRow['total'], $currency->name);

                $footer_data['total'] += $aRow['total'];
                $footer_data['total_tax'] += $aRow['total_tax'];
                $footer_data['total_value'] += $aRow['subtotal'];
              
                $output['aaData'][] = $row;
            }

            foreach ($footer_data as $key => $total) {
                $footer_data[$key] = app_format_money($total, $currency->name);
            }

            $output['sums'] = $footer_data;
            echo json_encode($output);
            die();
        }
    }

    /**
     *  purchase inv report
     *  
     *  @return json
     */
    public function purchase_inv_report()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('currencies_model');

            $select = [
                'invoice_number',
                'contract',
                 db_prefix().'pur_invoices.pur_order',
                'invoice_date',
                'payment_status',
                'subtotal',
                'tax',
                'total',
            ];
            $where =[];
            $custom_date_select = $this->get_where_report_period(db_prefix() . 'pur_invoices.invoice_date');
            if ($custom_date_select != '') {
                array_push($where, $custom_date_select);
            }

            

            $currency = $this->currencies_model->get_base_currency();
            $aColumns     = $select;
            $sIndexColumn = 'id';
            $sTable       = db_prefix() . 'pur_invoices';
            $join         = [
                'LEFT JOIN '.db_prefix().'pur_contracts ON '.db_prefix().'pur_contracts.id = '.db_prefix().'pur_invoices.contract'
            ];

            $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
                db_prefix().'pur_invoices.id as id',
                db_prefix().'pur_contracts.contract_number as contract_number',

            ]);

            $output  = $result['output'];
            $rResult = $result['rResult'];

            $footer_data = [
                'total'           => 0,
                'total_tax'       => 0,
                'total_value'     => 0,
            ];

            foreach ($rResult as $aRow) {
                $row = [];

                $row[] = '<a href="' . admin_url('purchase/purchase_invoice/' . $aRow['id']) . '" target="_blank">' . $aRow['invoice_number'] . '</a>';

                $row[] = '<a href="'.admin_url('purchase/contract/'.$aRow['contract']).'" target="_blank">'.$aRow['contract_number'].'</a>';

                $row[] = '<a href="'.admin_url('purchase/purchase_order/'.$aRow[db_prefix().'pur_invoices.pur_order']).'" target="_blank">'.get_pur_order_subject($aRow[ db_prefix().'pur_invoices.pur_order']).'</a>';

                $row[] = _d($aRow['invoice_date']);

                $class = '';
                if($aRow['payment_status'] == 'unpaid'){
                    $class = 'danger';
                }elseif($aRow['payment_status'] == 'paid'){
                    $class = 'success';
                }elseif ($aRow['payment_status'] == 'partially_paid') {
                    $class = 'warning';
                }

                $row[] = '<span class="label label-'.$class.' s-status invoice-status-3">'._l($aRow['payment_status']).'</span>';

                $row[] = app_format_money($aRow['subtotal'], $currency->name);

                $row[] = app_format_money($aRow['tax'], $currency->name);

                $row[] = app_format_money($aRow['total'], $currency->name);

                $footer_data['total'] += $aRow['total'];
                $footer_data['total_tax'] += $aRow['tax'];
                $footer_data['total_value'] += $aRow['subtotal'];
              
                $output['aaData'][] = $row;
            }

            foreach ($footer_data as $key => $total) {
                $footer_data[$key] = app_format_money($total, $currency->name);
            }

            $output['sums'] = $footer_data;
            echo json_encode($output);
            die();
        }
    }

    /**
     * { invoices }
     * @return view
     */
    public function invoices(){
        $data['title'] = _l('invoices');
        $data['contracts'] = $this->purchase_model->get_contract();
        $this->load->view('invoices/manage',$data);
    }

    /**
     * { table purchase invoices }
     */
    public function table_pur_invoices(){
        $this->app->get_table_data(module_views_path('purchase', 'invoices/table_pur_invoices'));
    }

    /**
     * { purchase invoice }
     *
     * @param      string  $id     The identifier
     */
    public function pur_invoice($id = ''){
        if($id == ''){
            $data['title'] = _l('add_invoice');

        }else{
            $data['title'] = _l('edit_invoice');
            $data['pur_invoice'] = $this->purchase_model->get_pur_invoice($id);
        }
        $data['contracts'] = $this->purchase_model->get_contract();
        $data['taxes'] = $this->purchase_model->get_taxes();
        $data['pur_orders'] = $this->purchase_model->get_pur_order_approved();
        $this->load->view('invoices/pur_invoice',$data);
    }

    /**
     * { pur invoice form }
     * @return redirect
     */
    public function pur_invoice_form(){
        if($this->input->post()){
            $data = $this->input->post();
            if($data['id'] == ''){
                unset($data['id']);
                $mess = $this->purchase_model->add_pur_invoice($data);
                if ($mess) {
                    handle_pur_invoice_file($mess);
                    set_alert('success', _l('added_successfully') . ' ' . _l('purchase_invoice'));

                } else {
                    set_alert('warning', _l('add_purchase_invoice_fail'));
                }
                redirect(admin_url('purchase/invoices'));
            }else{
                $id = $data['id'];
                unset($data['id']);
                handle_pur_invoice_file($id);
                $success = $this->purchase_model->update_pur_invoice($id, $data);
                if($success){
                    set_alert('success', _l('updated_successfully') . ' ' . _l('purchase_invoice'));
                }else{
                    set_alert('warning', _l('update_purchase_invoice_fail'));
                }
                redirect(admin_url('purchase/invoices'));
            }
        }
    }

    public function delete_pur_invoice($id){
        if (!$id) {
            redirect(admin_url('purchase/invoices'));
        }
        $response = $this->purchase_model->delete_pur_invoice($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('purchase_invoice')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('purchase_invoice')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('purchase_invoice')));
        }
        redirect(admin_url('purchase/invoices'));
    }

    /**
     * { contract change }
     *
     * @param      <type>  $ct    
     */
    public function contract_change($ct){
        $contract = $this->purchase_model->get_contract($ct);
        $value = 0;
        if($contract){
            $value = $contract->contract_value;
        }

        echo json_encode([
            'value' => $value,
        ]);
    }

    /**
     * { purchase order change }
     *
     * @param      <type>  $ct    
     */
    public function pur_order_change($ct){
        $pur_order = $this->purchase_model->get_pur_order($ct);
        $value = 0;
        if($pur_order){
            $value = $pur_order->total;
        }

        echo json_encode([
            'value' => $value,
        ]);
    }

    /**
     * { tax rate change }
     *
     * @param        $tax    The tax
     */
    public function tax_rate_change($tax){
        $this->load->model('taxes_model');
        $tax = $this->taxes_model->get($tax);
        $rate = 0;
        if($tax){
            $rate = $tax->taxrate;
        }

        echo  json_encode([
            'rate' => $rate,
        ]);
    }

    /**
     * { purchase invoice }
     *
     * @param       $id     The identifier
     */
    public function purchase_invoice($id){
        if (!$id) {
            redirect(admin_url('purchase/invoices'));
        }

        $this->load->model('staff_model');

        $this->load->model('payment_modes_model');
        $data['payment_modes'] = $this->payment_modes_model->get('', [
            'expenses_only !=' => 1,
        ]);
        $data['pur_invoice'] = $this->purchase_model->get_pur_invoice($id);
        $data['title'] = $data['pur_invoice']->invoice_number;
        $data['members']           = $this->staff_model->get('', ['active' => 1]);
        $data['payment'] = $this->purchase_model->get_payment_invoice($id);
        $data['pur_invoice_attachments'] = $this->purchase_model->get_purchase_invoice_attachments($id);
        $this->load->view('invoices/pur_invoice_preview',$data);
    }

    /**
     * Adds a payment for invoice.
     *
     * @param      <type>  $pur_order  The purchase order id
     * @return  redirect
     */
    public function add_invoice_payment($invoice){
         if ($this->input->post()) {
            $data = $this->input->post();
            $message = '';
            $success = $this->purchase_model->add_invoice_payment($data, $invoice);
            if ($success) {
                $message = _l('added_successfully', _l('payment'));
            }
            set_alert('success', $message);
            redirect(admin_url('purchase/purchase_invoice/'.$invoice));
            
        }
    }

     /**
     * { delete payment }
     *
     * @param      <type>  $id         The identifier
     * @param      <type>  $pur_order  The pur order
     * @return  redirect
     */
    public function delete_payment_pur_invoice($id,$inv)
    {
        if (!$id) {
            redirect(admin_url('purchase/purchase_invoice/'.$inv));
        }
        $response = $this->purchase_model->delete_payment_pur_invoice($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('payment')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('payment')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('payment')));
        }
        redirect(admin_url('purchase/purchase_invoice/'.$inv));
    }

    /**
     * { payment invoice }
     *
     * @param       $id     The identifier
     * @return view
     */
    public function payment_invoice($id){
        $this->load->model('currencies_model');

        $send_mail_approve = $this->session->userdata("send_mail_approve");
        if((isset($send_mail_approve)) && $send_mail_approve != ''){
            $data['send_mail_approve'] = $send_mail_approve;
            $this->session->unset_userdata("send_mail_approve");
        }
        
        $data['check_appr'] = $this->purchase_model->get_approve_setting('payment_request');
        $data['get_staff_sign'] = $this->purchase_model->get_staff_sign($id,'payment_request');
        $data['check_approve_status'] = $this->purchase_model->check_approval_details($id,'payment_request');
        $data['list_approve_status'] = $this->purchase_model->get_list_approval_details($id,'payment_request');


        $data['payment_invoice'] = $this->purchase_model->get_payment_pur_invoice($id);
        $data['title'] = _l('payment_for').' '.get_pur_invoice_number($data['payment_invoice']->pur_invoice);

        $data['invoice'] = $this->purchase_model->get_pur_invoice($data['payment_invoice']->pur_invoice);

        $data['base_currency'] = $this->currencies_model->get_base_currency();
        $this->load->view('invoices/payment_invoice',$data);
    }

    /**
     * { purchase invoice attachment }
     */
    public function purchase_invoice_attachment($id){
        handle_pur_invoice_file($id);
        redirect(admin_url('purchase/purchase_invoice/'.$id));
    }

    /**
     * { preview purchase invoice file }
     *
     * @param        $id      The identifier
     * @param        $rel_id  The relative identifier
     * @return  view
     */
    public function file_purinv($id, $rel_id)
    {
        $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
        $data['current_user_is_admin']             = is_admin();
        $data['file'] = $this->purchase_model->get_file($id, $rel_id);
        if (!$data['file']) {
            header('HTTP/1.0 404 Not Found');
            die;
        }
        $this->load->view('invoices/_file', $data);
    }

    /**
     * { delete purchase order attachment }
     *
     * @param      <type>  $id     The identifier
     */
    public function delete_purinv_attachment($id)
    {
        $this->load->model('misc_model');
        $file = $this->misc_model->get_file($id);
        if ($file->staffid == get_staff_user_id() || is_admin()) {
            echo html_entity_decode($this->purchase_model->delete_purinv_attachment($id));
        } else {
            header('HTTP/1.0 400 Bad error');
            echo _l('access_denied');
            die;
        }
    }

    /**
     * { purchase estimate pdf }
     *
     * @param      <type>  $id     The identifier
     * @return pdf output
     */
    public function purestimate_pdf($id)
    {
        if (!$id) {
            redirect(admin_url('purchase/quotations'));
        }

        $pur_estimate = $this->purchase_model->get_purestimate_pdf_html($id);

        try {
            $pdf = $this->purchase_model->purestimate_pdf($pur_estimate,$id);
        } catch (Exception $e) {
            echo html_entity_decode($e->getMessage());
            die;
        }
        
        $type = 'D';

        if ($this->input->get('output_type')) {
            $type = $this->input->get('output_type');
        }

        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf->Output(format_pur_estimate_number($id).'.pdf', $type);
    }

    /**
     * Sends a request quotation.
     * @return redirect
     */
    public function send_quotation(){
        if($this->input->post()){
            $data = $this->input->post();
            foreach($data['vendors'] as $id){
                $vendor = $this->purchase_model->get_primary_contacts($id);
                $data['email'][] = $vendor->email;
            }

            if(isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != ''){

                if(file_exists(PURCHASE_MODULE_UPLOAD_FOLDER .'/send_quotation/'. $data['pur_estimate_id'])){
                    $delete_old = delete_dir(PURCHASE_MODULE_UPLOAD_FOLDER .'/send_quotation/'. $data['pur_estimate_id']);
                }else{
                    $delete_old = true;
                }

                if($delete_old == true){
                    handle_send_quotation($data['pur_estimate_id']);
                }   
            }

            $send = $this->purchase_model->send_quotation($data);
            if($send){
                set_alert('success',_l('send_quotation_successfully'));
                
            }else{
                set_alert('warning',_l('send_quotation_fail'));
            }
            redirect(admin_url('purchase/quotations/'.$data['pur_estimate_id']));
            
        }
    }

    /**
     * Sends a purchase order.
     * @return redirect
     */
    public function send_po(){
        if($this->input->post()){
            $data = $this->input->post();
            foreach($data['vendor'] as $id){
                $vendor = $this->purchase_model->get_primary_contacts($id);
                $data['email'][] = $vendor->email;
            }

            if(isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != ''){

                if(file_exists(PURCHASE_MODULE_UPLOAD_FOLDER .'/send_po/'. $data['po_id'])){
                    $delete_old = delete_dir(PURCHASE_MODULE_UPLOAD_FOLDER .'/send_po/'. $data['po_id']);
                }else{
                    $delete_old = true;
                }

                if($delete_old == true){
                    handle_send_po($data['po_id']);
                }   
            }

            $send = $this->purchase_model->send_po($data);
            if($send){
                set_alert('success',_l('send_po_successfully'));
                
            }else{
                set_alert('warning',_l('send_po_fail'));
            }
            redirect(admin_url('purchase/purchase_order/'.$data['po_id']));
            
        }
    }

    /**
     * import xlsx commodity
     * @param  integer $id
     * @return view
     */
    public function import_xlsx_commodity() {
        if (!is_admin() && !has_permission('purchase', '', 'create')) {
            access_denied('purchase');
        }
        $this->load->model('staff_model');
        $data_staff = $this->staff_model->get(get_staff_user_id());

        /*get language active*/
        if ($data_staff) {
            if ($data_staff->default_language != '') {
                $data['active_language'] = $data_staff->default_language;

            } else {

                $data['active_language'] = get_option('active_language');
            }

        } else {
            $data['active_language'] = get_option('active_language');
        }
        $data['title'] = _l('import_excel');

        $this->load->view('items/import_excel', $data);
    }

    /**
     * import file xlsx commodity
     * @return json
     */
    public function import_file_xlsx_commodity() {
        if (!is_admin() && !has_permission('purchase', '', 'create')) {
            access_denied(_l('purchase'));
        }

        $total_row_false = 0;
        $total_rows_data = 0;
        $dataerror = 0;
        $total_row_success = 0;
        $total_rows_data_error = 0;
        $filename='';

        if ($this->input->post()) {

            /*delete file old before export file*/
            $path_before = COMMODITY_ERROR_PUR.'FILE_ERROR_COMMODITY'.get_staff_user_id().'.xlsx';
            if(file_exists($path_before)){
                unlink(COMMODITY_ERROR_PUR.'FILE_ERROR_COMMODITY'.get_staff_user_id().'.xlsx');
            }

            if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {
                //do_action('before_import_leads');

                // Get the temp file path
                $tmpFilePath = $_FILES['file_csv']['tmp_name'];
                // Make sure we have a filepath
                if (!empty($tmpFilePath) && $tmpFilePath != '') {
                    $tmpDir = TEMP_FOLDER . '/' . time() . uniqid() . '/';

                    if (!file_exists(TEMP_FOLDER)) {
                        mkdir(TEMP_FOLDER, 0755);
                    }

                    if (!file_exists($tmpDir)) {
                        mkdir($tmpDir, 0755);
                    }

                    // Setup our new file path
                    $newFilePath = $tmpDir . $_FILES['file_csv']['name'];

                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $import_result = true;
                        $rows = [];

                        $objReader = new PHPExcel_Reader_Excel2007();
                        $objReader->setReadDataOnly(true);
                        $objPHPExcel = $objReader->load($newFilePath);
                        $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
                        $sheet = $objPHPExcel->getActiveSheet();

                        //innit  file exel error start

                        $dataError = new PHPExcel();
                        $dataError->setActiveSheetIndex(0);
                        //create header file

                        // add style to the header
                        $styleArray = array(
                            'font' => array(
                                'bold' => true,

                            ),

                            'borders' => array(
                                'top' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                ),
                            ),
                            'fill' => array(

                                'rotation' => 90,
                                'startcolor' => array(
                                    'argb' => 'FFA0A0A0',
                                ),
                                'endcolor' => array(
                                    'argb' => 'FFFFFFFF',
                                ),
                            ),
                        );

                        // set the names of header cells
                        $dataError->setActiveSheetIndex(0)

                            ->setCellValue("A1", "(*)" . _l('commodity_code'))
                            ->setCellValue("B1", "(*)" . _l('commodity_name'))
                            ->setCellValue("C1", _l('commodity_barcode'))
                            ->setCellValue("D1", _l('sku_code'))
                            ->setCellValue("E1", _l('sku_name'))
                            ->setCellValue("F1", _l('description'))
                            ->setCellValue("G1", _l('unit_id'))
                            ->setCellValue("H1", _l('commodity_group'))
                            ->setCellValue("I1", _l('sub_group'))
                            ->setCellValue("J1", "(*)" . _l('purchase_price'))
                            ->setCellValue("K1", _l('rate'))
                            ->setCellValue("L1", _l('tax'));


                        /*set style for header*/
                        $dataError->getActiveSheet()->getStyle('A1:W1')->applyFromArray($styleArray);

                        // auto fit column to content

                        foreach (range('A', 'W') as $columnID) {
                            $dataError->getActiveSheet()->getColumnDimension($columnID)
                                ->setAutoSize(true);

                        }

                        $dataError->getActiveSheet()->getStyle('A1:W1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $dataError->getActiveSheet()->getStyle('A1:W1')->getFill()->getStartColor()->setARGB('29bb04');
                        // Add some data
                        $dataError->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);
                        $dataError->getActiveSheet()->getStyle('A1:W1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                        /*set header middle alignment*/
                        $dataError->getActiveSheet()->getStyle('A1:W1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $dataError->getActiveSheet()->getStyle('A1:W1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                        /*set row1 height*/
                        $dataError->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

                        //init file error end

                        // start row write 2
                        $numRow = 2;
                        $total_rows = 0;

                        $total_rows_actualy = 0;
                        
                        //get data for compare

                        foreach ($rowIterator as $row) {
                            $rowIndex = $row->getRowIndex();
                            if ($rowIndex > 1) {
                                $rd = array();
                                $flag = 0;
                                $flag2 = 0;
                                $flag_mail = 0;
                                $string_error = '';
                                $flag_contract_form = 0;

                                $flag_id_unit_id;
                                $flag_id_commodity_group;
                                $flag_id_sub_group;
                                $flag_id_tax;
                              

                                $value_cell_commodity_code = $sheet->getCell('A' . $rowIndex)->getValue();
                                $value_cell_description = $sheet->getCell('B' . $rowIndex)->getValue();

                                $value_cell_commodity_group = $sheet->getCell('H' . $rowIndex)->getValue();

                                $value_cell_unit_id = $sheet->getCell('G' . $rowIndex)->getValue();

                                $value_cell_sub_group = $sheet->getCell('I' . $rowIndex)->getValue();
                                
                                $value_cell_tax = $sheet->getCell('L' . $rowIndex)->getValue();
                               
                                $value_cell_rate = $sheet->getCell('K' . $rowIndex)->getValue();
                                $value_cell_purchase_price = $sheet->getCell('J' . $rowIndex)->getValue();

                                $pattern = '#^[a-z][a-z0-9\._]{2,31}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$#';

                                $reg_day = '#^(((1)[0-2]))(\/)\d{4}-(3)[0-1])(\/)(((0)[0-9])-[0-2][0-9]$#'; /*yyyy-mm-dd*/

                                /*check null*/
                                if (is_null($value_cell_commodity_code) == true) {
                                    $string_error .= _l('commodity_code') . _l('not_yet_entered');
                                    $flag = 1;
                                }

                                if (is_null($value_cell_commodity_group) == true) {
                                    $string_error .= _l('commodity_group') . _l('not_yet_entered');
                                    $flag = 1;
                                }


                                if (is_null($value_cell_description) == true) {
                                    $string_error .= _l('commodity_name') . _l('not_yet_entered');
                                    $flag = 1;
                                }

                                //check unit_code exist  (input: id or name contract)
                                if (is_null($value_cell_unit_id) != true && ( $value_cell_unit_id != '0')) {
                                    /*case input id*/
                                    if (is_numeric($value_cell_unit_id)) {

                                        $this->db->where('unit_type_id', $value_cell_unit_id);
                                        $unit_id_value = $this->db->count_all_results(db_prefix() . 'ware_unit_type');

                                        if ($unit_id_value == 0) {
                                            $string_error .= _l('unit_id') . _l('does_not_exist');
                                            $flag2 = 1;
                                        } else {
                                            /*get id unit_id*/
                                            $flag_id_unit_id = $value_cell_unit_id;
                                        }

                                    } else {
                                        /*case input name*/
                                        $this->db->like(db_prefix() . 'ware_unit_type.unit_code', $value_cell_unit_id);

                                        $unit_id_value = $this->db->get(db_prefix() . 'ware_unit_type')->result_array();
                                        if (count($unit_id_value) == 0) {
                                            $string_error .= _l('unit_id') . _l('does_not_exist');
                                            $flag2 = 1;
                                        } else {
                                            /*get unit_id*/
                                            $flag_id_unit_id = $unit_id_value[0]['unit_type_id'];
                                        }
                                    }

                                }

                                //check commodity_group exist  (input: id or name contract)
                                if (is_null($value_cell_commodity_group) != true && ($value_cell_commodity_group != '0')) {
                                    /*case input id*/
                                    if (is_numeric($value_cell_commodity_group)) {

                                        $this->db->where('id', $value_cell_commodity_group);
                                        $commodity_group_value = $this->db->count_all_results(db_prefix() . 'items_groups');

                                        if ($commodity_group_value == 0) {
                                            $string_error .= _l('commodity_group') . _l('does_not_exist');
                                            $flag2 = 1;
                                        } else {
                                            /*get id commodity_group*/
                                            $flag_id_commodity_group = $value_cell_commodity_group;
                                        }

                                    } else {
                                        /*case input name*/
                                        $this->db->like(db_prefix() . 'items_groups.commodity_group_code', $value_cell_commodity_group);

                                        $commodity_group_value = $this->db->get(db_prefix() . 'items_groups')->result_array();
                                        if (count($commodity_group_value) == 0) {
                                            $string_error .= _l('commodity_group') . _l('does_not_exist');
                                            $flag2 = 1;
                                        } else {
                                            /*get id commodity_group*/

                                            $flag_id_commodity_group = $commodity_group_value[0]['id'];
                                        }
                                    }

                                }

                            
                                //check taxes exist  (input: id or name contract)
                                if (is_null($value_cell_tax) != true && ($value_cell_tax!= '0')) {
                                    /*case input id*/
                                    if (is_numeric($value_cell_tax)) {

                                        $this->db->where('id', $value_cell_tax);
                                        $cell_tax_value = $this->db->count_all_results(db_prefix() . 'taxes');

                                        if ($cell_tax_value == 0) {
                                            $string_error .= _l('tax') . _l('does_not_exist');
                                            $flag2 = 1;
                                        } else {
                                            /*get id cell_tax*/
                                            $flag_id_tax = $value_cell_tax;
                                        }

                                    } else {
                                        /*case input name*/
                                        $this->db->like(db_prefix() . 'taxes.name', $value_cell_tax);

                                        $cell_tax_value = $this->db->get(db_prefix() . 'taxes')->result_array();
                                        if (count($cell_tax_value) == 0) {
                                            $string_error .= _l('tax') . _l('does_not_exist');
                                            $flag2 = 1;
                                        } else {
                                            /*get id warehouse_id*/

                                            $flag_id_tax = $cell_tax_value[0]['id'];
                                        }
                                    }

                                }

                                //check commodity_group exist  (input: id or name contract)
                                if (is_null($value_cell_sub_group) != true) {
                                    /*case input id*/
                                    if (is_numeric($value_cell_sub_group)) {

                                        $this->db->where('id', $value_cell_sub_group);
                                        $sub_group_value = $this->db->count_all_results(db_prefix() . 'wh_sub_group');

                                        if ($sub_group_value == 0) {
                                            $string_error .= _l('sub_group') . _l('does_not_exist');
                                            $flag2 = 1;
                                        } else {
                                            /*get id sub_group*/
                                            $flag_id_sub_group = $value_cell_sub_group;
                                        }

                                    } else {
                                        /*case input  name*/
                                        $this->db->like(db_prefix() . 'wh_sub_group.sub_group_code', $value_cell_sub_group);

                                        $sub_group_value = $this->db->get(db_prefix() . 'wh_sub_group')->result_array();
                                        if (count($sub_group_value) == 0) {
                                            $string_error .= _l('sub_group') . _l('does_not_exist');
                                            $flag2 = 1;
                                        } else {
                                            /*get id sub_group*/

                                            $flag_id_sub_group = $sub_group_value[0]['id'];
                                        }
                                    }

                                }

                                //check value_cell_rate input
                                if (is_null($value_cell_rate) != true) {
                                    if (!is_numeric($value_cell_rate)) {
                                        $string_error .= _l('cell_rate') . _l('_check_invalid');
                                        $flag = 1;

                                    }

                                }

                                //check value_cell_rate input
                                if (is_null($value_cell_purchase_price) != true) {
                                    if (!is_numeric($value_cell_purchase_price)) {
                                        $string_error .= _l('purchase_price') . _l('_check_invalid');
                                        $flag = 1;

                                    }

                                }

                                if (($flag == 1) || ($flag2 == 1)) {
                                    $dataError->getActiveSheet()->setCellValue('A' . $numRow, $sheet->getCell('A' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('B' . $numRow, $sheet->getCell('B' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('C' . $numRow, $sheet->getCell('C' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('D' . $numRow, $sheet->getCell('D' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('E' . $numRow, $sheet->getCell('E' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('F' . $numRow, $sheet->getCell('F' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('G' . $numRow, $sheet->getCell('G' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('H' . $numRow, $sheet->getCell('H' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('I' . $numRow, $sheet->getCell('I' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('J' . $numRow, $sheet->getCell('J' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('K' . $numRow, $sheet->getCell('K' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('M' . $numRow, $sheet->getCell('M' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('N' . $numRow, $sheet->getCell('N' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('O' . $numRow, $sheet->getCell('O' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('P' . $numRow, $sheet->getCell('P' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('Q' . $numRow, $sheet->getCell('Q' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('R' . $numRow, $sheet->getCell('R' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('R' . $numRow, $sheet->getCell('R' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('S' . $numRow, $sheet->getCell('S' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('T' . $numRow, $sheet->getCell('T' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('U' . $numRow, $sheet->getCell('U' . $rowIndex)->getValue());
                                    $dataError->getActiveSheet()->setCellValue('V' . $numRow, $sheet->getCell('V' . $rowIndex)->getValue());


                                    $dataError->getActiveSheet()->setCellValue('W' . $numRow, $string_error)->getStyle('W' . $numRow)->applyFromArray($styleArray);

                                    $numRow++;
                                    $total_rows_data_error++;
                                }

                                if (($flag == 0) && ($flag2 == 0)) {


                                    /*staff id is HR_code, input is HR_CODE, insert => staffid*/
                                    $rd['commodity_code'] = $sheet->getCell('A' . $rowIndex)->getValue();
                                    $rd['commodity_barcode'] = $sheet->getCell('C' . $rowIndex)->getValue();
                                    $rd['sku_code'] = $sheet->getCell('D' . $rowIndex)->getValue();
                                    $rd['sku_name'] = $sheet->getCell('E' . $rowIndex)->getValue();
                                    $rd['description'] = $sheet->getCell('B' . $rowIndex)->getValue();
                                    $rd['long_description'] = $sheet->getCell('F' . $rowIndex)->getValue();
                                    $rd['unit_id'] = isset($flag_id_unit_id) ? $flag_id_unit_id : '';
                                    $rd['group_id'] = isset($flag_id_commodity_group) ? $flag_id_commodity_group : '';
                                    $rd['sub_group'] = isset($flag_id_sub_group) ? $flag_id_sub_group : '';
                                    $rd['tax'] = isset($flag_id_tax) ? $flag_id_tax : '';
                                    $rd['rate'] = $sheet->getCell('K' . $rowIndex)->getValue();
                                    $rd['purchase_price'] = $sheet->getCell('J' . $rowIndex)->getValue();

                                }

                                if (get_staff_user_id() != '' && $flag == 0 && $flag2 == 0) {
                                    $rows[] = $rd;
                                    $result_value = $this->purchase_model->import_xlsx_commodity($rd);
                                    if ($result_value) {
                                        $total_rows_actualy++;
                                    }
                                }

                                $total_rows++;
                                $total_rows_data++;
                            }

                        }

                        if ($total_rows_actualy != $total_rows) {
                            $total_rows = $total_rows_actualy;
                        }


                        $total_rows = $total_rows;
                        $data['total_rows_post'] = count($rows);
                        $total_row_success = count($rows);
                        $total_row_false = $total_rows - (int) count($rows);
                        $dataerror = $dataError;
                        $message = 'Not enought rows for importing';

                        if(($total_rows_data_error > 0) || ($total_row_false != 0)){
                            $objWriter = new PHPExcel_Writer_Excel2007($dataError);

                            $filename = 'FILE_ERROR_COMMODITY' .get_staff_user_id().strtotime(date('Y-m-d H:i:s')). '.xlsx';
                            $objWriter->save(str_replace($filename, PURCHASE_IMPORT_ITEM_ERROR.$filename, $filename));

                            $filename = PURCHASE_IMPORT_ITEM_ERROR.$filename;
           

                        }
                        
                        $import_result = true;
                        @delete_dir($tmpDir);

                    }
                    
                } else {
                    set_alert('warning', _l('import_upload_failed'));
                }
            }

        }
        echo json_encode([
            'message' =>'Not enought rows for importing',
            'total_row_success' => $total_row_success,
            'total_row_false' => $total_rows_data_error,
            'total_rows' => $total_rows_data,
            'site_url' => site_url(),
            'staff_id' => get_staff_user_id(),
            'total_rows_data_error' => $total_rows_data_error,
            'filename' => $filename,
        ]);

    }

    /**
     * { import vendor }
     */
    public function vendor_import()
    {
        if (!has_permission('purchase', '', 'create')) {
            access_denied('purchase');
        }

        $this->load->model('staff_model');
        $data_staff = $this->staff_model->get(get_staff_user_id());

        /*get language active*/
        if ($data_staff) {
            if ($data_staff->default_language != '') {
                $data['active_language'] = $data_staff->default_language;

            } else {

                $data['active_language'] = get_option('active_language');
            }

        } else {
            $data['active_language'] = get_option('active_language');
        }
        $data['title'] = _l('import_excel');

        $this->load->view('vendors/import_excel', $data);
    }

    /**
     * { reset data }
     */
    public function reset_data()
    {

        if ( !is_admin()) {
            access_denied('purchase');
        }

            //delete purchase request
            $this->db->truncate(db_prefix().'pur_request');
            //delete purchase request detail
            $this->db->truncate(db_prefix().'pur_request_detail');
            //delete purchase order
            $this->db->truncate(db_prefix().'pur_orders');
            //delete purchase order detail
            $this->db->truncate(db_prefix().'pur_order_detail');
            //delete purchase order payment
            $this->db->truncate(db_prefix().'pur_order_payment');
            //delete purchase invoice
            $this->db->truncate(db_prefix().'pur_invoices');
            //delete purchase invoice payment
            $this->db->truncate(db_prefix().'pur_invoice_payment');
            //delete purchase estimate
            $this->db->truncate(db_prefix().'pur_estimates');
            //delete pur_estimate_detail
            $this->db->truncate(db_prefix().'pur_estimate_detail');
            //delete pur_contracts
            $this->db->truncate(db_prefix().'pur_contracts');
            //delete tblpur_approval_details
            $this->db->truncate(db_prefix().'pur_approval_details');

            //delete create task rel_type: "pur_contract", "pur_contract".
            $this->db->where('rel_type', 'pur_contract');
            $this->db->or_where('rel_type', 'pur_order');
            $this->db->or_where('rel_type', 'pur_quotation');
            $this->db->or_where('rel_type', 'pur_invoice');
            $this->db->delete(db_prefix() . 'tasks');


            $this->db->where('rel_type', 'pur_contract');
            $this->db->or_where('rel_type', 'pur_order');
            $this->db->or_where('rel_type', 'pur_estimate');
            $this->db->or_where('rel_type', 'pur_invoice');
            $this->db->delete(db_prefix() . 'files');

            delete_files_pur(PURCHASE_MODULE_UPLOAD_FOLDER.'/pur_order/');
            delete_files_pur(PURCHASE_MODULE_UPLOAD_FOLDER.'/pur_contract/');
            delete_files_pur(PURCHASE_MODULE_UPLOAD_FOLDER.'/pur_order/signature/');
            delete_files_pur(PURCHASE_MODULE_UPLOAD_FOLDER.'/pur_invoice/');
            delete_files_pur(PURCHASE_MODULE_UPLOAD_FOLDER.'/pur_estimate/');
            delete_files_pur(PURCHASE_MODULE_UPLOAD_FOLDER.'/pur_estimate/signature/');
            delete_files_pur(PURCHASE_MODULE_UPLOAD_FOLDER.'/payment_invoice/signature/');
            delete_files_pur(PURCHASE_MODULE_UPLOAD_FOLDER.'/payment_request/signature/');
            delete_files_pur(PURCHASE_MODULE_UPLOAD_FOLDER.'/request_quotation/');
            delete_files_pur(PURCHASE_MODULE_UPLOAD_FOLDER.'/send_po/');
            delete_files_pur(PURCHASE_MODULE_UPLOAD_FOLDER.'/send_quotation/');

            $this->db->where('rel_type', 'pur_contract');
            $this->db->or_where('rel_type', 'purchase_order');
            $this->db->or_where('rel_type', 'pur_invoice');
            $this->db->delete(db_prefix() . 'notes');

            $this->db->where('rel_type', 'pur_contract');
            $this->db->or_where('rel_type', 'purchase_order');
            $this->db->or_where('rel_type', 'pur_invoice');
            $this->db->delete(db_prefix() . 'reminders');

            $this->db->where('fieldto', 'pur_order');
            $this->db->delete(db_prefix() . 'customfieldsvalues');

            $this->db->where('rel_type', 'pur_invoice');
            $this->db->or_where('rel_type', 'pur_order');
            $this->db->delete(db_prefix() . 'taggables');

            set_alert('success',_l('reset_data_successful'));
            
            redirect(admin_url('purchase/setting'));

    }

    /**
     * Removes a po logo.
     */
    public function remove_po_logo(){
        if (!has_permission('purchase', '', 'delete') || !is_admin()) {
            access_denied('purchase');
        }

        $success = $this->purchase_model->remove_po_logo();
        if($success){
            set_alert('success', _l('deleted', _l('po_logo')));
        }
        redirect(admin_url('purchase/setting'));
    }
}