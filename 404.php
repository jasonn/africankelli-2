<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */

get_header(); ?>
<div class="content error-404">
  <h2 class="center">Sorry an error has occurred, the page you are looking for is lost.</h2>
  <p>Below you can search, view a list of archives by month, and also view a list of categories. If all else fails you can <a href="<?php bloginfo('url'); ?>/contact" title="Contact Africankelli">Contact Me</a>.</p>
  <?php get_search_form(); ?>
  <div class="column-one-two">
    <h3>Archives By Month:</h3>
    <ul class="archive-list no-float">
      <?php wp_get_archives('type=monthly'); ?>
    </ul>
  </div>
  
  <div class="column-two-two">
    <h3>Categories</h3>
    <ul class="archive-list">
      <?php wp_list_categories('show_count=1&title_li='); ?>
    </ul>
  </div>
</div>
<?php get_footer(); ?>