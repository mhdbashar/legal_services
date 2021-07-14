<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Invoiceitem_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

     }


    


  public function get_proposalinvoice($invoiceid)
     {
      # code...
     $this->db->where('rel_id',$invoiceid);
                $this->db->where('rel_type','invoice');
                $this->db->select('*')->from('tblitemable');
                    // $this->db->where('invoiceid',$invoiceid);                    
                    // $this->db->select('*')->from('tblinvoicepaymentrecords');
                
      
       return $this->db->get()->result();

     }
       public function get_Invoice_name($id)
     { 
         $this->db->where('id', $id);
         $q = $this->db->get('tblinvoices');
         $data = $q->row();
         
         $this->db->where('userid',$data->clientid);
         $qq=$this->db->get('tblclients');
         $data1=$qq->row();
         return $data1->company;
     }

     public function get_Invoice_paidamount($id)
     {
 $this->db->select('id,invoiceid,amount')->from('tblinvoicepaymentrecords');
        $this->db->where('invoiceid',$id);
    
            return $this->db->get()->result();

     }

    
}