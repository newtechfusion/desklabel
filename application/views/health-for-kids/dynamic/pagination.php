 <?php 
                        $count=0;
						if(!empty($data)){
                        foreach($data as $agency):
                        if($count==$partition|| $count==0) echo '<div class="span6">';
						 $clean = preg_replace('/[^A-Za-z0-9\-]/','-',$agency['name']);
					   	$clean=str_replace(array('',' ',NULL,',',"'"),'-',$clean); 
						
             ?>
                <div class="border-box">
                  <h5><a href="<?php echo $_SERVER['REQUEST_URI'].'/'.$clean.'/'.$agency['id']?>"><?php echo ucwords(clean($agency['name']))?></a></h5>
                  <p> <b>Address:</b><span class="agency_address"><?php echo $agency['address']?></span><br>
                    <b>Phone:</b><span><?php echo $agency['phone']?></span> </p>
                </div>
             
              <?php 	
                        $count++;
						$closing=FALSE;
                        if($count==$partition){$count=0; echo '</div>'; $closing=true;}
                        endforeach;
						if(!$closing) echo '</div>';
					}
			?>