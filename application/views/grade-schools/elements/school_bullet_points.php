<div class="row left_half">
	<?
		$list_values = array();
		$list_values['Total Students'] = $this->data->school->students;
		if($this->data->school->teachers > 0) : 
			$list_values['Total Teachers'] = $this->data->school->teachers;
		endif;
		if(count($this->data->teacher_compensation)) : 
			$list_values['Average Teacher Experience'] = $this->data->teacher_compensation->average_experience.' years';
			$list_values['Average Teacher Salary'] = '$'.number_format($this->data->teacher_compensation->average_salary);
		endif;
	?>
	<ul class="arrow-list">
		<? foreach($list_values as $list_value_name => $list_value) : ?>
			<? if(preg_replace('/[^\d]/', '', $list_value)) : ?>
				<li><b><?=$list_value_name;?></b> : <span><?=$list_value;?></span></li>
			<? endif; ?>
		<? endforeach; ?>
	</ul>
</div>