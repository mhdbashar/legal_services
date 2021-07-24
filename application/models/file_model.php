<?php

class file_model extends App_Model{

    public function __construct()
    {
        parent::__construct();
        if(!is_dir($this->Path)){
            mkdir($this->Path);
        }
    }




    
    public $Folder = "sessions"; // folder Name





    public $Path = FCPATH . 'uploads/sessions' . '/';






    public $TableName = 'my_service_session'; // Your Table






    public $IdName = 'id'; // Your table id like session_id, staffid ...etc








    public function get_sessions_attachments($attachment_id = '', $id = '')
    {
        if (is_numeric($attachment_id)) {
            $this->db->where('id', $attachment_id);

            return $this->db->get(db_prefix() . 'files')->row();
        }
        $this->db->order_by('dateadded', 'desc');
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', $this->Folder);

        return $this->db->get(db_prefix() . 'files')->result_array();
    }
    public function get_session_file($id){
        $this->db->where(db_prefix() . $this->TableName . '.' . $this->IdName, $id);
        $session_attachment = $this->db->get(db_prefix() . $this->TableName)->row();
        $merge_fields = [];
        $merge_fields['attachment'] = $this->get_sessions_attachments('', $id);
        foreach ($session_attachment as $key => $value) {
            $merge_fields[$key] = $value;
        }
        return $merge_fields;
    }

    public function get_upload_path_by_type($type)
    {
        $path = '';
        switch ($type) {
            
            case $this->Folder:
                $path = $this->Path;

        }

        return hooks()->apply_filters('get_upload_path_by_type', $path, $type);
    }
    public function delete_session_attachment($attachment_id)
    {
        $deleted    = false;
        $attachment = $this->get_sessions_attachments($attachment_id);

        if ($attachment) {
            if (empty($attachment->external)) {
                unlink($this->get_upload_path_by_type($this->Folder) . $attachment->rel_id . '/' . $attachment->file_name);
            }
            $this->db->where('id', $attachment->id);
            $this->db->delete(db_prefix() . 'files');
            if ($this->db->affected_rows() > 0) {
                $deleted = true;
                log_activity('Session Attachment Deleted [ContractID: ' . $attachment->rel_id . ']');
            }

            if (is_dir($this->get_upload_path_by_type($this->Folder) . $attachment->rel_id)) {
                // Check if no attachments left, so we can delete the folder also
                $other_attachments = list_files($this->get_upload_path_by_type($this->Folder) . $attachment->rel_id);
                if (count($other_attachments) == 0) {
                    // okey only index.html so we can delete the folder also
                    delete_dir($this->get_upload_path_by_type($this->Folder) . $attachment->rel_id);
                }
            }
        }

        return $deleted;
    }

    public function add_attachment_to_database($rel_id, $rel_type, $attachment, $external = false)
    {
        $data['dateadded'] = date('Y-m-d H:i:s');
        $data['rel_id']    = $rel_id;
        if (!isset($attachment[0]['staffid'])) {
            $data['staffid'] = get_staff_user_id();
        } else {
            $data['staffid'] = $attachment[0]['staffid'];
        }

        if (isset($attachment[0]['task_comment_id'])) {
            $data['task_comment_id'] = $attachment[0]['task_comment_id'];
        }

        $data['rel_type'] = $rel_type;

        if (isset($attachment[0]['contact_id'])) {
            $data['contact_id']          = $attachment[0]['contact_id'];
            $data['visible_to_customer'] = 1;
            if (isset($data['staffid'])) {
                unset($data['staffid']);
            }
        }

        $data['attachment_key'] = app_generate_hash();

        if ($external == false) {
            $data['file_name'] = $attachment[0]['file_name'];
            $data['filetype']  = $attachment[0]['filetype'];
        } else {
            $path_parts            = pathinfo($attachment[0]['name']);
            $data['file_name']     = $attachment[0]['name'];
            $data['external_link'] = $attachment[0]['link'];
            $data['filetype']      = !isset($attachment[0]['mime']) ? get_mime_by_extension('.' . $path_parts['extension']) : $attachment[0]['mime'];
            $data['external']      = $external;
            if (isset($attachment[0]['thumbnailLink'])) {
                $data['thumbnail_link'] = $attachment[0]['thumbnailLink'];
            }
        }

        $this->db->insert(db_prefix() . 'files', $data);
        $insert_id = $this->db->insert_id();

        if ($data['rel_type'] == 'customer' && isset($data['contact_id'])) {
            if (get_option('only_own_files_contacts') == 1) {
                $this->db->insert(db_prefix() . 'shared_customer_files', [
                    'file_id'    => $insert_id,
                    'contact_id' => $data['contact_id'],
                ]);
            } else {
                $this->db->select('id');
                $this->db->where('userid', $data['rel_id']);
                $contacts = $this->db->get(db_prefix() . 'contacts')->result_array();
                foreach ($contacts as $contact) {
                    $this->db->insert(db_prefix() . 'shared_customer_files', [
                        'file_id'    => $insert_id,
                        'contact_id' => $contact['id'],
                    ]);
                }
            }
        }

        return $insert_id;
    }

    function handle_contract_attachment($id)
    {
        if (isset($_FILES['file']) && _babil_upload_error($_FILES['file']['error'])) {
            header('HTTP/1.0 400 Bad error');
            echo _babil_upload_error($_FILES['file']['error']);
            die;
        }
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
            hooks()->do_action('before_upload_sessions_attachment', $id);
            $path = $this->get_upload_path_by_type($this->Folder) . $id . '/';
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
                    $CI->misc_model->add_attachment_to_database($id, $this->Folder, $attachment);
                    return true;
                }
            }
        }

        return false;
    }

}