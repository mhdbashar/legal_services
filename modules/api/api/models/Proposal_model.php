<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Proposal_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

     
	 }

	  public function get_Proposal($id,$rel_type)

    {
		$this->db->select('id,subject,addedfrom,datecreated,total,subtotal,total_tax,adjustment,discount_percent,discount_total,discount_type,show_quantity_as,currency,open_till,date,rel_id,rel_type,assigned,hash,proposal_to,country,zip,state,city,address,email,phone,allow_comments,status,estimate_id,invoice_id,date_converted,pipeline_order,is_expiry_notified,acceptance_firstname,acceptance_lastname,acceptance_email,acceptance_date,acceptance_ip,signature');
        if($id != '' && $rel_type!='')
        {
             $this->db->where('rel_id', $id);
             $this->db->where('rel_type', $rel_type);
        }
        return $this->db->get(db_prefix() . 'proposals')->result_array();
    }

// 	  public function get_Proposal($id)

//     {
      
//         $q = $this->db->get('tblproposals');

// print_r($q);
// die();
//         return $q->result();

//     }
}