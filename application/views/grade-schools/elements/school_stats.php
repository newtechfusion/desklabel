<div class="row">
	<div class="title"><span>School Stats</span></div>
	<?
		$desired_stats = array();
		$desired_stats['bachelor_degree'] = 'Teachers With Only A Bachelors Degree';
		$desired_stats['advanced_degree'] = 'Teachers With Only A Masters or Doctorate';
		$desired_stats['experience_one_to_five'] = 'Teachers With 5 Years or Less Experience';
		$desired_stats['experience_more_than_five'] = 'Teachers With More than 5 Years of Experience';
	?>
	<? foreach($desired_stats as $desired_stat => $desired_stat_name) : ?>
		<? if($this->data->teacher_compensation->$desired_stat > 0) : ?>
			<div class="skill" data-percent="<?=$this->data->teacher_compensation->$desired_stat;?>">
				<div class="label"><?=$desired_stat_name;?><span><?=$this->data->teacher_compensation->$desired_stat;?>%</span></div>
				<div class="bar">
					<div class="inner" style="width: <?=$this->data->teacher_compensation->$desired_stat;?>%;"></div>
				</div>
			</div>
		<? endif ;?>
	<? endforeach; ?>
</div>