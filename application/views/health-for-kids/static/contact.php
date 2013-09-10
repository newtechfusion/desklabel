    <script>
	function validateEmail() { 
	var mail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    result=mail.test(document.getElementById('email').value);
	if(!result){alert("Enter A Valid Email Address");return false;}
	}
    </script>
    <div class="row-fluid page_title">

        <div class="container">
            <div class="span12">
                <h2 class="title_size">
                    Contact
                    <span class="title_labeled">Us</span>
                </h2>
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

                <!--<div class="row-fluid">
                    <iframe class="googlemap" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=New+York,+NY,+United+States&amp;amp;hl=en&amp;amp;sll=37.0625,-95.677068&amp;amp;sspn=52.107327,79.013672&amp;amp;oq=new+york&amp;amp;t=m&amp;amp;hnear=New+York&amp;amp;z=10&amp;amp;output=embed&amp;output=embed"></iframe>
                    <div class="row-fluid">
                        <div class="bottom_shadow_full googlemap_shadow"></div>
                    </div>
                </div>-->
                <div class="row-fluid" >
                 
                </div>
                    <div class="row-fluid">
                     
                        <div class="span8 sc-col">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="recent_title">
                                        <h2>Leave us a message</h2>
                                    </div>
                                    <span class="row-fluid separator_border"></span>
                                </div>
                            </div>
                            <div class="row-fluid">
                            		<?= $this->content ?>
                                <form name="contactForm"  class="standard-form"  method="post"  onsubmit=" return validateEmail()">
                                    <input class="span8" placeholder="Name" required="required" name="name"  type="text"  id="name" 
                                    value="" /><br/>
                                    <input class="span8" placeholder="E-Mail" required="required" name="email"  type="text" id="email"
                                     value=""  />
                                    <textarea class="span12" placeholder="Message" name="message" cols="40" rows="7" id="themeple_message" >
                                    </textarea>
                                    <p>
                                        <input type="submit"  value="Send Message" class="button_bar" />
                                    </p>
                                </form>
                                <div id="ajaxresponse"></div>
                            </div>
                        </div>
                        <div class="span4 sc-col">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="recent_title">
                                        <h2>More Info</h2>
                                    </div>
                                    <span class="row-fluid separator_border"></span>
                                </div>
                            </div>
                            If you have any questions or comments, please use the form to the left and we'll get back to you as soon as we can.
                            Thanks for using Health For Kids!
                        </div>
                    </div>
                </p>

            </div>

        </div>
    </div>