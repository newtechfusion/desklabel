<div class="content">
	<? $this->load->view('elements/breadcrumbs'); ?>
	<div class="container main">
		<div class="row">
			<div class="portfolio-detail clearfix">
				<div class="twelve columns">
					<? $this->load->view('elements/map'); ?>
					<? $this->load->view('elements/quote'); ?>
					<?=$this->copy->copy;?>
					<? if(isset($this->geo->data->city_id)) : ?>
						<? $this->load->view('elements/schools'); ?>
						<? $this->load->view('elements/pagination'); ?>
					<? else : ?>
						<? $this->load->view('elements/top_schools'); ?>
					<? endif; ?>
					<? $this->load->view('elements/link_pack'); ?>
				</div>
				<div class="four columns">
					<? $this->load->view('elements/'.($this->domain->modifier ? 'modifier_' : '').'stats'); ?>
					<? $this->load->view('elements/callout'); ?>
				</div>
			</div>
		</div>
	</div>
	<? $this->load->view('elements/banner_call_out'); ?>
	<div class="container main">
		<? $this->load->view('elements/lateral_link_pack'); ?>
	</div>
</div>
