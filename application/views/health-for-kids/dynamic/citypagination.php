<?php
	$text=abbr(FALSE);
	$urltext=ucwords(implode(' ',$text)).' in ';
	 foreach($cities as $city):
	  	$clean= preg_replace('/[^A-Za-z0-9\-]/', ' ',$city['city']);
	  	$clean=str_replace(array('',' ',NULL),'-',$clean);  
		echo '<li>'.anchor(abbr().'/'.strtolower($clean).'/'.implode('-',abbr(false)),$urltext.ucfirst($city['city'])).'</li>';
	 endforeach; 
?>