<?php

class Train extends App_Model{
	public function __construct(){
		parent::__construct();
	}


    public function get_statuses(){
        return array(
                0 => 'Pending',
                1 => 'Started',
                2 => 'Compeleted',
                3 => 'Terminated'
        );
    }


    public function get_performances(){
        return array(
                0 => 'Not Concluded',
                1 => 'Satisfactory',
                2 => 'Average',
                3 => 'Poor',
                4 => 'Excellent'
        );
    }

    public function getTrains($id){
        $this->db->select('*');
        $this->db->from('tblmy_training');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();

    }

    public function getStaff(){
        $this->db->select('*');
        $this->db->from('tblstaff');
        return $this->db->get()->result_array();
    }

    public function update($data, $id)
    {

        $temp_atts = $data['Attachment'];
        unset($data['Attachment']);

    	$query = $this->db->get_where('tblmy_training', array('id' => $id));
    	if(empty($query->row_array())){
            unset($data['id']);
	        $this->db->insert('tblmy_training', $data);
            $id = $this->db->insert_id();
        }else {
        	$this->db->where(['id' => $id]);
        	$this->db->update('tblmy_training', $data);
        }

        $temp_atts = $this->handle_training_attachments($id);
        if ($temp_atts) {
            $this->insert_training_attachments_to_database($temp_atts, $id);
        }

        if ($this->db->affected_rows() > 0) {

            return true;
        }

        return false;
    }

	public function delete($id, $simpleDelete = false){

        $this->db->where('id', $id);

        $this->db->delete('tblmy_training');
        if ($this->db->affected_rows() > 0) {
            log_activity('Award Deleted [' . $id . ']');

            return true;
        }

        return false;
    }




    public function insert_training_attachments_to_database($attachments, $training)
    {
        foreach ($attachments as $attachment) {
            $attachment['trainid']  = $training;
            $attachment['dateadded'] = date('Y-m-d H:i:s');
            $this->db->insert(db_prefix() . 'my_training_attachments', $attachment);
        }
    }

    public function handle_training_attachments($trainid, $index_name = 'attachments')
    {
        $path           = TRAINING_ATTACHMENTS_FOLDER . $trainid . '/';
        $uploaded_files = [];

        if (isset($_FILES[$index_name])) {
            _file_attachments_index_fix($index_name);

            for ($i = 0; $i < count($_FILES[$index_name]['name']); $i++) {
                //hooks()->do_action('before_upload_ticket_attachment', $trainid);
                //if ($i <= get_option('maximum_allowed_ticket_attachments')) {
                    // Get the temp file path
                    $tmpFilePath = $_FILES[$index_name]['tmp_name'][$i];
                    // Make sure we have a filepath
                    if (!empty($tmpFilePath) && $tmpFilePath != '') {
                        // Getting file extension
                        $extension = strtolower(pathinfo($_FILES[$index_name]['name'][$i], PATHINFO_EXTENSION));

                        $allowed_extensions = explode(',', get_option('ticket_attachments_file_extensions'));
                        $allowed_extensions = array_map('trim', $allowed_extensions);
                        // Check for all cases if this extension is allowed
                        if (!in_array('.' . $extension, $allowed_extensions)) {
                            continue;
                        }
                        _maybe_create_upload_path($path);
                        $filename    = unique_filename($path, $_FILES[$index_name]['name'][$i]);
                        $newFilePath = $path . $filename;
                        // Upload the file into the temp dir
                        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                            array_push($uploaded_files, [
                                    'file_name' => $filename,
                                    'filetype'  => $_FILES[$index_name]['type'][$i],
                                    ]);
                        }
                    }
                //}
            }
        }
        if (count($uploaded_files) > 0) {
            return $uploaded_files;
        }

        return false;
    }


    public function get_training_attachments($id)
    {
        $this->db->where('trainid', $id);
        
        return $this->db->get(db_prefix() . 'my_training_attachments')->result_array();
    }

    public function delete_attachment($id){
        $this->db->where('id', $id);
        $this->db->delete('my_training_attachments');
        if ($this->db->affected_rows() > 0) {
            log_activity('Attachement Deleted [' . $id . ']');

            return true;
        }

        return false;
    }
}