<div class="page-header">
	<div class="container">
		<div class="sixteen columns">
			<h1 class="page-title"><?=$this->copy->h1;?></h1>
			<ul class="breadcrumb">
				<li><a href="<?=base_url();?>">Home</a><span class="divider">&raquo;</span></li>
				<? if (isset($this->copy->breadcrumbs)) : ?>
					<?
					
					foreach ($this->copy->breadcrumbs as $breadcrumb): ?>
						<? if (isset($breadcrumb->href)): ?>
							<li><a href="<?=$breadcrumb->href;?>" title="<?=$breadcrumb->title;?>"><?=$breadcrumb->text;?></a><span class="divider">&raquo;</span></li>
						<? else: ?>
							<li class="active"><?= $breadcrumb ?></li>
						<? endif; ?>
					<? endforeach; ?>
				<? endif; ?>
			</ul>
		</div>
	</div>
</div>