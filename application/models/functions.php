<?php
class Functions extends CI_Model {

	function __construct(){
		parent::__construct();
	}
}

function pagination_headers($base_url,$num_pages,$num_links=7){
	$return['pagination_headers']	= '';
	if(isset($_GET['page']) && $_GET['page'] > 1) : 
		$return['pagination_headers']	.= '<link rel="prev" href="'.$base_url.'?page='.($_GET['page'] - 1).'">';
		if($_GET['page'] < $num_pages) :
			$return['pagination_headers']	.= '<link rel="next" href="'.$base_url.'?page='.($_GET['page'] + 1).'">';
		endif;
	else :
		if($num_pages > 1) : 
			$return['pagination_headers']    .= '<link rel="next" href="'.$base_url.'?page=2">';
		endif;
	endif;
	
	$_GET['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
	$min_page = isset($_GET['page']) && $_GET['page'] > floor(($num_links - 1) / 2) ? $_GET['page'] - floor(($num_links - 1) / 2) : 1;
	$max_page = isset($_GET['page']) && ($num_pages - $_GET['page']) < floor(($num_links - 1) / 2) ? $num_pages : $_GET['page'] + floor(($num_links - 1) / 2);
	if($max_page == $num_pages) :
		$min_page = $num_pages - ($num_links - 1);
	elseif($max_page - $min_page < $num_links) :
		$max_page = $min_page + ($num_links - 1);
	endif;
	if($max_page > intval($num_pages)) :
		$max_page = intval($num_pages);
	endif;
	$min_page = $min_page < 1 ? 1 : $min_page;
	$return['pagination_range'] = range($min_page,$max_page);
	$return['page_num'] = $_GET['page'];
	$return['num_pages'] = $num_pages;
	$return['num_links'] = $num_links;
	
	return $return;
}

function flip_state($string){
	$string = strtolower(str_replace('-', ' ', $string));
	$short_to_state = state_array();
	$state_to_short = array_flip($short_to_state);
	if(isset($short_to_state[$string])):
		return $short_to_state[$string];
	elseif(isset($state_to_short[$string])) :
		return $state_to_short[$string];
	else : 
		return $string;
	endif;
}

function state_full_to_state_abbr($string){
	$string = strtolower(str_replace('-', ' ', $string));
	$states = array_flip(state_array());
	if(isset($states[$string])) :
		return $states[$string];
	else : 
		return $string;
	endif;
}

function state_abbr_to_state_full($string){
	$string = strtolower(str_replace('-', ' ', $string));
	$states = state_array();
	if(isset($states[$string])) :
		return $states[$string];
	else : 
		return $string;
	endif;
}
	
function geocode_location($address){
	$osm = json_decode(file_get_contents("http://www.mapquestapi.com/geocoding/v1/address?key=".MAPQUEST_APP_KEY."&inFormat=kvp&outFormat=json&location=".urlencode($address)));
	$return = array();
	$return['address'] = @$osm->results[0]->locations[0]->street;
	$return['city'] = @$osm->results[0]->locations[0]->adminArea5;
	$return['county'] = @$osm->results[0]->locations[0]->adminArea4;
	$return['state'] = @$osm->results[0]->locations[0]->adminArea3;
	$return['zip'] = @$osm->results[0]->locations[0]->postalCode;
	$return['lat'] = @$osm->results[0]->locations[0]->displayLatLng->lat;
	$return['lon'] = @$osm->results[0]->locations[0]->displayLatLng->lng;
	return $return;
}

function within_range($point_1, $point_2){
	return abs($point_1 - $point_2) < .7;
}

function calculate_median($array){
	asort($array);
	return $array[floor(count($array) / 2)];
}

function calc_avg_lat_lon($result){
	$avg_lat_1 = $avg_lat_2 = 0;
	$all_lats = $all_lons = array();
	$avg_lon_1 = $avg_lon_2 = 0;
	$num_items_1 = $num_items_2 = 0;
	foreach($result as $row) : 
		if($row->lat && $row->lon) :
			$all_lats[] = $row->lat;
			$all_lons[] = $row->lon;
			++$num_items_1;
		endif;
	endforeach;
	$avg_lat_1 = calculate_median($all_lats);
	$avg_lon_1 = calculate_median($all_lons);
	foreach($result as $row) : 
		if(within_range($row->lat, $avg_lat_1) && within_range($row->lon, $avg_lon_1)) :
			$avg_lat_2 += $row->lat;
			$avg_lon_2 += $row->lon;
			++$num_items_2;
		endif;
	endforeach;
	$return->lat = $avg_lat_2/$num_items_2;
	$return->lon = $avg_lon_2/$num_items_2;
	return $return;
}

function my_strip_tags($text){
	return clean_word(preg_replace('/\<.+?\>/', ' ', $text));
}

function prep_news_story($article,$length=150,$title_length=100){
	$new_feed_time = '';
	if(strtotime($article->updated) < (time() - (60 * 60 * 24))) : 
		$new_feed_time = date("D, M jS g:i A", strtotime($article->updated." GMT"));
	else :
		$num_seconds = time() - strtotime($article->updated." GMT");
		if($num_seconds < 0) : $num_seconds += (60 * 60); endif;
		$num_minutes = (floor($num_seconds / 60 ) % 60); 
		$num_hours = floor($num_seconds / (60 * 60)); 
		if($num_hours) :
			$new_feed_time .= $num_hours.' hour';
			$new_feed_time .= ($num_hours != 1) ? 's ' : ' ';
		endif;
		$new_feed_time .= $num_minutes.' minutes ago';
	endif;
	if(strlen(clean_word($article->content)) > $length) :
		$article->display_text = substr(clean_word(my_strip_tags($article->content)), 0, $length).' &#8230;';
	else :
		$article->display_text = clean_word(my_strip_tags($article->content));
	endif;
	if(strlen(clean_word($article->title)) > $title_length) :
		$article->display_title = substr(clean_word($article->title), 0, $title_length).' &#8230;';
	else :
		$article->display_title = clean_word($article->title);
	endif;
	$article->display_date = $new_feed_time;
	return $article;
}

function https($string){
	return str_replace('http://', 'https://', $string);
}

function non_https($string){
	return str_replace('https://', 'http://', $string);
}

function ucstring($words){
	$roman_numerals_lower = array(' ii', ' iii');
	$roman_numerals_upper = array(' II', ' III');
	return identify_abbreviations(str_ireplace($roman_numerals_lower, $roman_numerals_upper, preg_replace_callback('/(\bmc|\b)\p{Ll}/', '_uc_string_callback', strtolower(clean_word($words)))));
}

function identify_abbreviations($string){
	$return = '';
	$parts = preg_split('/\b/', $string);
	foreach($parts as $part) :
		if(strlen($part) > 2 && !array_intersect(vowels(), str_split(strtolower($part)))) :
			$return .= strtoupper($part);
		else :
			$return .= $part;
		endif;
	endforeach;
	return $return;
}

function _uc_string_callback($match) {
	return ucfirst(uclast($match[0]));
}

function uclast($str) {
	$str[strlen($str)-1] = strtoupper($str[strlen($str)-1]);
	return $str;
}

function make_slug($string, $delimiter='-'){
	return strtolower(trim(preg_replace('/[\W_]+/', $delimiter, $string), $delimiter));
}

function clean_word($word){
	return trim(preg_replace('/\s+/', ' ', preg_replace('/[^(\x20-\x7F)]+/', ' ', html_entity_decode(str_replace(array('&nbsp;', '&nbsp'), ' ', $word)))));
}

function vowels(){
	return array('a','e','i','o','u','y');
}

?>