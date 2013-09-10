<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	
	function home(){
		$this->copy->home_page();
		$this->copy->link_packs['browse_'.make_slug($this->domain->modifier).'_by_state'] = $this->copy->state_link_pack($this->query->states());
		$this->basics->output(array('header','home','footer'),$this->data);
	}
	
	function modifier($modifier=NULL) {
		$this->domain->set_modifier($modifier);
		$this->copy->modifier_page();
		$this->query->modifier_stats();
		$this->copy->link_packs['browse_'.make_slug($this->domain->modifier).'_by_state'] = $this->copy->state_link_pack($this->query->states());
		// die('<pre>'.print_r($this->domain, TRUE).print_r($this->data, TRUE).print_r($this->geo, TRUE).print_r($this->copy, TRUE).print_r($this->db, TRUE));
		$this->basics->output(array('header','national','footer'));
	}
	
	function state($state, $modifier=NULL) {
		
		$this->domain->set_modifier($modifier);
		$this->geo->state_info($state);
		$this->map->state();
		$this->query->state_stats();
		$this->copy->state_page();
		$this->copy->link_packs['counties_in_'.make_slug($this->copy->location_full,'_')] = $this->copy->county_link_pack($this->query->counties_in_state());
		$this->copy->link_packs['cities_in_'.make_slug($this->copy->location_full,'_')] = $this->copy->city_link_pack($this->query->cities_in_state());
		$this->data->schools = $this->copy->school_link_pack($this->query->schools_in_state());
		
		// die('<pre>'.print_r($this->domain, TRUE).print_r($this->data, TRUE).print_r($this->geo, TRUE).print_r($this->copy, TRUE).print_r($this->db, TRUE));
		$this->basics->output(array('header','geo','footer'));
	}
	
	function county($state, $county, $modifier=NULL) {
		
		$this->domain->set_modifier($modifier);
		$this->geo->county_info($state, $county);
		$this->map->county();
		$this->query->county_stats();
		$this->copy->county_page();
		$this->copy->link_packs['cities_in_'.make_slug($this->copy->location_full,'_')] = $this->copy->city_link_pack($this->query->cities_in_county());
		$this->copy->link_packs['nearby_counties'] = $this->copy->county_link_pack($this->query->nearby_counties());
		$this->data->schools = $this->copy->school_link_pack($this->query->schools_in_county());
		// die('<pre>'.print_r($this->domain, TRUE).print_r($this->geo, TRUE).print_r($this->copy, TRUE));
		$this->basics->output(array('header','geo','footer'));
	}
	
	function city($state, $city, $modifier=NULL) {
		$this->domain->set_modifier($modifier);
		$this->geo->city_info($state, $city);
		$this->map->city();
		$this->query->city_stats();
		$this->copy->city_page();
		
		$this->copy->link_packs['nearby_cities'] = $this->copy->city_link_pack($this->query->nearby_cities());
		$this->data->schools = $this->copy->school_link_pack($this->query->schools_in_city());
		// die('<pre>'.print_r($this->domain, TRUE).print_r($this->geo, TRUE).print_r($this->copy, TRUE));
		$this->basics->output(array('header','geo','footer'));
	}
	
	function school($state, $city, $school, $id){
		$this->query->school_info($state, $city, $school, $id);
		$this->map->school();
		$this->copy->school_page();
		$this->data->schools = $this->copy->school_link_pack($this->query->nearby_schools());
		// die('<pre>'.print_r($this->data, TRUE).print_r($this->domain, TRUE).print_r($this->geo, TRUE).print_r($this->copy, TRUE).print_r($this->db, TRUE));
		$this->basics->output(array('header','school','footer'));
	}
	
    function contact() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name',		'Name',				'required');
		$this->form_validation->set_rules('email',		'Email',			'required|trim|valid_email');
		$this->form_validation->set_rules('comment',	'Comment',			'required');
        $this->copy->title			= "Contact Grade-Schools.com";
        $this->copy->desc			= "Contact Grade-Schools.com";
        $this->copy->h1				= "Contact Us";
        $this->copy->breadcrumbs	= array('text'=>'Contact');
		if($this->form_validation->run()) :
			$_POST['date']	= date("Y-m-d H:i:s");
			$_POST['ip']	= $_SERVER['REMOTE_ADDR'];
			$this->load->model('email');
			$this->email->basic('mcapps@starnine.com', 'Comment Added Grade-Schools.com '.time(), print_r($_POST, TRUE), clean_word($_POST['email']));
	        $this->data->success = 'Your comment has been received.';
		endif;
		$this->basics->output(array('header','static/contact','footer'));
	}

	// to manage error	
	function error($type=404, $message="Page Not Found"){
		$this->basics->show_error($type, $message);
	}
	
	function test(){
				//for  testing purpose 
		}
}
