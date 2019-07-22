<?php

class Language extends AdminController
{

	public $fileName;

	public function __construct(){
		parent::__construct();
	}
	public function index($language = 'english', $offset = 0){

		$file = FCPATH . 'application/language/' . $language .'/custom_lang.php';

		if(!file_exists($file)){
			require FCPATH . 'application/language/' . $language . '/' . $language . '_lang.php';
			$a = $this->getArr($lang);
			$handle = fopen($file, 'w+');
			fwrite($handle, $a);
		}

		require $file;

		if(!isset($lang)){
			$lang = array('test' => "test");
		}

		if (!empty($this->input->get('value')) and !empty($this->input->get('key'))){

			$handle = fopen($file, 'w+');

			$key = $this->input->get('key'); $value = $this->input->get('value');
			$lang[$key] = $value;

			$a = $this->getArr($lang);
			fwrite($handle,  $a);
			
			fclose($handle);
		}
    	
    	$data['lang'] = $lang ;
    	$data['language'] = $language;

    	// Pagination
    	$data['per_page'] = 200;
    	$data['offset'] = $offset + 1;
    	$data['start'] = $offset + $data['per_page'];
    	$this->session->set_flashdata(['offset' => $offset]);
    	$data['title'] = "Label Management";

    	$this->load->view('language', $data);
	}

	public function delete($key, $language = 'english'){
		$file = FCPATH . 'application/language/' . $language .'/custom_lang.php';
    	require $file;
		unset($lang[$key]);

		$a = $this->getArr($lang);

		$handle = fopen($file, 'w+');
		fwrite($handle,  $a);
		fclose($handle);

		$offset = $this->session->flashdata('offset');
		redirect('label_management/Language/index/' . $language . '/' . $offset);
	}
	public function getArr($lang){
	    $str = '<?php';
	   foreach($lang as $key => $value){

	       $str .= "\n$" . "lang['" . $key . "']" . ' = "' . str_replace('"', '\"', $value) . '";';
	   }
	   return $str;
	}



}