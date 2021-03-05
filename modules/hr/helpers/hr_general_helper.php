<?php

function is_active_sub_department(){
	$CI = get_instance();
	$CI->db->where('name', 'sub_department');
	$CI->db->from(db_prefix() . 'hr_setting');
	$sub_department = $CI->db->get()->row();
	if($sub_department->active == 1)
		return true;
	return false;
}

function does_url_exists($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}