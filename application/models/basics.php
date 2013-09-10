<?php
class Basics extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->model(DOMAIN.'/copy', 'copy');
		$this->load->model(DOMAIN.'/query', 'query');
		$this->load->model(DOMAIN.'/'.make_slug(DOMAIN,'_'), 'domain');
	}
	
	function output($views, &$data=NULL){
		$output = "";
		foreach($views as $view) :
			$output .= $this->load->view($view, $data, TRUE);
			$data = '';
		endforeach;
		echo preg_replace('/[\n]+/', "\n", str_replace("\n ", "\n", preg_replace('/[ \t]+/', ' ', $output)));
		if(isset($_GET['db_debug']) && strpos($_SERVER['REMOTE_ADDR'], '192.168.100') === 0) :
			if($_GET['db_debug'] == 'raw') : echo '<pre>'.print_r($this->db, TRUE).'</pre>'; else : $this->output->enable_profiler(TRUE); endif;
		endif;
	}
	
	function show_error($response_code=404, $message="Page Not Found", $log=FALSE){
		if($response_code == 301) :
			$this->session->set_flashdata('warning', $message);
			redirect(base_url(), "Location", 301);
		else :
			$data['title'] = $response_code.' '.$message;
			$data['message'] = $message;
			$this->output->set_status_header($response_code);
			$this->output(array('header', 'error', 'footer'), $data);
		endif;
		die;
	}
	
	function remove_trailing_slash(){
		if(substr($_SERVER['REQUEST_URI'], -1) == '/' && trim($_SERVER['REQUEST_URI'], '/ ')) : 
			redirect(base_url().trim($_SERVER['REQUEST_URI'], '/'), "Location", 301);
		endif;
	}
}

?>