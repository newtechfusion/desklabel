<div class="row">
	<div class="title"><span>Contact Info</span></div>
	<ul class="label-list">
		<li>
			<span class="label"><i class="icon-home"></i> Address</span>
			<span><?=$this->data->school->physical_address.'<br />'.$this->data->school->physical_city.', '.$this->data->school->physical_state.' '.$this->data->school->physical_zip;?></span>
		</li>
		<li>
			<span class="label"><i class="icon-envelope"></i> Mailing</span>
			<span><?=$this->data->school->mailing_address.'<br />'.$this->data->school->mailing_city.', '.$this->data->school->mailing_state.' '.$this->data->school->mailing_zip;?></span>
		</li>
		<li>
			<span class="label"><i class="icon-iphone"></i> Phone</span>
			<span><?=$this->data->school->phone;?></span>
	</ul>
</div>