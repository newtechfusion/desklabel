		<footer class="footer">
			<div class="footer-bottom">
				<div class="container">
					<div class="six columns">
						Copyright 2013. Grade-Schools.com. All Rights Reserved.
					</div>
					<div class="ten columns">
						<ul class="footer-nav">
							<? foreach($this->copy->nav_links as $nav_link) : ?>
								<li><a href="<?=$nav_link['href'];?>" title="<?=$nav_link['title'];?>"><?=$nav_link['text'];?></a></li>
							<? endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</footer>
	</div>
	<link rel="stylesheet" href="//cdn.leafletjs.com/leaflet-0.4.5/leaflet.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="<?=base_url();?>js/lib.js"></script>
	<script type="text/javascript" src="<?=base_url();?>js/app.js"></script>
</body>
</html>