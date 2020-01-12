<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Locks extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/Locks_model', 'locks');
    }

    public function open_locks($ServID, $rel_sid, $rel_stype)
    {
        if ($this->input->post()) {
            $password = $this->input->post();
            $real_password = $this->locks->get_password($rel_sid, $rel_stype);
            if ($password['password'] === $real_password) {
                $opened = $this->locks->unlock($password, $rel_sid, $rel_stype);
                if($opened){
                    set_alert('success', _l('open_lock'));
                    redirect(admin_url("Case/view/$ServID/$rel_sid"));
                }
            }else{
                set_alert('danger', _l('vault_password_user_not_correct'));
                redirect(admin_url('LegalServices/Locks/open_locks/'.$ServID.'/'.$rel_sid.'/'.$rel_stype));
            }
        }
        $data['title'] = _l('services_locks');
        $this->load->view('admin/LegalServices/services_locks/open_locks',$data);
    }

}