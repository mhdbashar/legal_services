<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Leads_model_api extends CI_Model

{

    public function __construct() {

        parent::__construct();

        $this->load->model('Api_model');



    }

        public function getTagsField($id='')
        {
            $this->db->select('tbltaggables.tag_id,tbltaggables.tag_order,tbltags.name')->from('tbltaggables');
            $this->db->where('tbltaggables.rel_id',$id);
            $this->db->where('tbltaggables.rel_type','lead');
            $this->db->join('tbltags','tbltaggables.tag_id=tbltags.id');
            $this->db->order_by('tbltaggables.tag_order','asc');
            return $this->db->get()->result();
        }

        public function countLeads($filters = [], $ref = NULL) {

        if ($filters['lead_id']) {

            $this->db->where('id', $filters['lead_id']);

        }

        if ($filters['customer_id']) {

            $this->db->where('parent_id', $filters['customer_id']);

        }

        if ($filters['start_date']) {

            $this->db->where('dateadded >=', $filters['start_date']);

        }

        if ($filters['end_date']) {

            $this->db->where('dateadded <=', $filters['end_date']);

        }

        if ($filters['status']) {

            $this->db->where('status', $filters['status']);

        }

        $this->db->where('assigned', $filters['staff_id']);

        $this->db->from('tblleads');

        return $this->db->count_all_results();

    }



        public function get_leads($filters = []) {

        if ($filters['lead_id']) {

            $this->db->where('id', $filters['lead_id']);

        }

        if ($filters['customer_id']) {

            $this->db->where('parent_id', $filters['customer_id']);

        }
         if ($filters['start_date']) {

            $this->db->where('dateadded >=', $filters['start_date']);

        }

         if ($filters['end_date']) {

            $this->db->where('dateadded <=', $filters['end_date']);

        }

        if ($filters['date_added']) {

             $this->db->where('dateadded >=', $filters['date_added'][0]);
             $this->db->where('dateadded <=', $filters['date_added'][1]);
        }

         if ($filters['date_assigned']) {
             $this->db->where('dateassigned >=', $filters['date_assigned'][0]);
             $this->db->where('dateassigned <=', $filters['date_assigned'][1]);
        }
       if ($filters['date_lastcontact']) {
             $this->db->where('lastcontact >=', $filters['date_lastcontact'][0]);
             $this->db->where('lastcontact <=', $filters['date_lastcontact'][1]);
        }
         if ($filters['date_converted']) {
             $this->db->where('date_converted >=', $filters['date_converted'][0]);
             $this->db->where('date_converted <=', $filters['date_converted'][1]);
        }
         if ($filters['date_laststatus']) {
             $this->db->where('last_status_change >=', $filters['date_laststatus'][0]);
             $this->db->where('last_status_change <=', $filters['date_laststatus'][1]);
        }

          if ($filters['name']) {

            $this->db->where('name', $filters['name']);

        }
        if ($filters['status']) {

            $this->db->where_in('status', array($filters['status']));

        }
        if ($filters['source']) {

            $this->db->where_in('source',array($filters['status']) );

        }

        if ($filters['reference']) {

            $this->db->where('reference_no', $filters['reference']);

        } 

        else {

             $this->db->where('assigned', $filters['staff_id']);

            $this->db->order_by($filters['order_by'][0], $filters['order_by'][1] ? $filters['order_by'][1] : 'desc');

            $this->db->limit($filters['limit'], ($filters['start']-1));

        }

        return $this->db->get("tblleads")->result();

    }

    public function get_leads_all($filters = []) {

        if ($filters['lead_id']) {

            $this->db->where('id', $filters['lead_id']);

        }

        if ($filters['customer_id']) {

            $this->db->where('parent_id', $filters['customer_id']);

        }

        if ($filters['start_date']) {

            $this->db->where('dateadded >=', $filters['start_date']);

        }

        if ($filters['end_date']) {

            $this->db->where('dateadded <=', $filters['end_date']);

        }

         if ($filters['status']) {

            $this->db->where('status', $filters['status']);

        }

        if ($filters['reference']) {

            $this->db->where('reference_no', $filters['reference']);

        } 

        else {

            // $this->db->where('assigned', $filters['staff_id']);

            $this->db->order_by($filters['order_by'][0], $filters['order_by'][1] ? $filters['order_by'][1] : 'desc');

            $this->db->limit($filters['limit'], ($filters['start']-1));

        }

        return $this->db->get("tblleads")->result();

    }

    public function get_lead_status($type)

    {

        $q = $this->db->get('tblleads_'.$type);

        return $q->result();

    }

    public function get_tags()

    {

        $q = $this->db->get('tbltags');

        return $q->result();

    }


public function getaddedfrombyid($id)
{
   
        $this->db->where('staffid', $id);

       $q = $this->db->get('tblstaff');

       $data = $q->row();

       $name = $data->firstname.' '.$data->lastname;

        return $name;

}
        public function add_note($data, $rel_type, $rel_id)

    {

        $data['dateadded']   = date('Y-m-d H:i:s');

        $data['addedfrom']   = get_staff_user_id() ? get_staff_user_id() : $data['addedfrom'];

        $data['rel_type']    = $rel_type;

        $data['rel_id']      = $rel_id;

        $data['description'] = nl2br($data['description']);



        $data = hooks()->apply_filters('create_note_data', $data, $rel_type, $rel_id);



        $this->db->insert(db_prefix() . 'notes', $data);

        $insert_id = $this->db->insert_id();



        if ($insert_id) {

            hooks()->do_action('note_created', $insert_id, $data);



            return $insert_id;

        }



        return false;

    }

        public function add_reminder($data, $id)

    {

        if (isset($data['notify_by_email'])) {

            $data['notify_by_email'] = 1;

        } //isset($data['notify_by_email'])

        else {

            $data['notify_by_email'] = 0;

        }

        $data['date']        = to_sql_date($data['date'], true);

        $data['description'] = nl2br($data['description']);

        $data['staff']     = $data['creator'];

        $this->db->insert(db_prefix() . 'reminders', $data);

        $insert_id = $this->db->insert_id();

        if ($insert_id) {

            if ($data['rel_type'] == 'lead') {

                $this->load->model('leads_model');

                $this->leads_model->log_lead_activity($data['rel_id'], 'not_activity_new_reminder_created', false, serialize([

                    get_staff_full_name($data['staff']),

                    _dt($data['date']),

                    ]));

            }

            log_activity('New Reminder Added [' . ucfirst($data['rel_type']) . 'ID: ' . $data['rel_id'] . ' Description: ' . $data['description'] . ']');



            return true;

        } //$insert_id

        return false;

    }

    public function get_lead_notes($id,$typeby)

    {

        $this->db->where('rel_type',$typeby);

        $this->db->where('rel_id',$id);

         $q = $this->db->get('tblnotes');

        return $q->result();

    }

       public function get_lead_reminders($id,$typeby)

    {

        $this->db->where('rel_type',$typeby);

        $this->db->where('rel_id',$id);

         $q = $this->db->get('tblreminders');

        return $q->result();

    }







}

