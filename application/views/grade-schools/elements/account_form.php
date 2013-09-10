<form class="form" method="post" action="<?=base_url();?>register">
	<fieldset>
		<legend>Register for a Free Account</legend>
		<div class="form-row">
			<label for="contactform_name" class="form-label">Name</label>
			<div class="form-item">
				<input type="text" name="name" class="large required">
			</div>
		</div>
		<div class="form-row">
			<label for="contactform_email" class="form-label">Email</label>
			<div class="form-item">
				<input type="text" name="email" class="large required email">
			</div>
		</div>
		<div class="form-row">
			<label for="contactform_email" class="form-label">Password</label>
			<div class="form-item">
				<input type="password" name="password" class="large required email">
			</div>
		</div>
		<div class="button-row">
			<button type="submit" class="btn">Register</button>
		</div>
	</fieldset>
</form>