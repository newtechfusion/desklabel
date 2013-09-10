<?php
class Query extends CI_Model  {

	function __construct(){
		parent::__construct();
		$this->state_inner_query	= "INNER JOIN cache_state_counts c ON c.state_id = state.id";
		$this->county_inner_query	= "INNER JOIN cache_county_counts c ON c.county_id = county.id";
		$this->city_inner_query		= "INNER JOIN cache_city_counts c ON c.city_id = city.id";
		$this->zip_inner_query		= "#INNER JOIN alvins.my_data ON my_data.state = admin1s.code";
	}
	
	// INFO
	function school_info($state, $city, $school, $id){
		$this->data->school = $this->db->query("
			SELECT s.*, education_agency_id, school_id, city_name, admin1_name state_full, admin1_code state_abbr
			FROM schools s
			LEFT JOIN sh_geo.cached_postal_codes geo ON geo.postal_code_id = s.postal_code_id
			WHERE education_agency_id = '".substr($id,0,7)."'
			AND school_id = '".substr($id,-5)."'
		")->row();
		if(rtrim(base_url(),'/').str_replace('?json','',$_SERVER['REQUEST_URI']) != $this->link->school()->href) :
			$this->basics->show_error(404, "This School Could Not Be Located");
		endif;
		$this->geo->zip_info_by_id($this->data->school->postal_code_id);
		$this->data->school_district = $this->db->query("
			SELECT *
			FROM sh_geo.school_districts
			WHERE admin1_id = ".$this->geo->data->state_id."
			AND education_agency_number = '".substr($this->data->school->education_agency_id,2)."'
		")->row();
		$this->data->teacher_compensation = $this->db->query("
			SELECT *
			FROM teacher_compensation t
			WHERE education_agency_id = '".$this->data->school->education_agency_id."'
			AND school_id = '".$this->data->school->school_id."'
		")->row();
		$temp_grades = $this->db->query("
			SELECT *
			FROM grades
			WHERE education_agency_id = '".$this->data->school->education_agency_id."'
			AND school_id = '".$this->data->school->school_id."'
		")->result();
		$this->data->grades = array();
		foreach($temp_grades as $temp_grade) :
			$this->data->grades[ltrim($temp_grade->grade,'0')] = $temp_grade->students;
		endforeach;
	}
	
	// MODIFIER
	function states($limit=52){
		return $this->geo->all_states($this->state_inner_query, $limit);
	}
	
	function modifier_stats(){
		$this->mod_stats('national');
	}
	
	// STATE
	function counties_in_state(){
		$this->geo->order_by = "c.schools DESC";
		return $this->geo->counties_in_state($this->geo->data, $this->county_inner_query, 30);
	}
	
	function cities_in_state(){
		$this->geo->order_by = "c.schools DESC";
		return $this->geo->cities_in_state($this->geo->data, $this->city_inner_query,$this->next_page);
	}
	
	function state_stats(){
		$this->stats('state', $this->geo->data->state_id);
	}
	
	function schools_in_state(){
		return $this->schools_in('admin1_id',$this->geo->data->state_id);
	}
	
	// COUNTY
	function nearby_counties(){
		return $this->geo->nearby_counties($this->geo->data, $this->county_inner_query, 10);
	}
	
	function cities_in_county(){
		return $this->geo->cities_in_county($this->geo->data, $this->city_inner_query, 20);
	}
	
	function county_stats(){
		$this->stats('county', $this->geo->data->county_id);
	}
	
	function schools_in_county(){
		return $this->schools_in('admin2_id',$this->geo->data->county_id,30);
	}
	
	// CITY
	function nearby_cities(){
		return $this->geo->nearby_cities($this->geo->data, $this->city_inner_query, 15);
	}
	
	function city_stats(){
		$this->stats('city', $this->geo->data->city_id);
	}
	
	function schools_in_city(){
		$limit = 30;
		$offset = isset($_GET['page']) && (int)($_GET['page']) ? ((int)$_GET['page'] - 1) * $limit : 0;
		$count_query = "
			SELECT COUNT(*) `count`
			FROM schools s
			LEFT JOIN sh_geo.cached_postal_codes geo ON geo.postal_code_id = s.postal_code_id
			WHERE city_id = ".$this->geo->data->city_id."
			AND students > 0
			
		";
		$temp_total_records = $this->db->query($count_query)->row()->count;
		$this->domain->pagination_headers = pagination_headers($this->copy->full_base_url, ceil($temp_total_records/$limit), 9);
		$this->domain->pagination_headers['total_records'] = $temp_total_records;
		$this->domain->pagination_headers['total_per_page'] = $limit;
		$query = "
			SELECT
				education_agency_id, school_id,
				school_name,
				admin1_name state_full,
				admin1_code state_abbr,
				city_name
			FROM schools s
			LEFT JOIN sh_geo.cached_postal_codes geo ON geo.postal_code_id = s.postal_code_id
			WHERE city_id = ".$this->geo->data->city_id."
			AND students > 0
			ORDER BY school_name ASC
			LIMIT $offset, $limit
		";
		return $this->db->query($query)->result();
	}
	
	// SCHOOL
	function nearby_schools(){
		$distance = .4;
		$query = "
			SELECT *
			FROM (
				SELECT
					education_agency_id, school_id,
					school_name,
					admin1_name state_full,
					admin1_code state_abbr,
					city_name
				FROM schools s
				LEFT JOIN sh_geo.cached_postal_codes geo ON geo.postal_code_id = s.postal_code_id
				WHERE lat BETWEEN ".($this->data->school->lat - $distance)." AND ".($this->data->school->lat + $distance)."
				AND lon BETWEEN ".($this->data->school->lon - $distance)." AND ".($this->data->school->lon + $distance)."
				AND school_id <> ".$this->data->school->school_id."
				AND students > 0
				ORDER BY POW((s.lat - ".$this->data->school->lat."), 2) + POW((s.lon - ".$this->data->school->lon."), 2) DESC
				LIMIT 20
			) x
			ORDER BY school_name ASC
		";
		// die('<pre>'.print_r($this->data->school, TRUE));
		return $this->db->query($query)->result();
	}
	
	// COMMON 
	function mod_stats($geo, $id=NULL){
		if(!isset($id)) :
			$query = "
				SELECT *
				FROM cache_modifier_".$geo."_counts
				WHERE ".$this->domain->school_level_clause."
			";
		else :
			$query = "
				SELECT *
				FROM cache_modifier_".$geo."_counts
				WHERE ".$geo."_id = $id
				AND ".$this->domain->school_level_clause."
			";
		endif;
		$this->data->stats = $this->db->query($query)->row();
	}
	
	function stats($geo, $id){
		if($this->domain->modifier) : 
			$this->mod_stats($geo, $id);
		else :
			$this->data->stats = $this->db->query("
				SELECT *
				FROM cache_".$geo."_counts
				WHERE ".$geo."_id = $id
			")->row();
		endif;
	}
	
	function schools_in($column,$id,$limit=15){
		return $this->db->query("
			SELECT *
			FROM (
				SELECT
					education_agency_id, school_id,
					school_name,
					admin1_name state_full,
					admin1_code state_abbr,
					city_name
				FROM schools s
				LEFT JOIN sh_geo.cached_postal_codes geo ON geo.postal_code_id = s.postal_code_id
				WHERE $column = $id
				AND students > 0
				".($this->domain->school_level_clause ? 'AND '.$this->domain->school_level_clause : '')."
				ORDER BY students DESC
				LIMIT $limit
			) x
			ORDER BY school_name ASC
		")->result();
	}
}
?>
