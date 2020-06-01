<?php

class Language_model extends App_Model{


	public function __construct(){
		parent::__construct();
	}

	public function search($array, $str){
	    //This array will hold the indexes of every
	    //element that contains our substring.
	    $indexes = array();
	    foreach($array as $k => $v){
	        //If stristr, add the index to our
	        //$indexes array.
	        if(stristr($v, $str)){
	            $indexes[] = $k;
	        }
	    }
	    return $indexes;
	}
}