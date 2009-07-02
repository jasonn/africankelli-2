<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */

get_header(); ?>

	<?php if (have_posts()) : ?>
	  
	  <?php if (function_exists('results_count_remix')) results_count_remix(); ?>

		<?php while (have_posts()) : the_post(); ?>
		  
		  <div id="post-<?php the_ID(); ?>" class="article excerpt">
  		  <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

  			<p class="date"><strong><?php the_time('F jS') ?></strong></p>

  			<div class="section">
  				<?php the_excerpt(); ?>
  			</div>

  			<dl class="aside">
  			  <?php the_tags('<dt class="tags">Tagged</dt><dd>',', ','</dd>'); ?>
  			  <dt class="category">Posted in</dt>
  			  <dd><?php the_category(', ') ?></dd>
  			  <dt class="comments">Comments (<?php comments_popup_link('0', '1', '%', '', 'Comments are off for this post'); ?>)</dt>
  			</dl>
  		</div>

		<?php endwhile; ?>

		<ol class="nav paged">
  		<li class="next"><?php next_posts_link('<span>&larr;</span> Older Entries') ?></li>
  		<li class="previous"><?php previous_posts_link('Newer Entries <span>&rarr;</span>') ?></li>
  	</ol>

	<?php else : ?>

		<h2>No posts found. Try a different search?</h2>
		<?php get_search_form(); ?>

	<?php endif; ?>

<?php get_footer(); ?>