<?php

/**
 *  
 */
class Award extends AdminController
{
    
    function index(){
        $_POST['fullname'] = "Ahmad Zaher";
        $_POST['username'] = "ahmadzaher";
        $_POST['password'] = "12345ahmad";
        $_POST['email'] = "ahmadkhrezaty@gmail.com";
        $_POST['locale'] = "Syria";
        $_POST['language'] = "English";
        $_POST['phone'] = "5319932";
        $_POST['mobile'] = "0944543666";
        $_POST['role_id'] = "admin";
        $_POST['direction'] = "LTR";
        var_dump($this->input->post());
    }
}