<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */
?>
  <div id="footer">
    <div class="section">
      <div class="column-one">
        <h3>View the Archives</h3>
        <?php get_archives_bygrid(); ?>
        
        <?php get_search_form(); ?>
        
        <h3>Tutorials <!--<a href="<?php bloginfo('url'); ?>/tutorials" class="view-all">View All Turtorials &raquo;</a>--></h3>
        <ol class="category-list">
          <?php
            global $post;
            $tutorials = get_posts('numberposts=3&category_name=tutorial');
            
            foreach($tutorials as $post) {

              $custom_image = get_post_custom_values('thumbnail_image', $post->ID);  
              $image = $custom_image[0] ? $custom_image[0] : get_bloginfo("template_directory")."/images/no-featured-image.jpg";
          ?>
          
          <li>
            <a href="<?php the_permalink(); ?>" class="image-wrapper"><img src="<?=$image ?>" alt="<?php the_title(); ?>" /></a>
            <div class="title-wrapper"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
          </li>
          
          <?php } ?>
        </ol>
        <ol class="nav">
          <li><a href="<?php bloginfo('url'); ?>/about" title="About Africankelli">About Africankelli</a></li>
          <li class="divider">|</li>
          <li><a href="<?php bloginfo('url'); ?>/archives" title="View the Archives">Archives</a></li>
          <li class="divider">|</li>
          <li><a href="<?php bloginfo('url'); ?>/contact" title="Contact Africankelli">Contact Me</a></li>
          <li class="divider">|</li>
          <li><a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe to the Rss">Subscribe - rss</a></li>
        </ol>
      </div>
      <div class="column-two">
        <h3>Flickr Photos</h3>
        <?php if(function_exists('get_flickrRSS')) { ?><div class="flickr-photos"><? get_flickrRSS(array('num_items' => 8, 'html' => '<span class="single-image"><a href="%flickr_page%" title="%title%"><img src="%image_square%" alt="%title%"/></a></span>')); ?></div><? } ?>
        <h3>Friends &amp; Support</h3>
        <ul class="nav friends-list">
          <?php wp_list_bookmarks('title_li=&categorize=0&before=<li>&after=,</li>'); ?>
        </ul>
        <div class="about-the-author">
          <?php
            query_posts('page_id=1327');

            while (have_posts()) : the_post(); ?>
            
            <h3><?php the_title(); ?></h3>
            <?php the_content(); ?>
            
          <? endwhile; ?>
        </div>
        <a href="http://www.flickr.com/groups/940807@N24/" title="Craft: Along 2009" class="craft-along">Craft: Along 2009</a>
      </div>
    </div>
  </div>
</div>
<div id="copyright">
  <p>Africankelli</p>
</div>
  <?php wp_footer(); ?>
  
  <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
  <script type="text/javascript">
    try {
      var pageTracker = _gat._getTracker("UA-9151484-1");
      pageTracker._trackPageview();
    } catch(err) {}
  </script>
</body>
</html>