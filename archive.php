<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */

get_header(); ?>

  <?php if (have_posts()) : ?>
    
    <?php if (function_exists('results_count_remix')) results_count_remix(); ?>
    
    <?php while (have_posts()) : the_post(); ?>
      
      <div id="post-<?php the_ID(); ?>" class="article single">
  			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

        <p class="date"><strong><?php the_time('F jS') ?></strong></p>

  			<div class="section">
  				<?php the_content('Read More &rarr;'); ?>
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
  <?php else :

  	if ( is_category() ) { // If this is a category archive
  		printf("<h3>Sorry, but there aren't any posts in the %s category yet.</h3>", single_cat_title('',false));
  	} else if ( is_date() ) { // If this is a date archive
  		echo("<h3>Sorry, but there aren't any posts with this date.</h3>");
  	} else if ( is_author() ) { // If this is a category archive
  		$userdata = get_userdatabylogin(get_query_var('author_name'));
  		printf("<h3>Sorry, but there aren't any posts by %s yet.</h3>", $userdata->display_name);
  	} else {
  		echo("<h3>No posts found.</h3>");
  	}
  	get_search_form();

  endif;
  ?>

<?php get_footer(); ?>