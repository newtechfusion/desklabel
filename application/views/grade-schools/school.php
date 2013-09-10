<div class="content">
	<? $this->load->view('elements/breadcrumbs'); ?>
	<div class="container main">
		<div class="row">
			<div class="portfolio-detail clearfix">
				<div class="ten columns">
					<? $this->load->view('elements/school_bullet_points'); ?>
					<? $this->load->view('elements/pie_chart'); ?>
					<? if(count($this->data->teacher_compensation)) : ?>
						<? $this->load->view('elements/school_stats'); ?>
					<? endif; ?>
					<? $this->load->view('elements/grades_offered'); ?>
					<? $this->load->view('elements/quote'); ?>
					<? // =$this->copy->copy;?>
					<? $this->load->view('elements/schools'); ?>
				</div>
				<div class="six columns">
					<? $this->load->view('elements/map'); ?>
					<? $this->load->view('elements/school_contact'); ?>
					<? $this->load->view('elements/callout'); ?>
				</div>
			</div>
		</div>
	</div>
	<? $this->load->view('elements/banner_call_out'); ?>
</div>
