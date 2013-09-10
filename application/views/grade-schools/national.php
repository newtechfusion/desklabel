<div class="content">
	<? $this->load->view('elements/breadcrumbs'); ?>
	<div class="container main">
		<div class="row">
			<div class="portfolio-detail clearfix">
				<div class="twelve columns">
					<? // $this->load->view('elements/map'); ?>
					<? $this->load->view('elements/link_pack'); ?>
					<? $this->load->view('elements/quote'); ?>
				</div>
				<div class="four columns">
					<? $this->load->view('elements/modifier_stats'); ?>
					<? $this->load->view('elements/callout'); ?>
				</div>
			</div>
		</div>
	</div>
	<? $this->load->view('elements/banner_call_out'); ?>
</div>
