<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class CheckActivation_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

     }

     public function Check_Product($BaseUserURL,$PurchaseCode,$SecretKey)
     {

       
       
     

        $this->db->select('count(*) as Total');
        $this->db->where('domain_name', $BaseUserURL);
        $this->db->where('envato_key', $PurchaseCode);
        $this->db->where('active_key', $SecretKey);

        $q = $this->db->get('tbl_LicenceKey');
               
        $data = $q->row();
        if($data->Total==0){
                 return 0;
        }else{
                return 1;
        }
        
     }

}