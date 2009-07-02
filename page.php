<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" class="article page">
    	<h1><?php the_title(); ?></h1>
      
    	<div class="section">
    		<?php the_content('Read More &rarr;'); ?>
    		<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
    	</div>
    </div>
	<?php endwhile; endif; ?>

<?php get_footer(); ?>