<?php
class Email extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	function basic($to, $subject, $body, $reply=''){
		$headers = 'MIME-Version: 1.0'.PHP_EOL;
		$headers .= 'Content-type: text/plain; charset=iso-8859-1'.PHP_EOL;
		$headers .= 'From: Jeff Chambers <jeff@propertymaps.com>'.PHP_EOL;
		$headers .= 'Reply-To: '.$reply;
		mail($to, $subject, $body, $headers);
	}
}
?>