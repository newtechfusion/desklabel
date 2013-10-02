<?php 

function _flipState($string=TRUE){
			//$string = strtolower(str_replace('-', ' ', $string));
			
			$short_to_state = array('al'=>'alabama','ak'=>'alaska','az'=>'arizona','ar'=>'arkansas','ca'=>'california','co'=>'colorado','ct'=>'connecticut',
				'de'=>'delaware','dc'=>'district of columbia','fl'=>'florida','ga'=>'georgia','hi'=>'hawaii','id'=>'idaho','il'=>'illinois','in'=>'indiana',
				'ia'=>'iowa','ks'=>'kansas','ky'=>'kentucky','la'=>'louisiana','me'=>'maine','md'=>'maryland','ma'=>'massachusetts','mi'=>'michigan','mn'=>'minnesota',
				'ms'=>'mississippi','mo'=>'missouri','mt'=>'montana','ne'=>'nebraska','nv'=>'nevada','nh'=>'new hampshire','nj'=>'new jersey','nm'=>'new mexico',
				'ny'=>'new york','nc'=>'north carolina','nd'=>'north dakota','oh'=>'ohio','ok'=>'oklahoma','or'=>'oregon','pa'=>'pennsylvania','pr'=>'puerto rico','ri'=>'rhode island',
				'sc'=>'south carolina','sd'=>'south dakota','tn'=>'tennessee','tx'=>'texas','ut'=>'utah','vt'=>'vermont','va'=>'virginia','wa'=>'washington',
				'wv'=>'west virginia','wi'=>'wisconsin','wy'=>'wyoming');
			if($string):
				return  array_flip($short_to_state);
			else: 
				return  $state_to_short;
			endif;
			
}

function _stateToShort($string){
			//$string = str_replace('_',' ',strtolower($string));
			$state_to_short = array('alabama'=>'al','alaska'=>'ak','arizona'=>'az','arkansas'=>'ar','california'=>'ca','colorado'=>'co',
				'connecticut'=>'ct','delaware'=>'de','district of columbia'=>'dc','florida'=>'fl','georgia'=>'ga','hawaii'=>'hi','idaho'=>'id',
				'illinois'=>'il','indiana'=>'in','iowa'=>'ia','kansas'=>'ks','kentucky'=>'ky','louisiana'=>'la','maine'=>'me','maryland'=>'md',
				'massachusetts'=>'ma','michigan'=>'mi','minnesota'=>'mn','mississippi'=>'ms','missouri'=>'mo','montana'=>'mt','nebraska'=>'ne',
				'nevada'=>'nv','new hampshire'=>'nh','new jersey'=>'nj','new mexico'=>'nm','new york'=>'ny','north carolina'=>'nc',
				'north dakota'=>'nd','ohio'=>'oh','oklahoma'=>'ok','oregon'=>'or','pennsylvania'=>'pa','rhode island'=>'ri','south carolina'=>'sc',
				'south dakota'=>'sd','tennessee'=>'tn','texas'=>'tx','utah'=>'ut','vermont'=>'vt','virginia'=>'va','washington'=>'wa',
				'west virginia'=>'wv','wisconsin'=>'wi','wyoming'=>'wy');
			if(isset($state_to_short[$string]))
				return $state_to_short[$string];
			else
				return $string;
		}
		
		
function shotcodes($abbr=NULL){
				$state_abbr_list = array('al','ak','az','ar','ca','co','ct','de','dc',
					'fl','ga','hi','id','il','in','ia','ks','ky','la','me','md','ma',
					'mi','mn','ms','mo','mt','ne','nv','nh','nj','nm','ny','nc','nd',
					'oh','ok','or','pa','ri','sc','sd','tn','tx','ut','vt', 'va','wa','wv','wi','wy');
					
}

function _containsState($string=NULL){
			//$string = strtolower(str_replace('-', ' ', $string));
			$state_list = array('alabama','alaska','arizona','arkansas','california','colorado','connecticut',
				'delaware','district of columbia','florida','georgia','hawaii','idaho','illinois','indiana',
				'iowa','kansas','kentucky','louisiana','maine','maryland','massachusetts','michigan',
				'minnesota','mississippi','missouri','montana','nebraska','nevada','new hampshire','new jersey',
				'new mexico','new york','north carolina','north dakota','ohio','oklahoma','oregon','pennsylvania',
				'rhode island','south carolina','south dakota','tennessee','texas','utah','vermont', 
				'west virginia','virginia','washington','wisconsin','wyoming');
			return $state_list;
}

function text($str=NULL,$upc=FALSE,$modifier='-',$replace=' ')
{
	if(is_string($str) && !empty($str))  
	{
		$string=str_replace($modifier,$replace,$str);
		if($upc) $string=ucwords($string);
		return $string;
	}
}
function bradcrumburl($s,$a,$c=NULL)
{
	$url=base_url().$s.'/';
    if(!empty($c)) $url.=$c.'/';
	$url.=$a;
	return $url;
}
function segment($part=NULL){
	 $CI =& get_instance(); 
	 $segment=$CI->uri->segment_array();
	 if(empty($part)) return $segment[1]; 
	return  $explode=$segment[$part];
	
	 
	}
function abbr($abbr=TRUE){
	$CI =& get_instance(); 
	$segment=$CI->uri->segment_array();
	if(count($segment)>3) unset($segment[count($segment)]); 
	@$array=explode('-',$segment[count($segment)-1]);
	if($abbr) return  end($array);
	$array=explode('-',$segment[count($segment)]);
	return $array;
	
	}
function clean($str=NULL,$upc=FALSE,$modifier=' ',$replace='-'){
	 if(is_string($str) && !empty($str))  
	{
		$str=preg_replace('/[^" "A-Za-z0-9\-]/','',$str);
		$string=str_replace($modifier,$replace,$str);
		if($upc):
			$string=ucwords($string);
		else:
			$string=strtolower($string);
		endif;
		
		return $string;
	}
	}
	
function upc($str){
	 return(strtoupper($str));
	}
	