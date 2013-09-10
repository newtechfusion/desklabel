<div class="row">
	<div class="title"><span>Grades Offered</span></div>
	<? $grades = array('PK','KG','1','2','3','4','5','6','7','8','9','10','11','12'); ?>
	<div class="grades_offered">
		<ul>
			<? foreach($grades as $grade) : ?>
				<li <?=(isset($this->data->grades[$grade]) ? 'class="active"' : '')?>><span><?=$grade;?></span></li>
			<? endforeach; ?>
		</ul>
	</div>
</div>