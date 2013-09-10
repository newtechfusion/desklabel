<div class="row">
	<p class="pagination_message">
		Showing
			<?=(($this->domain->pagination_headers['page_num'] - 1) * $this->domain->pagination_headers['total_per_page']) + 1;?> to
			<?=(($this->domain->pagination_headers['page_num'] - 1) * $this->domain->pagination_headers['total_per_page']) + count($this->data->schools);?> of
			<?=$this->domain->pagination_headers['total_records'].' '.$this->domain->clean_modifier;?>
	</p>
	<div class="clear"></div>
	<div class="pagination">
		<ul>
			<? foreach(array_reverse($this->domain->pagination_headers['pagination_range']) as $page_num) : ?>
				<li class="<?=($_GET['page'] == $page_num ? 'active' : 'paginate_button');?>"><a href="<?=$this->copy->full_base_url;?>?page=<?=$page_num;?>"><?=$page_num;?></a></li>
			<? endforeach; ?>
		</ul>
	</div>
</div>
<div class="clear"></div>
