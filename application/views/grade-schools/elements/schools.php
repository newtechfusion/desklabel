<div class="row pagination_schools">
	<div class="title"><span>Schools in <?=$this->copy->location_full;?></span></div>
	<ul class="arrow-list">
		<? foreach($this->data->schools as $link_num => $link) : ?>
			<? if($link_num == floor((count($this->data->schools) + 1) / 2)) : ?></ul><ul class="arrow-list"><? endif; ?>
			<li><a href="<?=$link->href;?>" title="<?=$link->title;?>"><?=$link->text;?></a></li>
		<? endforeach; ?>
	</ul>
</div>
<div class="clear"></div>