<div id="contain">
<div class="row-fluid page_title">
  <div class="container">
    <div class="span12">
      <h1 class="title_size">
        <?php   $text=abbr(FALSE);
				echo $this->allcontent[0]['name'];
				$urltext=ucwords(implode(' ',$text)).' in ';
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
<div class="container">
    <div class="row-fluid distance_1">
        <div class="span12">
            <div class="row-fluid sc-col">
                <div class="row-fluid">
                    <div class="recent_title span12"><span class="span12 border_separator"></span></div>
                        <span class="row-fluid separator_border">
                        
                         <div class="span6">
                             <h1><?php echo $this->allcontent[0]['name'] ?></h1>
                             <h3>Location</h3>
                             <p>
                                 <span class="agency_address"><?php echo $this->allcontent[0]['address'] ?></span><br>
                                 <span class="agency_city"><?php echo ucfirst(strtolower($this->allcontent[0]['city'])) ?>, <?php echo $this->allcontent[0]['state'] ?>. <?php echo $this->allcontent[0]['zipcode'] ?></span><br>
                             </p>
                             <h3>Contact Information</h3>
                             <p><span><?php echo $this->allcontent[0]['phone'] ?></span></p>
                         </div>
                          <div class="span6 gmap">
                              <?php
                              $urltext = str_replace('-', ' ', $this->uri->segment(3)) . ' In ';
                              echo $map['js'];
                              echo $map['html'];
                              ?>
                          </div></div>

                        </span>

                         <ul  class="nav nav-tabs">   
                <li id="cities" class="active"><a data-toggle="tab" tabindex="-1" href="#nearby_cities">
                  <?=$this->lang->line('nearcity')?>
                  </a></li>
                  
                  <li id="counties"><a data-toggle="tab" href="#nearby_counties">
                 	 <?=$this->lang->line('nearcounty')?>
                  </a></li>
               
              </ul>
              <div class="row-fluid">
                <div class="tab-content link_pack">
                  <div id="nearby_cities" class="tab-pane active">
                    <ul class="near_by">
                      <?php
						$match=FALSE;
						foreach ($nearcitypack as $near):
						//if(in_array($near->city_name,$allcity)){
						$match=TRUE;
						$clean= preg_replace('/[^A-Za-z0-9\-]/', ' ',$near->city_name);
					     $clean=str_replace(array('',' ',NULL),'-',$near->city_name);
						echo '<li>'.anchor(segment().'/'.strtolower($clean).'/'.implode('-',abbr(false)),
						ucwords($near->city_name).', '.$near->state_abbr.' '.$urltext).'</li>';
						//}
						endforeach;
						echo '</ul></div><div id="nearby_counties" class="tab-pane"><ul class="near_by">';
						 /*?>if(!$match)echo'<script type="text/javascript"> ex();</script>';<?php */
						foreach ($counties as $county):
						$text=(strpos($county->text,'Schools'))? str_replace('Schools','',$county->text):$county->text;
						echo '<li>'.anchor($county->href.'/'.implode('-',abbr(false)),ucwords($text.' '.$urltext)).'</li>';
						endforeach;
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
