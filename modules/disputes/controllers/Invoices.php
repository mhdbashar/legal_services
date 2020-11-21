<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Invoices extends AdminController
{
    private $ci;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model');
        $this->load->model('credit_notes_model');
        $this->ci = & get_instance();
    }



    /* Get all invoices in case user go on index page */
    public function index($id = '')
    {
        $this->list_invoices($id);

    }

    /* List all invoices datatables */
    public function list_invoices($id = '')
    {
        if (!has_permission('invoices', '', 'view')
            && !has_permission('invoices', '', 'view_own')
            && get_option('allow_staff_view_invoices_assigned') == '0') {
            access_denied('invoices');
        }

        close_setup_menu();

        $this->load->model('payment_modes_model');
        $data['payment_modes']        = $this->payment_modes_model->get('', [], true);
        $data['invoiceid']            = $id;
        $data['title']                = _l('invoices');
        $data['invoices_years']       = $this->invoices_model->get_invoices_years();
        $data['invoices_sale_agents'] = $this->invoices_model->get_sale_agents();
        $data['invoices_statuses']    = $this->invoices_model->get_statuses();
        $data['bodyclass']            = 'invoices-total-manual';
        $this->load->view('disputes/invoices/manage', $data);
    }

    /* List all recurring invoices */
    public function recurring($id = '')
    {
        if (!has_permission('invoices', '', 'view')
            && !has_permission('invoices', '', 'view_own')
            && get_option('allow_staff_view_invoices_assigned') == '0') {
            access_denied('invoices');
        }

        close_setup_menu();

        $data['invoiceid']            = $id;
        $data['title']                = _l('invoices_list_recurring');
        $data['invoices_years']       = $this->invoices_model->get_invoices_years();
        $data['invoices_sale_agents'] = $this->invoices_model->get_sale_agents();
        $this->load->view('disputes/invoices/recurring/list', $data);
    }

    public function disputes_get_table_data($table, $params = [])
    {
        $params = hooks()->apply_filters('table_params', $params, $table);

        foreach ($params as $key => $val) {
            $$key = $val;
        }

        $customFieldsColumns = [];

        $path = APPPATH.'../modules/disputes/views/invoices/' . $table . EXT;

        /*if (!file_exists($path)) {
            $path = $table;
            if (!endsWith($path, EXT)) {
                $path .= EXT;
            }
        } else {
            $myPrefixedPath = VIEWPATH . 'admin/tables/my_' . $table . EXT;
            if (file_exists($myPrefixedPath)) {
                $path = $myPrefixedPath;
            }
        }*/

        include_once($path);

        echo json_encode($output);
        die;
    }


    public function table($clientid = '')
    {
        if (!has_permission('invoices', '', 'view')
            && !has_permission('invoices', '', 'view_own')
            && get_option('allow_staff_view_invoices_assigned') == '0') {
            ajax_access_denied();
        }

        $this->load->model('payment_modes_model');
        $data['payment_modes'] = $this->payment_modes_model->get('', [], true);

        $this->disputes_get_table_data(($this->input->get('recurring') ? 'recurring_invoices' : 'invoices'), [
            'clientid' => $clientid,
            'data'     => $data,
        ]);
    }

    public function client_change_data($customer_id, $current_invoice = '')
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('projects_model');
            $data                     = [];
            $data['billing_shipping'] = $this->clients_model->get_customer_billing_and_shipping_details($customer_id);
            $data['client_currency']  = $this->clients_model->get_customer_default_currency($customer_id);

            $data['customer_has_projects'] = customer_has_projects($customer_id);
            $data['billable_tasks']        = $this->tasks_model->get_billable_tasks($customer_id);

            if ($current_invoice != '') {
                $this->db->select('status');
                $this->db->where('id', $current_invoice);
                $current_invoice_status = $this->db->get(db_prefix() . 'my_project_invoices')->row()->status;
            }

            $_data['invoices_to_merge'] = !isset($current_invoice_status) || (isset($current_invoice_status) && $current_invoice_status != Invoices_model::STATUS_CANCELLED) ? $this->invoices_model->check_for_merge_invoice($customer_id, $current_invoice) : [];

            $data['merge_info'] = $this->load->view('disputes/invoices/merge_invoice', $_data, true);

            $this->load->model('currencies_model');

            $__data['expenses_to_bill'] = !isset($current_invoice_status) || (isset($current_invoice_status) && $current_invoice_status != Invoices_model::STATUS_CANCELLED) ? $this->invoices_model->get_expenses_to_bill($customer_id) : [];

            $data['expenses_bill_info'] = $this->load->view('disputes/invoices/bill_expenses', $__data, true);
            echo json_encode($data);
        }
    }

    public function update_number_settings($id)
    {
        $response = [
            'success' => false,
            'message' => '',
        ];
        if (has_permission('invoices', '', 'edit')) {
            $affected_rows = 0;

            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'my_project_invoices', [
                'prefix' => $this->input->post('prefix'),
            ]);
            if ($this->db->affected_rows() > 0) {
                $affected_rows++;
            }

            if ($affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = _l('updated_successfully', _l('invoice'));
            }
        }
        echo json_encode($response);
        die;
    }

    public function validate_invoice_number()
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
        if (total_rows(db_prefix() . 'my_project_invoices', [
            'YEAR(date)' => date('Y', strtotime(to_sql_date($date))),
            'number' => $number,
        ]) > 0) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function add_note($rel_id)
    {
        if ($this->input->post() && user_can_view_invoice($rel_id)) {
            $this->misc_model->add_note($this->input->post(), 'invoice', $rel_id);
            echo $rel_id;
        }
    }

    public function get_notes($id)
    {
        if (user_can_view_invoice($id)) {
            $data['notes'] = $this->misc_model->get_notes($id, 'invoice');
            $this->load->view('admin/includes/sales_notes_template', $data);
        }
    }

    public function pause_overdue_reminders($id)
    {
        if (has_permission('invoices', '', 'edit')) {
            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'my_project_invoices', ['cancel_overdue_reminders' => 1]);
        }
        redirect(admin_url('disputes/invoices/list_invoices/' . $id));
    }

    public function resume_overdue_reminders($id)
    {
        if (has_permission('invoices', '', 'edit')) {
            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'my_project_invoices', ['cancel_overdue_reminders' => 0]);
        }
        redirect(admin_url('disputes/invoices/list_invoices/' . $id));
    }

    public function mark_as_cancelled($id)
    {
        if (!has_permission('invoices', '', 'edit') && !has_permission('invoices', '', 'create')) {
            access_denied('invoices');
        }

        $success = $this->invoices_model->mark_as_cancelled($id);

        if ($success) {
            set_alert('success', _l('invoice_marked_as_cancelled_successfully'));
        }

        redirect(admin_url('disputes/invoices/list_invoices/' . $id));
    }

    public function unmark_as_cancelled($id)
    {
        if (!has_permission('invoices', '', 'edit') && !has_permission('invoices', '', 'create')) {
            access_denied('invoices');
        }
        $success = $this->invoices_model->unmark_as_cancelled($id);
        if ($success) {
            set_alert('success', _l('invoice_unmarked_as_cancelled'));
        }
        redirect(admin_url('disputes/invoices/list_invoices/' . $id));
    }

    public function copy($id)
    {
        if (!$id) {
            redirect(admin_url('invoices'));
        }
        if (!has_permission('invoices', '', 'create')) {
            access_denied('invoices');
        }
        $new_id = $this->invoices_model->copy($id);
        if ($new_id) {
            set_alert('success', _l('invoice_copy_success'));
            redirect(admin_url('disputes/invoices/invoice/' . $new_id));
        } else {
            set_alert('success', _l('invoice_copy_fail'));
        }
        redirect(admin_url('disputes/invoices/invoice/' . $id));
    }

    public function get_merge_data($id)
    {
        $invoice = $this->invoices_model->get($id);
        $cf      = get_custom_fields('items');

        $i = 0;

        foreach ($invoice->items as $item) {
            $invoice->items[$i]['taxname']          = get_invoice_item_taxes($item['id']);
            $invoice->items[$i]['long_description'] = clear_textarea_breaks($item['long_description']);
            $this->db->where('item_id', $item['id']);
            $rel              = $this->db->get(db_prefix().'related_items')->result_array();
            $item_related_val = '';
            $rel_type         = '';
            foreach ($rel as $item_related) {
                $rel_type = $item_related['rel_type'];
                $item_related_val .= $item_related['rel_id'] . ',';
            }
            if ($item_related_val != '') {
                $item_related_val = substr($item_related_val, 0, -1);
            }
            $invoice->items[$i]['item_related_formatted_for_input'] = $item_related_val;
            $invoice->items[$i]['rel_type']                         = $rel_type;

            $invoice->items[$i]['custom_fields'] = [];

            foreach ($cf as $custom_field) {
                $custom_field['value']                 = get_custom_field_value($item['id'], $custom_field['id'], 'items');
                $invoice->items[$i]['custom_fields'][] = $custom_field;
            }
            $i++;
        }
        echo json_encode($invoice);
    }

    public function get_bill_expense_data($id)
    {
        $this->load->model('expenses_model');
        $expense = $this->expenses_model->get($id);

        $expense->qty              = 1;
        $expense->long_description = clear_textarea_breaks($expense->description);
        $expense->description      = $expense->name;
        $expense->rate             = $expense->amount;
        if ($expense->tax != 0) {
            $expense->taxname = [];
            array_push($expense->taxname, $expense->tax_name . '|' . $expense->taxrate);
        }
        if ($expense->tax2 != 0) {
            array_push($expense->taxname, $expense->tax_name2 . '|' . $expense->taxrate2);
        }
        echo json_encode($expense);
    }

    /* Add new invoice or update existing */
    public function invoice($id = '')
    {
        
        if ($this->input->post()) {
            $invoice_data = $this->input->post();

            $opponents = $invoice_data['opponents'];
            unset($invoice_data['opponents']);
            



            if ($id == '') {
                if (!has_permission('invoices', '', 'create')) {
                    access_denied('invoices');
                }



            $cycls = $invoice_data['cycles']>1 ? $invoice_data['cycles'] : 1;
            $installment_date = $invoice_data['installment_date'];
            $installment_total = $invoice_data['installment_total'];
            unset($invoice_data['recurring'],$invoice_data['cycles'],$invoice_data['installment_date'],$invoice_data['installment_total']);
            $redUrl = array();

            for($cycl=0; $cycl<$cycls; $cycl++) {

                $invoice_data['discount_percent'] = 0;
                $invoice_data['discount_total'] = 0;
                $invoice_data['adjustment'] = 0;
                $invoice_data['duedate'] = $installment_date[$cycl];
                $invoice_data['subtotal'] = $invoice_data['total'] = $installment_total[$cycl];

                $id = $this->invoices_model->add($invoice_data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('invoice')));
                    $redUrl[] = admin_url('disputes/invoices/list_invoices/' . $id);
                }
                
            }



                if (isset($invoice_data['save_and_record_payment'])) {
                    $this->session->set_userdata('record_payment', true);
                }

                redirect($redUrl[0]);
            




                
            } else {
                if (!has_permission('invoices', '', 'edit')) {
                    access_denied('invoices');
                }


            $cycls = $invoice_data['cycles']>1 ? $invoice_data['cycles'] : 1;
            $installment_date = $invoice_data['installment_date'];
            $installment_total = $invoice_data['installment_total'];
            unset($invoice_data['recurring'],$invoice_data['cycles'],$invoice_data['installment_date'],$invoice_data['installment_total']);

            foreach ($opponents as $opponent) {
                $this->db->insert(db_prefix() . 'my_disputes_opponents', [
                    'opponent_id' => $opponent,
                    'dispute_id' => $invoice_data['project_id']
                ]);
            }
            $invoice_data['project_id'] = $invoice_data['project_id'];
            $redUrl = array();

            for($cycl=0; $cycl<$cycls; $cycl++) {

                $invoice_data['discount_percent'] = 0;
                $invoice_data['discount_total'] = 0;
                $invoice_data['adjustment'] = 0;
                $invoice_data['duedate'] = $installment_date[$cycl];
                $invoice_data['subtotal'] = $invoice_data['total'] = $installment_total[$cycl];

                $success = $this->invoices_model->update($invoice_data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('invoice')));
                }
                
            }


                
                redirect(admin_url('disputes/invoices/list_invoices/' . $id));
            }
        }
        if ($id == '') {
            $title                  = _l('create_new_invoice');
            $data['billable_tasks'] = [];
        } else {
            $invoice = $this->invoices_model->get($id);

            if (!$invoice || !user_can_view_invoice($id)) {
                blank_page(_l('invoice_not_found'));
            }

            $data['invoices_to_merge'] = $this->invoices_model->check_for_merge_invoice($invoice->clientid, $invoice->id);
            $data['expenses_to_bill']  = $this->invoices_model->get_expenses_to_bill($invoice->clientid);

            $data['invoice']        = $invoice;
            $data['edit']           = true;
            $data['billable_tasks'] = $this->tasks_model->get_billable_tasks($invoice->clientid, !empty($invoice->project_id) ? $invoice->project_id : '');

            $title = _l('edit', _l('invoice_lowercase')) . ' - ' . format_invoice_number($invoice->id);
        }

        if ($this->input->get('customer_id')) {
            $data['customer_id'] = $this->input->get('customer_id');
        }

        $this->load->model('payment_modes_model');
        $data['payment_modes'] = $this->payment_modes_model->get('', [
            'expenses_only !=' => 1,
        ]);

        $this->load->model('taxes_model');
        $data['taxes'] = $this->taxes_model->get();
        $this->load->model('invoice_items_model');

        $data['ajaxItems'] = false;
        if (total_rows(db_prefix().'items') <= ajax_on_total_items()) {
            $data['items'] = $this->invoice_items_model->get_grouped();
        } else {
            $data['items']     = [];
            $data['ajaxItems'] = true;
        }
        $data['items_groups'] = $this->invoice_items_model->get_groups();

        $this->load->model('currencies_model');
        $data['currencies'] = $this->currencies_model->get();

        $data['base_currency'] = $this->currencies_model->get_base_currency();

        $data['staff']     = $this->staff_model->get('', ['active' => 1]);
        $data['title']     = $title;
        $data['bodyclass'] = 'invoice';
        // Extract meta values of this project
        $this->load->model('Disputes_model');
        $meta = $this->Disputes_model->get_project_meta($invoice->project_id?$invoice->project_id:0);
        $data['meta'] = array();
        foreach ($meta as $array) {
            $data['meta'][$array['meta_key']] = $array['meta_value'];
        }
        $opponents = explode(',', isset($data['meta']['opponent_id'])?$data['meta']['opponent_id']:'');
        $data['opponents'] = array();
        foreach ($opponents as $opponent) {
            if($opponent) $data['opponents'][] = $this->clients_model->get($opponent);
        }
        $this->db->where('dispute_id', $invoice->project_id);
        $data['selected_opponents'] = $this->db->get('tblmy_disputes_opponents')->result_array();
        $this->load->view('disputes/invoices/invoice', $data);
    }

    /* Get all invoice data used when user click on invoiec number in a datatable left side*/
    public function get_invoice_data_ajax($id)
    {
        if (!has_permission('invoices', '', 'view')
            && !has_permission('invoices', '', 'view_own')
            && get_option('allow_staff_view_invoices_assigned') == '0') {
            echo _l('access_denied');
            die;
        }

        if (!$id) {
            die(_l('invoice_not_found'));
        }

        $invoice = $this->invoices_model->get($id);

        if (!$invoice || !disputes_user_can_view_invoice($id)) {
            echo _l('invoice_not_found');
            die;
        }

        $invoice->date    = _d($invoice->date);
        $invoice->duedate = _d($invoice->duedate);

        $template_name = 'invoice_send_to_customer';

        if ($invoice->sent == 1) {
            $template_name = 'invoice_send_to_customer_already_sent';
        }

        $data = prepare_mail_preview_data($template_name, $invoice->clientid);

        // Check for recorded payments
        $this->load->model('payments_model');
        $data['invoices_to_merge']          = $this->invoices_model->check_for_merge_invoice($invoice->clientid, $id);
        $data['members']                    = $this->staff_model->get('', ['active' => 1]);
        $data['payments']                   = $this->payments_model->get_invoice_payments($id);
        $data['activity']                   = $this->invoices_model->get_invoice_activity($id);
        $data['totalNotes']                 = total_rows(db_prefix().'notes', ['rel_id' => $id, 'rel_type' => 'invoice']);
        $data['invoice_recurring_invoices'] = $this->invoices_model->get_invoice_recurring_invoices($id);

        $data['applied_credits'] = $this->credit_notes_model->get_applied_invoice_credits($id);
        // This data is used only when credit can be applied to invoice
        if (credits_can_be_applied_to_invoice($invoice->status)) {
            $data['credits_available'] = $this->credit_notes_model->total_remaining_credits_by_customer($invoice->clientid);

            if ($data['credits_available'] > 0) {
                $data['open_credits'] = $this->credit_notes_model->get_open_credits($invoice->clientid);
            }

            $customer_currency = $this->clients_model->get_customer_default_currency($invoice->clientid);
            $this->load->model('currencies_model');

            if ($customer_currency != 0) {
                $data['customer_currency'] = $this->currencies_model->get($customer_currency);
            } else {
                $data['customer_currency'] = $this->currencies_model->get_base_currency();
            }
        }

        $data['invoice'] = $invoice;

        $data['record_payment'] = false;

        if ($this->session->has_userdata('record_payment')) {
            $data['record_payment'] = true;
            $this->session->unset_userdata('record_payment');
        }

        $this->load->view('disputes/invoices/invoice_preview_template', $data);
    }

    public function apply_credits($invoice_id)
    {
        $total_credits_applied = 0;
        foreach ($this->input->post('amount') as $credit_id => $amount) {
            $success = $this->credit_notes_model->apply_credits($credit_id, [
            'invoice_id' => $invoice_id,
            'amount'     => $amount,
        ]);
            if ($success) {
                $total_credits_applied++;
            }
        }

        if ($total_credits_applied > 0) {
            update_invoice_status($invoice_id, true);
            set_alert('success', _l('invoice_credits_applied'));
        }
        redirect(admin_url('disputes/invoices/list_invoices/' . $invoice_id));
    }

    public function get_invoices_total()
    {
        if ($this->input->post()) {
            load_invoices_total_template();
        }
    }

    /* Record new inoice payment view */
    public function record_invoice_payment_ajax($id)
    {
        $this->load->model('payment_modes_model');
        $this->load->model('payments_model');
        $data['payment_modes'] = $this->payment_modes_model->get('', [
            'expenses_only !=' => 1,
        ]);
        $data['invoice']  = $this->invoices_model->get($id);
        $data['payments'] = $this->payments_model->get_invoice_payments($id);
        $this->load->view('disputes/invoices/record_payment_template', $data);
    }



    /* This is where invoice payment record $_POST data is send */
    public function record_payment()
    {
        if (!has_permission('payments', '', 'create')) {
            access_denied('Record Payment');
        }
        if ($this->input->post()) {
            $this->load->model('payments_model');

            $data = $this->input->post();
            $invoice_data = $this->invoices_model->get($data['invoiceid']);

            $project_data = $this->projects_model->get($invoice_data->project_id);
            $billing_type = $project_data->billing_type;
            $project_percent = $project_data->project_rate_per_hour;
            $project_cost = $project_data->project_cost;
            //$percent = $invoice_data->total * $project_percent / 100;
            $percent = $data['amount'] * $project_percent / 100;

            //[newitems] => Array ( [1] => Array ( [order] => 1 [description] => Disputes static fees [long_description] => [qty] => 1 [unit] => [rate] => 500 ) [2] => Array ( [order] => 2 [description] => Disputes percent fees [long_description] => [qty] => 1 [unit] => [rate] => 25 ) [3] => Array ( [order] => 3 [description] => test [long_description] => [qty] => 1 [unit] => [rate] => 5 ) )
            
            $newitems = array();
            $new_total = 0;

            if($billing_type==11){
                $new_total = $percent;
                $newitems[] = Array ( 'order' => 1, 'description' => 'Disputes percent fees', 'long_description' =>'', 'qty' => 1, 'unit' => '', 'rate' => $percent  );

            }elseif($billing_type==1 || $billing_type==10){

                if (total_rows(db_prefix() . 'invoices', [
                            'project_id' => $invoice_data->project_id,
                        ]) > 0) {
                    $project_cost = 0;
                }else{
                    $newitems[] = Array ( 'order' => 1, 'description' => 'Disputes static fees', 'long_description' =>'', 'qty' => 1, 'unit' => '', 'rate' => $project_cost  );
                }


                if($billing_type==10){

                    $newitems[] = Array ( 'order' => 2, 'description' => 'Disputes percent fees', 'long_description' =>'', 'qty' => 1, 'unit' => '', 'rate' => $percent  );

                    $new_total = $percent + $project_cost;

                }elseif($billing_type==1){
                    $new_total = $project_cost;
                }

            }
            
            //print_r($invoice_data);die();
            //stdClass Object ( [id] => 14 [sent] => 0 [datesend] => [clientid] => 2 [deleted_customer_name] => [number] => 3 [prefix] => DIS- [number_format] => 1 [datecreated] => 2019-09-20 21:32:20 [date] => 2019-09-20 [duedate] => 2019-10-20 [currency] => 1 [subtotal] => 380.00 [total_tax] => 0.00 [total] => 380.00 [adjustment] => 0.00 [addedfrom] => 1 [hash] => b65173b8582a5131f8833a6b8434772e [status] => 1 [clientnote] => [adminnote] => [last_overdue_reminder] => [cancel_overdue_reminders] => 0 [allowed_payment_modes] => a:1:{i:0;s:1:"1";} [token] => [discount_percent] => 0.00 [discount_total] => 0.00 [discount_type] => [recurring] => 0 [recurring_type] => [custom_recurring] => 0 [cycles] => 0 [total_cycles] => 0 [is_recurring_from] => [last_recurring_date] => [terms] => [sale_agent] => 0 [billing_street] => [billing_city] => [billing_state] => [billing_zip] => [billing_country] => [shipping_street] => [shipping_city] => [shipping_state] => [shipping_zip] => [shipping_country] => [include_shipping] => 0 [show_shipping_on_invoice] => 1 [show_quantity_as] => 1 [project_id] => 6 [rel_sid] => [rel_stype] => [subscription_id] => 0 [symbol] => $ [name] => USD [decimal_separator] => . [thousand_separator] => , [placement] => before [isdefault] => 1 [currencyid] => 1 [currency_name] => USD [total_left_to_pay] => 380.00 [items] => Array ( [0] => Array ( [id] => 12 [rel_id] => 14 [rel_type] => invoice [description] => [long_description] => [qty] => 1.00 [rate] => 55.00 [unit] => [item_order] => 1 ) ) [attachments] => Array ( ) [project_data] => stdClass Object ( [id] => 6 [name] => Yasser Alkhayat [description] => [status] => 2 [clientid] => 2 [billing_type] => 1 [start_date] => 2019-08-17 [deadline] => [project_created] => 2019-08-17 [date_finished] => [progress] => 0 [progress_from_tasks] => 0 [project_cost] => 0.00 [project_rate_per_hour] => 0.00 [estimated_hours] => 0.00 [addedfrom] => 1 [project_type] => 1 [shared_vault_entries] => Array ( ) [settings] => stdClass Object ( [available_features] => a:15:{s:16:"project_overview";i:1;s:13:"project_tasks";i:1;s:18:"project_timesheets";i:1;s:18:"project_milestones";i:1;s:13:"project_files";i:1;s:19:"project_discussions";i:1;s:13:"project_gantt";i:1;s:15:"project_tickets";i:1;s:16:"project_invoices";i:1;s:17:"project_estimates";i:1;s:16:"project_expenses";i:1;s:20:"project_credit_notes";i:1;s:21:"project_subscriptions";i:1;s:13:"project_notes";i:1;s:16:"project_activity";i:1;} [view_tasks] => 1 [create_tasks] => 1 [edit_tasks] => 1 [comment_on_tasks] => 1 [view_task_comments] => 1 [view_task_attachments] => 1 [view_task_checklist_items] => 1 [upload_on_tasks] => 1 [view_task_total_logged_time] => 1 [view_finance_overview] => 1 [upload_files] => 1 [open_discussions] => 1 [view_milestones] => 1 [view_gantt] => 1 [view_timesheets] => 1 [view_activity_log] => 1 [view_team_members] => 1 [hide_tasks_on_main_tasks_table] => 0 ) [client_data] => stdClass Object ( [userid] => 2 [company] => Client company [vat] => [phonenumber] => [country] => 194 [city] => al-baha [zip] => [state] => [address] => [website] => [datecreated] => 2019-07-25 13:58:22 [active] => 1 [leadid] => [billing_street] => [billing_city] => [billing_state] => [billing_zip] => [billing_country] => 0 [shipping_street] => [shipping_city] => [shipping_state] => [shipping_zip] => [shipping_country] => 0 [longitude] => [latitude] => [default_language] => [default_currency] => 0 [show_primary_contact] => 0 [stripe_id] => [registration_confirmed] => 1 [addedfrom] => 1 [individual] => 0 ) ) [visible_attachments_to_customer_found] => [client] => stdClass Object ( [userid] => 2 [company] => Client company [vat] => [phonenumber] => [country] => 194 [city] => al-baha [zip] => [state] => [address] => [website] => [datecreated] => 2019-07-25 13:58:22 [active] => 1 [leadid] => [billing_street] => [billing_city] => [billing_state] => [billing_zip] => [billing_country] => 0 [shipping_street] => [shipping_city] => [shipping_state] => [shipping_zip] => [shipping_country] => 0 [longitude] => [latitude] => [default_language] => [default_currency] => 0 [show_primary_contact] => 0 [stripe_id] => [registration_confirmed] => 1 [addedfrom] => 1 [individual] => 0 ) [payments] => Array ( ) )

            //Array ( [clientid] => 2 [billing_street] => [billing_city] => [billing_state] => [billing_zip] => [show_shipping_on_invoice] => on [shipping_street] => [shipping_city] => [shipping_state] => [shipping_zip] => [number] => 3 [date] => 1441-1-21 [duedate] => 1441-1-21 [tags] => [allowed_payment_modes] => Array ( [0] => 1 ) [currency] => 1 [sale_agent] => [discount_type] => [repeat_every_custom] => 1 [repeat_type_custom] => day [adminnote] => [subtotal] => 330.00 [discount_percent] => 0 [discount_total] => 0 [adjustment] => 0 [total] => 330.00 [task_id] => [expense_id] => [clientnote] => [terms] => [save_and_send] => true [project_id] => 6 [prefix] => DIS- )


            //Array ( [cancel_merged_invoices] => on [clientid] => 2 [billing_street] => [billing_city] => [billing_state] => [billing_zip] => [show_shipping_on_invoice] => on [shipping_street] => [shipping_city] => [shipping_state] => [shipping_zip] => [number] => 000024 [date] => 1441-1-22 [duedate] => 1441-2-22 [tags] => [allowed_payment_modes] => Array ( [0] => 1 ) [currency] => 1 [sale_agent] => [recurring] => 0 [discount_type] => [repeat_every_custom] => 1 [repeat_type_custom] => day [adminnote] => [item_select] => [show_quantity_as] => 1 [description] => [long_description] => [quantity] => 1 [unit] => [rate] => [newitems] => Array ( [1] => Array ( [order] => 1 [description] => Disputes static fees [long_description] => [qty] => 1 [unit] => [rate] => 500 ) [2] => Array ( [order] => 2 [description] => Disputes percent fees [long_description] => [qty] => 1 [unit] => [rate] => 25 ) [3] => Array ( [order] => 3 [description] => test [long_description] => [qty] => 1 [unit] => [rate] => 5 ) ) [subtotal] => 530.00 [discount_percent] => 0 [discount_total] => 0.00 [adjustment] => 0 [total] => 530.00 [task_id] => [expense_id] => [clientnote] => [terms] => [project_id] => 4 )
            $id = $this->payments_model->process_payment($data, '');
            if ($id) {

                //Array ( [invoiceid] => 14 [amount] => 380.00 [date] => 1441-1-21 [paymentmode] => 1 [do_not_redirect] => on [transactionid] => 25552135123221 [note] => )

                    $invoice_data = Array ( 'clientid' => $invoice_data->clientid,
                     'billing_street' => $invoice_data->billing_street, 
                     'billing_city' => $invoice_data->billing_city, 
                     'billing_state' => $invoice_data->billing_state, 
                     'billing_zip' => $invoice_data->billing_zip, 
                     'show_shipping_on_invoice' => 'on',
                     'shipping_street' => $invoice_data->shipping_street, 
                     'shipping_city' => $invoice_data->shipping_city, 
                     'shipping_state' => $invoice_data->shipping_state, 
                     'shipping_zip' => $invoice_data->shipping_zip, 
                     'number' =>  get_option('next_invoice_number'),
                     'date' => _d(date('Y-m-d')), 
                     'duedate' => _d(date('Y-m-d')), 
                     //'tags' => $invoice_data->tags, 
                     'allowed_payment_modes' => Array ( 1 ), 
                     'currency' => $invoice_data->currency, 
                     'sale_agent' => $invoice_data->sale_agent, 
                     'discount_type' => $invoice_data->discount_type, 
                     //'repeat_every_custom' => $invoice_data->repeat_every_custom, 
                     //'repeat_type_custom' => $invoice_data->repeat_type_custom, 
                     'adminnote' => $invoice_data->adminnote, 
                     'subtotal' =>  $new_total,
                     'discount_percent' => $invoice_data->discount_percent, 
                     'discount_total' => $invoice_data->discount_total, 
                     'adjustment' => $invoice_data->adjustment, 
                     'total' =>  $new_total,
                     //'task_id' => $invoice_data->task_id, 
                     //'expense_id' => $invoice_data->expense_id, 
                     'clientnote' => $invoice_data->clientnote, 
                     'terms' => $invoice_data->terms, 
                     'newitems' => $newitems,
                     'project_id' => $invoice_data->project_id );
                    
                    if($new_total>0) $id2 = $this->invoices_model->add_invoice($invoice_data);
                    if ($id2) {
                        set_alert('success', _l('added_successfully', _l('invoice')));
                        redirect(admin_url('invoices/list_invoices/' . $id2));
                        //if (isset($invoice_data['save_and_record_payment'])) {
                        //    $this->session->set_userdata('record_payment', true);
                        //}
                    }
                




                set_alert('success', _l('invoice_payment_recorded'));
                //redirect(admin_url('disputes/payments/payment/' . $id));
            } else {
                set_alert('danger', _l('invoice_payment_record_failed'));
            }
            redirect(admin_url('disputes/invoices/list_invoices/' . $this->input->post('invoiceid')));
        }
    }

    /* Send invoice to email */
    public function send_to_email($id)
    {
        $canView = user_can_view_invoice($id);
        if (!$canView) {
            access_denied('Invoices');
        } else {
            if (!has_permission('invoices', '', 'view') && !has_permission('invoices', '', 'view_own') && $canView == false) {
                access_denied('Invoices');
            }
        }

        try {
            $success = $this->invoices_model->send_invoice_to_client($id, '', $this->input->post('attach_pdf'), $this->input->post('cc'));
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo $message;
            if (strpos($message, 'Unable to get the size of the image') !== false) {
                show_pdf_unable_to_get_image_size_error();
            }
            die;
        }

        // In case client use another language
        load_admin_language();
        if ($success) {
            set_alert('success', _l('invoice_sent_to_client_success'));
        } else {
            set_alert('danger', _l('invoice_sent_to_client_fail'));
        }
        redirect(admin_url('disputes/invoices/list_invoices/' . $id));
    }

    /* Delete invoice payment*/
    public function delete_payment($id, $invoiceid)
    {
        if (!has_permission('payments', '', 'delete')) {
            access_denied('payments');
        }
        $this->load->model('payments_model');
        if (!$id) {
            redirect(admin_url('payments'));
        }
        $response = $this->payments_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('payment')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('payment_lowercase')));
        }
        redirect(admin_url('disputes/invoices/list_invoices/' . $invoiceid));
    }

    /* Delete invoice */
    public function delete($id)
    {
        if (!has_permission('invoices', '', 'delete')) {
            access_denied('invoices');
        }
        if (!$id) {
            redirect(admin_url('disputes/invoices/list_invoices'));
        }
        $success = $this->invoices_model->delete($id);

        if ($success) {
            set_alert('success', _l('deleted', _l('invoice')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('invoice_lowercase')));
        }
        if (strpos($_SERVER['HTTP_REFERER'], 'list_invoices') !== false) {
            redirect(admin_url('disputes/invoices/list_invoices'));
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete_attachment($id)
    {
        $file = $this->misc_model->get_file($id);
        if ($file->staffid == get_staff_user_id() || is_admin()) {
            echo $this->invoices_model->delete_attachment($id);
        } else {
            header('HTTP/1.0 400 Bad error');
            echo _l('access_denied');
            die;
        }
    }

    /* Will send overdue notice to client */
    public function send_overdue_notice($id)
    {
        $canView = user_can_view_invoice($id);
        if (!$canView) {
            access_denied('Invoices');
        } else {
            if (!has_permission('invoices', '', 'view') && !has_permission('invoices', '', 'view_own') && $canView == false) {
                access_denied('Invoices');
            }
        }

        $send = $this->invoices_model->send_invoice_overdue_notice($id);
        if ($send) {
            set_alert('success', _l('invoice_overdue_reminder_sent'));
        } else {
            set_alert('warning', _l('invoice_reminder_send_problem'));
        }
        redirect(admin_url('disputes/invoices/list_invoices/' . $id));
    }

    /* Generates invoice PDF and senting to email of $send_to_email = true is passed */
    public function pdf($id)
    {
        if (!$id) {
            redirect(admin_url('disputes/invoices/list_invoices'));
        }

        $canView = user_can_view_invoice($id);
        if (!$canView) {
            access_denied('Invoices');
        } else {
            if (!has_permission('invoices', '', 'view') && !has_permission('invoices', '', 'view_own') && $canView == false) {
                access_denied('Invoices');
            }
        }

        $invoice        = $this->invoices_model->get($id);
        $invoice        = hooks()->apply_filters('before_admin_view_invoice_pdf', $invoice);
        $invoice_number = format_invoice_number($invoice->id);

        try {
            $pdf = invoice_pdf($invoice);
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo $message;
            if (strpos($message, 'Unable to get the size of the image') !== false) {
                show_pdf_unable_to_get_image_size_error();
            }
            die;
        }

        $type = 'D';

        if ($this->input->get('output_type')) {
            $type = $this->input->get('output_type');
        }

        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf->Output(mb_strtoupper(slug_it($invoice_number)) . '.pdf', $type);
    }

    public function mark_as_sent($id)
    {
        if (!$id) {
            redirect(admin_url('disputes/invoices/list_invoices'));
        }
        if (!user_can_view_invoice($id)) {
            access_denied('Invoice Mark As Sent');
        }
        $success = $this->invoices_model->set_invoice_sent($id, true);
        if ($success) {
            set_alert('success', _l('invoice_marked_as_sent'));
        } else {
            set_alert('warning', _l('invoice_marked_as_sent_failed'));
        }
        redirect(admin_url('disputes/invoices/list_invoices/' . $id));
    }

    public function get_due_date()
    {
        if ($this->input->post()) {
            $date    = $this->input->post('date');
            $duedate = '';
            if (get_option('invoice_due_after') != 0) {
                $date    = to_sql_date($date);
                $d       = date('Y-m-d', strtotime('+' . get_option('invoice_due_after') . ' DAY', strtotime($date)));
                $duedate = _d($d);
                echo $duedate;
            }
        }
    }
}
