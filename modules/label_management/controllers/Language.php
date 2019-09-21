<?php

class Language extends AdminController
{

	public $fileName;

	public function __construct(){
		parent::__construct();
		$this->load->model('Language_model');
	}
	public function index($language = 'english', $custom = 'custom_lang', $offset = 0, $search = ''){


		$file = FCPATH . 'application/language/' . $language .'/'. $custom .'.php';

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

			unset($lang[$key]);

			$new = array_merge([$key => $value], $lang);

			$lang = $new;



			$a = $this->getArr($lang);
			fwrite($handle,  $a);
			
			fclose($handle);
		}

		$filter_lang = [];


		if (!empty($this->input->get('search'))){

			redirect(base_url().'label_management/language/index/'.$language.'/'.$custom.'/0/'.$this->input->get('search'));

		}

		if (!empty($search)){

			$phrese = $search;
			$result = $this->Language_model->search($lang, urldecode($phrese));

			foreach ($result as $key){
				$filter_lang[$key] = $lang[$key];
			}
		}else{
			$filter_lang = $lang;
		}

		$data['custom'] = $custom;
    	$data['lang'] = $filter_lang ;
    	$data['language'] = $language;
    	$data['search'] = $search;

    	// Pagination
    	$data['per_page'] = 20;
    	$data['offset'] = $offset + 1;
    	$data['start'] = $offset + $data['per_page'];
    	$this->session->set_flashdata(['offset' => $offset]);
    	$data['title'] = "Label Management";

    	$this->load->view('language', $data);
	}

	public function delete($key, $language = 'english', $custom){
		$file = FCPATH . 'application/language/' . $language .'/'. $custom .'.php';
    	require $file;
		unset($lang[$key]);

		$a = $this->getArr($lang);

		$handle = fopen($file, 'w+');
		fwrite($handle,  $a);
		fclose($handle);

		$offset = $this->session->flashdata('offset');
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function getArr($lang){
	    $str = '<?php';
	   foreach($lang as $key => $value){

	       $str .= "\n$" . "lang['" . $key . "']" . ' = "' . str_replace('"', '\"', $value) . '";';
	   }
	   return $str;
	}



}