<?php

class Webhook extends ClientsController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $staffs = $this->db->get(db_prefix() . 'staff')->result_array();
        $notifiedUsers  = [];
        foreach ($staffs as $member) {
            $notified = add_notification([
                'fromcompany'     => true,
                'touserid'        => $member['staffid'],
                'description'     => $this->input->get('phone') . '<br />' .$this->input->get('message'),
                'link'            => 'babil_sms_gateway/',
            ]);
            if ($notified) {
                array_push($notifiedUsers, $member['staffid']);
            }
        }

        pusher_trigger_notification($notifiedUsers);
    }
}
