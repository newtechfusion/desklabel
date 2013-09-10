<div class="content">
	<? $this->load->view('elements/breadcrumbs'); ?>
	<div class="container main">
		<div class="sixteen columns">
			<div class="row">
				<div class="title"><span>Please Complete the Form Below to Register for Your Account</span></div>
				<form class="form" method="post">
					<div class="form-inline">
						<div class="form-row">
							<label class="form-label">Name</label>
							<div class="form-item">
								<input type="text" name="name" class="medium">
							</div>
						</div>
						<div class="form-row">
							<label class="form-label">Email</label>
							<div class="form-item">
								<input type="text" name="email" class="medium">
							</div>
						</div>
						<div class="form-row">
							<label class="form-label">Password</label>
							<div class="form-item">
								<input type="password" name="password" class="medium">
							</div>
						</div>
						<div class="form-row">
							<label class="form-label">Confirm Password</label>
							<div class="form-item">
								<input type="password" name="password_confirm" class="medium">
							</div>
						</div>
						<div class="form-row">
							<label class="form-label">Are You :</label>
							<div class="form-item clearfix">
								<ul class="form-list">
									<li><input type="checkbox" name="you[]" value="1"> <label>A Parent</label></li>
									<li><input type="checkbox" name="you[]" value="2"> <label>A Teacher</label></li>
									<li><input type="checkbox" name="you[]" value="3"> <label>A Student</label></li>
									<li><input type="checkbox" name="you[]" value="4"> <label>Researching Schools in Your Area</label></li>
									<li><input type="checkbox" name="you[]" value="5"> <label>Relocating to a New Area</label></li>
								</ul>
							</div>
						</div>
					</div>
					<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
					<div class="button-row">
						<input type="submit" value="Submit" class="btn">
						<input type="reset" value="Reset" class="btn btn-white">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
