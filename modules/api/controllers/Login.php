<?php defined('BASEPATH') or exit('No direct script access allowed');
require __DIR__ . '/API_Controller.php';

class Login extends API_Controller
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function login()
    {
        header("Access-Control-Allow-Origin: *");
        $this->load->model('api_model');
        // API Configuration

        $this->_apiConfig([
            'methods' => ['POST'],
        ]);

        $data = $this->input->post();
        $this->form_validation->set_rules('password', _l('clients_login_password'), 'required');
        $this->form_validation->set_rules('email', _l('clients_login_email'), 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->api_return(
                [
                    'status' => false,
                    'errors' => $this->form_validation->error_array(),
                ],
                401);
            die();
        } else {
            $row = $this->api_model->login($data['email'], $data['password']);
            if ($row['status']) {
                $user = $row['user'];
                // you user authentication code will go here, you can compare the user with the database or whatever
                $payload = [
                    'user_id' => $user->id,
                ];

                // Load Authorization Library or Load in autoload config file
                $this->load->library('Authorization_Token');

                // generate a token
                $token = $this->authorization_token->generateToken($payload);

                $success = $this->api_model->update_token($user->id, $token);
                // return data
                if ($success) {
                    $this->api_return(
                        [
                            'status' => true,
                            "data" => [
                                'user' => $user,
                                'token' => $token,
                            ],
                        ],
                        200);
                    die();
                } else {
                    $this->api_return(
                        ['status' => false,
                            'errors' =>  'update token '._l('something_went_wrong')
                        ],
                        401);
                    die();
                }
            } else {
                $this->api_return($row, 401);
                die();
            }
        }
    }

    public function get_feedback_questions()
    {
        header("Access-Control-Allow-Origin: *");
        $this->load->model('feedback_model','feedback');
        // API Configuration
        $this->_apiConfig([
            'methods' => ['GET'],
        ]);
        $questions = $this->feedback->get_questions();
        $this->api_return(
            [
                'status' => TRUE,
                'data' => $questions,
                'message' => 'feedback questions'
            ],
            200);
        die();
    }

}