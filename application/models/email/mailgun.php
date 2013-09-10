<?php
	class Mailgun extends CI_Model  {
	
	    function __construct(){
			parent::__construct();
		}
		
		function send($to, $from, $subject, $text, $html){
			if(ENVIRONMENT == 'development'):
				echo "\n\nYou are currently in development mode and should not be sending emails... Nothing was sent to {$to}.\nThis message originated from /application/models/email/mailgun.php\n\n";
			else:
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD, 'api:'.MAILGUN_API_KEY);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_URL, MAILGUN_API_URL);
				curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => $from,
														 'to'		=> $to,
														 'subject'	=> $subject,
														 'text'		=> $text,
														 'html'		=> $html,
														 )
				);
				$result = curl_exec($ch);
				curl_close($ch);
			endif;
		}
	}
?>