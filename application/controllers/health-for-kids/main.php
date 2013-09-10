<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	public $content='';
	public $breadcrumb=array();
	function __construct(){
		parent::__construct();
		
		
	}

	function home(){
		$this->copy->home_page();
		//$this->copy->link_packs['browse_'.make_slug($this->domain->modifier).'_by_state'] = $this->copy->state_link_pack($this->query->states());
		$this->basics->output(array('header','home','footer'));
	}
	
	

    function contact() {
		/*$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('email','Email','required|trim|valid_email');
		$this->form_validation->set_rules('comment','Comment','required');  */
		$this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
      if($this->input->post()) :
	 
			$this->load->library('email');
			$this->email->from($this->input->post('email'));
			$this->email->to('support@health-for-kids.com');
			$this->email->subject('Helath For Kids');
			$this->email->message('Name:'.$this->input->post('name').'Message:'.$this->input->post('message'));
			$this->email->send();
			$this->content="Your Messsage has been Recived";
{
    // Generate error
}
			
	endif;
		$this->basics->output(array('header','static/contact','footer'));
	}

    function bmi(){
		$this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
        //$this->copy->bmi();
        //$this->copy->link_packs['browse_'.make_slug($this->domain->modifier).'_by_state'] = $this->copy->state_link_pack($this->query->states());
        $this->basics->output(array('header','static/bmi','footer'));
    }

	// to manage error	
	function error($type=404, $message="Page Not Found"){
		$this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
		$this->basics->show_error($type, $message);
	}
		
	function healthyathome(){
		$this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/healthyathome','footer'));	
		}
		
	function healthydaycare(){
		$this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/parents/healthydaycare','footer'));	
		}
		
	function mealforfamily(){
		$this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/parents/mealforfamily','footer'));	
		}
		
	function nutrition(){
			 $this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/parents/nutrition','footer'));	
		}
		
	function nutritiontrap(){
		    $this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			$this->basics->output(array('header','static/parents/nutritiontrap','footer'));	
		}
		
	function rainyday(){
		     $this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/parents/rainyday','footer'));	
		}
		
					
//teachers	
		
	function obesityfactor(){
			 $this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/teachers/obesityfactor','footer'));
		}
		
	function playground(){
			 $this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/teachers/playground','footer'));	
		}
		
	function resource(){
			 $this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/teachers/resource','footer'));	
		}
		
	
		
	function teaching_habits(){
			$this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/teachers/teaching-habits','footer'));	
		}					
//kids 	
		
	function birthdayparty(){
			$this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/kids/birthdayparty','footer'));	
		}
		
	function share_tips(){
			 $this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/kids/share-tips','footer'));	
		}
		
	function summer(){
			 $this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment())));
			 $this->basics->output(array('header','static/kids/summer','footer'));	
		}			
		
}
