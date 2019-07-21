<?php

defined('BASEPATH') or exit('No direct script access allowed');

class L_Locations extends AdminController
{
    public function __construct(){
        parent::__construct();
        $this->load->model('Countries_model');
        $this->load->model('Cities_model');
    }

    public function index(){
        if(!is_admin()){
            access_denied();
        }
        if($this->input->is_ajax_request()){
            $this->locationapp->get_table_data('countries_table');
        }
        $data['title'] = 'Locations';
        $this->load->view('admin/countries/countries_manage', $data);
    }

    

    public function country_json($id){
        $data = $this->Countries_model->get($id);
        echo json_encode($data);
    }

    public function edit_country(){
        $data = $this->input->post();
        $id = $this->input->post('country_id');
        $success = $this->Countries_model->update_country($data, $id);
        if($success)
            set_alert('success', 'Country Updated successfully');
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_country(){
        $data = $this->input->post();
        $success = $this->Countries_model->add_country($data);
        if($success)
            set_alert('success', 'Country Added successfully');
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_city(){
        $data = $this->input->post();
        $success = $this->Cities_model->add_city($data);
        if($success)
            set_alert('success', 'City Added successfully');
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function city_json($id){
        $data = $this->Cities_model->get($id);
        echo json_encode($data);
    }

    public function update_city(){

        $data = $this->input->post();
        $id = $this->input->post('Id');
        $success = $this->Cities_model->update_city($data, $id);
        if($success)
            set_alert('success', 'City Updated successfully');
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function edit_country_json(){
        if(!is_admin()){
            access_denied();
        }

        if($this->input->is_ajax_request()){
            if($data['country_id'] = ''){
                echo json_encode(
                    [
                        'sucess' => false,
                        'message' => 'No Id supplied',
                    ]
                );
            } else {
                $response = $this->Countries_model->get($data['country_id']);
                var_dump($response);
                echo json_encode(
                    [
                        'success' => true,
                        'message' => 'successfully returned the data',
                        'data' => $response
                    ]
                );
            }
        }
    }

    /* Delete Customer representative from database */
    public function delete_Country($id)
    {
        if (!$id) {
            redirect(admin_url('location_module/L_Locations/edit_country'));
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Countries_model->delete($id);
        if ($response == true) {
            set_alert('success', 'Deleted country');
        } else {
            set_alert('warning', 'Problem deleting country');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function cities_index($country_id){
        if(!is_admin()){
            access_denied();
        }
        if($this->input->is_ajax_request()){
            $this->locationapp->get_table_data('cities_table', ['country_id' => $country_id]);
        }
        $data['title'] = 'Locations';
        $data['country_id'] = $country_id;
        $this->load->view('admin/cities/cities_manage', $data);
    }

    public function edit_city(){
        if (!is_admin()) {
            access_denied();
        }

        if ($this->input->is_ajax_request()) {
            $data = $this->input->post();
            if ($data['Id'] == '') {
                $id      = $this->Cities_model->add($data);
                $message = $id ? "City added successfully" : 'There is a problem in contacting the server';
                echo json_encode([
                    'success' => $id ? true : false,
                    'message' => $message,
                    'id'      => $id,
                    'name'    => $data['Name_en'],
                ]);
            } else {
                $success = $this->Cities_model->update($data, $data['Id']);
                $message = '';
                if ($success == true) {
                    $message = "City updated successfully";
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
        }
    }

    public function delete_City($id){
        if (!$id) {
            redirect(admin_url('location_module/L_Locations/edit_city'));
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Cities_model->delete($id);
        if ($response == true) {
            set_alert('success', 'Deleted city');
        } else {
            set_alert('warning', 'Problem deleting city');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}