<?php
class Cron extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->db->close();
	}
	
	function dev_database($db_name) {
		$db_config['hostname'] = "192.168.100.230";
		$db_config['username'] = "root";
		$db_config['password'] = "starnine.com";
		$db_config['database'] = $db_name;
		$db_config['dbdriver'] = "mysql";
		$db_config['dbprefix'] = "";
		$db_config['pconnect'] = FALSE;
		$db_config['db_debug'] = TRUE;
		$db_config['cache_on'] = FALSE;
		$db_config['cachedir'] = "";
		$db_config['char_set'] = "utf8";
		$db_config['dbcollat'] = "utf8_general_ci";
		return $this->load->database($db_config, TRUE);
	}
	
	function communityguard_database(){
		$db_config['hostname'] = "192.168.100.230";
		$db_config['username'] = "root";
		$db_config['password'] = "starnine.com";
		$db_config['database'] = "community_guard";
		$db_config['dbdriver'] = "mysql";
		$db_config['dbprefix'] = "";
		$db_config['pconnect'] = FALSE;
		$db_config['db_debug'] = TRUE;
		$db_config['cache_on'] = FALSE;
		$db_config['cachedir'] = "";
		$db_config['char_set'] = "utf8";
		$db_config['dbcollat'] = "utf8_general_ci";
		return $this->load->database($db_config, TRUE);
	}
	
	function buster_cluster(){
		$db_config['hostname'] = "192.168.1.161";
		$db_config['username'] = "root";
		$db_config['password'] = "starnine.com";
		$db_config['database'] = "bms"; // FORCE DATABASE NAME SPECIFICATION
		$db_config['dbdriver'] = "mysql";
		$db_config['dbprefix'] = "";
		$db_config['pconnect'] = FALSE;
		$db_config['db_debug'] = TRUE;
		$db_config['cache_on'] = FALSE;
		$db_config['cachedir'] = "";
		$db_config['char_set'] = "utf8";
		$db_config['dbcollat'] = "utf8_general_ci";
		return $this->load->database($db_config, TRUE);
	}
	
	function busted_database(){
		$db_config['hostname'] = "192.168.2.254";
		$db_config['username'] = "sh_mugshots";
		$db_config['password'] = "ADB28B9D61791EC022E8E10B41055FBC3523CC788396B4488C0DD4D20D1871E3";
		$db_config['database'] = "sh_shared";
		$db_config['dbdriver'] = "mysql";
		$db_config['dbprefix'] = "";
		$db_config['pconnect'] = FALSE;
		$db_config['db_debug'] = TRUE;
		$db_config['cache_on'] = FALSE;
		$db_config['cachedir'] = "";
		$db_config['char_set'] = "utf8";
		$db_config['dbcollat'] = "utf8_general_ci";
		return $this->load->database($db_config, TRUE);
	}
	
	function education_database() {
		$db_config['hostname'] = "192.168.100.230";
		$db_config['username'] = "root";
		$db_config['password'] = "starnine.com";
		$db_config['database'] = "education_development";
		$db_config['dbdriver'] = "mysql";
		$db_config['dbprefix'] = "";
		$db_config['pconnect'] = FALSE;
		$db_config['db_debug'] = TRUE;
		$db_config['cache_on'] = FALSE;
		$db_config['cachedir'] = "";
		$db_config['char_set'] = "utf8";
		$db_config['dbcollat'] = "utf8_general_ci";
		return $this->load->database($db_config, TRUE);
	}
	
	function government_contracts_database() {
		$db_config['hostname'] = '192.168.100.230';
		$db_config['username'] = 'root';
		$db_config['password'] = 'starnine.com';
		$db_config['database'] = 'sh_government_contracts';
		// $db_config['database'] = 'governmentcontracts_sample';
		$db_config['dbdriver'] = 'mysql';
		$db_config['dbprefix'] = '';
		$db_config['pconnect'] = FALSE;
		$db_config['db_debug'] = TRUE;
		$db_config['cache_on'] = FALSE;
		$db_config['cachedir'] = '';
		$db_config['char_set'] = 'utf8';
		$db_config['dbcollat'] = 'utf8_general_ci';
		$db_config['swap_pre'] = '';
		$db_config['autoinit'] = TRUE;
		$db_config['stricton'] = FALSE;
		return $this->load->database($db_config, TRUE);
	}
	
	function hc_database() {
		$db_config['hostname'] = '192.168.100.230';
		$db_config['username'] = 'root';
		$db_config['password'] = 'starnine.com';
		$db_config['database'] = 'HC_HHCompare';
		$db_config['dbdriver'] = 'mysql';
		$db_config['dbprefix'] = '';
		$db_config['pconnect'] = FALSE;
		$db_config['db_debug'] = TRUE;
		$db_config['cache_on'] = FALSE;
		$db_config['cachedir'] = '';
		$db_config['char_set'] = 'utf8';
		$db_config['dbcollat'] = 'utf8_general_ci';
		$db_config['swap_pre'] = '';
		$db_config['autoinit'] = TRUE;
		$db_config['stricton'] = FALSE;
		return $this->load->database($db_config, TRUE);
	}
}

?>