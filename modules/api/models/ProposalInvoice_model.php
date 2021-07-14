<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class ProposalInvoice_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

     }

     public function get_proposalinvoice($staff_id,$type,$invoiceid,$ispaid)
     {
     	# code...
     	if($staff_id!='' && $type!=''){
     		if($type=='proposals'){
     		 $this->db->select('*')
                   ->from('tblproposals');
            // $this->db->where('assigned', $staff_id);

     		}if($type=='invoices'){
                if($invoiceid==''){
				 $this->db->select('*')
                         ->from('tblinvoices');
            // $this->db->where('addedfrom', $staff_id);  			
        }else{
                 $this->db->select('*')
                         ->from('tblinvoices');
            $this->db->where('addedfrom', $staff_id);           
            $this->db->where('id', $invoiceid);           

        }
     		}if($type=='payment'){
                if($invoiceid==''){

                $this->db->select('tblinvoicepaymentrecords.*')->from('tblinvoicepaymentrecords');    
            
$this->db->join('tblinvoices', 'tblinvoices.id = tblinvoicepaymentrecords.invoiceid AND tblinvoices.addedfrom='. $staff_id, 'inner');
$this->db->order_by('tblinvoicepaymentrecords.id','asc');

                
            }else{
 if($ispaid=='True'){
                    $this->db->where('invoiceid',$invoiceid);                    
                    $this->db->select('*')->from('tblinvoicepaymentrecords');
                  }else{
                $this->db->where('rel_id',$invoiceid);
                $this->db->where('rel_type','invoice');
                $this->db->select('*')->from('tblitemable');
                 }
            }

            }
     	}
     	 return $this->db->get()->result();

     }


public function get_TotalAmount($id)
{
   $this->db->where('id', $id);
         $q = $this->db->get('tblinvoices');
         $data = $q->row();
         return $data->total;
}
public function get_paymentinvoice($id='')
{
    # code...
   
    
    $this->db->where('invoiceid',$id);
    
   
      
      
         $this->db->select_sum('amount');
$result = $this->db->get('tblinvoicepaymentrecords')->row();  
return $result->amount;
}
     public function get_currency_name($id)
     { 
         $this->db->where('id', $id);
         $q = $this->db->get('tblcurrencies');
         $data = $q->row();
         return $data->name;
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

     public function get_Company_name($id)
     {
        $this->db->where('userid',$id);
         $qq=$this->db->get('tblclients');
         $data1=$qq->row();
         return $data1->company;
     }
      public function get_paymentmode_name($id)
     { 
         $this->db->where('id', $id);
         $q = $this->db->get('tblpayment_modes');
         $data = $q->row();
         return $data->name;
     }
}