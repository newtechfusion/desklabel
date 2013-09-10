<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


    function get_marker_info()
    {
		$args=func_get_args();
		$keys=array_keys($args[0]);
		$marker['position']=$args[0][$keys[1]];
		$marker['infowindow_content'] ='<h6>'.$args[0][$keys[3]].'</h6>'.'<p>'.$args[0][$keys[2]].','.$args[0][$keys[0]].'</p>'.'<b>Phone:</b>'.
		$args[0][$keys[4]];
		$marker['animation']="BOUNCE";
        return $marker;
    }   

 function make_map_stylish()
 	 {
		$config['zoom'] = 'auto';
		$config['styles'] = array(
		
		   array("name"=>"Red Parks", "definition"=>array(
				 array("featureType"=>"all", "stylers"=>array(array("saturation"=>"50","bgcolor"=>"#F26522"))),
				 array("featureType"=>"poi.park", "stylers"=>array(array("saturation"=>"10"), array("hue"=>"#990000")))
		   )),
		   array("name"=>"Black Roads", "definition"=>array(
				 array("featureType"=>"all", "stylers"=>array(array("saturation"=>"-70"))),
				 array("featureType"=>"road.arterial", "elementType"=>"geometry", "stylers"=>array(array("hue"=>"#000000")))
		  )),
		  array("name"=>"No Businesses", "definition"=>array(
				 array("featureType"=>"poi.business", "elementType"=>"labels", "stylers"=>array(array("visibility"=>"off")))
		   ))
		);
		$config['stylesAsMapTypes']=true;
		$config['stylesAsMapTypesDefault']="Black Roads"; 
		$config['streetViewPovHeading'] =90;
		return $config;
 	}
	
 function centralize_map($address=NULL)
    {	
		$center='952 Cordova Street, Anchorage, AK';
		if(!empty($address)) $center=$address;
		return $center; 
	}
 function map_types()
 	{
		return  array("HYBRID", "ROADMAP","SATELLITE","TERRAIN","STREET");	
	}	
	
 function related()
 	{
		/*$config['panoramio'] = TRUE;
		$config['panoramioTag'] = 'sunset';
		$config['directions'] = TRUE;
		$config['directionsStart'] = '750 D Street, Anchorage, AK';
		$config['directionsEnd'] = '7011 Old Seward Highway, Anchorage, AK';
		$config['directionsDivID'] = 'directionsDiv';
		//$marker['draggable'] = TRUE;
        //$marker['icon']=$icon;
		//$marker['title']=;
		*/
	
	}