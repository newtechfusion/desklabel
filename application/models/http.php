<?php
class Http extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.204 Safari/534.16';
	}
	
	function request($url){
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL, $url);
		curl_setopt($curl,CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl,CURLOPT_HEADER, FALSE);
		$page_src = curl_exec($curl);
		curl_close($curl);
		return $page_src;
	}
	
	
  function  select($tablename,$where='',$feild='',$limit='',$order_by='',$distinct=FALSE,$likes=NULL,$in=NULL){
	 
	
		 if(!empty($feild)) $this->db->select($feild);
		 if(empty($feild))  $this->db->select();
		 if($distinct)$this->db->distinct();
		 if(!empty($where)) $this->db->where($where); 
		if(!empty($likes) && is_array($likes)):
		  foreach($likes as $like):
			 $keys=array_keys($like);
			 $this->db->like($keys[0],$like[$keys[0]]);
		  endforeach;
		endif;
		if(!empty($in))$this->db->where_in(key($in),$in[key($in)]);	
		if(!empty($order_by)) $this->db->order_by($order_by);
		if(!empty($limit)) 
		{ 
			if(is_array($limit))
			{	
			$this->db->limit($limit[1],$limit[0]);
			}else{
				$this->db->limit($limit);
				}
		}
		 $this->db->from('sh_nces.'.$tablename);
		 $query = $this->db->get();
		  return $query->result_array();
	}
	
	 function load()
    {
		$db['default']['hostname'] = 'ec2-54-234-35-26.compute-1.amazonaws.com';
		$db['default']['username'] = 'dev_user';
		$db['default']['password'] = 'devpassword';
		$db['default']['database'] = 'sh_nces';
		$db['default']['dbdriver'] = 'mysql';
		$specific_db_settings['dbprefix'] = "";
		$specific_db_settings['pconnect'] = TRUE;
		$specific_db_settings['db_debug'] = FALSE;
		$specific_db_settings['cache_on'] = FALSE;
		$specific_db_settings['cachedir'] = "";
		$specific_db_settings['char_set'] = "utf8";
		$specific_db_settings['dbcollat'] = "utf8_general_ci";
		
		return $this->load->database($specific_db_settings, TRUE);
    }

	function nearby_cities($city_data, $inner_join="", $limit=20, $lat_lon_distance=2.0){
		
		$this->load();
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
	
	 
}

?>