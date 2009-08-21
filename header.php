<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en-us" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
	  <?php if (is_single() || is_page() || is_archive()) {
			wp_title('',true); echo(' - '); bloginfo('name');
		} else if (is_home()) { 
			bloginfo('name'); echo(' - '); bloginfo('description');
		} else if (is_404()) { 
			echo('404 Error! Page Not Found'); echo(', '); bloginfo('name'); echo(' - '); bloginfo('description');
		} else if (is_search()) { 
			echo('Search Results for: '); echo wp_specialchars($s, 1); echo(' - '); bloginfo('name');
		} else { 
			bloginfo('name'); echo(' - '); bloginfo('description'); } 
		?>
	</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en-us" />
	<meta name="verify-v1" content="RNuO2mVhENY807lIsLUAhmYLAYNxYeR2kT8qXjriKac=" />
	
	<meta name="description" content="Where Travel and Craft Collide" />
	<meta name="keywords" content="africankelli, african kelli, domestic art, Calculated Acts of Kindness, CAOK, billy gibbons hat, wristlet tutorial, african nudu hat, purse organizer pattern, nudu cap, pattern for purse organizer, African Cameroon Nudu Tribal Hat, angle zipper tutorial, amy butler birdie sling tutorial, sewing 101, happy hippie, amy butler pattern, sewing tutorial, The Peace T-Shirt Project, africa, arizona" />
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/seasons/spring-summer-09/styles/season.css" type="text/css" media="screen" />
	
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/javascript/jquery.js"></script>
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/javascript/global.js"></script>
	
	<?php wp_head(); ?>
	
	<script src="/mint/?js" type="text/javascript"></script>
</head>
<body>
<div id="header">
  <div id="nav">
    <ol>
      <li><a href="<?php bloginfo('url'); ?>/about" title="About" class="about">About</a></li>
      <li><a href="<?php bloginfo('url'); ?>/archives" title="View the Archives" class="archives">Archives</a></li>
      <li><a href="<?php bloginfo('url'); ?>/contact" title="Contact Me" class="contact">Contact Me</a></li>
    </ol>
  </div>
  <?php if ( is_home() ) { ?>
    <h1 class="title"><?php bloginfo('name'); ?></h1>
  <?php } else if ( !is_singular() ) { ?>
    <h1 class="title">
      <a href="<?php echo get_option('home'); ?>/" title="<?php bloginfo('name'); ?> - Home"><?php bloginfo('name'); ?></a>
      <div class="tooltip">
      	<a href="<?php echo get_option('home'); ?>/" title="<?php bloginfo('name'); ?> - Home">&laquo; Home</a>
      </div>
    </h1>
  <?php } else { ?>
    <div class="title">
      <a href="<?php echo get_option('home'); ?>/" title="<?php bloginfo('name'); ?> - Home"><?php bloginfo('name'); ?></a>
      <div class="tooltip">
      	<a href="<?php echo get_option('home'); ?>/" title="<?php bloginfo('name'); ?> - Home">&laquo; Home</a>
      </div>
    </div>
  <?php } ?>
</div>

<div id="content-wrapper">
  <div class="header-shadow">&nbsp;</div>
  