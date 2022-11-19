<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Countries extends AdminController {

    public function build_dropdown_cities() {

        $this->load->model('countries_model');
        $cities = $this->countries_model->get_cities_by_countryId($this->input->post('country'));
        $output = '<option value=""></option>';
        $select=$this->input->post('selected');
        foreach ($cities as $row)
        {
            if($row->Id==$select)$selected="selected";else $selected="";
            $staff_language = get_staff_default_language(get_staff_user_id());
           // $staff_language = get_option('active_language');
            if($staff_language == 'arabic'){
                $output .= '<option value="'.$row->Name_ar.'" '.$selected.' >'.$row->Name_ar.'</option>';
            }else{
                $output .= '<option value="'.$row->Name_en.'" '.$selected.' >'.$row->Name_en.'</option>';
            }
        }
        echo $output;
    }

}