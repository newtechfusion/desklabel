<?php
class Html extends CI_Model {

	function __construct(){
		parent::__construct();
		include_once('./application/libraries/simple_html_dom.php');
	}
}

?>