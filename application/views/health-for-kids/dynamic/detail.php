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

                       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
