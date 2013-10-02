<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

function modifiers(){return array('elementary-schools','middle-schools','high-schools');}
$modifier	= '[\/]?('.str_replace(' ', '-', implode('|',modifiers())).')?';
$list= '[\/]?('.str_replace(' ', '-', implode('|',goforlist())).')?';

$state		= '('.str_replace(' ', '-', implode('|',state_array())).')';
$slug		= '([a-z0-9-]+)';
$any		= '([a-z0-9-]+)';
$number		= '([0-9]+)';

$route['default_controller']	                = "main/home";
$route['404_override']			              = "main/error";

$route['contact']				               = "main/contact";

$route['healthy-at-home']   			        = "main/healthyathome";
$route['obesity-factor']   				        = "main/obesityfactor";
$route['meal-for-family']   				    = "main/mealforfamily";
$route['nutrition-traps']   				    = "main/nutritiontrap";
$route['healthy-day-care']   				    = "main/healthydaycare";


$route['obesityfactor']   			            = "main/obesityfactor";
$route['playground']   				            = "main/playground";
$route['healthy-habit-resources']   		    = "main/resource";
$route['teaching-habits']   		            = "main/teaching_habits";

$route['stay-healthy-in-summer']   				= "main/summer";       
$route['share-tips']   				            = "main/share_tips";
$route['birthday-party']   				        = "main/birthdayparty";

$route['rainyday']   							= "main/rainyday";       
$route['nutrition']   				            = "main/nutrition";
$route['bmi']   				                = "main/bmi";
$route[$state.'/'.$slug.'-county/'.$list]	    = "mlist/citiesincounty";
$route[$modifier]							    = "main/modifier/$1";
$route[$list]								    = "mlist";
$route[$state.'/'.$list]					    = "mlist/city";
$route[$state.'/'.$slug.'/'.$list]		        = "mlist/geo/$1/$2/$3";
$route[$state.'/(:any)/'.$list.'/(:any)']		= "mlist/detail/$1/$2/$3/$4/$5";
$route[$state.$modifier]						= "main/state/$1/$2";

$route[$state.'/'.$number.$modifier]			= "main/zip/$1/$2/$3";
$route[$state.'/'.$slug.$modifier]				= "main/city/$1/$2/$3";
$route[$state.'/'.$slug.'/'.$slug.'/'.$number]	= "main/school/$1/$2/$3/$4";


/* End of file routes.php */
/* Location: ./application/config/routes.php */