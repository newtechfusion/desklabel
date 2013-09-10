<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hc_database_modifications extends CI_Controller {

	function __construct(){
		parent::__construct();
		set_time_limit(0);
		$this->temp_file		= '/tmp/geocode_encrypted_file.txt';
		$this->ips				= explode("\n", trim(shell_exec('ip addr show eth0 | grep "inet " | grep -v "127.0.0" | awk "{print \$2}" | cut -d/ -f1')));
		$this->encryption_key	= 'APANtByIGI1BpVXZTJgcsAG8GZl8pdwwa84';
		$this->post_url			= 'http://galaxy01.starnine.com/garbage_ass3/garbage_geo/google/parsed';
	}
	
	/**
	 ** $data should be an array containing array(s) or object(s) with the following values:
	 **   * key (usually the ID value of the DB row being geocoded)
	 **   * full_street_address (the street address including street number and name)
	 **   * city (the city the address is in)
	 **   * state  (the state the address is in)
	 **   * postal_code  (the zip code)
	 **/
	function geocode($data = NULL) {
		if ($data == NULL) return NULL;
	
		file_put_contents($this->temp_file, $this->encrypt(gzdeflate(json_encode($data))));
		echo "\t".count($data)." items to be geocoded.\n";
		
		$post_fields['data'] = '@'.$this->temp_file;
		$post_fields['md5'] = md5(file_get_contents($this->temp_file));
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_INTERFACE, $this->ips[array_rand($this->ips)]);
		curl_setopt($ch, CURLOPT_URL, $this->post_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		$result = curl_exec($ch);
		curl_close($ch);
		unset($ch);
		
		unlink($this->temp_file);
		$data_output = json_decode(gzinflate($this->decrypt(rtrim($result))), TRUE);
		// print_r($data_output);
		
		echo "\t".count($data_output)." items returned.\n";
		unset($result);
		
		return $data_output;
	}
}
?>