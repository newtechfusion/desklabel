<div class="row-fluid page_title">
        <div class="container">
            <div class="span12">
                <h1 class="title_size">
				<?php 	
					  $text=abbr(FALSE);echo ucwords($text[0]);
					  $urltext=ucwords(implode(' ',$text)).' in ';
				?>
                <?=ucwords($text[1])?>
                </h1>
                 <h2 class="title_desc">
					 <?php $this->load->view('breadcrumb'); ?>
				</h2>
            </div>
        </div>

        <div class="row-fluid divider base_color_background">
            <div class="container">
                <span class="bottom_arrow"></span>
            </div>
        </div>

    </div>
    
    <div class="container shadow">
		<span class="bottom_shadow_full"></span>
	</div>

<div class="container">
  <div class="row-fluid distance_1">
    <div class="span12">
      <div class="row-fluid sc-col">
        <div class="row-fluid">
          <div class="span12">
            <div class="recent_title">
              <h1><?php  echo $this->lang->line('find').ucfirst(str_replace('-',' ',segment())).$this->lang->line('area')?></h1>
             
            	</div>
            	<span class="row-fluid separator_border">
               <div class="row-fluid" >
                	<?php $count=0;
					foreach( _flipState() as $sort=>$state): 
					if($count==15 || $count==0) {echo '<ul class="span3">';}
					echo '<li>'.anchor(str_replace(' ','-',$sort).'/'.segment(),ucfirst(str_replace('-',' ',segment())).' in '.ucfirst($sort)).'</li>';?>
			  		<?php  $count++;if($count==15){$count=0; echo '</ul>';};endforeach ?>
					</div>
                </span> 
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
