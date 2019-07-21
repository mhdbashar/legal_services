<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Ahmad helpers
// label_management module 
function getArr($lang){
    $str = '<?php';
   foreach($lang as $key => $value){

       $str .= "\n$" . "lang['" . $key . "']" . ' = "' . str_replace('"', '\"', $value) . '";';
   }
   return $str;
}

