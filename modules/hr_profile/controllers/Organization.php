<?php

class Organization extends AdminController{

    public function __construct(){
        parent::__construct();
        $this->load->model('Official_document_model');
        if (!has_permission('hr', '', 'view_own') && !has_permission('hr', '', 'view'))
        access_denied();
}
//documents
public function officail_documents(){
  if($this->input->is_ajax_request()){
    $this->load->library("hr_profile/HrmApp");
      $this->hrmapp->get_table_data('my_official_documents_table');
  }
  $data['title'] = _l('official_documents');
  $this->load->view('organization/officail_documents', $data);
}

public function json_document($id){
  $data = $this->Official_document_model->get($id);
  echo json_encode($data);
}
public function update_document(){
  $data = $this->input->post();
  $id = $this->input->post('id');
  $success = $this->Official_document_model->update($data, $id);
  if($success)
      set_alert('success', _l('updated_successfully'));
  else
      set_alert('warning', 'Problem Updating');
  redirect($_SERVER['HTTP_REFERER']);
}

public function add_document(){
  $data = $this->input->post();
  $success = $this->Official_document_model->add($data);
  if($success)
      set_alert('success', _l('added_successfully'));
  else
      set_alert('warning', 'Problem Creating');
  redirect($_SERVER['HTTP_REFERER']);
}

public function delete_document($id)
{
  if (!$id) {
      redirect($_SERVER['HTTP_REFERER']);
  }
  if (!is_admin()) {
      access_denied();
  }
  $response = $this->Official_document_model->delete($id);
  if ($response == true) {
      set_alert('success', _l('deleted_successfully'));
  } else {
      set_alert('warning', 'Problem deleting');
  }
  redirect($_SERVER['HTTP_REFERER']);
}
//expired_document
public function expired_documents(){

	if(!$this->input->get('group')){
			$_GET['group'] = 'employee';
	}
	$group = $this->input->get('group');

if ($this->input->is_ajax_request()) {
			if($group == 'employee'){
				$this->load->library("hr_profile/HrmApp");
		$this->hrmapp->get_table_data('expired_documents/my_employee_table');
			}elseif($group == 'official'){			
					$this->load->library("hr_profile/HrmApp");
					$this->hrmapp->get_table_data('expired_documents/my_official_table');
			}elseif($group == 'immigration'){
				$this->load->library("hr_profile/HrmApp");
					$this->hrmapp->get_table_data('expired_documents/my_immigration_table');
			}
}
	$data['group'] = $group;
$data['title'] = _l('general');
$this->load->view('expired_documents/manage', $data);
}




}