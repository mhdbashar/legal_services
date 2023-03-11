<?php

defined('BASEPATH') or exit('No direct script access allowed');

class  Countries_model  extends App_Model{

    public function __construct()
    {
        parent::__construct();
    }

    // public function get_all(){
    //     return $this->db->order_by('Country_name_ar','asc')->where('Country_name_ar !=',"")->get('countries')->result();
    // }

    // public function get_by_countryName($country_name){
    //     return $this->db->where('country_name_en',$country_name)->get('babilcountries')->row();
    // }

    // public function get_by_countryId($country_id){
    //     return $this->db->where('Id',$country_id)->get('babilcountries')->row();
    // }
    public function get_all_cities(){
        return $this->db->get('cities')->result();
    }
    public function get_cities_by_countryId($country_id){
        return $this->db->where('Country_id',$country_id)->get('cities')->result();
    }
}