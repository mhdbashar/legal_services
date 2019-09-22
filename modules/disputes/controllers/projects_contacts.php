<?php

defined('BASEPATH') or exit('No direct script access allowed');

class projects_contacts extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Project_contacts');
    }

    public function printall($project_id=0)
    {
        $options = explode(",",_l('project_contacts_types'));
        $fetch_data = $this->Project_contacts->get_all($project_id);
        $text = '';
        foreach ($fetch_data as $row) {
            $text .= '      <div class="contact_item">
                            <div class="form-group col-md-12">
                                <label class="control-label col-md-12">'.$options[$row->contact_type].': '.$row->contact_name.' <a class="delete_contact" rel="'.$row->id.'" href="#" style="position: absolute; right: 5px;"><i class="fa fa-remove"></i></a></label>
                                <div class="col-md-6">'.$row->contact_address.'</div>
                                <div class="col-md-3">'.$row->contact_email.'</div>
                                <div class="col-md-3">'.$row->contact_phone.'</div>
                                
                            </div>
                        </div>';
        }
        echo $text;
    }

	public function add($id='')
    {    		
        if ($this->input->post()) {

            $data = $this->input->post();  

            if(!$data['project_id']){
                return false;
            }

            if (!$id){
                    
                $added = $this->Project_contacts->add_new($data);
                if ($added) {
                    //set_alert('success', _l('added_successfully'), _l('disputes'));
                    //redirect(admin_url('disputes/statuses'));
                }else{
                    return false;
                }

            }else{

                $data = $this->input->post();                              
                $success = $this->Project_contacts->update($id,$data);
                if ($success) {
                    //set_alert('success', _l('updated_successfully', _l('disputes')));
                    //redirect(admin_url('disputes/statuses'));                
                }else{
                    //set_alert('warning', _l('problem_updating', _l('disputes')));
                    return false;
                }

            }
        }
        $this->printall($data['project_id']);
    }


	public function delete($id)
    {    	     

        $data = $this->input->post();  
        if (!isset($data['project_id'])) {
            return false;
        }
        $response = $this->Project_contacts->delete($id);
        if ($response == true) {
            //set_alert('success', _l('deleted', _l('disputes')));
        } else {
            //set_alert('warning', _l('problem_deleting', _l('disputes')));
            return false;
        }
        $this->printall($data['project_id']);
        //return json_encode($this->Project_contacts->get_all($project_id));
        //redirect(admin_url('disputes/statuses'));
    }
	
}
