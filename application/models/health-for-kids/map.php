<?php
class Map extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->polylines = array();
	}
	
	function state() {
		if(isset($_GET['json'])) :
			$this->json = $this->db->query("
				SELECT
					s.*,
					admin1_name state_full,
					admin1_code state_abbr,
					city_name
				FROM schools s
				LEFT JOIN sh_geo.cached_postal_codes geo ON geo.postal_code_id = s.postal_code_id
				WHERE admin1_id = ".$this->geo->data->state_id."
				AND students > 0
				".($this->domain->school_level_clause ? 'AND '.$this->domain->school_level_clause : '')."
				ORDER BY students DESC
				LIMIT 500
			")->result();
			$this->output();
		endif;
	}
	
	function county() {
		if(isset($_GET['json'])) :
			$this->json = $this->db->query("
				SELECT
					s.*,
					admin1_name state_full,
					admin1_code state_abbr,
					city_name
				FROM schools s
				LEFT JOIN sh_geo.cached_postal_codes geo ON geo.postal_code_id = s.postal_code_id
				WHERE admin2_id = ".$this->geo->data->county_id."
				AND students > 0
				".($this->domain->school_level_clause ? 'AND '.$this->domain->school_level_clause : '')."
				ORDER BY students DESC
			")->result();
			$this->output();
		endif;
	}
	
	function city() {
		if(isset($_GET['json'])) :
			$this->json = $this->db->query("
				SELECT
					s.*,
					admin1_name state_full,
					admin1_code state_abbr,
					city_name
				FROM schools s
				LEFT JOIN sh_geo.cached_postal_codes geo ON geo.postal_code_id = s.postal_code_id
				WHERE city_id = ".$this->geo->data->city_id."
				AND students > 0
				".($this->domain->school_level_clause ? 'AND '.$this->domain->school_level_clause : '')."
				ORDER BY students DESC
			")->result();
			$this->output();
		endif;
	}
	
	function school() {
		if(isset($_GET['json'])) :
			$this->json = $this->db->query("
				SELECT
					s.*,
					admin1_name state_full,
					admin1_code state_abbr,
					city_name
				FROM schools s
				LEFT JOIN sh_geo.cached_postal_codes geo ON geo.postal_code_id = s.postal_code_id
				WHERE education_agency_id = ".$this->data->school->education_agency_id."
				AND school_id = ".$this->data->school->school_id."
				AND students > 0
				ORDER BY students DESC
			")->result();
			$this->polylines[] = $this->_create_vertices_from_text($this->db->query("
				SELECT AsText(shape) AS shape
				FROM sh_geo.school_district_shapes
				WHERE school_district_id = ".$this->data->school_district->id."
			")->row()->shape);
			// $temp_polylines = $this->db->query("
				// SELECT AsText(shape) AS shape
				// FROM sh_geo.postal_code_shapes
				// WHERE Overlaps(shape, (SELECT shape FROM sh_geo.school_district_shapes WHERE school_district_id=".$this->data->school_district->id.")) = 1
			// ")->result();
			// foreach($temp_polylines as $temp_polyline) : 
				// $this->polylines[] = $this->_create_vertices_from_text($temp_polyline->shape);
			// endforeach;
			$this->output();
		endif;
	}
	
	function output(){
		$markers = array();
		$temp_data_array_i = 0;
		$temp_lat = 0;
		$temp_lon = 0;
		foreach($this->json as $point_num => $point) :
			if($point->lat && $point->lon) :
				$markers[$temp_data_array_i]['lat'] = (float)$point->lat;
				$markers[$temp_data_array_i]['lon'] = (float)$point->lon;
				$markers[$temp_data_array_i]['level'] = @$point->level;
				$markers[$temp_data_array_i++]['name'] = @'<a href="'.$this->link->school($point)->href.'">'.ucstring($point->school_name).'</a>';
				$temp_lat += (float)$point->lat;
				$temp_lon += (float)$point->lon;
				$min_lat = isset($min_lat) ? (($point->lat < $min_lat) ? $point->lat : $min_lat) : $point->lat;
				$max_lat = isset($max_lat) ? (($point->lat > $max_lat) ? $point->lat : $max_lat) : $point->lat;
				$min_lon = isset($min_lon) ? (($point->lon < $min_lon) ? $point->lon : $min_lon) : $point->lon;
				$max_lon = isset($max_lon) ? (($point->lon > $max_lon) ? $point->lon : $max_lon) : $point->lon;
			endif;
		endforeach;
		if(count($this->polylines)) : 
			$polygon['type'] = 'FeatureCollection';
			$polygon['features'] = array();
			foreach($this->polylines as $polyline_num => $polyline) : 
				$polygon['features'][$polyline_num]->type = 'Feature';
				$polygon['features'][$polyline_num]->geometry->type = 'MultiPolygon';
				$polygon['features'][$polyline_num]->geometry->coordinates = $polyline;
			endforeach;
		endif;
		error_reporting(0);
		$return = array();
		$return['polygon']	= $polygon;
		$return['markers']	= $markers;
		$return['min_lat']	= $min_lat;
		$return['max_lat']	= $max_lat;
		$return['min_lon']	= $min_lon;
		$return['max_lon']	= $max_lon;
		$return['cen_lat']	= $temp_lat/$temp_data_array_i;
		$return['cen_lon']	= $temp_lon/$temp_data_array_i;
		$return['legend']	= $this->load->view('elements/legend',NULL,TRUE);
		die(json_encode($return));
	}
	
	function _create_vertices_from_text($shape_text){
		$return = array();
		$polygons = explode(')),((', str_replace(array('MULTIPOLYGON', 'POLYGON'), '', $shape_text));
		foreach($polygons as $polygon_num => $polygon) :
			$lat_lons = explode('),(', $polygon);
			foreach($lat_lons as $lat_lon_num => $temp_lat_lons) :
				preg_match_all('/(?<lon>[0-9-\.]+) (?<lat>[0-9-\.]+)/', $temp_lat_lons, $temp_matches);
				foreach($temp_matches['lat'] as $temp_point_num => $temp_point) :
					$return[$polygon_num][$lat_lon_num][$temp_point_num][0] = $temp_matches['lon'][$temp_point_num];
					$return[$polygon_num][$lat_lon_num][$temp_point_num][1] = $temp_point;
				endforeach;
			endforeach;
		endforeach;
		return $return;
	}
}
?>