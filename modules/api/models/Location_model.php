<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Location_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

    }

  public function insertlocation($data)
  {
      if($data){
    $this->db->insert('tbllocation',$data);
    return 1;        
      }
      return 0;
  }

  public function getAllData($filter)
  {
    if($filter['staffid']!=0){
        $this->db->select('*')->from('tbllocation');
        $this->db->where('f_staffid',$filter['staffid']);
      $this->db->like('Currentdate', $filter['searchbydate']);
        $this->db->order_by('Currentdate','asc');
        return $this->db->get()->result();
    }

  }

}