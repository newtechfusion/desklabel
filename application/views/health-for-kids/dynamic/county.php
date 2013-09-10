<div id="contain">
  <div class="row-fluid page_title">
    <div class="container">
      <div class="span12 text-center">
        <h1 class="title_size">
          <?php $text=abbr(FALSE);
		  		echo $heading=ucwords(implode(' ',$text).' In '.str_replace('-',' ',segment(2)).','.ucfirst(segment())) ;
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
					load_result(page*10,'geo');
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
            <div class="span12">
              <div class="recent_title span12">
                <?php  echo $this->lang->line('find').$heading ?>
                <span class="span12 border_separator"> </span> </div>
              <span class="row-fluid separator_border">
              <div class="row-fluid" >
                <?php $this->load->view('breadcrumb'); ?>
              </div>
              <div class="row-fluid" >
                <div id="viewcontainer">
                  <?php 
                        $count=0;
						if(!empty($data)){
                        foreach($data as $agency):
                        if($count==$partition|| $count==0) echo '<div class="span6">';
						
             ?>
                  <div class="border-box">
                    <h4><a href="<?php echo $_SERVER['REQUEST_URI'].'/'.clean($agency['name']).'/'.$agency['id']?>"><?php echo $agency['name']?></a></h4>
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
						  
						}else{echo $this->lang->line('dont');}
            ?>
                </div>
                </span>
                <ul class="nav nav-tabs">
                  <li class="active" id="cities"><a data-toggle="tab" href="#nearby_cities">Cities In
                    <?=ucwords(str_replace('-',' ',segment(2)))?>
                    </a></li>
                  <li id="counties"><a data-toggle="tab" href="#nearby_counties">NearbyCounties</a></li>
                </ul>
                <div class="row-fluid">
                  <div class="tab-content link_pack">
                    <div id="nearby_cities" class="tab-pane active">
                      <ul class="near_by">
                        <?php 
						$count=0;
						$match=FALSE;
						foreach($this->allcontent as $city): 
						if(in_array($city,$this->data['allcity'])){
						$match=TRUE;
						 $clean= preg_replace('/[^A-Za-z0-9\-]/', ' ',$city);
					     $clean=str_replace(array('',' ',NULL),'-',strtolower($clean)); 
						echo '<li>'.anchor(segment().'/'.$clean.'/'.implode('-',abbr(false)),ucwords($city.', '._stateToShort(segment()).' '.$urltext)).'</li>';
						}
						endforeach; 
						echo '</ul></div><div id="nearby_counties" class="tab-pane"><ul class="near_by">';
						foreach ($this->data['nearconunties'] as $county):
						echo '<li>'.anchor($county->state_slug.'/'.$county->county_slug.'-county/'.implode('-',abbr(false)),
						ucwords($county->county_name.' County, '.$county->state_abbr.' '.$urltext)).'</li>';
						$count++;	
						endforeach;
						if(!$match)echo'<script type="text/javascript"> ex();</script>';
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
</div>
</div>
