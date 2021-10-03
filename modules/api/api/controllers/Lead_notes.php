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

class Lead_notes extends REST_Controller {



    function __construct()

    {

        // Construct the parent class

        parent::__construct();

        $this->load->model('Api_model');

        $this->load->model('Leads_model_api');

        $this->load->model('misc_model');



    }




    public function data_get($id = '')
    {
        $type = $this->get('type');
        $typeby = $this->get('typeby');
        $lead_id = $this->get('lead_id');
        if ($type == 'notes') {
            if ($info =$this->Leads_model_api->get_lead_notes($lead_id,$typeby)) {
                $sl_data = [];
                foreach ($info as $infos) {
                    $infos->addedfrom_name = $this->Leads_model_api->getaddedfrombyid($infos->addedfrom);
                           
                   // $team->created_by = $this->team_api->getUser($sale->created_by);
                    $sl_data[] = $infos;
                }
           
                $data =  [
                'data' => $sl_data,
                'status' => 1,
                ];
                $this->response($data, REST_Controller::HTTP_OK);
            }

        }elseif ($type == 'reminder'){
                if ($info =$this->Leads_model_api->get_lead_reminders($lead_id,$typeby)) {
                $sl_data = [];
                foreach ($info as $infos) {
                    $infos->reminder_name = $this->Leads_model_api->getaddedfrombyid($infos->staff);
                           
                   // $team->created_by = $this->team_api->getUser($sale->created_by);
                    $sl_data[] = $infos;
                }
           
                $data =  [
                'data' => $sl_data,
                'status' => 1,
                ];
                $this->response($data, REST_Controller::HTTP_OK);
            }
        }
    // Check if the data store contains
        if ($data)
        {
            // Set the response and exi
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



    public function data_search_get()

    {

        $key = $this->get('keyword');

        $data = $this->Api_model->search('lead', $key);

        //echo "string"; die();

                // Check if the data store contains

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

            $lead_id = $this->input->post('lead_id', TRUE);

            $type = $this->input->post('type', TRUE);
            $typeby = $this->input->post('typeby', TRUE);

            if ($type == 'notes') {

                 $insert_data = [

                'description' => $this->input->post('description', TRUE),

                'date_contacted' => $this->input->post('date_contacted') ? $this->input->post('date_contacted') : NULL,

                'addedfrom' => $this->input->post('staff_id') ? $this->input->post('staff_id') : NULL,

                ];

            // insert data

             $output = $this->Leads_model_api->add_note($insert_data, $typeby, $lead_id);

                   if($output > 0 && !empty($output)){

                // success

                $this->handle_lead_attachments_array($output);

                $message = array(

                'status' => TRUE,

                'message' => 'Notes add successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Notes add fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

                  }

            }elseif ($type == 'reminder') {

                $insert_data = [

                'description' => $this->input->post('description', TRUE),

                'date' => $this->input->post('date_contacted') ? $this->input->post('date_contacted') : NULL,

                'creator' => $this->input->post('staff_id') ? $this->input->post('staff_id') : NULL,

                'notify_by_email' => $this->input->post('notify_by_email'),

                'rel_id' => $lead_id,

                'rel_type' => $typeby];

            // insert data

             $output = $this->Leads_model_api->add_reminder($insert_data, $lead_id);

                   if($output > 0 && !empty($output)){

                // success

                $this->handle_lead_attachments_array($output);

                $message = array(

                'status' => TRUE,

                'message' => 'Reminder add successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Reminder add fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

                  }

            }

    }





    /**

     * @api {delete} api/delete/leads/:id Delete a Lead

     * @apiName DeleteLead

     * @apiGroup Lead

     *

     * @apiHeader {String} Authorization Basic Access Authentication token.

     *

     * @apiParam {Number} id lead unique ID.

     *

     * @apiSuccess {String} status Request status.

     * @apiSuccess {String} message Lead Delete Successful.

     *

     * @apiSuccessExample Success-Response:

     *     HTTP/1.1 200 OK

     *     {

     *       "status": true,

     *       "message": "Lead Delete Successful."

     *     }

     *

     * @apiError {Boolean} status Request status.

     * @apiError {String} message Lead Delete Fail.

     *

     * @apiErrorExample Error-Response:

     *     HTTP/1.1 404 Not Found

     *     {

     *       "status": false,

     *       "message": "Lead Delete Fail."

     *     }

     */

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





    /**

     * @api {put} api/leads/:id Update a lead

     * @apiName PutLead

     * @apiGroup Lead

     *

     * @apiHeader {String} Authorization Basic Access Authentication token.

     *

     * @apiParam {String} source            Mandatory Lead source.

     * @apiParam {String} status            Mandatory Lead Status.

     * @apiParam {String} name              Mandatory Lead Name.

     * @apiParam {String} [assigned]        Optional Lead assigned.

     * @apiParam {String} [client_id]       Optional Lead From Customer.

     * @apiParam {String} [tags]            Optional Lead tags.

     * @apiParam {String} [contact]         Optional Lead contact.

     * @apiParam {String} [title]           Optional Position.

     * @apiParam {String} [email]           Optional Lead Email Address.

     * @apiParam {String} [website]         Optional Lead Website.

     * @apiParam {String} [phonenumber]     Optional Lead Phone.

     * @apiParam {String} [company]         Optional Lead company.

     * @apiParam {String} [address]         Optional Lead address.

     * @apiParam {String} [city]            Optional Lead City.

     * @apiParam {String} [state]           Optional Lead state.

     * @apiParam {String} [country]         Optional Lead Country.

     * @apiParam {String} [default_language]        Optional Lead Default Language.

     * @apiParam {String} [description]             Optional Lead description.

     * @apiParam {String} [lastcontact]             Optional Lead Last Contact.

     * @apiParam {String} [is_public]               Optional Lead google sheet id.

     *

     *

     * @apiParamExample {json} Request-Example:

     *  {

     *       "name": "Lead name",

     *       "contact": "contact",

     *       "title": "title",

     *       "company": "C.TY TNHH TM VẬN TẢI & DU LỊCH ĐẠI BẢO AN",

     *       "description": "description",

     *       "tags": "",

     *       "city": "London",

     *       "state": "London",

     *       "address": "1a The Alexander Suite Silk Point",

     *       "assigned": "5",

     *       "source": "4",

     *       "email": "AA@gmail.com",

     *       "website": "www.themesic.com",

     *       "phonenumber": "123456789",

     *       "is_public": "on",

     *       "default_language": "english",

     *       "client_id": "3",

     *       "lastcontact": "25/07/2019 08:38:04"

     *   }

     *

     * @apiSuccess {Boolean} status Request status.

     * @apiSuccess {String} message Lead Update Successful.

     *

     * @apiSuccessExample Success-Response:

     *     HTTP/1.1 200 OK

     *     {

     *       "status": true,

     *       "message": "Lead Update Successful."

     *     }

     *

     * @apiError {Boolean} status Request status.

     * @apiError {String} message Lead Update Fail.

     *

     * @apiErrorExample Error-Response:

     *     HTTP/1.1 404 Not Found

     *     {

     *       "status": false,

     *       "message": "Lead Update Fail."

     *     }

     */

    public function data_put($id = '')

    {

        $_POST = json_decode($this->security->xss_clean(file_get_contents("php://input")), true);

        $this->form_validation->set_data($_POST);

        

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



            $update_data = $this->input->post();

            // update data

            $this->load->model('leads_model');

            $output = $this->leads_model->update($update_data, $id);

            if($output > 0 && !empty($output)){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'Lead Update Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Lead Update Fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

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







}

