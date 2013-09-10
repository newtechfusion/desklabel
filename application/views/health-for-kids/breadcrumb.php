<ul class="breadcrumb crumb">
				<li><a href="<?php base_url();?>">Home</a><span class="divider">&raquo;</span></li>
				<?php  if (isset($this->breadcrumb)) : ?>
					<?php 
					
					foreach ($this->breadcrumb as $breadcrumb): ?>
						<?php  if (isset($breadcrumb['href'])){?>
							<li><a href="<?php echo $breadcrumb['href'];?>"><?php echo ucfirst(clean($breadcrumb['text'],false));?></a><span class="divider">&raquo;</span></li>
						<?php }else{ ?>
							<li class="active"><?php echo ucfirst(clean($breadcrumb['text'],false)); ?></li>
						<?php  } ?>
					<?php  endforeach; ?>
				<?php  endif; ?>
</ul>