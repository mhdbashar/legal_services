<?php

function is_active_sub_department(){
	$CI = get_instance();
	$CI->db->where('name', 'sub_department');
	$CI->db->from('tblhr_setting');
	$sub_department = $CI->db->get()->row();
	if($sub_department->active == 1)
		return true;
	return false;
}