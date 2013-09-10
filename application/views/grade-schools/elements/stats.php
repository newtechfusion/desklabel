<div class="sidebar-block portfolio-meta">
	<h4 class="title"><span><?=$this->domain->clean_modifier.' Stats For '.(strlen($this->copy->location_full) > 10 ? ' <br />' : '').$this->copy->location_full;?></span></h4>
	<ul class="">
		<?
			$stat_columns = array();
			$stat_columns['schools'] = 'Schools';
			$stat_columns['primary'] = 'Primary Schools';
			$stat_columns['middle'] = 'Middle Schools';
			$stat_columns['high'] = 'High Schools';
			$stat_columns['charter'] = 'Charter Schools';
			$stat_columns['magnet'] = 'Magnet Schools';
		?>
		<? foreach($stat_columns as $stat_column => $stat_name) : ?>
			<? if($this->data->stats->$stat_column) : ?>
				<li><span><b><?=number_format($this->data->stats->$stat_column);?></b> <?=$stat_name;?></span></li>
			<? endif; ?>
		<? endforeach; ?>
	</ul>
</div>