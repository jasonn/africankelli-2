<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */

/*
Template Name: Tutorials
*/

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
	<h2><?php the_title(); ?></h2>
		<div class="entry">
			<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

		</div>
	</div>
	<?php endwhile; endif; ?>
<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

<div class="post-list">
  <?php $my_query = new WP_Query('category_name=tutorial');
  while ($my_query->have_posts()) : $my_query->the_post();
  $do_not_duplicate = $post->ID; ?>
  <div class="post">
    <div class="post-title">
      <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a> <span><?php the_time('m') ?>/<?php the_time('d') ?>/<?php the_time('y') ?></span></h2>
    </div> <!-- /post-title -->

    <div class="post-meta">
      <?php show_post_attachment($post->ID); ?>
    </div> <!-- /post-meta -->
  </div> <!-- /post -->
      
  <?php endwhile; ?>
</div> <!-- /post-list -->


<div id="featured">  
    <ul id="carousel">  
        <?php  
        $featured_posts = get_posts('numberposts=10&category_name=tutorial');  
          
        foreach( $featured_posts as $post ) {  
            $custom_image = get_post_custom_values('small_image', $post->ID);  
            $image = $custom_image[0] ? $custom_image[0] : get_bloginfo("template_directory")."/images/no-featured-image.jpg";  
            printf('<li><a href="%s" title="%s"><img src="%s" alt="%s" /></a></li>', get_permalink($post->ID), $post->post_title, $image, $post->post_title);  
        }  
        ?>  
    </ul>  
    <div class="clear"></div>  
</div>

<?php get_footer(); ?>