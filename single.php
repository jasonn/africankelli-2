<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	  
	  <div id="post-<?php the_ID(); ?>" class="article single">
			<h1><?php the_title(); ?></h1>
			
			<p class="date"><strong><?php the_time('F jS') ?></strong></p>
			
			<div class="section">
				<?php the_content('Read More &rarr;'); ?>
			</div>
			
			<?php show_post_attachment($post->ID); ?>
      
			<dl class="aside">
			  <?php the_tags('<dt class="tags">Tagged</dt><dd>',', ','</dd>'); ?>
			  <dt class="category">Posted in</dt>
			  <dd><?php the_category(', ') ?></dd>
			  <dt class="comments">Follow the <?php post_comments_feed_link('comments'); ?>.</dt>
			  <?php edit_post_link('Edit this entry','<dt class="edit">','</dt>'); ?>
			</dl>
		</div>

    <div class="comments-wrapper">
		<?php if (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
			// Only Pings are Open ?>
			Comments are currently closed.
		<?php } ?>
		
    <?php comments_template(); ?>
    </div>

	<?php endwhile; else: ?>

		<p><strong>Sorry, no posts matched your criteria.</strong></p>

<?php endif; ?>

<?php get_footer(); ?>