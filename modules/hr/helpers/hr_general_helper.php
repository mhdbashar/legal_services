<?php

function is_active_sub_department(){
	$CI = get_instance();
	$CI->db->where('name', 'sub_department');
	$CI->db->from(db_prefix() . 'hr_setting');
	$sub_department = $CI->db->get()->row();
	if($sub_department->active == 1)
		return true;
	return false;
}

function does_url_exists($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}

function get_insurance_types_relation_data($book_num) {
    $CI = get_instance();
    $CI->load->model('Insurance_type_model');
    $data = $CI->Insurance_type_model->get('', ['insurance_book_id' => $book_num, 'for_staff' => 1]);
    return $data;
}


/**
 * Handle contract attachments if any
 * @param  mixed $contractid
 * @return boolean
 */
function handle_hr_contract_attachment($id)
{
    if (isset($_FILES['file']) && _babil_upload_error($_FILES['file']['error'])) {
        header('HTTP/1.0 400 Bad error');
        echo _babil_upload_error($_FILES['file']['error']);
        die;
    }
    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
        hooks()->do_action('before_upload_hr_contract_attachment', $id);
        $path = get_upload_path_by_type('hr_contract') . $id . '/';
        // Get the temp file path
        $tmpFilePath = $_FILES['file']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            _maybe_create_upload_path($path);
            $filename    = unique_filename($path, $_FILES['file']['name']);
            $newFilePath = $path . $filename;
            // Upload the file into the company uploads dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $CI           = & get_instance();
                $attachment   = [];
                $attachment[] = [
                    'file_name' => $filename,
                    'filetype'  => $_FILES['file']['type'],
                ];
                $CI->misc_model->add_attachment_to_database($id, 'hr_contract', $attachment);

                return true;
            }
        }
    }

    return false;
}


/**
 * Tasks html table used all over the application for relation tasks
 * This table is not used for the main tasks table
 * @param  array  $table_attributes
 * @return string
 */
function hr_init_relation_tasks_table($table_attributes = [])
{
    $table_data = [
        _l('the_number_sign'),
        [
            'name'     => _l('tasks_dt_name'),
            'th_attrs' => [
                'style' => 'width:200px',
            ],
        ],
        _l('task_status'),
        [
            'name'     => _l('tasks_dt_datestart'),
            'th_attrs' => [
                'style' => 'width:75px',
            ],
        ],
        [
            'name'     => _l('task_duedate'),
            'th_attrs' => [
                'style' => 'width:75px',
                'class' => 'duedate',
            ],
        ],
        [
            'name'     => _l('task_assigned'),
            'th_attrs' => [
                'style' => 'width:75px',
            ],
        ],
        _l('tags'),
        _l('tasks_list_priority'),
    ];

    array_unshift($table_data, [
        'name'     => '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="rel-tasks"><label></label></div>',
        'th_attrs' => ['class' => ($table_attributes['data-new-rel-type'] !== 'project' ? 'not_visible' : '')],
    ]);

    $custom_fields = get_custom_fields('tasks', [
        'show_on_table' => 1,
    ]);

    foreach ($custom_fields as $field) {
        array_push($table_data, $field['name']);
    }

    $table_data = hooks()->apply_filters('tasks_related_table_columns', $table_data);

    $name = 'rel-tasks';
    if ($table_attributes['data-new-rel-type'] == 'lead') {
        $name = 'rel-tasks-leads';
    }

    $table      = '';
    $CI         = &get_instance();
    $table_name = '.table-' . $name;
    $CI->load->view('admin/tasks/tasks_filter_by', [
        'view_table_name' => $table_name,
    ]);
    if (has_permission('tasks', '', 'create')) {
        $disabled   = '';
        $table_name = addslashes($table_name);
        if ($table_attributes['data-new-rel-type'] == 'customer' && is_numeric($table_attributes['data-new-rel-id'])) {
            if (total_rows(db_prefix() . 'clients', [
                    'active' => 0,
                    'userid' => $table_attributes['data-new-rel-id'],
                ]) > 0) {
                $disabled = ' disabled';
            }
        }
        // projects have button on top
        if ($table_attributes['data-new-rel-type'] != 'project') {
            echo "<a href='#' class='btn btn-info pull-left mbot25 mright5 new-task-relation" . $disabled . "' onclick=\"new_task_from_relation('$table_name'); return false;\" data-rel-id='" . $table_attributes['data-new-rel-id'] . "' data-rel-type='" . $table_attributes['data-new-rel-type'] . "'>" . _l('new_task') . '</a>';
        }
    }

    if ($table_attributes['data-new-rel-type'] == 'project') {
        echo "<a href='" . admin_url('tasks/detailed_overview?project_id=' . $table_attributes['data-new-rel-id']) . "' class='btn btn-success pull-right mbot25'>" . _l('detailed_overview') . '</a>';
        echo "<a href='" . admin_url('tasks/list_tasks?project_id=' . $table_attributes['data-new-rel-id'] . '&kanban=true') . "' class='btn btn-default pull-right mbot25 mright5 hidden-xs'>" . _l('view_kanban') . '</a>';
        echo '<div class="clearfix"></div>';
        echo $CI->load->view('admin/tasks/_bulk_actions', ['table' => '.table-rel-tasks'], true);
        echo $CI->load->view('admin/tasks/_summary', ['rel_id' => $table_attributes['data-new-rel-id'], 'rel_type' => 'project', 'table' => $table_name], true);
        echo '<a href="#" data-toggle="modal" data-target="#tasks_bulk_actions" class="hide bulk-actions-btn table-btn" data-table=".table-rel-tasks">' . _l('bulk_actions') . '</a>';
    } elseif ($table_attributes['data-new-rel-type'] == 'customer') {
        echo '<div class="clearfix"></div>';
        echo '<div id="tasks_related_filter">';
        echo '<p class="bold">' . _l('task_related_to') . ': </p>';

        echo '<div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" checked value="customer" disabled id="ts_rel_to_customer" name="tasks_related_to[]">
        <label for="ts_rel_to_customer">' . _l('client') . '</label>
        </div>';

        $services = $CI->db->get('my_basic_services')->result();
        foreach ($services as $service):
            if($service->is_module == 0):
                echo '<div class="checkbox checkbox-inline mbot25">
                      <input type="checkbox" value="'.$service->slug.'" id="ts_rel_to_'.$service->slug.'" name="tasks_related_to[]">
                      <label for="ts_rel_to_'.$service->slug.'">' . $service->name . '</label>
                      </div>';
            else:
                echo '<div class="checkbox checkbox-inline mbot25">
                    <input type="checkbox" value="project" id="ts_rel_to_project" name="tasks_related_to[]">
                    <label for="ts_rel_to_project">' . $service->name . '</label>
                    </div>';
            endif;
        endforeach;

        echo '<div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="invoice" id="ts_rel_to_invoice" name="tasks_related_to[]">
        <label for="ts_rel_to_invoice">' . _l('invoices') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="estimate" id="ts_rel_to_estimate" name="tasks_related_to[]">
        <label for="ts_rel_to_estimate">' . _l('estimates') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="contract" id="ts_rel_to_contract" name="tasks_related_to[]">
        <label for="ts_rel_to_contract">' . _l('contracts') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="hr_contract" id="ts_rel_to_hr_contract" name="tasks_related_to[]">
        <label for="ts_rel_to_hr_contract">' . _l('contracts') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="ticket" id="ts_rel_to_ticket" name="tasks_related_to[]">
        <label for="ts_rel_to_ticket">' . _l('tickets') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="expense" id="ts_rel_to_expense" name="tasks_related_to[]">
        <label for="ts_rel_to_expense">' . _l('expenses') . '</label>
        </div>

        <div class="checkbox checkbox-inline mbot25">
        <input type="checkbox" value="proposal" id="ts_rel_to_proposal" name="tasks_related_to[]">
        <label for="ts_rel_to_proposal">' . _l('proposals') . '</label>
        </div>';

        echo '</div>';
    }
    echo "<div class='clearfix'></div>";

    // If new column is added on tasks relations table this will not work fine
    // In this case we need to add new identifier eq task-relation
    $table_attributes['data-last-order-identifier'] = 'tasks';
    $table_attributes['data-default-order']         = get_table_last_order('tasks');

    $table .= render_datatable($table_data, $name, [], $table_attributes);

    return $table;
}

/**
 * Check the contract view restrictions
 *
 * @param  int $id
 * @param  string $hash
 *
 * @return void
 */
function check_hr_contract_restrictions($id, $hash)
{
    $CI = &get_instance();
    $CI->load->model('hr_contracts_model');

    if (!$hash || !$id) {
        show_404();
    }

    if (!is_client_logged_in() && !is_staff_logged_in()) {
        if (get_option('view_contract_only_logged_in') == 1) {
            redirect_after_login_to_current_url();
            redirect(site_url('authentication/login'));
        }
    }

    $contract = $CI->hr_contracts_model->get($id);

    if (!$contract || ($contract->hash != $hash)) {
        show_404();
    }

    // Do one more check
    if (!is_staff_logged_in()) {
        if (get_option('view_contract_only_logged_in') == 1) {
            if ($contract->client != get_staff_user_id()) {
                show_404();
            }
        }
    }
}

/**
 * hr profile get kb groups
 * @return [type]
 */
function hr_get_kb_groups()
{
    $CI = & get_instance();

    return $CI->db->get(db_prefix() . 'hr_knowledge_base_groups')->result_array();
}

/**
 * hr profile handle kb article files upload
 * @param  string $articleid
 * @param  string $index_name
 * @return [type]
 */
function hr_profile_handle_kb_article_files_upload($articleid = '', $index_name = 'kb_article_files')
{
    $path           = get_hr_profile_upload_path_by_type('kb_article_files') . $articleid . '/';
    $uploaded_files = [];
    if (isset($_FILES[$index_name])) {
        _file_attachments_index_fix($index_name);
        // Get the temp file path
        $tmpFilePath = $_FILES[$index_name]['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            // Getting file extension
            $extension = strtolower(pathinfo($_FILES[$index_name]['name'], PATHINFO_EXTENSION));

            $allowed_extensions = explode(',', get_option('ticket_attachments_file_extensions'));
            $allowed_extensions = array_map('trim', $allowed_extensions);
            // Check for all cases if this extension is allowed

            _maybe_create_upload_path($path);
            $filename    = unique_filename($path, $_FILES[$index_name]['name']);
            $newFilePath = $path . $filename;

            // Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $CI                       = & get_instance();

                $CI->db->insert(db_prefix().'files', [
                    'rel_id' => $articleid,
                    'rel_type' => 'hr_profile_kb_article',
                    'file_name' => $_FILES['kb_article_files']['name'],
                    'filetype' => $_FILES['kb_article_files']['type'],
                    'staffid' => get_staff_user_id()
                ]);
                return true;
            }
        }
    }

    return false;
}

/**
 * get hr profile upload path by type
 * @param  string $type
 */
function get_hr_profile_upload_path_by_type($type)
{
    $path = '';
    switch ($type) {
        case 'staff_contract':
            $path = HR_PROFILE_CONTRACT_ATTACHMENTS_UPLOAD_FOLDER;

            break;

        case 'job_position':
            $path = HR_PROFILE_JOB_POSIITON_ATTACHMENTS_UPLOAD_FOLDER;

            break;

        case 'kb_article_files':
            $path = HR_PROFILE_Q_A_ATTACHMENTS_UPLOAD_FOLDER;
            break;

        case 'att_files':
            $path = HR_PROFILE_FILE_ATTACHMENTS_UPLOAD_FOLDER;

            break;


    }

    return hooks()->apply_filters('get_hr_profile_upload_path_by_type', $path, $type);
}

/**
 * hr get staff email by id
 * @param  [type] $id
 * @return [type]
 */
function hr_get_staff_email_by_id($id)
{
    $CI = & get_instance();

    $staff = $CI->app_object_cache->get('staff-email-by-id-' . $id);

    if (!$staff) {
        $CI->db->where('staffid', $id);
        $staff = $CI->db->select('email')->from(db_prefix() . 'staff')->get()->row();
        $CI->app_object_cache->add('staff-email-by-id-' . $id, $staff);
    }

    return ($staff ? $staff->email : '');
}
