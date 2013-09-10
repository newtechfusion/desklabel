<div class="row top_schools">
	<div class="title"><span>Largest <?=$this->domain->clean_modifier;?> in <?=$this->copy->location_full;?></span></div>
	<ul class="arrow-list">
		<? foreach($this->data->schools as $link) : ?>
			<li><a href="<?=$link->href;?>" title="<?=$link->title;?>"><?=$link->text;?></a></li>
		<? endforeach; ?>
	</ul>
</div>
<div class="clear"></div>