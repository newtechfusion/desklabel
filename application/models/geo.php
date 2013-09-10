<?php
class Geo extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->data = new stdClass();
	}
	
	// ---------------------------------------------------------------------------------------------------------------------
	// INFO
	// ---------------------------------------------------------------------------------------------------------------------
	function state_info($state){
		$return = $this->db->query("
			SELECT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				a1.lat,
				a1.lon,
				a1.population,
				a1.admin2s_count AS county_count,
				a1.cities_count AS cities_count,
				a1.postal_codes_count AS zip_count
			FROM sh_geo.admin1s a1
			WHERE a1.slug = '".make_slug($state)."'
				AND a1.is_active = 1
		")->row();
		if(!isset($return->state_id)) :
			$this->basics->show_error(404, "This State Could Not Be Located");
			die;
		endif;
		$this->data = $return;
		return $return;
	}

	function county_info($state, $county){
		$return = $this->db->query("
			SELECT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				a2.id AS county_id,
				a2.name AS county_name,
				a2.slug AS county_slug,
				a2.lat,
				a2.lon,
				a2.population
			FROM sh_geo.admin1s a1
				LEFT OUTER JOIN sh_geo.admin2s a2 ON a2.admin1_id = a1.id
			WHERE
				a1.is_active = 1
				AND a2.is_active = 1
				AND a1.slug = '".make_slug($state)."'
				AND a2.slug = '".make_slug($county)."'
		")->row();
		if(!isset($return->county_id)) :
			$this->basics->show_error(404, "This County Could Not Be Located");
			die;
		endif;
		$this->data = $return;
		return $return;
	}

	function city_info($state, $city){
		$return = $this->db->query("
			SELECT DISTINCT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				a2.id AS county_id,
				a2.name AS county_name,
				a2.slug AS county_slug,
				c.id AS city_id,
				c.name AS city_name,
				c.slug AS city_slug,
				c.lat,
				c.lon,
				c.population
			FROM (
				SELECT DISTINCT c.id AS city_id
				FROM sh_geo.cities c
					LEFT OUTER JOIN sh_geo.cities_postal_codes cpc ON cpc.city_id = c.id
				WHERE
					c.is_active = 1
					AND cpc.is_primary = 1
					AND c.slug = '".make_slug($city)."'
			) AS sub_query
				LEFT OUTER JOIN sh_geo.cities c ON c.id = sub_query.city_id
				LEFT OUTER JOIN sh_geo.admin1s a1 ON a1.id = c.admin1_id
				LEFT OUTER JOIN sh_geo.admin2s_cities a2c ON a2c.city_id = c.id
				LEFT OUTER JOIN sh_geo.admin2s a2 ON a2.id = a2c.admin2_id
				LEFT OUTER JOIN sh_geo.cities_postal_codes cpc ON cpc.city_id = c.id
			WHERE
				a1.is_active = 1
				AND c.is_active = 1
				AND cpc.is_primary = 1
				AND a1.slug = '".make_slug($state)."'
			ORDER BY a2.population DESC
			LIMIT 1
		")->row();
		if(!isset($return->city_id)) :
			$this->basics->show_error(404, "This City Could Not Be Located");
			die;
		endif;
		$this->data = $return;
		return $return;
	}

	
	function zip_info($state, $zip){
		$return = $this->db->query("
			SELECT DISTINCT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				a2.id AS county_id,
				a2.name AS county_name,
				a2.slug AS county_slug,
				c.id AS city_id,
				c.name AS city_name,
				c.slug AS city_slug,
				pc.id AS zip_id,
				pc.code AS zip_code,
				pc.lat,
				pc.lon,
				pc.population
			FROM sh_geo.admin1s a1
				LEFT OUTER JOIN sh_geo.postal_codes pc ON pc.admin1_id = a1.id
				LEFT OUTER JOIN sh_geo.cities_postal_codes cpc ON cpc.postal_code_id = pc.id
				LEFT OUTER JOIN sh_geo.cities c ON c.admin1_id = a1.id AND c.id = cpc.city_id
				LEFT OUTER JOIN sh_geo.admin2s_postal_codes a2pc ON a2pc.postal_code_id = pc.id
				LEFT OUTER JOIN sh_geo.admin2s a2 ON a2.admin1_id = a1.id AND a2.id = a2pc.admin2_id
			WHERE
				a1.is_active = 1
				AND a2.is_active = 1
				AND c.is_active = 1
				AND pc.is_active = 1
				AND cpc.is_primary = 1
				AND a1.slug = '".make_slug($state)."'
				AND pc.code = '".make_slug($zip)."'
		")->row();
		if(!isset($return->zip_id)) :
			$this->basics->show_error(404, "This Zipcode Could Not Be Located");
			die;
		endif;
		$this->data = $return;
		return $return;
	}
	
	function zip_info_by_id($postal_code_id) {
		$return = $this->db->query("
			SELECT DISTINCT
				admin1_id AS state_id,
				admin1_code AS state_abbr,
				admin1_name AS state_full,
				admin1_slug AS state_slug,
				admin2_id AS county_id,
				admin2_name AS county_name,
				admin2_slug AS county_slug,
				city_id,
				city_name,
				city_slug,
				postal_code_id AS zip_id,
				postal_code AS zip_code,
				postal_lat AS lat,
				postal_lon AS lon,
				postal_population AS population
			FROM sh_geo.cached_postal_codes
			WHERE 
				postal_code_id = $postal_code_id
		")->row();
		if (!isset($return->zip_id)):
			$this->basics->show_error(404, "This Zipcode Could Not Be Located");
			die;
		endif;
		$this->data = $return;
		return $return;
	}
	// ---------------------------------------------------------------------------------------------------------------------




	// ---------------------------------------------------------------------------------------------------------------------
	// STATE
	// ---------------------------------------------------------------------------------------------------------------------
	function counties_in_state($state_data, $inner_join="", $limit=20){
		$order_by = isset($this->order_by) ? $this->order_by : "county.population DESC";
		$return = $this->db->query("
			SELECT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				a2.id AS county_id,
				a2.name AS county_name,
				a2.slug AS county_slug,
				a2.lat,
				a2.lon,
				a2.population
			FROM (
				SELECT DISTINCT county.id AS county_id
				FROM sh_geo.admin2s county
					LEFT OUTER JOIN sh_geo.admin1s state ON state.id = county.admin1_id
					$inner_join
				WHERE
					state.is_active = 1
					AND county.is_active = 1
					AND state.id = ".$state_data->state_id."
				ORDER BY ".$order_by."
				LIMIT $limit
			) AS sub_query
				LEFT OUTER JOIN sh_geo.admin2s a2 ON a2.id = sub_query.county_id
				LEFT OUTER JOIN sh_geo.admin1s a1 ON a1.id = a2.admin1_id
			WHERE
				a1.is_active = 1
				AND a2.is_active = 1
			ORDER BY county_name
		")->result();
		return $return;
	}


	function cities_in_state($state_data, $inner_join="", $limit=20){
		$order_by = isset($this->order_by) ? $this->order_by : "city.population DESC";
		$return = $this->db->query("
			SELECT DISTINCT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				c.id AS city_id,
				c.name AS city_name,
				c.slug AS city_slug,
				c.lat,
				c.lon,
				c.population
			FROM (
				SELECT DISTINCT city.id AS city_id
				FROM sh_geo.cities city
					LEFT OUTER JOIN sh_geo.admin1s state ON state.id = city.admin1_id
					LEFT OUTER JOIN sh_geo.cities_postal_codes ON cities_postal_codes.city_id = city.id
					$inner_join
				WHERE
					state.is_active = 1
					AND city.is_active = 1
					AND cities_postal_codes.is_primary = 1
					AND state.id = ".$state_data->state_id."
				ORDER BY ".$order_by."
				LIMIT $limit
			) AS sub_query
				LEFT OUTER JOIN sh_geo.cities c ON c.id = sub_query.city_id
				LEFT OUTER JOIN sh_geo.cities_postal_codes cpc on cpc.city_id = c.id
				LEFT OUTER JOIN sh_geo.admin1s a1 ON a1.id = c.admin1_id
			WHERE
				a1.is_active = 1
				AND c.is_active = 1
				AND cpc.is_primary = 1
			ORDER BY city_name
		")->result();
		return $return;
	}


	function zips_in_state($state_data, $inner_join="", $limit=20){
		$return = $this->db->query("
			SELECT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				c.name AS city_name,
				pc.id AS zip_id,
				pc.code AS zip_code,
				pc.slug AS zip_slug,
				pc.lat,
				pc.lon,
				pc.population
			FROM (
				SELECT DISTINCT zip.id AS zip_id
				FROM sh_geo.postal_codes zip
					LEFT OUTER JOIN sh_geo.admin1s state ON state.id = zip.admin1_id
					$inner_join
				WHERE
					state.is_active = 1
					AND zip.is_active = 1
					AND state.id = ".$state_data->state_id."
				ORDER BY zip.population DESC
 				LIMIT $limit
			) AS sub_query
				LEFT OUTER JOIN sh_geo.postal_codes pc ON pc.id = sub_query.zip_id
				LEFT OUTER JOIN sh_geo.admin1s a1 ON a1.id = pc.admin1_id
				LEFT OUTER JOIN sh_geo.cities_postal_codes cpc ON cpc.postal_code_id = pc.id
				LEFT OUTER JOIN sh_geo.cities c ON c.id = cpc.city_id
			WHERE
				a1.is_active = 1
				AND pc.is_active = 1
			ORDER BY zip_code
		")->result();
		return $return;
	}
	// ---------------------------------------------------------------------------------------------------------------------




	// ---------------------------------------------------------------------------------------------------------------------
	// COUNTY
	// ---------------------------------------------------------------------------------------------------------------------
	function cities_in_county($county_data, $inner_join="", $limit=20){
		$return = $this->db->query("
			SELECT DISTINCT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				a2.id AS county_id,
				a2.name AS county_name,
				a2.slug AS county_slug,
				c.id AS city_id,
				c.name AS city_name,
				c.slug AS city_slug,
				c.lat,
				c.lon,
				c.population
			FROM (
				SELECT DISTINCT city.id AS city_id
				FROM sh_geo.cities city
					LEFT OUTER JOIN sh_geo.admin2s_cities ON admin2s_cities.city_id = city.id
					LEFT OUTER JOIN sh_geo.admin2s county ON county.id = admin2s_cities.admin2_id
					LEFT OUTER JOIN sh_geo.cities_postal_codes ON cities_postal_codes.city_id = city.id
					$inner_join
				WHERE
					city.is_active = 1
					AND county.is_active = 1
					AND cities_postal_codes.is_primary = 1
					AND county.id = ".$county_data->county_id."
				ORDER BY city.population DESC
				LIMIT $limit
			) AS sub_query
				LEFT OUTER JOIN sh_geo.cities c ON c.id = sub_query.city_id
				LEFT OUTER JOIN sh_geo.admin1s a1 ON a1.id = c.admin1_id
			 	LEFT OUTER JOIN sh_geo.admin2s_cities a2c ON a2c.city_id = c.id
				LEFT OUTER JOIN sh_geo.admin2s a2 ON a2.id = a2c.admin2_id
			 	LEFT OUTER JOIN sh_geo.cities_postal_codes cpc ON cpc.city_id = c.id
			WHERE
				a1.is_active = 1
				AND a2.is_active = 1
				AND c.is_active = 1
			 	AND cpc.is_primary = 1
				AND a2.id = ".$county_data->county_id."
			ORDER BY city_name
		")->result();
		return $return;
	}
	
	function zips_in_county($county_data, $inner_join="", $limit=20){
		$return = $this->db->query("
			SELECT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				a2.id AS county_id,
				a2.name AS county_name,
				a2.slug AS county_slug,
				c.id AS city_id,
				c.name AS city_name,
				c.slug AS city_slug,
				pc.id AS zip_id,
				pc.name AS zip_code,
				pc.slug AS zip_slug,
				pc.lat,
				pc.lon,
				pc.population
			FROM (
				SELECT DISTINCT zip.id AS zip_id
				FROM sh_geo.postal_codes zip
					LEFT OUTER JOIN sh_geo.admin2s_postal_codes ON admin2s_postal_codes.postal_code_id = zip.id
					LEFT OUTER JOIN sh_geo.admin2s county ON county.id = admin2s_postal_codes.admin2_id
					LEFT OUTER JOIN sh_geo.cities_postal_codes cpc ON cpc.postal_code_id = zip.id
					$inner_join
				WHERE
					zip.is_active = 1
					AND county.is_active = 1
					AND county.id = ".$county_data->county_id."
					AND cpc.is_primary = 1
				ORDER BY zip.population DESC
				LIMIT $limit
			) AS sub_query
				LEFT OUTER JOIN sh_geo.postal_codes pc ON pc.id = sub_query.zip_id
				LEFT OUTER JOIN sh_geo.admin1s a1 ON a1.id = pc.admin1_id
			 	LEFT OUTER JOIN sh_geo.admin2s_postal_codes a2pc ON a2pc.postal_code_id = pc.id
				LEFT OUTER JOIN sh_geo.admin2s a2 ON a2.id = a2pc.admin2_id
				LEFT OUTER JOIN sh_geo.cities_postal_codes cpc ON cpc.postal_code_id = pc.id
				LEFT OUTER JOIN sh_geo.cities c ON c.id = cpc.city_id
			WHERE
				a1.is_active = 1
				AND a2.is_active = 1
				AND pc.is_active = 1
				AND cpc.is_primary = 1
				AND a2.id = ".$county_data->county_id."
			ORDER BY zip_code
		")->result();
		return $return;
	}
	// ---------------------------------------------------------------------------------------------------------------------




	// ---------------------------------------------------------------------------------------------------------------------
	// CITY
	// ---------------------------------------------------------------------------------------------------------------------
	function zips_in_city($city_data, $inner_join="", $limit=20){
		$return = $this->db->query("
			SELECT DISTINCT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				c.id AS city_id,
				c.name AS city_name,
				c.slug AS city_slug,
				pc.id AS zip_id,
				pc.name AS zip_code,
				pc.slug AS zip_slug,
				pc.lat,
				pc.lon,
				pc.population
			FROM (
				SELECT DISTINCT zip.id AS zip_id
				FROM sh_geo.postal_codes zip
					LEFT OUTER JOIN sh_geo.cities_postal_codes ON cities_postal_codes.postal_code_id = zip.id
					LEFT OUTER JOIN sh_geo.cities city ON city.id = cities_postal_codes.city_id
					$inner_join
				WHERE
					zip.is_active = 1
					AND city.is_active = 1
					AND cities_postal_codes.is_primary = 1
					AND city.id = ".$city_data->city_id."
				ORDER BY zip.population DESC
				LIMIT $limit
			) AS sub_query
				LEFT OUTER JOIN sh_geo.postal_codes pc ON pc.id = sub_query.zip_id
				LEFT OUTER JOIN sh_geo.admin1s a1 ON a1.id = pc.admin1_id
			 	LEFT OUTER JOIN sh_geo.cities_postal_codes cpc ON cpc.postal_code_id = pc.id
				LEFT OUTER JOIN sh_geo.cities c ON c.id = cpc.city_id
			WHERE
				a1.is_active = 1
				AND c.is_active = 1
				AND pc.is_active = 1
				AND cpc.is_primary = 1
				AND c.id = ".$city_data->city_id."
			ORDER BY zip_code
		")->result();
		return $return;
	}

	// ---------------------------------------------------------------------------------------------------------------------
	// NEARBY
	// ---------------------------------------------------------------------------------------------------------------------
	function nearby_states($state_data, $inner_join="", $limit=20, $lat_lon_distance=50.0){
		$return = $this->db->query("
			SELECT DISTINCT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				a1.lat,
				a1.lon,
				a1.population,
				sub_query.distance_in_miles
			FROM (
				SELECT DISTINCT
					state.id AS state_id,
					round(sqrt(pow(69.1 * (state.lat - center.lat), 2) + pow(53.0 * (state.lon - center.lon), 2)), 3) AS distance_in_miles
				FROM sh_geo.admin1s center
					LEFT OUTER JOIN sh_geo.admin1s state ON TRUE
					$inner_join
				WHERE
					center.is_active = 1
					AND state.is_active = 1
					AND center.id = ".$state_data->state_id."
					AND state.id <> ".$state_data->state_id."
					AND (state.lat BETWEEN (center.lat - ".$lat_lon_distance.") AND (center.lat + ".$lat_lon_distance.")) AND (state.lon BETWEEN (center.lon - ".$lat_lon_distance.") AND (center.lon + ".$lat_lon_distance."))
				ORDER BY distance_in_miles
				LIMIT $limit
			) sub_query
				LEFT OUTER JOIN sh_geo.admin1s a1 ON a1.id = sub_query.state_id
			ORDER BY distance_in_miles
		")->result();
		return $return;
	}


	function nearby_counties($county_data, $inner_join="", $limit=20, $lat_lon_distance=2.0){
		$return = $this->db->query("
			SELECT DISTINCT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				a2.id AS county_id,
				a2.name AS county_name,
				a2.slug AS county_slug,
				a2.lat,
				a2.lon,
				a2.population,
				sub_query.distance_in_miles
			FROM (
				SELECT DISTINCT
					county.id AS county_id,
					round(sqrt(pow(69.1 * (county.lat - center.lat), 2) + pow(53.0 * (county.lon - center.lon), 2)), 3) AS distance_in_miles
				FROM sh_geo.admin2s center
					LEFT OUTER JOIN sh_geo.admin2s county ON TRUE
					$inner_join
				WHERE
					center.is_active = 1
					AND county.is_active = 1
					AND center.id = ".$county_data->county_id."
					AND county.id <> ".$county_data->county_id."
					AND (county.lat BETWEEN (center.lat - ".$lat_lon_distance.") AND (center.lat + ".$lat_lon_distance.")) AND (county.lon BETWEEN (center.lon - ".$lat_lon_distance.") AND (center.lon + ".$lat_lon_distance."))
				ORDER BY distance_in_miles
				LIMIT $limit
			) sub_query
				LEFT OUTER JOIN sh_geo.admin2s a2 ON a2.id = sub_query.county_id
				LEFT OUTER JOIN sh_geo.admin1s a1 ON a1.id = a2.admin1_id
			WHERE
				a1.is_active = 1
				AND a2.is_active = 1
			ORDER BY distance_in_miles
		")->result();
		return $return;
	}


	function nearby_cities($city_data, $inner_join="", $limit=20, $lat_lon_distance=2.0){
		$return = $this->db->query("
			SELECT DISTINCT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				c.id AS city_id,
				c.name AS city_name,
				c.slug AS city_slug,
				c.lat,
				c.lon,
				c.population,
				sub_query.distance_in_miles
			FROM (
				SELECT DISTINCT
					city.id AS city_id,
					round(sqrt(pow(69.1 * (city.lat - center.lat), 2) + pow(53.0 * (city.lon - center.lon), 2)), 3) AS distance_in_miles
				FROM sh_geo.cities center
					LEFT OUTER JOIN sh_geo.cities city ON TRUE
					LEFT OUTER JOIN sh_geo.cities_postal_codes ON cities_postal_codes.city_id = city.id
					$inner_join
				WHERE
					center.is_active = 1
					AND city.is_active = 1
					AND cities_postal_codes.is_primary = 1
					AND center.id = ".$city_data->city_id."
					AND city.id <> ".$city_data->city_id."
					AND (city.lat BETWEEN (center.lat - ".$lat_lon_distance.") AND (center.lat + ".$lat_lon_distance.")) AND (city.lon BETWEEN (center.lon - ".$lat_lon_distance.") AND (center.lon + ".$lat_lon_distance."))
				ORDER BY distance_in_miles
				LIMIT $limit
			) sub_query
				LEFT OUTER JOIN sh_geo.cities c ON c.id = sub_query.city_id
				LEFT OUTER JOIN sh_geo.admin1s a1 ON a1.id = c.admin1_id
				LEFT OUTER JOIN sh_geo.cities_postal_codes cpc ON cpc.city_id = c.id
			WHERE
				a1.is_active = 1
				AND c.is_active = 1
				AND cpc.is_primary = 1
			ORDER BY distance_in_miles
		")->result();
		return $return;
	}
	
	function nearby_zips($zip_data, $inner_join="", $limit=20, $lat_lon_distance=1.0){
		$return = $this->db->query("
			SELECT DISTINCT
				a1.id AS state_id,
				a1.code AS state_abbr,
				a1.name AS state_full,
				a1.slug AS state_slug,
				c.id AS city_id,
				c.name AS city_name,
				c.slug AS city_slug,
				pc.id AS zip_id,
				pc.name AS zip_code,
				pc.slug AS zip_slug,
				pc.lat,
				pc.lon,
				pc.population,
				sub_query.distance_in_miles
			FROM (
				SELECT DISTINCT
					zip.id AS zip_id,
					round(sqrt(pow(69.1 * (zip.lat - center.lat), 2) + pow(53.0 * (zip.lon - center.lon), 2)), 3) AS distance_in_miles
				FROM sh_geo.postal_codes center
					LEFT OUTER JOIN sh_geo.postal_codes zip ON TRUE
					LEFT OUTER JOIN sh_geo.cities_postal_codes cpc ON cpc.postal_code_id = zip.id
					$inner_join
				WHERE
					center.is_active = 1
					AND zip.is_active = 1
					AND cpc.is_primary = 1
					AND center.id = ".$zip_data->zip_id."
					AND zip.id <> ".$zip_data->zip_id."
					AND (zip.lat BETWEEN (center.lat - ".$lat_lon_distance.") AND (center.lat + ".$lat_lon_distance.")) AND (zip.lon BETWEEN (center.lon - ".$lat_lon_distance.") AND (center.lon + ".$lat_lon_distance."))
				ORDER BY distance_in_miles
				LIMIT $limit
			) sub_query
				LEFT OUTER JOIN sh_geo.postal_codes pc ON pc.id = sub_query.zip_id
				LEFT OUTER JOIN sh_geo.admin1s a1 ON a1.id = pc.admin1_id
				LEFT OUTER JOIN sh_geo.cities_postal_codes cpc ON cpc.postal_code_id = pc.id
				LEFT OUTER JOIN sh_geo.cities c ON c.id = cpc.city_id
			WHERE
				a1.is_active = 1
				AND pc.is_active = 1
				AND cpc.is_primary = 1
			ORDER BY zip_code, distance_in_miles, c.population desc
		")->result();
		return $return;
	}
	// ---------------------------------------------------------------------------------------------------------------------

	function min_max_lat_lon_counties_in_state($state_abbr) {
		$return = $this->db->query("
			SELECT
				MAX(county.lat) AS max_lat,
				MIN(county.lat) AS min_lat,
				MAX(county.lon) AS max_lon,
				MIN(county.lon) AS min_lon
			FROM sh_geo.admin2s county
				LEFT JOIN sh_geo.admin1s state ON state.id = county.admin1_id
			WHERE
				state.is_active = 1
				AND county.is_active = 1
				AND state.code = '$state_abbr'
		")->row();
		return $return;
	}

	// NATIONAL
	function all_states($inner_join="", $limit=20){
		$return = $this->db->query("
			SELECT
				state.id state_id,
				state.code state_abbr,
				state.name state_full,
				state.lat,
				state.lon,
				state.population
			FROM (
				SELECT state.id state_id
				FROM sh_geo.admin1s state
			 	$inner_join
				ORDER BY population DESC
				LIMIT $limit
			) sub_query
				LEFT OUTER JOIN sh_geo.admin1s state ON state.id = sub_query.state_id
			ORDER BY state_full
		")->result();
		return $return;
	}
	
	function top_cities($inner_join="", $limit=20){
		$return = $this->db->query("
			SELECT
				city.id city_id,
				admin2s.id county_id,
				state.id state_id,
				state.code state_abbr,
				state.name state_full,
				admin2s.name county_name,
				city.name city_name,
				city.lat,
				city.lon,
				city.population
			FROM (
				SELECT city.id city_id
				FROM sh_geo.cities city
				$inner_join
				ORDER BY population DESC
				LIMIT $limit
			) AS sub_query
				LEFT OUTER JOIN sh_geo.cities city ON city.id = sub_query.city_id
				LEFT OUTER JOIN sh_geo.admin1s state ON state.id = city.admin1_id
				LEFT OUTER JOIN sh_geo.admin2s ON admin2s.admin1_id = state.id
				LEFT OUTER JOIN sh_geo.admin2s_cities ON admin2s_cities.admin2_id = admin2s.id AND admin2s_cities.city_id = city.id
			ORDER BY city_name
		")->result();
		return $return;
	}
}

?>