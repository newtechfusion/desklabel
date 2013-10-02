<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_Controller extends LIST_All {
		
	public function getTemplate($data=NULL)
	{
	 $this->basics->output(array('header',$this->location.$this->view,'footer'),$data);
	}
	
	
	
	public function content($object)
	{
	foreach($object as $k=>$value){
			$content[]=$value['city'];
			
			}
			
		return $content;	
	}
	public function htmlview($data)
	{
		return $this->load->view($this->location.$this->view,$data,true);
	}
	public function ajax_request()
	{
		
		if($this->input->post('ajax', FALSE))
		{
			call_user_func_array(array($this,$this->input->post('name')), array($this->input->post('value')));
		}	
		
	}
	
	public function google_data($limit=NULL,$initial=FALSE,$inarray=NULL)
	{ 
	
		$cleantext=str_replace('-',' ',segment(2));
		$where=(empty($inarray))?array('LTRIM(RTRIM(city))'=>$cleantext):NULL;
		return $this->http->select('google_data',$where,
		array('id','city','address','name','keyword','phone'),
 		$limit,"name",FALSE,$this->getkeyword('keyword'),$inarray
		);
	}
	
	public function getcity($limit=NULL)
	{ 
		$limit=(!empty($limit))?$limit:NULL;
		return $this->http->select('google_data',array('state'=>_stateToShort(clean(segment()))),array('city'),$limit,"city",TRUE,
		$this->getkeyword('keyword'));
	}	
	
	public function getallcity($limit=NULL)
	{ 
		$limit=(!empty($limit))?$limit:NULL;
		return $this->http->select('google_data',NULL,array('city'),$limit,"city",TRUE,
		$this->getkeyword('keyword'));
	}	
	function county($state, $county) {
		$clean=trim(str_replace(array('-county','-'),' ',$county));
		$this->breadcrumb[]=array('href'=>base_url().segment().'/'.implode('-',abbr(FALSE)),'text'=>ucwords(segment().' '.implode(' ',abbr(FALSE))));
		$this->breadcrumb[]=array('text'=>ucwords(str_replace('-',' ',segment(2)).' '._stateToShort(segment()).','.implode(' ',abbr(FALSE))));
		$this->geo->county_info($state,$clean);
		$this->map->county();
		$this->query->county_stats();
		$this->copy->county_page();
		foreach($this->query->cities_in_county() as $cities):
				$this->allcontent[]=$cities->city_name;
		endforeach;
		$data['nearconunties']=$this->query->nearby_counties();
		$data['allcity']=$this->content($this->getallcity());
		$this->data=$data;
	}
	
	
	function state_counties($state, $city=FALSE) {
		/*$this->geo->state_info($state);
		$this->map->state();
		$this->query->state_stats();
		$this->copy->state_page();
		if($city) $this->data=$this->query->cities_in_state() ;
		return $this->copy->county_link_pack($this->query->counties_in_state());*/	
		//$this->data->schools = $this->copy->school_link_pack($this->query->schools_in_state());
		
		/* echo '<pre>';print_r($this->geo->Geoselect('cities',array('a1.code'=>_stateToShort($state)),
		array('county.name','county.slug as county_slug','a1.code','a1.slug','admin2s_cities.admin2_id','cities.name as city_name'),
 		FALSE,FALSE,TRUE,FALSE,
		array('cities.name'=>$this->content($this->getcity()),
		)));die;*/
		return $this->geo->Geoselect('cities',array('a1.code'=>_stateToShort($state)),
		array('county.name','county.slug as county_slug','a1.code','a1.slug','admin2s_cities.admin2_id','cities.name as city_name'),
 		FALSE,FALSE,TRUE,FALSE,
		array('cities.name'=>$this->content($this->getcity()),
		));
	
		
	}
	function nearby_city($state,$city,$modifier=NULL) {
		$this->domain->set_modifier($modifier);
		$this->geo->city_info($state, $city);
		$this->map->city();
		$this->query->city_stats();
		$this->copy->city_page();
		return $this->query->nearby_cities();
		
	}
}
