<?php
class Health_for_kids extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->model(DOMAIN.'/data');
		$this->load->model(DOMAIN.'/link');
		$this->load->model(DOMAIN.'/map');
		$this->modifiers = modifiers();
		$this->default_modifier = FALSE;
		$this->modifier = $this->default_modifier;
		$this->default_clean_modifier = "Schools";
		$this->clean_modifier = $this->default_clean_modifier;
		$this->pagination_headers = FALSE;
		$this->school_level_clause = '';
	}
	
	function set_modifier($modifier=NULL){
		if(isset($modifier) && $modifier) : 
			$this->modifier = $modifier;
			$levels['high-schools'] = 3;
			$levels['middle-schools'] = 2;
			$levels['elementary-schools'] = 1;
			$this->clean_modifier = ucstring(make_slug($modifier, ' '));
			$this->school_level_clause = "`level` = ".$levels[$this->modifier];
			// $this->query->county_inner_query .= " AND c.".$temp_columns[$this->modifier]." > 0";
			// $this->query->city_inner_query .= " AND c.".$temp_columns[$this->modifier]." > 0";
			// $this->map->modifier_conditional = $this->domain->modifier && $this->domain->modifier ? "AND modifier = '".$this->domain->modifier."'" : "";
			// // $this->query->modifier_conditional = " AND n.commod_group LIKE '%".str_replace('_mines', '', make_slug($this->clean_modifier, '_'))."%'";
		endif;
	}
}

?>