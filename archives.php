<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div class="content archives">
  <h1>Africankelli Archives</h1>
  <h3><a href="<?php bloginfo('url'); ?>/archive/all/">View all items by date or title</a></h3>
  <div class="column-one">
    <h2>By Year:</h2>
    <?php get_archives_byyear(); ?>
  
    <h2>By Month:</h2>
    <?php get_archives_bymonth(); ?>
  </div>

  <div class="column-two">
    <h2>By Category:</h2>
    <?php get_archives_bycategory(); ?>
    <h2>Pages:</h2>
    <?php get_archives_all_pages_bytitle(); ?>
  </div>

  <div class="column-three">
    <h2>By Tag:</h2>
    <?php get_archives_bytag(); ?>
  </div>
</div>
<?php get_footer(); ?>
