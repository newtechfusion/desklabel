<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlist extends Main_Controller {
	 function __construct()
    {
        parent::__construct();	
		$this->data=new stdClass();	
				
	}
	
	function getkeyword($feild)
	{
		foreach(abbr(FALSE) as $bbr):
		$abbrs[]=array($feild=>$bbr);
		endforeach;
		return $abbrs ;
	}	
		

    function index()
    {
		$this->breadcrumb[]=array('text'=>ucwords(implode(' ',abbr(FALSE))));
		$this->getTemplate(); 
	
    }
	
	
	function city()
	{
		$this->next_page=$this->per_page;
		$this->view='city';
		$this->breadcrumb[]=array('href'=>base_url().implode('-',abbr(FALSE)),'text'=>ucwords(implode(' ',abbr(FALSE))));
		$this->breadcrumb[]=array('text'=>ucwords(segment().' '.implode(' ',abbr(FALSE))));
		if($this->input->post('ajax',FALSE))
		{
			$param=FALSE;
			$value=$this->input->post('value');
			$this->next_page=array($value,$this->per_page);
		}
		$cities = $this->getcity($this->next_page);
		$data   = array('cities'=>$cities,'items'=>count($this->getcity()));
		if($this->input->post('ajax', FALSE))
		{	$this->view='citypagination';
			 echo json_encode(array(
			   'results' =>$this->htmlview($data),
			));
		    die();
		}
		
		   
		$this->getTemplate($data);
	}
	
	/*function geo()
	{
		
		$data=$this->http->select('google_data',array('city'=>strtoupper(abbr())),array('city','address','name','keyword','phone'),NULL,
		"city",FALSE,$this->getkeyword('keyword')); 
		$map['map']=$this->map($data);
		$this->getTemplate($data);			   
	} */
	function citiesincounty()
	{
		$this->view='county';
		$this->next_page=$this->per_page;
		$param=TRUE;
		$this->county(segment(),segment(2));
		if($this->input->post('ajax', FALSE))
		{
			$param=FALSE;
			$this->next_page=$this->input->post('value');	
		}
		
		$gdata=$this->google_data($this->next_page,$param,array('city'=>$this->allcontent));
		$data=array('data'=>$gdata,'partition'=>round(count($gdata)/2),'items'=>count($this->google_data()));
		if($this->input->post('ajax',FALSE))
		{
			$this->view ='pagination';
			   echo json_encode(array(
			   'results' =>$this->htmlview($data)
			  ));
		 die();
		}
		
		
		$this->getTemplate();
	}	
	
	function geo($arg=NULL)
	{
		$this->view='community';
		$this->next_page=0;
		//$param=TRUE;
		$this->breadcrumb[]=array('href'=>segment().'/'.implode('-',abbr(FALSE)),'text'=>ucwords(segment().' '.implode(' ',abbr(FALSE))));
		$this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment(2)).' '.upc(_stateToShort(segment())).', '.implode(' ',abbr(FALSE))));
		if($this->input->post('ajax', FALSE)) $this->next_page=$this->input->post('value');
		$gdata=$this->google_data(array($this->next_page,$this->per_page));
		$data=array('data'=>$gdata,'partition'=>round(count($gdata)/2)
		,'nearcitypack'=>$this->nearby_city(segment(),str_replace('-',' ',segment(2))),
		'counties'=>$this->state_counties(segment()),
		'allcity'=>$this->content($this->getcity()),
		'items'=>count($this->google_data()));
		if($this->input->post('ajax',FALSE) )
		{
			$this->view ='pagination';
			   echo json_encode(array(
			   'results' =>$this->htmlview($data)
			  ));
		 die();
		}
		$this->getTemplate($data);
					
	}
	
	function detail(){
		
		
		$this->view='detail';
		$this->allcontent=$this->http->select('google_data',
		array('id'=>$this->uri->segment(5)),
		array('city','state','zipcode','address','name','keyword','phone'),
 		1,NULL,FALSE,NULL
		);
		$content=$this->allcontent[0];
        $this->breadcrumb[]=array('href'=>base_url().segment().'/'.segment(3),'text'=>ucwords(segment().' '.$content['keyword']));
		$this->breadcrumb[]=array('href'=>base_url().segment().'/'.$content['city'].'/'.segment(3),
		'text'=>$content['city'].' '.ucwords(upc(_stateToShort(segment())).', '.$content['keyword']));
		$this->breadcrumb[]=array('text'=>ucwords($content['name']));
		$this->load->library('googlemaps');
		$this->load->helper('gmap_helper');
		$config=make_map_stylish();
	    $config['map_types_available']=map_types();
		$config['zoom']=7;
		$config['center'] =$this->allcontent[0]['address'];
		$config['map_width']='460px';
		$this->googlemaps->initialize($config);
		$marker=array();
		$marker['position']=$this->allcontent[0]['address'];
		$this->googlemaps->add_marker($marker);
		$data=array('map'=>$this->googlemaps->create_map(),'nearcitypack'=>$this->nearby_city(segment()
		,$this->uri->segment(2)),'counties'=>$this->state_counties(segment()));
		$this->getTemplate($data);
		
	}
	
	
}