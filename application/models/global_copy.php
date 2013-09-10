<?php
class Global_copy extends CI_Model  {

	function __construct(){
		parent::__construct();
	}
	
	// GEO PAGES
	function state_page($state_data){
		$location_full = $state_data->state_full;
		$return = $this->copy->_meta_copy($location_full);
		$return['location_full'] = $location_full;
		$return['full_base_url'] = base_url().make_slug($state_data->state_full);
		$return['breadcrumbs'][] = $location_full;
		return $return;
	}
	
	function county_page($county_data){
		$location_full = $county_data->county_name.' County, '.$county_data->state_abbr;
		$return = $this->copy->_meta_copy($location_full);
		$return['location_full'] = $location_full;
		$return['full_base_url'] = base_url().make_slug($county_data->state_full).'/'.make_slug($county_data->county_name).'-county';
		$return['breadcrumbs'][] = array_merge($this->copy->_link_copy($county_data->state_full), array('href' => base_url().make_slug($county_data->state_full)));
		$return['breadcrumbs'][] = $location_full;
		return $return;
	}
	
	function city_page($city_data){
		$location_full = $city_data->city_name.', '.$city_data->state_abbr;
		$return = $this->copy->_meta_copy($location_full);
		$return['location_full'] = $location_full;
		$return['full_base_url'] = base_url().make_slug($city_data->state_full).'/'.make_slug($city_data->city_name);
		$return['breadcrumbs'][] = array_merge($this->copy->_link_copy($city_data->state_full), array('href' => base_url().make_slug($city_data->state_full)));
		$return['breadcrumbs'][] = array_merge($this->copy->_link_copy($city_data->county_name.' County, '.$city_data->state_full), array('href' => base_url().make_slug($city_data->state_full).'/'.make_slug($city_data->county_name).'-county'));
		$return['breadcrumbs'][] = $location_full;
		return $return;
	}
	
	function zip_page($zip_data){
		$location_full = $zip_data->state_abbr.' '.$zip_data->zip_code;
		$return = $this->copy->_meta_copy($location_full);
		$return['location_full'] = $location_full;
		$return['full_base_url'] = base_url().make_slug($zip_data->state_full).'/'.make_slug($zip_data->zip_code);
		$return['breadcrumbs'][] = array_merge($this->copy->_link_copy($zip_data->state_full), array('href' => base_url().make_slug($zip_data->state_full)));
		$return['breadcrumbs'][] = array_merge($this->copy->_link_copy($zip_data->county_name.' County, '.$zip_data->state_full), array('href' => base_url().make_slug($zip_data->state_full).'/'.make_slug($zip_data->county_name).'-county'));
		$return['breadcrumbs'][] = array_merge($this->copy->_link_copy($zip_data->city_name.', '.$zip_data->state_full), array('href' => base_url().make_slug($zip_data->state_full).'/'.make_slug($zip_data->city_name)));
		$return['breadcrumbs'][] = $location_full;
		return $return;
	}
	
	// LINK PACKS
	function state_link_pack($states){
		$return = array();
		foreach($states as $state_num => $state) :
			$return[$state_num] = $this->copy->_link_copy($state->state_full);
			$return[$state_num]['href'] = base_url().make_slug($state->state_full);
		endforeach;
		return $return;
	}
	function county_link_pack($counties){
		$return = array();
		foreach($counties as $county_num => $county) :
			$return[$county_num] = $this->copy->_link_copy($county->county_name.' County, '.$county->state_abbr);
			$return[$county_num]['href'] = base_url().make_slug($county->state_full).'/'.make_slug($county->county_name).'-county';
		endforeach;
		return $return;
	}
	
	function city_link_pack($cities){
		$return = array();
		foreach($cities as $city_num => $city) :
			$return[$city_num] = $this->copy->_link_copy($city->city_name.', '.$city->state_abbr);
			$return[$city_num]['href'] = base_url().make_slug($city->state_full).'/'.make_slug($city->city_name);
		endforeach;
		return $return;
	}
	
	function zip_link_pack($zips){
		$return = array();
		foreach($zips as $zip_num => $zip) :
			// die('<pre>'.print_r($zip));
			$return[$zip_num] = $this->copy->_link_copy($zip->city_name.', '.$zip->state_abbr.' '.$zip->zip_code);
			$return[$zip_num]['href'] = base_url().make_slug($zip->state_full).'/'.make_slug($zip->zip_code);
		endforeach;
		return $return;
	}
}
?>