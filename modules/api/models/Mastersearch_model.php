<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mastersearch_model extends App_Model
{
    public $notifications_limit;

    public function __construct()
    {
        parent::__construct();
        $this->notifications_limit = 15;
    }

   
   
    public function perform_search($q,$staffid)
    {
        $q = trim($q);
        $this->load->model('staff_model');
        $is_admin                       = is_admin();
        $result                         = [];
        $limit                          = get_option('limit_top_search_bar_results_to');
        $have_assigned_customers        = have_assigned_customers();
        $have_permission_customers_view = has_permission('customers', $staffid, 'view');

        if ($have_assigned_customers || $have_permission_customers_view) {

            // Clients
            $this->db->select(implode(',', prefixed_table_fields_array(db_prefix() . 'clients')) . ',' . get_sql_select_client_company());

            $this->db->join(db_prefix() . 'countries', db_prefix() . 'countries.country_id = ' . db_prefix() . 'clients.country', 'left');
            $this->db->join(db_prefix() . 'contacts', db_prefix() . 'contacts.userid = ' . db_prefix() . 'clients.userid AND is_primary = 1', 'left');
            $this->db->from(db_prefix() . 'clients');
            if ($have_assigned_customers && !$have_permission_customers_view) {
                $this->db->where(db_prefix() . 'clients.userid IN (SELECT customer_id FROM ' . db_prefix() . 'customer_admins WHERE staff_id=' . $staffid . ')');
            }

            $this->db->where('(company LIKE "%' . $q . '%"
                OR vat LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'clients.phonenumber LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'contacts.phonenumber LIKE "%' . $q . '%"
                OR city LIKE "%' . $q . '%"
                OR zip LIKE "%' . $q . '%"
                OR state LIKE "%' . $q . '%"
                OR zip LIKE "%' . $q . '%"
                OR address LIKE "%' . $q . '%"
                OR email LIKE "%' . $q . '%"
                OR CONCAT(firstname, \' \', lastname) LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'countries.short_name LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'countries.long_name LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'countries.numcode LIKE "%' . $q . '%"
                )');

            $this->db->limit($limit);
            $result[] = [
                'result'         => $this->db->get()->result_array(),
                'type'           => 'clients',
                'search_heading' => _l('clients'),
            ];
        }


        $staff_search = $this->_search_staff($q, $limit);
        if (count($staff_search['result']) > 0) {
            $result[] = $staff_search;
        }


        $where_contacts = '';
        if ($have_assigned_customers && !$have_permission_customers_view) {
            $where_contacts = db_prefix() . 'contacts.userid IN (SELECT customer_id FROM ' . db_prefix() . 'customer_admins WHERE staff_id=' . $staffid . ')';
        }


        $contacts_search = $this->_search_contacts($q, $limit, $where_contacts);
        if (count($contacts_search['result']) > 0) {
            $result[] = $contacts_search;
        }

        $tickets_search = $this->_search_tickets($q, $limit,$staffid);
        if (count($tickets_search['result']) > 0) {
            $result[] = $tickets_search;
        }

        $leads_search = $this->_search_leads($q, $limit,[],$staffid);
        if (count($leads_search['result']) > 0) {
            $result[] = $leads_search;
        }

        $proposals_search = $this->_search_proposals($q, $limit,$staffid);
        if (count($proposals_search['result']) > 0) {
            $result[] = $proposals_search;
        }

        $invoices_search = $this->_search_invoices($q, $limit,$staffid);
        if (count($invoices_search['result']) > 0) {
            $result[] = $invoices_search;
        }

        $credit_notes_search = $this->_search_credit_notes($q, $limit,$staffid);
        if (count($credit_notes_search['result']) > 0) {
            $result[] = $credit_notes_search;
        }

        $estimates_search = $this->_search_estimates($q, $limit,$staffid);
        if (count($estimates_search['result']) > 0) {
            $result[] = $estimates_search;
        }

        $expenses_search = $this->_search_expenses($q, $limit,$staffid);
        if (count($expenses_search['result']) > 0) {
            $result[] = $expenses_search;
        }

        $projects_search = $this->_search_projects($q, $limit,false,$staffid);
        if (count($projects_search['result']) > 0) {
            $result[] = $projects_search;
        }

        $contracts_search = $this->_search_contracts($q, $limit,$staffid);
        if (count($contracts_search['result']) > 0) {
            $result[] = $contracts_search;
        }


        if (has_permission('knowledge_base', '', 'view')) {
            // Knowledge base articles
            $this->db->select()->from(db_prefix() . 'knowledge_base')->like('subject', $q)->or_like('description', $q)->or_like('slug', $q)->limit($limit);

            $this->db->order_by('subject', 'ASC');

            $result[] = [
                'result'         => $this->db->get()->result_array(),
                'type'           => 'knowledge_base_articles',
                'search_heading' => _l('kb_string'),
            ];
        }

        // Tasks Search
        $tasks = has_permission('tasks', '', 'view');
        // Staff tasks
        $this->db->select();
        $this->db->from(db_prefix() . 'tasks');
        if (!$is_admin) {
            if (!$tasks) {
                $where = '(id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid = ' . $staffid . ') OR id IN (SELECT taskid FROM ' . db_prefix() . 'task_followers WHERE staffid = ' . $staffid . ') OR (addedfrom=' . $staffid . ' AND is_added_from_contact=0) ';
                if (get_option('show_all_tasks_for_project_member') == 1) {
                    $where .= ' OR (rel_type="project" AND rel_id IN (SELECT project_id FROM ' . db_prefix() . 'project_members WHERE staff_id=' . $staffid . '))';
                }
                $where .= ' OR is_public = 1)';
                $this->db->where($where);
            } //!$tasks
        } //!$is_admin
        if (!startsWith($q, '#')) {
            $this->db->where('(name LIKE "%' . $q . '%" OR description LIKE "%' . $q . '%")');
        } else {
            $this->db->where('id IN
                (SELECT rel_id FROM ' . db_prefix() . 'taggables WHERE tag_id IN
                (SELECT id FROM ' . db_prefix() . 'tags WHERE name="' . strafter($q, '#') . '")
                AND ' . db_prefix() . 'taggables.rel_type=\'task\' GROUP BY rel_id HAVING COUNT(tag_id) = 1)
                ');
        }

        $this->db->limit($limit);
        $this->db->order_by('name', 'ASC');

        $result[] = [
            'result'         => $this->db->get()->result_array(),
            'type'           => 'tasks',
            'search_heading' => _l('tasks'),
        ];


        // Payments search
        $has_permission_view_payments     = has_permission('payments', $staffid, 'view');
        $has_permission_view_invoices_own = has_permission('invoices', $staffid, 'view_own');

        if (has_permission('payments', '', 'view') || $has_permission_view_invoices_own || get_option('allow_staff_view_invoices_assigned') == '1') {
            if (is_numeric($q)) {
                $q = trim($q);
                $q = ltrim($q, '0');
            } elseif (startsWith($q, get_option('invoice_prefix'))) {
                $q = strafter($q, get_option('invoice_prefix'));
                $q = trim($q);
                $q = ltrim($q, '0');
            }
            $noPermissionQuery = get_invoices_where_sql_for_staff($staffid);
            // Invoice payment records
            $this->db->select('*,' . db_prefix() . 'invoicepaymentrecords.id as paymentid');
            $this->db->from(db_prefix() . 'invoicepaymentrecords');
            $this->db->join(db_prefix() . 'payment_modes', '' . db_prefix() . 'invoicepaymentrecords.paymentmode = ' . db_prefix() . 'payment_modes.id', 'LEFT');
            $this->db->join(db_prefix() . 'invoices', '' . db_prefix() . 'invoices.id = ' . db_prefix() . 'invoicepaymentrecords.invoiceid');

            if (!$has_permission_view_payments) {
                $this->db->where('invoiceid IN (select id from ' . db_prefix() . 'invoices where ' . $noPermissionQuery . ')');
            }

            $this->db->where('(' . db_prefix() . 'invoicepaymentrecords.id LIKE "' . $q . '"
                OR paymentmode LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'payment_modes.name LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'invoicepaymentrecords.note LIKE "%' . $q . '%"
                OR number LIKE "' . $q . '"
                )');

            $this->db->order_by(db_prefix() . 'invoicepaymentrecords.date', 'ASC');

            $result[] = [
                'result'         => $this->db->get()->result_array(),
                'type'           => 'invoice_payment_records',
                'search_heading' => _l('payments'),
            ];
        }

        // Custom fields only admins
        if ($is_admin) {
            $this->db->select()->from(db_prefix() . 'customfieldsvalues')->like('value', $q)->limit($limit);
            $result[] = [
                'result'         => $this->db->get()->result_array(),
                'type'           => 'custom_fields',
                'search_heading' => _l('custom_fields'),
            ];
        }

        // Invoice Items Search
        $has_permission_view_invoices       = has_permission('invoices', $staffid, 'view');
        $has_permission_view_invoices_own   = has_permission('invoices', $staffid, 'view_own');
        $allow_staff_view_invoices_assigned = get_option('allow_staff_view_invoices_assigned');

        if ($has_permission_view_invoices || $has_permission_view_invoices_own || $allow_staff_view_invoices_assigned == '1') {
            $noPermissionQuery = get_invoices_where_sql_for_staff($staffid);
            $this->db->select()->from(db_prefix() . 'itemable');
            $this->db->where('rel_type', 'invoice');
            $this->db->where('(description LIKE "%' . $q . '%" OR long_description LIKE "%' . $q . '%")');

            if (!$has_permission_view_invoices) {
                $this->db->where('rel_id IN (select id from ' . db_prefix() . 'invoices where ' . $noPermissionQuery . ')');
            }

            $this->db->order_by('description', 'ASC');
            $result[] = [
                'result'         => $this->db->get()->result_array(),
                'type'           => 'invoice_items',
                'search_heading' => _l('invoice_items'),
            ];
        }

        // Estimate Items Search
        $has_permission_view_estimates       = has_permission('estimates', $staffid, 'view');
        $has_permission_view_estimates_own   = has_permission('estimates', $staffid, 'view_own');
        $allow_staff_view_estimates_assigned = get_option('allow_staff_view_estimates_assigned');
        if ($has_permission_view_estimates || $has_permission_view_estimates_own || $allow_staff_view_estimates_assigned) {
            $noPermissionQuery = get_estimates_where_sql_for_staff($staffid);

            $this->db->select()->from(db_prefix() . 'itemable');
            $this->db->where('rel_type', 'estimate');

            if (!$has_permission_view_estimates) {
                $this->db->where('rel_id IN (select id from ' . db_prefix() . 'estimates where ' . $noPermissionQuery . ')');
            }
            $this->db->where('(description LIKE "%' . $q . '%" OR long_description LIKE "%' . $q . '%")');
            $this->db->order_by('description', 'ASC');
            $result[] = [
                'result'         => $this->db->get()->result_array(),
                'type'           => 'estimate_items',
                'search_heading' => _l('estimate_items'),
            ];
        }

        $result = hooks()->apply_filters('global_search_result_query', $result, $q, $limit);

        return $result;
    }

    public function _search_proposals($q, $limit = 0,$staffid)
    {
        $result = [
            'result'         => [],
            'type'           => 'proposals',
            'search_heading' => _l('proposals'),
        ];

        $has_permission_view_proposals     = has_permission('proposals', '', 'view');
        $has_permission_view_proposals_own = has_permission('proposals', '', 'view_own');

        if ($has_permission_view_proposals || $has_permission_view_proposals_own || get_option('allow_staff_view_proposals_assigned') == '1') {
            if (is_numeric($q)) {
                $q = trim($q);
                $q = ltrim($q, '0');
            } elseif (startsWith($q, get_option('proposal_number_prefix'))) {
                $q = strafter($q, get_option('proposal_number_prefix'));
                $q = trim($q);
                $q = ltrim($q, '0');
            }

            $noPermissionQuery = get_proposals_sql_where_staff($staffid);

            // Proposals
            $this->db->select('*,' . db_prefix() . 'proposals.id as id');
            $this->db->from(db_prefix() . 'proposals');
            $this->db->join(db_prefix() . 'currencies', db_prefix() . 'currencies.id = ' . db_prefix() . 'proposals.currency');

            if (!$has_permission_view_proposals) {
                $this->db->where($noPermissionQuery);
            }

            $this->db->where('(
                ' . db_prefix() . 'proposals.id LIKE "' . $q . '%"
                OR ' . db_prefix() . 'proposals.subject LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'proposals.content LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'proposals.proposal_to LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'proposals.zip LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'proposals.state LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'proposals.city LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'proposals.address LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'proposals.email LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'proposals.phone LIKE "%' . $q . '%"
                )');

            $this->db->order_by(db_prefix() . 'proposals.id', 'desc');
            if ($limit != 0) {
                $this->db->limit($limit);
            }
            $result['result'] = $this->db->get()->result_array();
        }

        return $result;
    }

    public function _search_leads($q, $limit = 0, $where = [],$staffid)
    {
        $result = [
            'result'         => [],
            'type'           => 'leads',
            'search_heading' => _l('leads'),
        ];

        $has_permission_view = has_permission('leads', '', 'view');

        if (is_staff_member()) {
            // Leads
            $this->db->select();
            $this->db->from(db_prefix() . 'leads');

            if (!$has_permission_view) {
                $this->db->where('(assigned = ' . $staffid . ' OR addedfrom = ' . $staffid . ' OR is_public=1)');
            }

            if (!startsWith($q, '#')) {
                $this->db->where('(name LIKE "%' . $q . '%"
                    OR title LIKE "%' . $q . '%"
                    OR company LIKE "%' . $q . '%"
                    OR zip LIKE "%' . $q . '%"
                    OR city LIKE "%' . $q . '%"
                    OR state LIKE "%' . $q . '%"
                    OR address LIKE "%' . $q . '%"
                    OR email LIKE "%' . $q . '%"
                    OR phonenumber LIKE "%' . $q . '%"
                    )');
            } else {
                $this->db->where('id IN
                    (SELECT rel_id FROM ' . db_prefix() . 'taggables WHERE tag_id IN
                    (SELECT id FROM ' . db_prefix() . 'tags WHERE name="' . strafter($q, '#') . '")
                    AND ' . db_prefix() . 'taggables.rel_type=\'lead\' GROUP BY rel_id HAVING COUNT(tag_id) = 1)
                    ');
            }


            $this->db->where($where);

            if ($limit != 0) {
                $this->db->limit($limit);
            }
            $this->db->order_by('name', 'ASC');
            $result['result'] = $this->db->get()->result_array();
        }

        return $result;
    }

    public function _search_tickets($q, $limit = 0,$staffid)
    {
        $result = [
            'result'         => [],
            'type'           => 'tickets',
            'search_heading' => _l('support_tickets'),
        ];

        if (is_staff_member() || (!is_staff_member() && get_option('access_tickets_to_none_staff_members') == 1)) {
            $is_admin = is_admin();

            $where = '';
            if (!$is_admin && get_option('staff_access_only_assigned_departments') == 1) {
                $this->load->model('departments_model');
                $staff_deparments_ids = $this->departments_model->get_staff_departments($staffid, true);
                $departments_ids      = [];
                if (count($staff_deparments_ids) == 0) {
                    $departments = $this->departments_model->get();
                    foreach ($departments as $department) {
                        array_push($departments_ids, $department['departmentid']);
                    }
                } else {
                    $departments_ids = $staff_deparments_ids;
                }
                if (count($departments_ids) > 0) {
                    $where = 'department IN (SELECT departmentid FROM ' . db_prefix() . 'staff_departments WHERE departmentid IN (' . implode(',', $departments_ids) . ') AND staffid="' . $staffid . '")';
                }
            }

            $this->db->select();
            $this->db->from(db_prefix() . 'tickets');
            $this->db->join(db_prefix() . 'departments', db_prefix() . 'departments.departmentid = ' . db_prefix() . 'tickets.department');
            $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid = ' . db_prefix() . 'tickets.userid', 'left');
            $this->db->join(db_prefix() . 'contacts', db_prefix() . 'contacts.id = ' . db_prefix() . 'tickets.contactid', 'left');


            if (!startsWith($q, '#')) {
                $this->db->where('(
                    ticketid LIKE "' . $q . '%"
                    OR subject LIKE "%' . $q . '%"
                    OR message LIKE "%' . $q . '%"
                    OR ' . db_prefix() . 'contacts.email LIKE "%' . $q . '%"
                    OR CONCAT(firstname, \' \', lastname) LIKE "%' . $q . '%"
                    OR company LIKE "%' . $q . '%"
                    OR vat LIKE "%' . $q . '%"
                    OR ' . db_prefix() . 'contacts.phonenumber LIKE "%' . $q . '%"
                    OR ' . db_prefix() . 'clients.phonenumber LIKE "%' . $q . '%"
                    OR city LIKE "%' . $q . '%"
                    OR state LIKE "%' . $q . '%"
                    OR address LIKE "%' . $q . '%"
                    OR ' . db_prefix() . 'departments.name LIKE "%' . $q . '%"
                    )');

                if ($where != '') {
                    $this->db->where($where);
                }
            } else {
                $this->db->where('ticketid IN
                    (SELECT rel_id FROM ' . db_prefix() . 'taggables WHERE tag_id IN
                    (SELECT id FROM ' . db_prefix() . 'tags WHERE name="' . strafter($q, '#') . '")
                    AND ' . db_prefix() . 'taggables.rel_type=\'ticket\' GROUP BY rel_id HAVING COUNT(tag_id) = 1)
                    ');
            }

            if ($limit != 0) {
                $this->db->limit($limit);
            }
            $this->db->order_by('ticketid', 'DESC');
            $result['result'] = $this->db->get()->result_array();
        }

        return $result;
    }

    public function _search_contacts($q, $limit = 0, $where = '')
    {

        $result = [
            'result'         => [],
            'type'           => 'contacts',
            'search_heading' => _l('customer_contacts'),
        ];
 
        $have_assigned_customers        = have_assigned_customers();
        $have_permission_customers_view = has_permission('customers', '', 'view');
        if ($have_assigned_customers || $have_permission_customers_view) {
            // Contacts
            $this->db->select(implode(',', prefixed_table_fields_array(db_prefix() . 'contacts')) . ',company');
            $this->db->from(db_prefix() . 'contacts');

            $this->db->join(db_prefix() . 'clients', '' . db_prefix() . 'clients.userid=' . db_prefix() . 'contacts.userid', 'left');
            $this->db->where('(firstname LIKE "%' . $q . '%"
                OR lastname LIKE "%' . $q . '%"
                OR email LIKE "%' . $q . '%"
                OR CONCAT(firstname, \' \', lastname) LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'contacts.phonenumber LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'contacts.title LIKE "%' . $q . '%"
                OR company LIKE "%' . $q . '%"
                )');

            if ($where != '') {
                $this->db->where($where);
            }

            if ($limit != 0) {
                $this->db->limit($limit);
            }

            $this->db->order_by('firstname', 'ASC');
            $result['result'] = $this->db->get()->result_array();

        }

        return $result;
    }

    public function _search_staff($q, $limit = 0)
    {
        $result = [
            'result'         => [],
            'type'           => 'staff',
            'search_heading' => _l('staff_members'),
        ];

        if (has_permission('staff', '', 'view')) {
            // Staff
            $this->db->select();
            $this->db->from(db_prefix() . 'staff');
            $this->db->like('firstname', $q);
            $this->db->or_like('lastname', $q);
            $this->db->or_like("CONCAT(firstname, ' ', lastname)", $q, false);
            $this->db->or_like('facebook', $q);
            $this->db->or_like('linkedin', $q);
            $this->db->or_like('phonenumber', $q);
            $this->db->or_like('email', $q);
            $this->db->or_like('skype', $q);

            if ($limit != 0) {
                $this->db->limit($limit);
            }
            $this->db->order_by('firstname', 'ASC');
            $result['result'] = $this->db->get()->result_array();
        }

        return $result;
    }

    public function _search_contracts($q, $limit = 0,$staffid)
    {
        $result = [
            'result'         => [],
            'type'           => 'contracts',
            'search_heading' => _l('contracts'),
        ];

        $has_permission_view_contracts = has_permission('contracts', '', 'view');
        if ($has_permission_view_contracts || has_permission('contracts', '', 'view_own')) {
            // Contracts
            $this->db->select();
            $this->db->from(db_prefix() . 'contracts');
            if (!$has_permission_view_contracts) {
                $this->db->where(db_prefix() . 'contracts.addedfrom', $staffid);
            }

            $this->db->where('(description LIKE "%' . $q . '%" OR subject LIKE "%' . $q . '%")');

            if ($limit != 0) {
                $this->db->limit($limit);
            }
            $this->db->order_by('subject', 'ASC');
            $result['result'] = $this->db->get()->result_array();
        }

        return $result;
    }

    public function _search_projects($q, $limit = 0, $where = false,$staffid)
    {
        $result = [
            'result'         => [],
            'type'           => 'projects',
            'search_heading' => _l('projects'),
        ];

        $projects = has_permission('projects', '', 'view');
        // Projects
        $this->db->select();
        $this->db->from(db_prefix() . 'projects');
        $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid = ' . db_prefix() . 'projects.clientid');
        if (!$projects) {
            $this->db->where(db_prefix() . 'projects.id IN (SELECT project_id FROM ' . db_prefix() . 'project_members WHERE staff_id=' . $staffid . ')');
        }
        if ($where != false) {
            $this->db->where($where);
        }
        if (!startsWith($q, '#')) {
            $this->db->where('(company LIKE "%' . $q . '%"
                OR description LIKE "%' . $q . '%"
                OR name LIKE "%' . $q . '%"
                OR vat LIKE "%' . $q . '%"
                OR phonenumber LIKE "%' . $q . '%"
                OR city LIKE "%' . $q . '%"
                OR zip LIKE "%' . $q . '%"
                OR state LIKE "%' . $q . '%"
                OR zip LIKE "%' . $q . '%"
                OR address LIKE "%' . $q . '%"
                )');
        } else {
            $this->db->where('id IN
                (SELECT rel_id FROM ' . db_prefix() . 'taggables WHERE tag_id IN
                (SELECT id FROM ' . db_prefix() . 'tags WHERE name="' . strafter($q, '#') . '")
                AND ' . db_prefix() . 'taggables.rel_type=\'project\' GROUP BY rel_id HAVING COUNT(tag_id) = 1)
                ');
        }

        if ($limit != 0) {
            $this->db->limit($limit);
        }

        $this->db->order_by('name', 'ASC');
        $result['result'] = $this->db->get()->result_array();

        return $result;
    }

    public function _search_invoices($q, $limit = 0,$staffid)
    {
        $result = [
            'result'         => [],
            'type'           => 'invoices',
            'search_heading' => _l('invoices'),
        ];
        $has_permission_view_invoices     = has_permission('invoices', $staffid, 'view');
        $has_permission_view_invoices_own = has_permission('invoices', $staffid, 'view_own');

        if ($has_permission_view_invoices || $has_permission_view_invoices_own || get_option('allow_staff_view_invoices_assigned') == '1') {
            if (is_numeric($q)) {
                $q = trim($q);
                $q = ltrim($q, '0');
            } elseif (startsWith($q, get_option('invoice_prefix'))) {
                $q = strafter($q, get_option('invoice_prefix'));
                $q = trim($q);
                $q = ltrim($q, '0');
            }
            $invoice_fields    = prefixed_table_fields_array(db_prefix() . 'invoices');
            $clients_fields    = prefixed_table_fields_array(db_prefix() . 'clients');
            $noPermissionQuery = get_invoices_where_sql_for_staff($staffid);
            // Invoices
            $this->db->select(implode(',', $invoice_fields) . ',' . implode(',', $clients_fields) . ',' . db_prefix() . 'invoices.id as invoiceid,' . get_sql_select_client_company());
            $this->db->from(db_prefix() . 'invoices');
            $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid = ' . db_prefix() . 'invoices.clientid', 'left');
            $this->db->join(db_prefix() . 'currencies', db_prefix() . 'currencies.id = ' . db_prefix() . 'invoices.currency');
            $this->db->join(db_prefix() . 'contacts', db_prefix() . 'contacts.userid = ' . db_prefix() . 'clients.userid AND is_primary = 1', 'left');

            if (!$has_permission_view_invoices) {
                $this->db->where($noPermissionQuery);
            }
            if (!startsWith($q, '#')) {
                $this->db->where('(
                ' . db_prefix() . 'invoices.number LIKE "' . $q . '"
                OR
                ' . db_prefix() . 'clients.company LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'invoices.clientnote LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.vat LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.phonenumber LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.zip LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.address LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'invoices.adminnote LIKE "%' . $q . '%"
                OR
                CONCAT(firstname,\' \',lastname) LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'invoices.billing_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'invoices.billing_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'invoices.billing_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'invoices.billing_zip LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'invoices.shipping_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'invoices.shipping_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'invoices.shipping_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'invoices.shipping_zip LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_zip LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_zip LIKE "%' . $q . '%"
                )');
            } else {
                $this->db->where(db_prefix() . 'invoices.id IN
                (SELECT rel_id FROM ' . db_prefix() . 'taggables WHERE tag_id IN
                (SELECT id FROM ' . db_prefix() . 'tags WHERE name="' . strafter($q, '#') . '")
                AND ' . db_prefix() . 'taggables.rel_type=\'invoice\' GROUP BY rel_id HAVING COUNT(tag_id) = 1)
                ');
            }


            $this->db->order_by('number,YEAR(date)', 'desc');
            if ($limit != 0) {
                $this->db->limit($limit);
            }

            $result['result'] = $this->db->get()->result_array();
        }

        return $result;
    }

    public function _search_credit_notes($q, $limit = 0)
    {
        $result = [
            'result'         => [],
            'type'           => 'credit_note',
            'search_heading' => _l('credit_notes'),
        ];

        $has_permission_view_credit_notes     = has_permission('credit_notes', $staffid, 'view');
        $has_permission_view_credit_notes_own = has_permission('credit_notes', $staffid, 'view_own');

        if ($has_permission_view_credit_notes || $has_permission_view_credit_notes_own) {
            if (is_numeric($q)) {
                $q = trim($q);
                $q = ltrim($q, '0');
            } elseif (startsWith($q, get_option('credit_note_prefix'))) {
                $q = strafter($q, get_option('credit_note_prefix'));
                $q = trim($q);
                $q = ltrim($q, '0');
            }
            $credit_note_fields = prefixed_table_fields_array(db_prefix() . 'creditnotes');
            $clients_fields     = prefixed_table_fields_array(db_prefix() . 'clients');
            // Invoices
            $this->db->select(implode(',', $credit_note_fields) . ',' . implode(',', $clients_fields) . ',' . db_prefix() . 'creditnotes.id as credit_note_id,' . get_sql_select_client_company());
            $this->db->from(db_prefix() . 'creditnotes');
            $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid = ' . db_prefix() . 'creditnotes.clientid', 'left');
            $this->db->join(db_prefix() . 'currencies', db_prefix() . 'currencies.id = ' . db_prefix() . 'creditnotes.currency');
            $this->db->join(db_prefix() . 'contacts', db_prefix() . 'contacts.userid = ' . db_prefix() . 'clients.userid AND is_primary = 1', 'left');

            if (!$has_permission_view_credit_notes) {
                $this->db->where(db_prefix() . 'creditnotes.addedfrom', $staffid);
            }

            $this->db->where('(
                ' . db_prefix() . 'creditnotes.number LIKE "' . $q . '"
                OR
                ' . db_prefix() . 'clients.company LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'creditnotes.clientnote LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.vat LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.phonenumber LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.zip LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.address LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'creditnotes.adminnote LIKE "%' . $q . '%"
                OR
                CONCAT(firstname,\' \',lastname) LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'creditnotes.billing_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'creditnotes.billing_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'creditnotes.billing_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'creditnotes.billing_zip LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'creditnotes.shipping_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'creditnotes.shipping_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'creditnotes.shipping_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'creditnotes.shipping_zip LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_zip LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_zip LIKE "%' . $q . '%"
                )');


            $this->db->order_by('number', 'desc');
            if ($limit != 0) {
                $this->db->limit($limit);
            }

            $result['result'] = $this->db->get()->result_array();
        }

        return $result;
    }

    public function _search_estimates($q, $limit = 0,$staffid)
    {
        $result = [
            'result'         => [],
            'type'           => 'estimates',
            'search_heading' => _l('estimates'),
        ];

        $has_permission_view_estimates     = has_permission('estimates', $staffid, 'view');
        $has_permission_view_estimates_own = has_permission('estimates', $staffid, 'view_own');

        if ($has_permission_view_estimates || $has_permission_view_estimates_own || get_option('allow_staff_view_estimates_assigned') == '1') {
            if (is_numeric($q)) {
                $q = trim($q);
                $q = ltrim($q, '0');
            } elseif (startsWith($q, get_option('estimate_prefix'))) {
                $q = strafter($q, get_option('estimate_prefix'));
                $q = trim($q);
                $q = ltrim($q, '0');
            }
            // Estimates
            $estimates_fields  = prefixed_table_fields_array(db_prefix() . 'estimates');
            $clients_fields    = prefixed_table_fields_array(db_prefix() . 'clients');
            $noPermissionQuery = get_estimates_where_sql_for_staff($staffid);

            $this->db->select(implode(',', $estimates_fields) . ',' . implode(',', $clients_fields) . ',' . db_prefix() . 'estimates.id as estimateid,' . get_sql_select_client_company());
            $this->db->from(db_prefix() . 'estimates');
            $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid = ' . db_prefix() . 'estimates.clientid', 'left');
            $this->db->join(db_prefix() . 'currencies', db_prefix() . 'currencies.id = ' . db_prefix() . 'estimates.currency');
            $this->db->join(db_prefix() . 'contacts', db_prefix() . 'contacts.userid = ' . db_prefix() . 'clients.userid AND is_primary = 1', 'left');

            if (!$has_permission_view_estimates) {
                $this->db->where($noPermissionQuery);
            }

            $this->db->where('(
                ' . db_prefix() . 'estimates.number LIKE "' . $q . '"
                OR
                ' . db_prefix() . 'clients.company LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'estimates.clientnote LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.vat LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.phonenumber LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.zip LIKE "%' . $q . '%"
                OR
                address LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'estimates.adminnote LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'estimates.billing_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'estimates.billing_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'estimates.billing_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'estimates.billing_zip LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'estimates.shipping_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'estimates.shipping_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'estimates.shipping_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'estimates.shipping_zip LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.billing_zip LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_street LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_city LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_state LIKE "%' . $q . '%"
                OR
                ' . db_prefix() . 'clients.shipping_zip LIKE "%' . $q . '%"
                )');

            $this->db->order_by('number,YEAR(date)', 'desc');
            if ($limit != 0) {
                $this->db->limit($limit);
            }
            $result['result'] = $this->db->get()->result_array();
        }

        return $result;
    }

    public function _search_expenses($q, $limit = 0)
    {
        $result = [
            'result'         => [],
            'type'           => 'expenses',
            'search_heading' => _l('expenses'),
        ];

        $has_permission_expenses_view     = has_permission('expenses', $staffid, 'view');
        $has_permission_expenses_view_own = has_permission('expenses', $staffid, 'view_own');

        if ($has_permission_expenses_view || $has_permission_expenses_view_own) {
            // Expenses
            $this->db->select('*,' . db_prefix() . 'expenses.amount as amount,' . db_prefix() . 'expenses_categories.name as category_name,' . db_prefix() . 'payment_modes.name as payment_mode_name,' . db_prefix() . 'taxes.name as tax_name, ' . db_prefix() . 'expenses.id as expenseid,' . db_prefix() . 'currencies.name as currency_name');
            $this->db->from(db_prefix() . 'expenses');
            $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid = ' . db_prefix() . 'expenses.clientid', 'left');
            $this->db->join(db_prefix() . 'payment_modes', db_prefix() . 'payment_modes.id = ' . db_prefix() . 'expenses.paymentmode', 'left');
            $this->db->join(db_prefix() . 'taxes', db_prefix() . 'taxes.id = ' . db_prefix() . 'expenses.tax', 'left');
            $this->db->join(db_prefix() . 'expenses_categories', db_prefix() . 'expenses_categories.id = ' . db_prefix() . 'expenses.category');
            $this->db->join(db_prefix() . 'currencies', '' . db_prefix() . 'currencies.id = ' . db_prefix() . 'expenses.currency', 'left');
            if (!$has_permission_expenses_view) {
                $this->db->where(db_prefix() . 'expenses.addedfrom', $staffid);
            }

            $this->db->where('(company LIKE "%' . $q . '%"
                OR paymentmode LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'payment_modes.name LIKE "%' . $q . '%"
                OR vat LIKE "%' . $q . '%"
                OR phonenumber LIKE "%' . $q . '%"
                OR city LIKE "%' . $q . '%"
                OR zip LIKE "%' . $q . '%"
                OR address LIKE "%' . $q . '%"
                OR state LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'expenses_categories.name LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'expenses.note LIKE "%' . $q . '%"
                OR ' . db_prefix() . 'expenses.expense_name LIKE "%' . $q . '%"
                )');

            if ($limit != 0) {
                $this->db->limit($limit);
            }
            $this->db->order_by('date', 'DESC');
            $result['result'] = $this->db->get()->result_array();
        }

        return $result;
    }
}
