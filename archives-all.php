<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */
/*
Template Name: Archives-All
*/
?>

<?php get_header(); ?>

<div class="content archives">
  <h1>Africankelli Archives - All Posts</h1>
  <h3><a href="<?php bloginfo('url'); ?>/archives/">View sorted archives</a></h3>
  <div class="column-one-two">
    <h2>By Year:</h2>
    <ol id="archive-list-date" class="archive-list">
      <?php get_archives_all_bydate(); ?>
    </ol>
  </div>
  
  <div class="column-two-two">
    <h2>By Title:</h2>
    <ol id="archive-list-title" class="archive-list">
      <?php get_archives_all_bytitle(); ?> 
    </ol>
  </div>
</div>
<?php get_footer(); ?>
