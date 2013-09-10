<?php
class link extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->modifier = FALSE;
		$this->clean_modifier = FALSE;
	}
	
	function modifier(){
		$return = new stdClass();
		$return->href	= rtrim(base_url().make_slug($this->domain->modifier),'/');
		$return->text	= $this->domain->clean_modifier;
		$return->title	= 'Browse '.$this->domain->clean_modifier;
		return $return;
	}
	
	function state($geo_data=NULL){
		$this->modifier = ($geo_data === TRUE) ? $this->domain->default_modifier: $this->domain->modifier;
		$this->clean_modifier = ($geo_data === TRUE) ? $this->domain->default_clean_modifier: $this->domain->clean_modifier;
		$geo_data = isset($geo_data) && $geo_data !== TRUE ? $geo_data : $this->geo->data;
		$return = new stdClass();
		$return->href	= rtrim(base_url().make_slug($geo_data->state_full).'/'.make_slug($this->modifier),'/');
		$return->text	= $geo_data->state_full.' '.$this->clean_modifier;
		$return->title	= 'Browse '.$this->clean_modifier.' in '.$geo_data->state_full;
		// die('<pre>'.print_r($this->domain, TRUE));
		return $return;
	}
	
	function county($geo_data=NULL){
		$this->modifier = ($geo_data === TRUE) ? $this->domain->default_modifier: $this->domain->modifier;
		$this->clean_modifier = ($geo_data === TRUE) ? $this->domain->default_clean_modifier: $this->domain->clean_modifier;
		$geo_data = isset($geo_data) && $geo_data !== TRUE ? $geo_data : $this->geo->data;
		$return = new stdClass();
		$return->href	= rtrim(base_url().make_slug($geo_data->state_full).'/'.make_slug($geo_data->county_name).'-county/'.make_slug($this->modifier),'/');
		$return->text	= $geo_data->county_name.' County, '.$geo_data->state_abbr.' '.$this->clean_modifier;
		$return->title	= 'Browse '.$this->clean_modifier.' in '.$geo_data->county_name.' County, '.$geo_data->state_abbr;
		return $return;
	}
	
	function city($geo_data=NULL){
		$this->modifier = ($geo_data === TRUE) ? $this->domain->default_modifier: $this->domain->modifier;
		$this->clean_modifier = ($geo_data === TRUE) ? $this->domain->default_clean_modifier: $this->domain->clean_modifier;
		$geo_data = isset($geo_data) && $geo_data !== TRUE ? $geo_data : $this->geo->data;
		$return = new stdClass();
		$return->href	= rtrim(base_url().make_slug($geo_data->state_full).'/'.make_slug($geo_data->city_name).'/'.make_slug($this->modifier),'/');
		$return->text	= $geo_data->city_name.', '.$geo_data->state_abbr.' '.$this->clean_modifier;
		$return->title	= 'Browse '.$this->clean_modifier.' in '.$geo_data->city_name.', '.$geo_data->state_abbr;
		return $return;
	}
	
	function zip($geo_data=NULL){
		$this->modifier = ($geo_data === TRUE) ? $this->domain->default_modifier: $this->domain->modifier;
		$this->clean_modifier = ($geo_data === TRUE) ? $this->domain->default_clean_modifier: $this->domain->clean_modifier;
		$geo_data = isset($geo_data) && $geo_data !== TRUE ? $geo_data : $this->geo->data;
		$return = new stdClass();
		$return->href	= rtrim(base_url().make_slug($geo_data->state_full).'/'.make_slug($geo_data->zip_code).'/'.make_slug($this->modifier),'/');
		$return->text	= $geo_data->state_abbr.' '.$geo_data->zip_code.' '.$this->clean_modifier;
		$return->title	= 'Browse '.$this->clean_modifier.' in '.$geo_data->state_abbr.' '.$geo_data->zip_code;
		return $return;
	}
	
	function school($geo_data=NULL){
		$geo_data = isset($geo_data) ? $geo_data : $this->data->school;
		$return = new stdClass();
		$return->href	= base_url().make_slug($geo_data->state_full).'/'.make_slug($geo_data->city_name).'/'.make_slug($geo_data->school_name).'/'.$geo_data->education_agency_id.$geo_data->school_id;
		$return->text	= ucstring($geo_data->school_name);
		$return->title	= htmlentities(ucstring($geo_data->school_name)).' in '.$geo_data->city_name.', '.$geo_data->state_abbr;
		return $return;
	}
}

?>