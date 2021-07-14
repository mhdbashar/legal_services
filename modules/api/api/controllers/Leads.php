<?php



defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__.'/REST_Controller.php';

/**

 * This is an example of a few basic user interaction methods you could use

 * all done with a hardcoded array

 *

 * @package         CodeIgniter

 * @subpackage      Rest Server

 * @category        Controller

 */

class Leads extends REST_Controller {



    function __construct()

    {

        // Construct the parent class

        parent::__construct();

        $this->load->model('Api_model');

        $this->load->model('Leads_model_api');

        $this->load->model('Leads_model');
        $this->load->model('Sendnotification');




    }



    public function data_get($id = '')

    {

        $reference = $this->get('reference');

        $staff_id = $this->get('staff_id');

        $filters = [
        'reference' => $reference,
        'staff_id' => $staff_id,
        'include' => $this->get('include') ? explode(',', $this->get('include')) : NULL,
        'start' => $this->get('start') && is_numeric($this->get('start')) ? $this->get('start') : 1,
        'limit' => $this->get('limit') && is_numeric($this->get('limit')) ? $this->get('limit') : 10,
        'start_date' => $this->get('start_date')  ? date('Y-m-d 00:00:00',strtotime($this->get('start_date'))) : NULL,
        'end_date' => $this->get('end_date') ? date('Y-m-d 00:00:00',strtotime($this->get('end_date'))) : NULL,
        'date_added' => $this->get('date_added')  ? explode(',', $this->get('date_added')) : NULL,
        'date_assigned' => $this->get('date_assigned')  ? explode(',', $this->get('date_assigned')) : NULL,
        'date_lastcontact' => $this->get('date_lastcontact')  ? explode(',', $this->get('date_lastcontact')) : NULL,
        'date_converted' => $this->get('date_converted')  ? explode(',', $this->get('date_converted')) : NULL,
        'date_laststatus' => $this->get('date_laststatus')  ? explode(',', $this->get('date_laststatus')) : NULL,
        'order_by' => $this->get('order_by') ? explode(',', $this->get('order_by')) : ['id', 'decs'],
        'lead_id' => $this->get('lead_id') ? $this->get('lead_id') : NULL,
        'lead_name' => $this->get('lead_name') ? $this->get('lead_name') : NULL,
        'status' => $this->get('status') ? $this->get('status') : NULL,
        'source' => $this->get('source') ? $this->get('source') : NULL,
        'view_all' => $this->get('view_all') ? $this->get('view_all') : NULL,
        ];

        $check_permission = $this->Api_model->check_permission('leads',$staff_id,'view');
       
        if ($filters['view_all'] == 1 && $check_permission == 1) {

            if ($leads =$this->Leads_model_api->get_leads_all($filters)) {

                $sl_data = [];

                foreach ($leads as $lead) {

                    $lead->staff_name = $this->Api_model->getStaffbyId($lead->assigned);
                    $lead->status_name = $this->Api_model->get_lead_status($lead->status);
                    $lead->source_name = $this->Api_model->get_lead_source($lead->source);
                    $lead->tags_field=$this->Leads_model_api->getTagsField($lead->id);

                    if (!empty($filters['include'])) {
                        foreach ($filters['include'] as $include) {
                            if ($include == 'status') {
                                $team->name = $this->team_api->getclientnamebyid($team->id);
                            }
                            if ($include == 'customer_data') {
                                $team->client_data = $this->team_api->getclientdataid($team->id);
                            }
                        }
                    }



                   // $team->created_by = $this->team_api->getUser($sale->created_by);

                    $sl_data[] = $lead;

                }

                $data =  [

                'data' => $sl_data,

                'limit' => (int) $filters['limit'],

                'start' => (int) $filters['start'],

                'status' => 1,

                'total' => $this->Leads_model_api->countLeads($filters),

                ];

                $this->response($data, REST_Controller::HTTP_OK);



            }

       

        // Check if the data store contains

        if ($data)

        {

            // Set the response and exit

            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

        }

        else

        {

            // Set the response and exit

            $this->response([

                'status' => FALSE,

                'message' => 'No data were found'

            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

        }

    }else{

            if ($leads =$this->Leads_model_api->get_leads($filters)) {

                $sl_data = [];

                foreach ($leads as $lead) {

                    $lead->staff_name = $this->Api_model->getStaffbyId($lead->assigned);

                    $lead->status = $this->Api_model->get_lead_status($lead->status);

                    $lead->source = $this->Api_model->get_lead_source($lead->source);

                    if (!empty($filters['include'])) {

                        

                        foreach ($filters['include'] as $include) {

                            if ($include == 'status') {

                                $team->name = $this->team_api->getclientnamebyid($team->id);

                            }

                            if ($include == 'customer_data') {

                                $team->client_data = $this->team_api->getclientdataid($team->id);

                            }

                        }

                    }



                   // $team->created_by = $this->team_api->getUser($sale->created_by);

                    $sl_data[] = $lead;

                }

                $data =  [

                'data' => $sl_data,

                'limit' => (int) $filters['limit'],

                'start' => (int) $filters['start'],

                'status' => 1,

                'total' => $this->Leads_model_api->countLeads($filters),

                ];

                $this->response($data, REST_Controller::HTTP_OK);



            }

       

        // Check if the data store contains

        if ($data)

        {

            // Set the response and exit

            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

        }

        else

        {

            // Set the response and exit

            $this->response([

                'status' => FALSE,

                'message' => 'No data were found'

            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

        }

    }

}



    public function data_search_get()

    {

        $key = $this->get('keyword');

        $data = $this->Api_model->search('lead', $key);

        $S_data = [];

        if ($data)

        {

             $S_data =  [

                'data' => $data,

                'keyword' => $key,

                'status' => 1,

                //'total' => $this->Leads_model->countLeads($filters),

                ];

            // Set the response and exit

            $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

        }

        else

        {

            // Set the response and exit

            $this->response([

                'status' => FALSE,

                'message' => 'No data were found'

            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

        }

    }


    public function data_post()

    {
            $insert_data = [

                'name' => $this->input->post('name', TRUE),

                'source' => $this->input->post('source', TRUE),

                'status' => $this->input->post('status', TRUE),

                'assigned' => $this->Api_model->value($this->input->post('assigned', TRUE)),

                'tags' => $this->Api_model->value($this->input->post('tags', TRUE)),

                'title' => $this->Api_model->value($this->input->post('title', TRUE)),

                'email' => $this->Api_model->value($this->input->post('email', TRUE)),

                'website' => $this->Api_model->value($this->input->post('website', TRUE)),

                'phonenumber' => $this->Api_model->value($this->input->post('phonenumber', TRUE)),

                'company' => $this->Api_model->value($this->input->post('company', TRUE)),

                'address' => $this->Api_model->value($this->input->post('address', TRUE)),

                'city' => $this->Api_model->value($this->input->post('city', TRUE)),

                'zip' => '',

                'state' => $this->Api_model->value($this->input->post('state', TRUE)),

                'default_language' => $this->Api_model->value($this->input->post('default_language', TRUE)),

                'description' => $this->Api_model->value($this->input->post('description', TRUE)),

                'custom_contact_date' => $this->Api_model->value($this->input->post('custom_contact_date', TRUE)),

                'is_public' => $this->Api_model->value($this->input->post('is_public', TRUE)),

                'contacted_today' => $this->Api_model->value($this->input->post('contacted_today', TRUE))

                ];

            // insert data

            $this->load->model('leads_model');


            $output = $this->leads_model->add($insert_data);
            if($output>0){    
            $tokenid=$this->Api_model->getToken($insert_data['assigned']);
            $tokenkey=$this->Api_model->getKey($insert_data['assigned']);
             if($tokenid){
            $q=$this->Sendnotification->send_fcm('#-'.$output.'New Lead Created',$tokenid,'New Lead',$tokenkey);
            }                // success
            }

            if($output > 0 && !empty($output)){

        
                $this->handle_lead_attachments_array($output);

                $message = array(

                'status' => TRUE,

                'message' => 'Lead add successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Lead add fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        // }

    }
    public function data_delete($id = '')

    { 

        $id = $this->security->xss_clean($id);

        if(empty($id) && !is_numeric($id))

        {

            $message = array(

            'status' => FALSE,

            'message' => 'Invalid Lead ID'

        );

        $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }

        else

        {

            // delete data

            $this->load->model('leads_model');

            $output = $this->leads_model->delete($id);

            if($output === TRUE){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'Lead Delete Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Lead Delete Fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

    }

 public function update_post()

    {
    	$leadid=$this->input->post('leadid',TRUE);

            $update_data = [
                'name' => $this->input->post('name', TRUE),
                'source' => $this->input->post('source', TRUE),
                'status' => $this->input->post('status', TRUE),
                'assigned' => $this->Api_model->value($this->input->post('assigned', TRUE)),
                'tags' => $this->Api_model->value($this->input->post('tags', TRUE)),
                'title' => $this->Api_model->value($this->input->post('title', TRUE)),
                'email' => $this->Api_model->value($this->input->post('email', TRUE)),
                'website' => $this->Api_model->value($this->input->post('website', TRUE)),
                'phonenumber' => $this->Api_model->value($this->input->post('phonenumber', TRUE)),
                'company' => $this->Api_model->value($this->input->post('company', TRUE)),
                'address' => $this->Api_model->value($this->input->post('address', TRUE)),
                'city' => $this->Api_model->value($this->input->post('city', TRUE)),
                'zip' => '',
                'state' => $this->Api_model->value($this->input->post('state', TRUE)),
                'default_language' => $this->Api_model->value($this->input->post('default_language', TRUE)),
                'description' => $this->Api_model->value($this->input->post('description', TRUE)),
                'lastcontact' => $this->Api_model->value($this->input->post('lastcontact', TRUE)),
                'is_public' => $this->Api_model->value($this->input->post('is_public', TRUE)),
                // 'contacted_today' => $this->Api_model->value($this->input->post('contacted_today', TRUE))
                ];


            $this->load->model('leads_model');

            $output = $this->leads_model->update($update_data,$leadid);

            if($output > 0 && !empty($output)){

                // success

                $this->handle_lead_attachments_array($output);

                $message = array(

                'status' => TRUE,

                'message' => 'Lead update successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Lead update fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        // }

    }
    



    function handle_lead_attachments_array($leadid, $index_name = 'file')

    {

        $path           = get_upload_path_by_type('lead') . $leadid . '/';

        $CI             = &get_instance();



        if (isset($_FILES[$index_name]['name'])

            && ($_FILES[$index_name]['name'] != '' || is_array($_FILES[$index_name]['name']) && count($_FILES[$index_name]['name']) > 0)) {

            if (!is_array($_FILES[$index_name]['name'])) {

                $_FILES[$index_name]['name']     = [$_FILES[$index_name]['name']];

                $_FILES[$index_name]['type']     = [$_FILES[$index_name]['type']];

                $_FILES[$index_name]['tmp_name'] = [$_FILES[$index_name]['tmp_name']];

                $_FILES[$index_name]['error']    = [$_FILES[$index_name]['error']];

                $_FILES[$index_name]['size']     = [$_FILES[$index_name]['size']];

            }



            _file_attachments_index_fix($index_name);

            for ($i = 0; $i < count($_FILES[$index_name]['name']); $i++) {

                // Get the temp file path

                $tmpFilePath = $_FILES[$index_name]['tmp_name'][$i];



                // Make sure we have a filepath

                if (!empty($tmpFilePath) && $tmpFilePath != '') {

                    if (_perfex_upload_error($_FILES[$index_name]['error'][$i])

                        || !_upload_extension_allowed($_FILES[$index_name]['name'][$i])) {

                        continue;

                    }



                    _maybe_create_upload_path($path);

                    $filename    = unique_filename($path, $_FILES[$index_name]['name'][$i]);

                    $newFilePath = $path . $filename;



                    // Upload the file into the temp dir

                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                        $CI = & get_instance();

                        $CI->load->model('leads_model');

                        $data   = [];

                        $data[] = [

                            'file_name' => $filename,

                            'filetype'  => $_FILES[$index_name]['type'][$i],

                            ];

                        $CI->leads_model->add_attachment_to_database($leadid, $data, false);

                    }

                }

            }

        }

        return true;

    }


public function Leadall_get()
{
$leadid=$this->get('leadid');
$data = $this->db->query('CALL getlead_data(?)',array('id'=>$leadid))->result();
	  $S_data = [];
        if ($data)
        {
             $S_data =  [
                'data' => $data,
                'status' => 1,
                'message'=>'success'
                //'total' => $this->Leads_model->countLeads($filters),
                ];
            // Set the response and exit
            $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
             $S_data =  [
                'data' => $data,
                'status' => 0,
                'message'=>'record not found'
                //'total' => $this->Leads_model->countLeads($filters),
                ];
            // Set the response and exit
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
}




}

