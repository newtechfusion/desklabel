<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="lt-ie9 lt-ie8 lt-ie7 ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="lt-ie9 lt-ie8 ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="lt-ie9 ie8" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="ie9" lang="en"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?=isset($this->copy->title) ? $this->copy->title : 'Grade Schools';?></title>
	<meta name="description" content="<?=(isset($this->copy->desc) ? $this->copy->desc : 'Browse the largest directory of grade schools on the web.')?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<? if(isset($this->copy->full_base_url) && $this->copy->full_base_url): ?><link rel="canonical" href="<?=$this->copy->full_base_url;?>" /><? endif ?>
	<? if(isset($this->domain->pagination_headers) && isset($this->domain->pagination_headers['pagination_headers'])): echo $this->domain->pagination_headers['pagination_headers']; endif; ?>
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600">
	<link rel="stylesheet" href="<?= base_url() ?>css/style.css">
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<? $this->load->view('google/analytics'); ?>
</head>
<body>
	<div class="main-wrap">
		<header class="header">
			<div class="container">
				<div class="sixteen columns">
					<div class="header-row">
						<div class="header-col brand">
							<a href="<?=base_url();?>" class="logo"><img src="<?=base_url();?>css/img/grade-schools.png" alt="Grade Schools"></a>
						</div>
						<nav class="header-col navigation">
							<ul>
								<?
									$this->copy->nav_links = array();
									$this->copy->nav_links[]		= array('href'=>base_url(),				'text'=>'Home',		'title'=>'Home');
									foreach(modifiers() as $modifier) : 
										$this->copy->nav_links[]	= array('href'=>base_url().$modifier,	'text'=>ucstring(make_slug($modifier,' ')),	'title'=>ucstring(make_slug($modifier,' ')));
									endforeach;
									$this->copy->nav_links[]		= array('href'=>base_url().'contact',	'text'=>'Contact',	'title'=>'Contact Us');
								?>
								<? foreach($this->copy->nav_links as $nav_link) : ?>
									<? $temp_active = (trim($_SERVER['REQUEST_URI'], '/') && str_replace(base_url(),'',$nav_link['href']) && strpos(trim($_SERVER['REQUEST_URI'], '/'), rtrim(str_replace(base_url(),'',$nav_link['href']),'s')) !== FALSE) ? TRUE : (!trim($_SERVER['REQUEST_URI'], '/') && !str_replace(base_url(),'',$nav_link['href']) ? TRUE : FALSE); ?>
									<li <?=($temp_active ? ' class="active"' : '');?>>
										<a href="<?=$nav_link['href'];?>" title="<?=$nav_link['title'];?>"><?=$nav_link['text'];?></a>
									</li>
								<? endforeach; ?>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</header>