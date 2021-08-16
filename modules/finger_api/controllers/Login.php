<?php defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__.'/API_Controller.php';
class Login extends API_Controller
{
    public function __construct() {
        header('Access-Control-Allow-Methods: GET, POST');
        parent::__construct();
    }

    public function login_post()
    {
        $this->load->model('Authentication_model');
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
        ]);
        $this->form_validation->set_rules('password', _l('admin_auth_login_password'), 'required');
        $this->form_validation->set_rules('email', _l('admin_auth_login_email'), 'trim|required|valid_email');
        if (show_recaptcha()) {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_recaptcha');
        }
        if ($this->form_validation->run() !== false) {
            $email = $this->input->post('email');
            $password = $this->input->post('password', false);
            $remember = $this->input->post('remember');

            $data = $this->Authentication_model->login($email, $password, $remember, true);
            if (is_array($data) && isset($data['memberinactive'])) {
                $this->api_return(
                    [
                        'status' => false,
                        "message" => _l('admin_auth_inactive_account'),

                    ],
                    403);
                die();
            }
            if($data == true){
                $payload = [
                    $email
                ];


                $this->load->library('Authorization_token');

                // generate a token
                $token = $this->Authorization_token->generateToken($payload);$this->api_return(
                    [
                        'status' => true,
                        "token" => $token,

                    ],
                    200);
                $data = [];
                $data['user'] = $email;
                $this->load->model('Staff_model');
                $staff = $this->Staff_model->get('', ['email' => $email]);

                $data['name'] = $staff[0]['firstname'];
                $data['token'] = $token;
                $data['expiration_date'] = date('Y-m-d', strtotime(date('Y-m-d'). ' + '. '720'.' days'));
                $this->db->insert(db_prefix() . 'user_finger_api', $data);
                $insert_id = $this->db->insert_id();
                if ($insert_id) {
                    log_activity('New User Added [ID: ' . $insert_id . ', Name: ' . $data['name'] . ']');
                }
                die();
            }
            $this->api_return(
                [
                    'status' => false,
                    "message" => 'The given data was invalid!',

                ],
                400);
            die();


        }





        // Load Authorization Library or Load in autoload config file

    }

    /**
     * view method
     *
     * @link [finger_api/user/view]
     * @method POST
     * @return Response|void
     */
    public function view()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration [Return Array: User Token Data]
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);

        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'user_data' => $user_data['token_data']
                ],
            ],
        200);
    }

    public function api_key()
    {
        $this->_APIConfig([
            'methods' => ['POST'],
            'key' => ['header', 'Set API Key'],
        ]);
    }
}