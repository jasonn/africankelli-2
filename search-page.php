<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */

/*
Template Name: Search
*/

get_header(); ?>

<div class="content search">
  <h1>Search Africankelli</h1>
	<?php get_search_form(); ?>

	<div class="column-one-two">	
  	<h2>Recent Posts</h2>
  	  <ol class="recent-posts">
      	<?php
         $postslist = get_posts('numberposts=10&order=DECS&orderby=date');
         foreach ($postslist as $post) : 
            setup_postdata($post);
        ?> 
        <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
        <?php endforeach; ?>
     </ol>
   </div>
   
  <div class="column-two-two">
    <h2>Tags</h2>
    <?php wp_tag_cloud(''); ?>
  </div>
</div>
<?php get_footer(); ?>