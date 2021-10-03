<?php

defined('BASEPATH') or exit('No direct script access allowed');

require FCPATH. '/modules/googlesheets/thid_party/vendor/autoload.php';

class Googlesheets extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Drive_model');
        $this->load->model('Sheets_model');
    }

    public  function login()
    {

        $client = new Google_Client();
        $client->setAuthConfig(__DIR__.'/client_id.json');
        $client->setRedirectUri('http://localhost:80/perfex_crm/admin/googlesheets/login');
        $client->setApprovalPrompt('force');
        $client->setAccessType ("offline");
        if (isset($_GET["code"]))
        {
            $access_token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
            $client->setAccessToken($access_token);
            $access_token['staff_id'] = get_staff_user_id();
            $success = $this->Drive_model->add($access_token);
            if($success)
                set_alert('success', 'Login Successfully');
            else
                set_alert('warning', 'Problem');
        }
        set_alert('warning', 'Something went wrong!');
        redirect(admin_url('googlesheets'));
    }
     /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */

    public function index()
    {
        log_activity("index");
        log_message("error","index");
        $data = [];
        $result["files"] = [];
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__.'/client_id.json');
        $client->addScope(Google_Service_Drive::DRIVE,Google_Service_sheets::SPREADSHEETS);
        $client->setRedirectUri('http://localhost:80/perfex_crm/admin/googlesheets/login');
        $credentials = $this->Drive_model->get(get_staff_user_id());
        $client->setApprovalPrompt('force');
        $client->setAccessType ("offline");
        if (is_array($credentials)) {
            unset($credentials['staff_id']);
            $access_token = $credentials;
            $client->setAccessToken($access_token);
            if ($client->isAccessTokenExpired() ) {
                log_message("error","is expired");
                $refresh_token = $client->getRefreshToken();
                $client->fetchAccessTokenWithRefreshToken($refresh_token);
                $this->Drive_model->update($client->getAccessToken(), get_staff_user_id());
            }
            $drive_service = new Google_Service_Drive($client);
            $files_list = $drive_service->files->listFiles(array())->getFiles();
            $type_is_sheet="application/vnd.google-apps.spreadsheet";
            $type_is_excel ="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
            $optParams = array(
                'q' => 'mimeType="'.$type_is_sheet.'" or mimeType="'. $type_is_excel.'"',
                'fields' => 'nextPageToken, files(id, name,mimeType)',
              );
              $results = $drive_service->files->listFiles($optParams);
            if (count($results->getFiles()) == 0) {
            } else {
                foreach ($results->getFiles() as $file) {
                        array_push($data, $file);
                }
            }
        } else {
            $login_button = $client->createAuthUrl();
            $result['login_button'] = $login_button;
        }
        $result["files"] = $data;
        $this->load->view('manage',$result);
    }

    public function logout()
    {
        $success = $this->Drive_model->delete(get_staff_user_id());
        if($success)
        {
            set_alert('success', 'logout successfully!');
            redirect(admin_url('googlesheets'));
        }
        else
        {
            set_alert('warning', 'Something went wrong!');
        }
    }

    public function new_sheet()
    {
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__.'/client_id.json');
        $client->addScope(Google_Service_Drive::DRIVE,Google_Service_sheets::SPREADSHEETS);
        $client->setRedirectUri('http://localhost:80/legalserv/admin/googlesheets/login');
        $credentials = $this->Drive_model->get(get_staff_user_id());
        $client->setApprovalPrompt('force');
        $client->setAccessType ("offline");
        if (is_array($credentials))
        {
            unset($credentials['staff_id']);
            $access_token = $credentials;
            $client->setAccessToken($access_token);
            if ($client->isAccessTokenExpired() ) {
                log_message("error","is expired");
                $refresh_token = $client->getRefreshToken();
                $client->fetchAccessTokenWithRefreshToken($refresh_token);
                $this->Drive_model->update($client->getAccessToken(), get_staff_user_id());
            }
        }
        $spreadsheet = new Google_Service_Sheets_Spreadsheet([
            'properties' => [
                'title' => $this->input->post('name')
                            ]
                        ]);
        $service = new Google_Service_Sheets($client);
        $spreadsheet = $service->spreadsheets->create($spreadsheet, [
            'fields' => 'spreadsheetId'
        ]);
        redirect(admin_url('googlesheets/sheetbyid/'.$spreadsheet->spreadsheetId));
    }


    public function DeleteSpreadsheet_from_google($spreadsheet_id)
    {
        $access_token = $this->Drive_model->get(get_staff_user_id());
        $access_token = $access_token['access_token'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/drive/v3/files/' . $spreadsheet_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token, 'Content-Type: application/json'));
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        if($http_code != 204)
        set_alert('warning', 'Problem delete from google');
        if($http_code = 204)
        {
            set_alert('success', 'deleted sheet from google drive successfully!');
            redirect(admin_url('googlesheets'));
         }
         else
         {
            set_alert('warning', 'Problem delete from google');
        }
    }

    public function DeleteSpreadsheet_from_database($id)
    {
        $data = $this->Sheets_model->get($id);
        $path = "uploads/google_sheets/" . $data['id'];
        $success = $this->Sheets_model->deleteDirectory($path);
        if($success) {
            $success = $this->Sheets_model->delete($id);
            if ($success) {
                set_alert('success', 'deleted Sheet from database Successfully');
                redirect(admin_url('googlesheets'));
            } else
                set_alert('warning', 'Problem deleted from database');
        } else
            set_alert('warning', 'Problem deleted form website');
    }

    public function DeleteSpreadsheet_from_project($id)
    {
        $data = $this->Sheets_model->get($id);
        $path = "uploads/google_sheets/" . $data['id'];
        $success = $this->Sheets_model->deleteDirectory($path);
        if($success) {
            $success = $this->Sheets_model->delete($id);
            if ($success) {
                set_alert('success', 'deleted Sheet from database Successfully');
                $type = $data['rel_type'];
                $id = $data['rel_id'];
                $data_relate = get_relation_data($type,$id);
                $rel_values = get_relation_values($data_relate,$type);
                redirect($rel_values['link'].'?group=project_google_sheets');
            } else
                set_alert('warning', 'Problem deleted from database');
        }else
            set_alert('warning', 'Problem deleted form website');
    }

    public function UpdateSpreadsheetProperties()
    {
        $data = $this->Drive_model->get(get_staff_user_id());
        $access_token = $data['access_token'];
        $curlPost = array('name' => $this->input->post('name'));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/drive/v3/files/' . $this->input->post('id'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token, 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlPost));
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        if($http_code = 200){
            $id = $this->Sheets_model->get($this->input->post('id'));
            $path = $id['sheet_path'];
            $success = $this->Sheets_model->deleteDirectory($path);
            if($success) {
            $edit['sheet_id'] = $this->input->post('id');
            $edit['sheet_title'] = $this->input->post('name');
            $edit['sheet_path'] = "uploads/google_sheets/".$id['id'].'/'.$this->input->post('name').'.xlsx';
            $success = $this->Sheets_model->update($edit);
            if($success){
                $client = new Google_Client();
                $client->setAuthConfig(__DIR__.'/client_id.json');
                $client->addScope(Google_Service_Drive::DRIVE,Google_Service_sheets::SPREADSHEETS);
                $client->setRedirectUri('http://localhost:80/perfex_crm/admin/googlesheets/login');
                $credentials = $this->Drive_model->get(get_staff_user_id());
                $client->setApprovalPrompt('force');
                $client->setAccessType ("offline");
                if (is_array($credentials)) {
                    unset($credentials['staff_id']);
                    $access_token = $credentials;
                    $client->setAccessToken($access_token);
                    if ($client->isAccessTokenExpired()) {
                        log_message("error", "is expired");
                        $refresh_token = $client->getRefreshToken();
                        $client->fetchAccessTokenWithRefreshToken($refresh_token);
                        $this->Drive_model->update($client->getAccessToken(), get_staff_user_id());
                    }
                    $service = new Google_Service_Drive($client);
                    $response = $service->files->export($this->input->post('id'), 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        array('alt' => 'media'));
                    $content = $response->getBody()->getContents();
                    $filePath = "uploads/google_sheets/".$id['id'].'/'.$this->input->post('name').'.xlsx';
                    file_put_contents($filePath, $content);
                    if (file_exists($filePath)){
                        set_alert('success', 'download Sheet Successfully');
                        redirect(admin_url('googlesheets'));
                    } else
                        set_alert('warning', 'Problem');
                }
            }
                set_alert('success', 'Save Sheet Successfully');
                redirect(admin_url('googlesheets'));}
                else
                set_alert('warning', 'Problem');
        }
        if($http_code != 200)
        set_alert('warning', 'Problem');
    }

    function synchronizaion() {
        $result_db = $this->Sheets_model->get_all_fils();
        $data_client = $this->Drive_model->get(get_staff_user_id());
        $access_token = $data_client['access_token'];
        if ($result_db){
            foreach ($result_db as $id) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/drive/v3/files/' . $id['sheet_id']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token, 'Content-Type: application/json'));
                $data = json_decode(curl_exec($ch), true);
                $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
                if($http_code == 200){
                    $client = new Google_Client();
                    $client->setAuthConfig(__DIR__.'/client_id.json');
                    $client->addScope(Google_Service_Drive::DRIVE,Google_Service_sheets::SPREADSHEETS);
                    $client->setRedirectUri('http://localhost:80/perfex_crm/admin/googlesheets/login');
                    $client->setApprovalPrompt('force');
                    $client->setAccessType ("offline");
                    if (is_array($data_client)) {
                        unset($data_client['staff_id']);
                        $access_token = $data_client;
                        $client->setAccessToken($access_token);
                        if ($client->isAccessTokenExpired()) {
                            log_message("error", "is expired");
                            $refresh_token = $client->getRefreshToken();
                            $client->fetchAccessTokenWithRefreshToken($refresh_token);
                            $this->Drive_model->update($client->getAccessToken(), get_staff_user_id());
                        }
                        $service = new Google_Service_Drive($client);
                        $response = $service->files->export($id['sheet_id'], 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            array('alt' => 'media'));
                        $content = $response->getBody()->getContents();
                        $file = $service->files->get($id['sheet_id']);
                        $filePath = "uploads/google_sheets/".$id['id'].'/'.$id['sheet_title'].'.xlsx';
                        $this->Sheets_model->deleteDirectory($filePath);
                        $edit['sheet_id'] = $id['sheet_id'];
                        $edit['sheet_title'] = $file->name;
                        $edit['sheet_path'] = "uploads/google_sheets/".$id['id'].'/'.$file->name.'.xlsx';
                        $this->Sheets_model->update($edit);
                        $filePath = "uploads/google_sheets/" . $id['id'] . '/' . $file->name . '.xlsx';
                        file_put_contents($filePath, $content);
                        if (file_exists($filePath)) {
                            break;
                        }
                    }
                }
                if($http_code != 200) {
                    $filePath = "uploads/google_sheets/" . $id['id'];
                    $success = $this->Sheets_model->deleteDirectory($filePath);
                    if($success) {
                        $success = $this->Sheets_model->delete($id['sheet_id']);
                        if ($success) {
                            break;
                        }
                    }

                }
            }
            set_alert('success', 'synchronizaion Sheets Successfully');
            redirect(admin_url('googlesheets'));
        }else
            set_alert('success', 'synchronizaion');
        redirect(admin_url('googlesheets'));
    }

    public function getfiles($spreadsheet_id,$spreadsheet_name)
    {
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__.'/client_id.json');
        $client->addScope(Google_Service_Drive::DRIVE,Google_Service_sheets::SPREADSHEETS);
        $client->setRedirectUri('http://localhost:80/perfex_crm/admin/googlesheets/login');
        $credentials = $this->Drive_model->get(get_staff_user_id());
        $client->setApprovalPrompt('force');
        $client->setAccessType ("offline");
        if (is_array($credentials))
        {
            unset($credentials['staff_id']);
            $access_token = $credentials;
            $client->setAccessToken($access_token);
            if ($client->isAccessTokenExpired() ) {
                log_message("error","is expired");
                $refresh_token = $client->getRefreshToken();
                $client->fetchAccessTokenWithRefreshToken($refresh_token);
                $this->Drive_model->update($client->getAccessToken(), get_staff_user_id());
            }
            $service = new Google_Service_Drive($client);
            $response = $service->files->export($spreadsheet_id, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            array('alt' => 'media' ));
            $content = $response->getBody()->getContents();
            $filePath = "C:\Users\m.noor\Downloads".'/'.$spreadsheet_name.'.xlsx';
            file_put_contents($filePath, $content);
            if (file_exists($filePath)){
                set_alert('success', 'Download Sheet Successfully Check Your Download Folder ');
                redirect(admin_url('googlesheets'));}
                else
                set_alert('warning', 'Problem');
            }
    }

    function insert_file()
    {
        $data = $this->input->post();
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__.'/client_id.json');
        $client->addScope(Google_Service_Drive::DRIVE,Google_Service_sheets::SPREADSHEETS);
        $client->setRedirectUri('http://localhost:80/perfex_crm/admin/googlesheets/login');
        $credentials = $this->Drive_model->get(get_staff_user_id());
        $client->setApprovalPrompt('force');
        $client->setAccessType ("offline");
        if (is_array($credentials)) {
            unset($credentials['staff_id']);
            $access_token = $credentials;
            $client->setAccessToken($access_token);
            if ($client->isAccessTokenExpired()) {
                log_message("error", "is expired");
                $refresh_token = $client->getRefreshToken();
                $client->fetchAccessTokenWithRefreshToken($refresh_token);
                $this->Drive_model->update($client->getAccessToken(), get_staff_user_id());
            }
            $service = new Google_Service_Drive($client);
            $response = $service->files->export($data['id'], 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                array('alt' => 'media'));
            $content = $response->getBody()->getContents();
            $add_sheets['staff_id'] = get_staff_user_id();
            $add_sheets['sheet_id'] = $data['id'];
            $add_sheets['sheet_title'] = $data['name'];
            $add_sheets['rel_type'] = $data['rel_type'];
            $add_sheets['rel_id'] = $data['rel_id'];
            $success = $this->Sheets_model->add($add_sheets);
            if($success) {
                $id = $this->Sheets_model->get($data['id']);
                mkdir('uploads/google_sheets/' . $id['id'], 0777, true);
                $filePath = "uploads/google_sheets/" . $id['id'] . '/' . $data['name'] . '.xlsx';
                file_put_contents($filePath, $content);
                $add_sheets['sheet_path'] = $filePath;
                $add_sheets['sheet_id'] = $data['id'];
                $success = $this->Sheets_model->update($add_sheets);
                if ($success) {
                    set_alert('success', 'Save Sheet Successfully');
                    redirect(admin_url('googlesheets'));
                } else
                    set_alert('warning', 'Problem');
            }
            else
                set_alert('warning', 'Problem');
        }
    }

    public function sheetbyid($id)
    {
        $data["id"] = $id;
        $this->load->view('sheet',$data);
    }

    public function uploadImage($field, $id)
    {
        $this->deleteDirectory("uploads/hr/document/$id");
        mkdir('uploads/hr/document/'.$id, 0777, true);
        $config['upload_path'] = 'uploads/hr/document/'.$id.'/';
        //png, jpg, jpeg, gif, txt, pdf, xls, xlsx, doc, docx
        $config['allowed_types'] = 'gif|jpg|png|jpeg|txt|pdf|xls|xlsx|doc|docs';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($field)) {
            $error = $this->upload->display_errors();
            return $error;
            // uploading failed. $error will holds the errors.
        } else {
            $data = $this->upload->data();
            $file['path'] = $config['upload_path'] . $data['file_name'];
            return $file;
        }
    }



}
