<ul class="breadcrumb crumb">
				<li><a href="<?php echo base_url();?>">Home</a><span class="divider">&raquo;</span></li>
				<?php if (isset($this->breadcrumb)) : ?>
					<?php
					//echo '<pre>';print_r($this->breadcrumb);die; 
					foreach ($this->breadcrumb as $breadcrumb): ?>
						<?php if (isset($breadcrumb['href'])): ?>
							<li><a href="<?php echo $breadcrumb['href'];?>"><?php echo $breadcrumb['text'];?></a><span class="divider">&raquo;</span></li>
						<?php else: ?>
							<li class="active"><?php echo $breadcrumb['text'] ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
</ul>