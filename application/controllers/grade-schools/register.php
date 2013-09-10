<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	
    function index() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name',				'Name',				'required');
		$this->form_validation->set_rules('email',				'Email',			'required|trim|valid_email');
		$this->form_validation->set_rules('password',			'Password',			'required');
		$this->form_validation->set_rules('password_confirm',	'Password',			'required');
        $this->copy->title			= "Register on Grade-Schools.com";
        $this->copy->desc			= "Grade-Schools is working to compile the most complete set of data on public schools in the US.";
        $this->copy->h1				= "Register Today For Free";
        $this->copy->breadcrumbs	= array('text'=>'Register');
		if($this->form_validation->run()) :
			$insert = array();
			$insert['name']		= clean_word($_POST['name']);
			$insert['email']	= clean_word($_POST['email']);
			$insert['password']	= md5(clean_word($_POST['password']));
			$insert['details']	= json_encode($_POST['you']);
			$this->db->insert('accounts', $insert);
			$this->basics->output(array('header','subscribe/thank_you','footer'));
			return;
		endif;
		$this->basics->output(array('header','subscribe/register','footer'));
	}
}
