<div class="tab tab-bordered">
	<ul class="tab-nav">
		<? $temp_link_pack_count = 0; ?>
		<? foreach($this->copy->link_packs as $link_pack_title => $link_pack) : ?>
			<li <?=(!$temp_link_pack_count++ ? 'class="active"' : '');?>><a href="#<?=$link_pack_title;?>" data-toggle="tab"><?=ucstring(make_slug($link_pack_title,' '));?></a></li>
		<? endforeach; ?>
	</ul>
	<div class="tab-content link_pack">
		<? $temp_link_pack_count = 0; ?>
		<? foreach($this->copy->link_packs as $link_pack_title => $link_pack) : ?>
			<div id="<?=$link_pack_title;?>" class="tab-pane <?=(!$temp_link_pack_count++ ? 'active' : '');?>">
				<ul class="arrow-list">
					<? foreach($link_pack as $link_num => $link) : ?>
						<? if($link_num == floor((count($link_pack) + 1) / 2)) : ?></ul><ul class="arrow-list"><? endif; ?>
						<li><a href="<?=$link->href;?>" title="<?=$link->title;?>"><?=$link->text;?></a></li>
					<? endforeach; ?>
				</ul>
				<br class="clear" />
			</div>
		<? endforeach; ?>
	</div>
</div>