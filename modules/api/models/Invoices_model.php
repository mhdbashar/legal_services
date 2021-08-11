<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Invoices_model extends App_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get client object based on passed clientid if not passed clientid return array of all clients
     * @param  mixed $id    client id
     * @param  array  $where
     * @return mixed
     */
    public function get($email) {
        $sql1 = 'select userid from tblcontacts where email ="' . $email . '" ';
        $query1 = $this->db->query($sql1);
        $result1 = $query1->row();
        if ($result1) {
            $sql2 = 'select userid from tblclients   where userid="' . $result1->userid . '"';
            $query2 = $this->db->query($sql2);
            $result2 = $query2->row();
        }

        if ($result2) {
            $sql3 = "select * from tblinvoices where clientid='" . $result2->userid . "' and  rel_stype= 'imported' and status=2  ";

            $query3 = $this->db->query($sql3);
            $result3 = $query3->result_array();
            if ($result3) {
                return $result3;
            } else {
                return 'No Data Found';
            }
        }
//$sq = "select a.userid,b.userid,b.email,c.clientid,c.* from  tblclients a, tblcontacts b, tblinvoices c where a.userid=b.userid and a.userid = c.clientid  and c.rel_stype= 'imported' and status=2 and b.email='" . $email . "' ";
    }

}
