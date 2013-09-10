<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LIST_All extends CI_Controller {
	
	public  $view='state';
	public  $location='dynamic/';
	public  $per_page=10;
	public  $next_page=10;
	public $county=FALSE;
	public $allcontent=array();
	public $breadcurmbs=array();
	var    $map;
    function __construct()
    {
        parent::__construct();
		
    }
	
	function paginate($totalrows,$base_url=FALSE){
		 $base_url = ($base_url) ?$base_url:$_SERVER['REQUEST_URI'];
		 $this->load->library('pagination');
		 $config = array();
		 $config['base_url'] =$base_url;
		 $config['total_rows'] =$totalrows;
		 $config['per_page'] =$this->per_page;
		
		  $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test">'; // for jQuery
		  $config['full_tag_close'] = '</ul></div>';
		  $config['first_link'] = '&laquo; First';
		  $config['first_tag_open'] = '<li class="prev page">';
		  $config['first_tag_close'] = '</li>';
		
		  $config['last_link'] = 'Last &raquo;';
		  $config['last_tag_open'] = '<li class="next page">';
		  $config['last_tag_close'] = '</li>';
		
		  $config['next_link'] = 'Next &rarr;';
		  $config['next_tag_open'] = '<li class="next page">';
		  $config['next_tag_close'] = '</li>';
		
		  $config['prev_link'] = '&larr; Previous';
		  $config['prev_tag_open'] = '<li class="prev page">';
		  $config['prev_tag_close'] = '</li>';
		
		  $config['cur_tag_open'] = '<li class="active"><a href="">';
		  $config['cur_tag_close'] = '</a></li>';
		
		  $config['num_tag_open'] = '<li class="page">';
		  $config['num_tag_close'] = '</li>';
		  //Initialize all setting
		  $this->pagination->initialize($config);
		
		}
	
	
}