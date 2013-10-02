<div id="contain">
<div class="row-fluid page_title">
  <div class="container">
    <div class="span12">
      <h1 class="title_size">
        <?php   $text=abbr(FALSE);echo ucwords($text[0]);
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
                placement: 'bottom',
				itemContainerClass:'pointer-cursor'
				
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
  <?php  echo ucwords(segment().' '.ucfirst(implode(' ',abbr(FALSE))));?>
  <span class="span12 border_separator"></span> </div>
<span class="row-fluid separator_border">
<ul class="near_by" id="viewcontainer">
<?php 
                     foreach($cities as $city): 
					
					 $clean= preg_replace('/[^A-Za-z0-9\-]/', ' ',$city['city']);
					 $clean=str_replace(array('',' ',NULL),'-',$clean); 
						echo '<li>'.anchor(abbr().'/'.strtolower($clean).'/'.implode('-',abbr(false)),$urltext.ucfirst($city['city'])).'</li>';
                    endforeach; 
				echo '</ul><div class="row-fluid span12" id="pagination"></div>';
                                    
            ?>
</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
