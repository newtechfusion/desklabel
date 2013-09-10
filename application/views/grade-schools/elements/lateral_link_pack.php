<div class="row">
	<div class="title"><span>Browse Schools <?=($this->copy->location_full ? 'in '.$this->copy->location_full : '');?> by Grade</span></div>
	<div class="portfolio-items carousel clearfix">
		<? $images = array(); ?>
		<? $images['elementary-schools'] = 'school_bus'; ?>
		<? $images['middle-schools'] = 'apple'; ?>
		<? $images['high-schools'] = 'class'; ?>
		<? foreach(modifiers() as $modifier_num => $modifier) : ?>
			<? $photos = array('child','field','mask','tongue'); ?>
			<div class="one-third column portfolio-item web-design">
				<img src="<?=base_url();?>css/img/<?=$images[$modifier];?>.jpg" alt="" style="width: 300px; height: 125px;">
				<div class="item-info">
					<h5 class="item-title">
						<a href="<?=rtrim(str_replace($this->domain->modifiers, '', $this->copy->full_base_url), '/').'/'.make_slug($modifier);?>"><?=ucstring(make_slug($modifier,' '));?></a>
					</h5>
					<span class="item-tags"><?=$this->copy->location_full.' '.ucstring(make_slug($modifier,' '));?></span>
				</div>
			</div>
		<? endforeach; ?>
	</div>
</div>