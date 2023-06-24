<?php

class Immigration extends AdminController{

  public function json_immigration($id){
    $data = $this->Immigration_model->get($id);
    echo json_encode($data);
}
public function update_immigration(){
    if (!has_permission('hr', '', 'edit')) {
        access_denied('hr');
    }
    $data = $this->input->post();
    $data['issue_date'] = to_sql_date($data['issue_date']);
    $data['date_expiry'] = to_sql_date($data['date_expiry']);
    $data['eligible_review_date'] = to_sql_date($data['eligible_review_date']);
    $id = $this->input->post('id');
    $success = $this->Immigration_model->update($data, $id);
    if($success)
        set_alert('success', _l('updated_successfully'));
    else
        set_alert('warning', 'Problem Updating');
    redirect($_SERVER['HTTP_REFERER']);
}

public function add_immigration(){
    if (!has_permission('hr_profile', '', 'create')) {
        access_denied('hr_profile');
    }
    $data = $this->input->post();
    $data['issue_date'] = to_sql_date($data['issue_date']);
    $data['date_expiry'] = to_sql_date($data['date_expiry']);
    $data['eligible_review_date'] = to_sql_date($data['eligible_review_date']);
    $this->load->model("hr_profile/Immigration_model")
    $success = $this->Immigration_model->add($data);
    if($success)
        set_alert('success', _l('added_successfully'));
    else
        set_alert('warning', 'Problem Creating');
    redirect($_SERVER['HTTP_REFERER']);
}

public function delete_immigration($id)
{
    if (!has_permission('hr', '', 'delete')) {
        access_denied('hr');
    }
    if (!$id) {
        redirect($_SERVER['HTTP_REFERER']);
    }
    $response = $this->Immigration_model->delete($id);
    if ($response == true) {
        set_alert('success', _l('deleted_successfully'));
    } else {
        set_alert('warning', 'Problem deleting');
    }
    redirect($_SERVER['HTTP_REFERER']);
}

}