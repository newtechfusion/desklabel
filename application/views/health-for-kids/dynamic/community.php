<div id="contain">
  <div class="row-fluid page_title">
    <div class="container">
      <div class="span12 text-center">
        <h1 class="title_size">
          <?php $text=abbr(FALSE);
		  		echo $heading=ucwords(implode(' ',$text).' In '.abbr().','.ucfirst(segment())) ;
		  		$urltext=implode(' ',$text);
		  ?>
        </h1>
        <h2 class="title_desc">
          <?php $this->load->view('breadcrumb'); ?>
        </h2>
      </div>
    </div>
    <div class="row-fluid divider base_color_background">
      <div class="container"> <span class="bottom_arrow"></span> </div>
    </div>
  </div>
  <div class="container shadow"> <span class="bottom_shadow_full"></span> </div>
  <div class="container" > 
    <script>

 jQuery(document).ready(function() { 
	var options = {
            currentPage:1,
            totalPages:<?php echo ceil(($items/10)-1)?>,
			numberOfPages:10,
			alignment:'center',
            onPageClicked: function(e,originalEvent,type,page){
				if(options.currentPage!=page)
				{
					load_result((page-1)*10,'geo');
				}
				options.currentPage=page;
              },
			bootstrapTooltipOptions: {
                html: true,
                placement: 'bottom'
            }
			
		 }

      jQuery('#pagination').bootstrapPaginator(options);
	  
function load_result(index,callable) {
	  index = index || 0;
	  callable=callable||null;
  	  jQuery.post(window.href,{ajax:true,name:callable,value:index},function(data) {
	  		
			jQuery('#viewcontainer').html('');
  			jQuery('#viewcontainer').html(data.results);
	  },"json");
  }


});

</script>
    <div class="row-fluid distance_1">
      <div class="span12">
        <div class="row-fluid sc-col">
          <div class="row-fluid">
            <div class="recent_title span12">
              <?php  echo $this->lang->line('find').$heading ?>
              <span class="span12 border_separator"> </span></div>
            <span class="row-fluid separator_border" >
            <div class="row-fluid">
              <div id="viewcontainer">
                <?php 
                        $count=0;
						if(!empty($data)){
                        foreach($data as $agency):
                        if($count==$partition|| $count==0) echo '<div class="span6">';
				 ?>
                <div class="border-box">
                  <h5>
                  	<a href="<?php echo $_SERVER['REQUEST_URI'].'/'.clean($agency['name']).'/'.$agency['id']?>">
				  		<?php echo clean($agency['name'],TRUE,'-',' ')?>
                 	 </a>
                  </h5>
                  <p> <b>Address:</b><span class="agency_address"><?php echo $agency['address']?></span><br>
                    <b>Phone:</b><span><?php echo $agency['phone']?></span> </p>
                </div>
                <?php 	
                        $count++;
						$closing=FALSE;
                        if($count==$partition){$count=0; echo '</div>'; $closing=true;}
                        endforeach;
						if(!$closing) echo '</div>';
						
						  echo '</div></div><div class="row-fluid span12" id="pagination"></div>';
						  
						}else{echo "<H4>Sorry No ".ucwords(implode(' ',abbr(FALSE)))." Found IN ".ucfirst(abbr())."</H4>";}
            ?>
                </span>
                <ul  class="nav nav-tabs">
                  <li id="cities" class="active"><a data-toggle="tab" tabindex="-1" href="#nearby_cities">
                    <?=$this->lang->line('nearcity')?>
                    </a></li>
                  <li id="counties"><a data-toggle="tab" href="#nearby_counties">
                    Counties In <?php echo ucfirst(segment())?> 
                    </a></li>
                </ul>
                <div class="row-fluid">
                  <div class="tab-content link_pack">
                    <div id="nearby_cities" class="tab-pane active">
                      <ul class="near_by">
                        <?php
						$match=FALSE;
						$citymatch=FALSE;
						$countymatch=FALSE;
						
						foreach ($nearcitypack as $near):
						if(in_array(upc($near->city_name),$allcity)){
						 $clean= preg_replace('/[^A-Za-z0-9\-]/', ' ',$near->city_name);
					     $clean=str_replace(array('',' ',NULL),'-',$near->city_name); 
						$match=TRUE;
						echo '<li>'.anchor(segment().'/'.strtolower($clean).'/'.implode('-',abbr(false)),
						ucwords($near->city_name).', '.$near->state_abbr.' '.$urltext).'</li>';
						}
						endforeach;
						echo '</ul></div><div id="nearby_counties" class="tab-pane"><ul class="near_by">';
						if(!$match){echo'<script type="text/javascript"> ex();</script>';$citymatch=TRUE;}
						$match=FALSE;
						$countslug=array();
						foreach ($counties as $county):
						if(!in_array($county['slug'],$countslug)){
						$countslug[]=$county['slug'];
						if(in_array(upc($county['city_name']),$allcity)){
						$match=TRUE;
				        echo '<li>'.anchor($county['slug'].'/'.$county['county_slug'].'-county/'.implode('-',abbr(false)),
						ucwords($county['name'].' County'.', '.$county['code'].' '.$urltext)).'</li>';
						 }
						}
						endforeach;
						unset($countslug);
						if(!$match){echo'<script type="text/javascript"> hidecountiestab();</script>';$countymatch=TRUE;}
						
						if($citymatch && $countymatch) echo'<script type="text/javascript"> hidetab();</script>';
                  ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
