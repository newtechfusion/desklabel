<?php
class Copy extends CI_Model  {

	function __construct(){
		parent::__construct();
		$this->link_packs = array();
		$this->breadcrumbs = array();
		$this->get_random_quote();
		$this->location_full = '';
		$this->full_base_url = base_url();
	}
	
	// GEO PAGES
	function home_page(){
		$this->full_base_url	= base_url();
		$this->breadcrumbs[]	= $this->domain->clean_modifier;
	}
	
	function modifier_page(){
		$this->full_base_url	= $this->link->modifier()->href;
		$this->title			= $this->domain->clean_modifier;
		$this->desc				= "Locate ".$this->domain->clean_modifier." in your area. Browse ".$this->domain->clean_modifier." by state.";
		$this->h1				= $this->domain->clean_modifier;
		$this->breadcrumbs[]	= $this->domain->clean_modifier;
	}
	
	function state_page(){
		$this->location_full = $this->geo->data->state_full;
		$this->full_base_url = $this->link->state()->href;
		$this->_meta_copy();
		if($this->domain->modifier) : $this->breadcrumbs[] = $this->link->state(TRUE); endif;
		$this->breadcrumbs[] = clean_word($this->location_full.' '.$this->domain->clean_modifier);
	}
	
	function county_page(){
		$this->location_full = $this->geo->data->county_name.' County, '.$this->geo->data->state_full;
		$this->full_base_url = $this->link->county()->href;
		$this->_meta_copy();
		$this->breadcrumbs[] = $this->link->state();
		$this->breadcrumbs[] = clean_word($this->location_full.' '.$this->domain->clean_modifier);
	}
	
	function city_page(){
		$this->location_full = $this->geo->data->city_name.', '.$this->geo->data->state_full;
		$this->full_base_url = $this->link->city()->href;
		$this->_meta_copy();
		$this->breadcrumbs[] = $this->link->state();
		$this->breadcrumbs[] = $this->link->county();
		$this->breadcrumbs[] = clean_word($this->location_full.' '.$this->domain->clean_modifier);
	}
	
	function zip_page(){
		$this->location_full = $this->geo->data->state_full.' '.$this->geo->data->zip_code;
		$this->full_base_url = $this->link->zip()->href;
		$this->_meta_copy();
		$this->breadcrumbs[] = $this->link->state();
		$this->breadcrumbs[] = $this->link->county();
		$this->breadcrumbs[] = $this->link->city();
		$this->breadcrumbs[] = clean_word($this->location_full.' '.$this->domain->clean_modifier);
	}
	
	function school_page(){
		$this->data->school->school_name = ucstring($this->data->school->school_name);
		$this->location_full = $this->geo->data->city_name.', '.$this->geo->data->state_full;
		$this->full_base_url = $this->link->school()->href;
		$this->title = $this->data->school->school_name." in ".$this->location_full;
		$this->desc = "Statistics for ".$this->data->school->school_name.". Explore student population, average teacher salary, student-to-teacher ratios and much more for ".$this->data->school->school_name." in ".$this->location_full.".";
		$this->h1 = $this->data->school->school_name;
		$this->copy = '
			<p>
				Education is an extremely important part of life, especially for young children, which is why finding the right school is crucial.
				If you live in '.$this->location_full.' and you\'re looking for a school for your child, then you\'ve come to the right place.
				Grade-Schools.com offers valuable insight into '.strtolower($this->domain->clean_modifier).' in '.$this->location_full.'.
				We provide information such as student population, average teacher salary, student-to-teacher ratios and much more.
				Get started today by selecting a school on the map above, or select your location below.
			</p>
		';
		$this->breadcrumbs[] = $this->link->state();
		$this->breadcrumbs[] = $this->link->county();
		$this->breadcrumbs[] = $this->link->city();
		$this->breadcrumbs[] = ucstring($this->data->school->school_name);
	}
	
	// LINK PACKS
	function state_link_pack($states){
		$return = array();
		foreach($states as $state_num => $state) :
			$return[$state_num] = $this->link->state($state);
		endforeach;
		return $return;
	}
	
	function county_link_pack($counties){
		$return = array();
		foreach($counties as $county_num => $county) :
			$return[$county_num] = $this->link->county($county);
		endforeach;
		return $return;
	}
	
	function city_link_pack($cities){
		$return = array();
		foreach($cities as $city_num => $city) :
			$return[$city_num] = $this->link->city($city);
		endforeach;
		return $return;
	}
	
	function zip_link_pack($zips){
		return $this->global_copy->zip_link_pack($zips);
	}
	
	function school_link_pack($schools){
		$return = array();
		foreach($schools as $school_num => $school) :
			$return[$school_num] = $this->link->school($school);
		endforeach;
		return $return;
	}
	
	// PRIVATE FUNCTIONS
	function _meta_copy(){
		$this->title = $this->domain->clean_modifier." in ".$this->location_full;
		$this->desc = "Locate ".$this->domain->clean_modifier." in ".$this->location_full.". Explore student populations, average teacher salary, student-to-teacher ratios, and more in ".$this->location_full." ".$this->domain->clean_modifier.".";
		$this->h1 = $this->domain->clean_modifier." in ".$this->location_full;
		$this->copy = '
			<p>
				Education is an extremely important part of life, especially for young children, which is why finding the right '.rtrim(strtolower($this->domain->clean_modifier),'s').' is crucial.
				If you live in '.$this->location_full.' and you\'re looking for a '.rtrim(strtolower($this->domain->clean_modifier),'s').' for your child, then you\'ve come to the right place.
				Grade-Schools.com offers valuable insight into '.strtolower($this->domain->clean_modifier).' in '.$this->location_full.'.
				We provide information such as student population, average teacher salary, student-to-teacher ratios and much more.
				Get started today by selecting a '.rtrim(strtolower($this->domain->clean_modifier),'s').' on the map above, or select your location below.
			</p>
		';
	}
	
	// MISC
	function get_random_quote(){
		$quotes = array();
		$quotes[] = array('Albert Einstein',	'Education is what remains after one has forgotten what one has learned in school.');
		$quotes[] = array('George Santayana',	'A child educated only at school is an uneducated child.');
		$quotes[] = array('Abraham Lincoln',	'The philosophy of the school room in one generation will be the philosophy of government in the next.');
		$quotes[] = array('Emo Philips',		'You don\'t appreciate a lot of stuff in school until you get older. Little things like being spanked every day by a middle-aged woman: Stuff you pay good money for in later life.');
		$quotes[] = array('Quentin Tarantino',	'When people ask me if I went to film school I tell them, \'no, I went to films.\'');
		$quotes[] = array('Sandra Cisneros',	'I always tell people that I became a writer not because I went to school but because my mother took me to the library. I wanted to become a writer so I could see my name in the card catalog.');
		$quotes[] = array('Janet Napolitano',	'Today in America, we are trying to prepare students for a high tech world of constant change, but we are doing so by putting them through a school system designed in the early 20th Century that has not seen substantial change in 30 years.');
		$quotes[] = array('Mahatma Gandhi',		'Live as if you were to die tomorrow. Learn as if you were to live forever.');
		$quotes[] = array('Mark Twain',			'I have never let my schooling interfere with my education.');
		$quotes[] = array('Oscar Wilde',		'You can never be overdressed or overeducated.');
		$quotes[] = array('Nelson Mandela',		'Education is the most powerful weapon which you can use to change the world.');
		$quotes[] = array('Walter Cronkite',	'Whatever the cost of our libraries, the price is cheap compared to that of an ignorant nation.');
		$quotes[] = array('Robert Frost',		'Education is the ability to listen to almost anything without losing your temper or your self-confidence.');
		$quotes[] = array('Maya Angelou',		'When you know better you do better.');
		$quotes[] = array('C.S. Lewis',			'Education without values, as useful as it is, seems rather to make man a more clever devil.');
		$quotes[] = array('Jim Henson',			'[Kids] don\'t remember what you try to teach them. They remember what you are.');
		$quotes[] = array('Leonardo da Vinci',	'Study without desire spoils the memory, and it retains nothing that it takes in.');
		$quotes[] = array('G.K. Chesterton',	'Without education, we are in a horrible and deadly danger of taking educated people seriously.');
		$quotes[] = array('Bill Watterson',		'You know, sometimes kids get bad grades in school because the class moves too slow for them. Einstein got D\'s in school. Well guess what, I get F\'s!!!');
		$quotes[] = array('Margaret Mead',		'Children must be taught how to think, not what to think.');
		$quotes[] = array('Confucius',			'It does not matter how slowly you go as long as you do not stop.');
		$quotes[] = array('Malcolm X',			'Education is our passport to the future, for tomorrow belongs to the people who prepare for it today.');
		$quotes[] = array('Aristotle',			'Educating the mind without educating the heart is no education at all.');
		$quotes[] = array('Henry Ford',			'Anyone who stops learning is old, whether at twenty or eighty. Anyone who keeps learning stays young.');
		$quotes[] = array('W.B. Yeats',			'Education is not the filling of a pail, but the lighting of a fire.');
		$quotes[] = array('Phil Collins',		'In learning you will teach, and in teaching you will learn.');
		$quotes[] = array('Socrates',			'Education is the kindling of a flame, not the filling of a vessel.');
		$quotes[] = array('Brigham Young',		'Education is the power to think clearly, the power to act well in the world\'s work, and the power to appreciate life.');
		$quotes[] = array('Oscar Wilde',		'Nothing that is worth knowing can be taught.');
		$quotes[] = array('Albert Einstein',	'Wisdom is not a product of schooling but of the lifelong attempt to acquire it.');
		$quotes[] = array('Jacques Barzun',		'Teaching is not a lost art, but the regard for it is a lost tradition.');
		$quotes[] = array('Eleanor Roosevelt',	'All of life is a constant education.');
		$quotes[] = array('Will Durant',		'Education is a progressive discovery of our own ignorance.');
		$quote = $quotes[array_rand($quotes)];
		$this->quote = new stdClass();
		$this->quote->author = $quote[0];
		$this->quote->message = $quote[1];
	}
}
?>