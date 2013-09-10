<div class="sidebar-block portfolio-meta">
	<h4 class="title"><span><?=$this->domain->clean_modifier.' Stats';?></span></h4>
	<ul class="">
		<?
			$stat_columns = array();
			$stat_columns['schools'] = $this->domain->clean_modifier;
			$stat_columns['students'] = 'Students';
			$stat_columns['teachers'] = 'Teachers';
		?>
		<? foreach($stat_columns as $stat_column => $stat_name) : ?>
			<? if($this->data->stats->$stat_column) : ?>
				<li><span><b><?=number_format($this->data->stats->$stat_column);?></b> <?=$stat_name;?></span></li>
			<? endif; ?>
		<? endforeach; ?>
	</ul>
</div>