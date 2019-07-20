<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Hr extends App_Model
{
    public function getGenderList()
    {
        return array('name'=>'male','name'=>'female');
    }
}

?>
