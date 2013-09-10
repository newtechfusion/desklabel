<div class="content">
	<? $this->load->view('elements/breadcrumbs'); ?>
		<div class="container main">
			<div class="eleven columns">
				<div class="row">
					<div class="title"><span>Send Us a Message</span></div>
					<? if(isset($this->data->success)) : ?>
						<div class="alert alert-success">
							<h4>Thank You</h4>
							Thank You for contacting us. We will get back to you as soon as possible.<br />
							<br />
							Thank You,<br />
							Grade-Schools.com
						</div>
					<? else : ?>
						<form id="contact-form" class="form" method="post" action="<?=base_url();?>contact" novalidate="novalidate">
							<div id="contact-message" class="alert alert-info">
								<h4>Attention!</h4>
								Please send us a message using the form below for general inquiries, questions, suggestions or career opportunities.
							</div>
							<div class="form-row">
								<label for="contactform_name" class="form-label">Name</label>
								<div class="form-item">
									<input type="text" id="contactform_name" name="name" class="required">
								</div>
							</div>
							<div class="form-row">
								<label for="contactform_email" class="form-label">Email</label>
								<div class="form-item">
									<input type="text" id="contactform_email" name="email" class="required email">
								</div>
							</div>
							<div class="form-row">
								<label for="contactform_comment" class="form-label">Comment</label>
								<div class="form-item">
									<textarea id="contactform_comment" name="comment" class="large required"></textarea>
								</div>
							</div>
							<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
							<div class="button-row">
								<button type="submit" class="btn">Submit</button>
							</div>
						</form>
					<? endif; ?>
				</div>
			</div>
			<div class="five columns">
				<div class="row">
					<div class="title"><span>Contact Info</span></div>
					<ul class="label-list">
						<li>
							<span class="label"><i class="icon-home"></i> Address</span>
							<span>435 Aspen Dr <br> Austin, TX 78737</span>
						</li>
						<li>
							<span class="label"><i class="icon-iphone"></i> Phone</span>
							<span>+5127913527</span>
						</li>
						<li>
							<span class="label"><i class="icon-envelope"></i> Email</span>
							<span><a href="#">jeff@propertymaps.com</a></span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	<? $this->load->view('elements/banner_call_out'); ?>
</div>
