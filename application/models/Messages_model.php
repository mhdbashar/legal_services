<?php

class Messages_model extends App_Model
{

    protected $table = null;

    public function __construct()
    {
        $this->table = 'tblmessages';
        parent::__construct($this->table);
    }

    /*
     * prepare details info of a message
     */

    public function get_details($options = array())
    {

        $messages_table = 'tblmessages';
        $users_table = 'tblstaff';
        $mode = $this->get_clean_value($options, "mode");

        $where = "";
        $id = $this->get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $messages_table.id=$id";
        }

        $message_id = $this->get_clean_value($options, "message_id");
        if ($message_id) {
            $where .= " AND $messages_table.message_id=$message_id";
        }

        $user_id = $this->get_clean_value($options, "user_id");
        if ($user_id) {
            $where .= " AND ($messages_table.from_user_id=$user_id OR $messages_table.to_user_id=$user_id) ";
        }

        $join_with = "$messages_table.from_user_id";
        $join_another = "$messages_table.to_user_id";
        if ($user_id && $mode === "inbox") {
            $where .= " AND $messages_table.message_id=0 ";
        } else if ($user_id && $mode === "sent_items") {
            $where .= " AND $messages_table.message_id=0 ";
            $join_with = "$messages_table.to_user_id";
            $join_another = "$messages_table.from_user_id";
        }

        $last_message_id = $this->get_clean_value($options, "last_message_id");
        if ($last_message_id) {
            $where .= " AND $messages_table.id > $last_message_id";
        }

        $top_message_id = $this->get_clean_value($options, "top_message_id");

        if ($top_message_id) {

            $where .= " AND $messages_table.id < $top_message_id";
        }

        $limit = $this->get_clean_value($options, "limit");
        $limit = $limit ? $limit : "30";
        $offset = $this->get_clean_value($options, "offset");
        $offset = $offset ? $offset : "0";

        $sql = "SELECT * FROM (SELECT 0 AS reply_message_id, $messages_table.*, CONCAT($users_table.firstname, ' ', $users_table.lastname) AS user_name, $users_table.profile_image AS user_image,  CONCAT(another_user.firstname, ' ', another_user.lastname) AS another_user_name, another_user.staffid AS another_user_id
        FROM $messages_table
        LEFT JOIN $users_table ON $users_table.staffid=$join_with
        LEFT JOIN $users_table AS another_user ON another_user.staffid=$join_another
        WHERE $messages_table.deleted=0 $where
        ORDER BY $messages_table.id DESC  LIMIT $offset, $limit) new_message ORDER BY id ASC";

        $query = $this->db->query($sql);

        $data = new \stdClass();
        $data->result = $query->result();
        $data->row = $query->row();
        $data->found_rows = 0;

        if ($message_id) {
            $data->found_rows = $this->db->query("SELECT COUNT(id) AS found_rows FROM $messages_table WHERE $messages_table.message_id = $message_id")->Row()->found_rows;
        }

        return $data;
    }

    /*
     * prepare inbox/sent items list
     */
    public function update($data, $id)
    {

        $affectedRows = 0;
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            if (handle_custom_fields_post($id, $custom_fields)) {
                $affectedRows++;
            }
            unset($data['custom_fields']);
        }

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'messages', $data);
        if ($this->db->affected_rows() > 0) {

            $affectedRows++;
            log_activity('Messages Updated [ID: ' . $id . ']');

            return true;
        }

        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    public function delete($id, $simpleDelete = false)
    {

        $this->db->where('relid', $id);
        $this->db->where('fieldto', 'message'); //message is the name of belong to in custom fields table
        $this->db->delete(db_prefix() . 'customfieldsvalues');

        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'messages');
        if ($this->db->affected_rows() > 0) {
            if (is_dir(get_upload_path_by_type('message') . $id)) {
                if (delete_dir(get_upload_path_by_type('message') . $id)) {
                    $this->db->where('rel_id', $id);
                    $this->db->where('rel_type', 'message');
                    $this->db->delete(db_prefix() . 'files');

                }
            }

            $this->db->where('message_id', $id);
            $this->db->delete(db_prefix() . 'messages');

            log_activity('Message Deleted [' . $id . ']');

            return true;
        }

        return false;
    }

    public function get_list($options = array())
    {
        $messages_table = 'tblmessages';
        $users_table = 'tblcontacts';

        $mode = $this->get_clean_value($options, "mode");
        $user_id = $this->get_clean_value($options, "user_id");

        if ($user_id && $mode === "inbox") {
            $where_user = "to_user_id";
            $select_user = "from_user_id";
        } else if ($user_id && $mode === "sent_items") {
            $where_user = "from_user_id";
            $select_user = "to_user_id";
        }

        $where = "";
        $user_ids = $this->get_clean_value($options, "user_ids");
        if ($user_ids) {
            $where .= " AND $messages_table.$select_user IN($user_ids)";
        }

        $notification_sql = "";
        $is_notification = $this->get_clean_value($options, "is_notification");
        if ($is_notification) {
            $notification_sql = " ORDER BY timestamp($messages_table.created_at) DESC LIMIT 10 ";
        }

        //ignor sql mode here
        $this->db->query("SET sql_mode = ''");

        $sql = "SELECT  y.*, $messages_table.status, $messages_table.created_at, $messages_table.files,
                CONCAT($users_table.firstname, ' ', $users_table.lastname) AS user_name, $users_table.profile_image AS user_image
                FROM (
                    SELECT max(x.id) as id, main_message_id,  subject, IF(subject='', (SELECT subject FROM $messages_table WHERE id=main_message_id) ,'') as reply_subject, $select_user
                        FROM (SELECT id, IF(message_id=0,id,message_id) as main_message_id, subject, $select_user
                                FROM $messages_table
                              WHERE deleted=0 AND $where_user=$user_id $where AND FIND_IN_SET($user_id, $messages_table.deleted_by_users) = 0) x
                    GROUP BY main_message_id) y
                LEFT JOIN $users_table ON $users_table.staffid= y.$select_user
                LEFT JOIN $messages_table ON $messages_table.id= y.id ";

        return $this->db->query($sql);
    }

    public function get_list_client_contacts($options = array())
    {
        $messages_table = 'tblmessages';
        $users_table = 'tblcontacts';

        $mode = $this->get_clean_value($options, "mode");
        $user_id = $this->get_clean_value($options, "user_id");
        $user_id = $user_id . '_client';

        //ignor sql mode here
        $this->db->query("SET sql_mode = ''");

        if ($mode == 'inbox') {
            $sql = "select * from $messages_table where  to_user_id like '" . $user_id . "' AND message_id = 0";
        } elseif ($mode == 'sent_items') {
            $sql = "select * from $messages_table where  from_user_id like '" . $user_id . "' AND message_id = 0 ";
        }

        return $this->db->query($sql);
    }

    public function get_list_sent_items($options = array())
    {

        $messages_table = 'tblmessages';
        $users_table = 'tblstaff';
        $mode = "sent_items";
        $user_id = $this->get_clean_value($options, "user_id");

        if ($user_id && $mode === "sent_items") {
            $where_user = "from_user_id";
            $select_user = "to_user_id";
        }

        //ignor sql mode here
        $this->db->query("SET sql_mode = ''");

        $sql = "SELECT  y.*, $messages_table.status, $messages_table.created_at, $messages_table.files,
                CONCAT($users_table.firstname, ' ', $users_table.lastname) AS user_name, $users_table.profile_image AS user_image
                FROM (
                    SELECT max(x.id) as id, main_message_id,  subject, IF(subject='', (SELECT subject FROM $messages_table WHERE id=main_message_id) ,'') as reply_subject, $select_user
                        FROM (SELECT id, IF(message_id=0,id,message_id) as main_message_id, subject, $select_user
                                FROM $messages_table
                              WHERE deleted=0 AND $where_user=$user_id  AND FIND_IN_SET($user_id, $messages_table.deleted_by_users) = 0) x
                    GROUP BY main_message_id) y
                LEFT JOIN $users_table ON $users_table.staffid= $user_id
                LEFT JOIN $messages_table ON $messages_table.id= y.id ";

        return $this->db->query($sql);

    }

    public function get_list_staff($options = array())
    {

        $messages_table = 'tblmessages';
        $users_table = 'tblstaff';
        $mode = $this->get_clean_value($options, "mode");
        $user_id = 3;
        $this->get_clean_value($options, "user_id");

        if ($user_id && $mode === "inbox") {
            $where_user = "to_user_id";
            $select_user = "from_user_id";
        } else if ($user_id && $mode === "sent_items") {
            $where_user = "from_user_id";
            $select_user = "to_user_id";
        }

        $where = "";

        $notification_sql = "";
        $is_notification = $this->get_clean_value($options, "is_notification");
        if ($is_notification) {
            $notification_sql = " ORDER BY timestamp($messages_table.created_at) DESC LIMIT 10 ";
        }

        //ignor sql mode here
        $this->db->query("SET sql_mode = ''");

        $sql = "SELECT  y.*, $messages_table.status, $messages_table.created_at, $messages_table.files,
                CONCAT($users_table.firstname, ' ', $users_table.lastname) AS user_name, $users_table.profile_image AS user_image
                FROM (
                    SELECT max(x.id) as id, main_message_id,  subject, IF(subject='', (SELECT subject FROM $messages_table WHERE id=main_message_id) ,'') as reply_subject, $select_user
                        FROM (SELECT id, IF(message_id=0,id,message_id) as main_message_id, subject, $select_user
                                FROM $messages_table
                              WHERE deleted=0 AND $where_user=2 $where AND FIND_IN_SET($user_id, $messages_table.deleted_by_users) = 0) x
                    GROUP BY main_message_id) y
                LEFT JOIN $users_table ON $users_table.staffid= y.$select_user
                LEFT JOIN $messages_table ON $messages_table.id= y.id $notification_sql";

        return $this->db->query($sql);
    }

    protected function get_clean_value($options, $key)
    {

        $value = get_array_value($options, $key);

        return $value; //false, 0, null

    }
    public function add($data)
    {

        $this->db->insert('tblmessages', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Message [ID: ' . $insert_id . ']');

            return $insert_id;
        }

        return false;
    }
    public function get()
    {

        return $this->db->get(db_prefix() . 'staff')->result();

    }
    public function get_contact()
    {
        // get_contact_user_id()

        return $this->db->get(db_prefix() . 'contacts')->result();

    }
    public function get_one($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);

            return $this->db->get(db_prefix() . 'messages')->row();
        }

        $this->db->order_by('id', 'desc');
        return $this->db->get(db_prefix() . 'messages')->result_array();
    }

    public function get_reply_all($message_id)
    {
        $sql = "select * from tblmessages where message_id = $message_id ";

        return $this->db->query($sql)->result();

    }
    public function get_unread_messages()
    {

        $to_user_id = get_staff_user_id() . '_staff';
        $query = $this->db->query("select * from tblmessages where status = 'unread' and to_user_id = '" . $to_user_id . "'");
        return $query->num_rows();

    }

    public function get_unread_messages_client()
    {

        $to_user_id = get_contact_user_id() . '_client';
        $query = $this->db->query("select * from tblmessages where status = 'unread' and to_user_id = '" . $to_user_id . "'");
        return $query->num_rows();

    }

    public function update_notification($view)
    {

        $this->db->query("UPDATE tblmessages SET status = 'read'");

    }
    public function GetSender($id)
    {
        //proccess id to extract staff or client from from_use_id

        if (str_contains($id, 'staff')) {

            $from_use_id = str_replace('_staff', '', $id);
            $this->db->select('staff.staffid, staff.firstname, staff.lastname,messages.from_user_id');
            $this->db->from('staff,messages');

            $this->db->where('staff.staffid', $from_use_id);
            return $this->db->get()->row();

        } elseif (str_contains($id, 'client')) {

            $from_use_id = str_replace('_client', '', $id);
            $this->db->select('contacts.id, contacts.firstname, contacts.lastname,messages.from_user_id');
            $this->db->from('contacts,messages');

            $this->db->where('contacts.id', $from_use_id);
            return $this->db->get()->row();

        }

    }

    public function GetSender_get($id)
    {
        //proccess id to extract staff or client from  to_use_id

        if (str_contains($id, 'staff')) {

            $to_use_id = str_replace('_staff', '', $id);
            $this->db->select('staff.staffid, staff.firstname, staff.lastname,messages.to_user_id');
            $this->db->from('staff,messages');

            $this->db->where('staff.staffid', $to_use_id);
            return $this->db->get()->row();

        } elseif (str_contains($id, 'client')) {

            $to_use_id = str_replace('_client', '', $id);
            $this->db->select('contacts.id, contacts.firstname, contacts.lastname,messages.to_user_id');
            $this->db->from('contacts,messages');

            $this->db->where('contacts.id', $to_use_id);
            return $this->db->get()->row();

        }

    }
    public function delete_message_attachment($id)
    {
        if (is_dir(get_upload_path_by_type('message') . $id)) {
            if (delete_dir(get_upload_path_by_type('message') . $id)) {
                $this->db->where('rel_id', $id);
                $this->db->where('rel_type', 'message');
                $this->db->delete(db_prefix() . 'files');
                log_activity('Message Doc Deleted [ProcID: ' . $id . ']');

                return true;
            }
        }

        return false;
    }

}
