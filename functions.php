<?php
/**
 * @package WordPress
 * @subpackage AK_Theme
 */

/*
#  Changes the default 'stylesheet_directory' to something better than styles.css
*/
/*
function get_new_stylesheet_uri() {
     $stylesheet_uri = get_theme_root_uri() ."/". get_option('template') . "/stylesheets/base-styles.css";
     //$stylesheet_uri = "http://www.africankelli.com/wp-content/themes/africankelli-2/stylesheets/base-styles.css";
     return $stylesheet_uri;
}

add_filter('stylesheet_uri', 'get_new_stylesheet_uri');
*/

/*
#  Removes unwanted info from the wp_head() function.
*/
remove_action('wp_head', 'wp_generator'); 
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link'); 

function hide_wp_head_info() {
  return '';
}

add_filter('the_generator','hide_wp_head_info');

/*
#  Gets archives by grid. Modified version of 'Smart Archives' by Justin Blanton - http://justinblanton.com/projects/smartarchives/
#  Basicly gets the year and month and displays in a nice little grid. No hrefs for months that don't have any posts.
*/
function get_archives_bygrid() {  
    global $wpdb, $PHP_SELF;
    setlocale(LC_ALL,WPLANG); // set localization language; please see instructions
    $now = gmdate("Y-m-d H:i:s",(time()+((get_settings('gmt_offset'))*3600)));  // get the current GMT date
    $bogusDate = "/01/2001"; // used for the strtotime() function below
	
	$yearsWithPosts = $wpdb->get_results("
	    SELECT distinct year(post_date) AS `year`, count(ID) as posts
	    FROM $wpdb->posts 
	    WHERE post_type = 'post' 
	    AND post_status = 'publish' 
	    GROUP BY year(post_date) 
	    ORDER BY post_date DESC");
	
	foreach ($yearsWithPosts as $currentYear) {
		
		for ($currentMonth = 1; $currentMonth <= 12; $currentMonth++) {
			
			$monthsWithPosts[$currentYear->year][$currentMonth] = $wpdb->get_results("
			SELECT ID, post_title FROM $wpdb->posts 
			WHERE post_type = 'post'
			AND post_status = 'publish' 
			AND year(post_date) = '$currentYear->year' 
			AND month(post_date) = '$currentMonth'			
			ORDER BY post_date DESC");
		}
	}
	
		// get the shortened month name; strftime() should localize
    for($currentMonth = 1; $currentMonth <= 12; $currentMonth++) $shortMonths[$currentMonth] = ucfirst(strftime("%b", strtotime("$currentMonth"."$bogusDate")));
		
		if ($yearsWithPosts) {
?>
  <dl id="monthly-archives">
<?php foreach ($yearsWithPosts as $currentYear) { ?>	
				<dt><a href="<?=get_year_link($currentYear->year, $currentYear->year); ?>"><?=$currentYear->year ?></a></dt>
			<?php	
				for ($currentMonth = 1; $currentMonth <= 12; $currentMonth++) {
				?>
					
				<?php if ($monthsWithPosts[$currentYear->year][$currentMonth]) { ?>
				  <dd><a href="<?=get_month_link($currentYear->year, $currentMonth); ?>"><?=$shortMonths[$currentMonth]; ?></a></dd>
				<?php } else { ?>
				  <dd class="empty-month"><?=$shortMonths[$currentMonth]; ?></dd>
				<?php
				  }
				}
			}
?>
  </dl>
<?php		
		}
}

/*
#  Gets archives by year.
#  Archives by year with the total posts in each year displayed.
*/
function get_archives_byyear() { 
  global $wpdb, $PHP_SELF;
  
  $years = $wpdb->get_results("
    SELECT DISTINCT YEAR( post_date ) AS year,
    MONTH( post_date ) AS month,
    COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish'
    and post_date <= now( ) and post_type = 'post'
    GROUP BY year
    ORDER BY post_date DESC");

  if ( $years ) {?><ul class="archive-list"><?php foreach ($years as $year) {
?>
    <li>
      <a href="<?php bloginfo('url') ?>/<?=$year->year; ?>/<?php echo date("m", mktime(0, 0, 0, $year->month, 1, $year->year)) ?>"><?php echo $year->year ?></a> <?=$year->post_count; ?></li>

    <?php 
    } ?></ul><?php
  }
}

/*
#  Gets archives by month.
#  Archives by month with the total posts in each month displayed.
*/
function get_archives_bymonth() {
  global $wpdb, $PHP_SELF;
  
  $months = $wpdb->get_results("
    SELECT DISTINCT MONTH( post_date ) AS month,
    YEAR( post_date ) AS year,
    COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish'
    and post_date <= now( ) and post_type = 'post'
    GROUP BY month, year
    ORDER BY post_date DESC");

  if ( $months ) {?><ul class="archive-list"><?php foreach ($months as $month) {
?>
  <li>
    <a href="<?php bloginfo('url') ?>/<?=$month->year; ?>/<?php echo date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>"><?php echo date("F", mktime(0, 0, 0, $month->month, 1, $month->year)) ?> <?php echo $month->year ?></a> <?=$month->post_count; ?></li>

    <?php 
    } ?></ul><?php
  }
}

/*
#  Gets archives by category.
#  Archives by category with the total posts in each category displayed.
*/
function get_archives_bycategory() {
  $categories = get_categories();

  if ($categories) {?><ul class="archive-list"><?php 
  foreach($categories as $category) {
?>
  <li><a href="<?=get_category_link( $category->term_id ) ?>" title="<?=sprintf( __( "View all posts in %s" ), $category->name ) ?>"><?=$category->name ?></a> <?=$category->count ?></li>
  <?php
    } ?></ul><?php
  }
}

/*
#  Gets archives by tag.
#  Archives by tag with the total posts in each tag displayed.
*/
function get_archives_bytag() {
  $tags = get_tags(array('order' => 'ASC',));
?><ul class="archive-list"><?php 
  foreach ($tags as $tag) {
    ?>
  <li><a href="<?=get_tag_link($tag->term_id) ?>" rel="tag"><?=$tag->name ?></a> <?=$tag->count ?></li>
  <?php
  }; ?></ul><?php
}

/*
#  Gets all archives by date.
#  All posts archives by date with the date displayed after the title.
*/
function get_archives_all_bydate() { 
  global $wpdb, $PHP_SELF;
  
  $posts = $wpdb->get_results("
    SELECT post_title,
    MONTH( post_date ) AS month,
    YEAR( post_date ) AS year,
    DAY( post_date ) AS day,
    id FROM $wpdb->posts WHERE post_status = 'publish'
    AND post_date <= now( ) and post_type = 'post'
    ORDER BY post_date DESC");

  if ( $posts ) { foreach ($posts as $post) {
?>
<li><a href="<?php echo get_permalink($post->id)?>"><?=$post->post_title ?></a> <?php echo date("F jS, Y",mktime(0, 0, 0, $post->month, $post->day, $post->year)) ?></li>
<?php
    }
  }
}

/*
#  Gets all archives by title.
#  All posts archives by title with the date displayed after the title.
*/
function get_archives_all_bytitle() { 
  global $wpdb, $PHP_SELF;
    
  $posts = $wpdb->get_results("
    SELECT post_title,
    MONTH( post_date ) AS month,
    YEAR( post_date ) AS year,
    DAY( post_date ) AS day,
    id FROM $wpdb->posts WHERE post_status = 'publish'
    AND post_date <= now( ) and post_type = 'post'
    ORDER BY post_title ASC");

  if ($posts) { foreach ($posts as $post) {
?>
<li><a href="<?php echo get_permalink($post->id)?>"><?=$post->post_title ?></a> <?php echo date("F jS, Y",mktime(0, 0, 0, $post->month, $post->day, $post->year)) ?></li>
<?php
    }
  }
}

/*
#  Gets all archive pages by title.
#  All pages by title with the date displayed after the title.
*/
function get_archives_all_pages_bytitle() { 
  global $wpdb, $PHP_SELF;
    
  $posts = $wpdb->get_results("
    SELECT post_title,
    MONTH( post_date ) AS month,
    YEAR( post_date ) AS year,
    DAY( post_date ) AS day,
    id FROM $wpdb->posts WHERE post_status = 'publish'
    AND post_date <= now( ) and post_type = 'page'
    ORDER BY post_title ASC");

  if ($posts) {?><ul class="archive-list page-list"><?php foreach ($posts as $post) {
?>
<li><a href="<?php echo get_permalink($post->id)?>"><?=$post->post_title ?></a></li>
<?php
    } ?></ul><?php
  }
}

/*
#  Adds in a count to the archives, tag archives, and search.
#  Mostly taken from the 'Results Count Remix' plugin, but I just
#   took out what I did not need and reformated things a bit differently.
#  Inserts count: 1–10 of 53.
*/
function results_count_remix() {
	if (is_search() || is_archive()) {
		global $posts_per_page, $wpdb, $paged, $wp_query;

		$numposts = $wp_query->found_posts;

		if (0 < $numposts)
			$numposts = number_format($numposts);

		if (empty($paged))
			$paged = 1;

		$startpost = ($posts_per_page * $paged) - $posts_per_page + 1;

		if (($startpost + $posts_per_page - 1) >= $numposts)
			$endpost = $numposts;
		else
			$endpost = $startpost + $posts_per_page - 1;

		if ($numposts != 1)
			$plural_posts = true;
		if ($numposts > $posts_per_page)
			$plural_pages = true;

		// Handle category archives
		if (is_category()) {
			if ($plural_pages)
				echo '<p class="results">', $startpost, '&ndash;', $endpost,' of ', $numposts, ' entries in the category: ';
			else {
				if ($plural_posts)
					echo '<p class="results">', $numposts, ' entries in the category: ';
				else
					echo '<p class="results">One entry in the category: ';
			}
		
			echo '<strong>', single_cat_title('', false), '</strong></p>';
		}
		
		// Handle tag archives
		elseif (is_tag()) {
			if ($plural_pages)
				echo '<p class="results">', $startpost, '&ndash;', $endpost,' of ', $numposts, ' entries tagged: ';
			else {
				if ($plural_posts)
					echo '<p class="results">', $numposts, ' entries tagged: ';
				else
					echo '<p class="results">One entry tagged: ';
			}
		
			echo '<strong>', single_tag_title('', false), '</strong></p>';
		}

		// Handle monthly archives
		if (is_month()) {
			if ($plural_pages)
				echo '<p class="results">', $startpost, '&ndash;', $endpost, ' of ', $numposts, ' entries from the month of: ';
			else {
				if ($plural_posts)
					echo '<p class="results">', $numposts, ' entries from the month of: ';
				else
					echo '<p class="results">One entry from the month of: ';
			}

			echo '<strong>', get_the_time('F Y'), '</strong></p>';
		}

		// Handle yearly archives
		elseif (is_year()) {
			if ($plural_pages)
				echo '<p class="results">', $startpost, '&ndash;', $endpost, ' of ', $numposts, ' entries from the year: ';
			else {
				if ($plural_posts)
					echo '<p class="results">', $numposts, ' entries from the year: ';
				else
					echo '<p class="results">One entry from the year: ';
			}

			echo '<strong>', get_the_time('F Y'), '</strong></p>';
		}

		// Handle search results
		elseif (is_search()) {
			if ($plural_pages)
				echo '<p class="results">', $startpost, '&ndash;', $endpost,' of ', $numposts, ' search results for: ';
			else {
				if ($plural_posts)
					echo '<p class="results">', $numposts, ' search results for: ';
				else
					echo '<p class="results">One result for the search: ';
			}
		
			echo '<strong>', attribute_escape(get_search_query()), '</strong></p>';
		}
	}
}

/*
#  Search Excerpt
#  Modify <code>the_exceprt()</code> template code during search to return snippets containing the search phrase.
#  Adds a <strong class="search-excerpt"> around the search item.
*/
class SearchExcerpt {
    function get_content() {
        // Get the content of current post. We like to have the entire
        // content. If we call get_the_content() we'll only get the teaser +
        // page 1.
        global $post;
        
        // Password checking copied from
        // template-functions-post.php/get_the_content()
        // Search shouldn't match a passworded entry anyway.
        if (!empty($post->post_password) ) { // if there's a password
            if (stripslashes($_COOKIE['wp-postpass_'.COOKIEHASH]) != 
                $post->post_password ) 
            {      // and it doesn't match the cookie
                return get_the_password_form();
            }
        }

        return $post->post_content;
    }
    
    function get_query($text) {
        static $last = null;
        static $lastsplit = null;

        if ($last == $text)
            return $lastsplit;

        // The dot, underscore and dash are simply removed. This allows
        // meaningful search behaviour with acronyms and URLs.
        $text = preg_replace('/[._-]+/', '', $text);

        // Process words
        $words = explode(' ', $text);

        // Save last keyword result
        $last = $text;
        $lastsplit = $words;

        return $words;
    }

    function highlight_excerpt($keys, $text) {
        $text = strip_tags($text);

        for ($i = 0; $i < sizeof($keys); $i ++)
            $keys[$i] = preg_quote($keys[$i], '/');

        $workkeys = $keys;

        // Extract a fragment per keyword for at most 4 keywords.  First we
        // collect ranges of text around each keyword, starting/ending at
        // spaces.  If the sum of all fragments is too short, we look for
        // second occurrences.
        $ranges = array();
        $included = array();
        $length = 0;
        while ($length < 256 && count($workkeys)) {
            foreach ($workkeys as $k => $key) {
                if (strlen($key) == 0) {
                    unset($workkeys[$k]);
                    continue;
                }
                if ($length >= 256) {
                    break;
                }
                // Remember occurrence of key so we can skip over it if more
                // occurrences are desired.
                if (!isset($included[$key])) {
                    $included[$key] = 0;
                }

                // NOTE: extra parameter for preg_match requires PHP 4.3.3
                if (preg_match('/'.$key.'/iu', $text, $match, 
                               PREG_OFFSET_CAPTURE, $included[$key])) 
                {
                    $p = $match[0][1];
                    $success = 0;
                    if (($q = strpos($text, ' ', max(0, $p - 60))) !== false && 
                         $q < $p)
                    {
                        $end = substr($text, $p, 80);
                        if (($s = strrpos($end, ' ')) !== false && $s > 0) {
                            $ranges[$q] = $p + $s;
                            $length += $p + $s - $q;
                            $included[$key] = $p + 1;
                            $success = 1;
                        }
                    }

                    if (!$success) {
                        // for the case of asian text without whitespace
                        $q = _jamul_find_1stbyte($text, max(0, $p - 60));
                        $q = _jamul_find_delimiter($text, $q);
                        $s = _jamul_find_1stbyte_reverse($text, $p + 80, $p);
                        $s = _jamul_find_delimiter($text, $s);
                        if (($s >= $p) && ($q <= $p)) {
                            $ranges[$q] = $s;
                            $length += $s - $q;
                            $included[$key] = $p + 1;
                        } else {
                            unset($workkeys[$k]);
                        }
                    }
                } else {
                    unset($workkeys[$k]);
                }
            }
        }

        // If we didn't find anything, return the beginning.
        if (sizeof($ranges) == 0)
            return '<p>' . _jamul_truncate($text, 256) . '&nbsp;...</p>';

        // Sort the text ranges by starting position.
        ksort($ranges);

        // Now we collapse overlapping text ranges into one. The sorting makes
        // it O(n).
        $newranges = array();
        foreach ($ranges as $from2 => $to2) {
            if (!isset($from1)) {
                $from1 = $from2;
                $to1 = $to2;
                continue;
            }
            if ($from2 <= $to1) {
                $to1 = max($to1, $to2);
            } else {
                $newranges[$from1] = $to1;
                $from1 = $from2;
                $to1 = $to2;
            }
        }
        $newranges[$from1] = $to1;

        // Fetch text
        $out = array();
        foreach ($newranges as $from => $to)
            $out[] = substr($text, $from, $to - $from);

        $text = (isset($newranges[0]) ? '' : '...&nbsp;').
            implode('&nbsp;...&nbsp;', $out).'&nbsp;...';
        $text = preg_replace('/('.implode('|', $keys) .')/iu', 
                             '<strong class="search-excerpt">\0</strong>', 
                             $text);
        return "<p>$text</p>";
    }

    function the_excerpt($text) {
        static $filter_deactivated = false;
        global $more;
        global $wp_query;

        // If we are not in a search - simply return the text unmodified.
        if (!is_search())
            return $text;

        // Deactivating some of the excerpt text.
        if (!$filter_deactivated) {
            remove_filter('the_excerpt', 'wpautop');
            $filter_deactivated = true;
        }

        // Get the whole document, not just the teaser.
        $more = 1;
        $query = SearchExcerpt::get_query($wp_query->query_vars['s']);
        $content = SearchExcerpt::get_content();

        return SearchExcerpt::highlight_excerpt($query, $content);
    }
}

// The number of bytes used when WordPress looking around to find delimiters
// (either a whitespace or a point where ASCII and other character switched).
// This also represents the number of bytes of few characters.
define('_JAMUL_LEN_SEARCH', 15);

function _jamul_find_1stbyte($string, $pos=0, $stop=-1) {
    $len = strlen($string);
    if ($stop < 0 || $stop > $len) {
        $stop = $len;
    }
    for (; $pos < $stop; $pos++) {
        if ((ord($string[$pos]) < 0x80) || (ord($string[$pos]) >= 0xC0)) {
            break;      // find 1st byte of multi-byte characters.
        }
    }
    return $pos;
}

function _jamul_find_1stbyte_reverse($string, $pos=-1, $stop=0) {
    $len = strlen($string);
    if ($pos < 0 || $pos >= $len) {
        $pos = $len - 1;
    }
    for (; $pos >= $stop; $pos--) {
        if ((ord($string[$pos]) < 0x80) || (ord($string[$pos]) >= 0xC0)) {
            break;      // find 1st byte of multi-byte characters.
        }
    }
    return $pos;
}

function _jamul_find_delimiter($string, $pos=0, $min = -1, $max=-1) {
    $len = strlen($string);
    if ($pos == 0 || $pos < 0 || $pos >= $len) {
        return $pos;
    }
    if ($min < 0) {
        $min = max(0, $pos - _JAMUL_LEN_SEARCH);
    }
    if ($max < 0 || $max >= $len) {
        $max = min($len - 1, $pos + _JAMUL_LEN_SEARCH);
    }
    if (ord($string[$pos]) < 0x80) {
        // Found ASCII character at the trimming point.  So, trying
        // to find new trimming point around $pos.  New trimming point
        // should be on a whitespace or the transition from ASCII to
        // other character.
        $pos3 = -1;
        for ($pos2 = $pos; $pos2 <= $max; $pos2++) {
            if ($string[$pos2] == ' ') {
                break;
            } else if ($pos3 < 0 && ord($string[$pos2]) >= 0x80) {
                $pos3 = $pos2;
            }
        }
        if ($pos2 > $max && $pos3 >= 0) {
            $pos2 = $pos3;
        }
        if ($pos2 > $max) {
            $pos3 = -1;
            for ($pos2 = $pos; $pos2 >= $min; $pos2--) {
                if ($string[$pos2] == ' ') {
                    break;
                } else if ($pos3 < 0 && ord($string[$pos2]) >= 0x80) {
                    $pos3 = $pos2 + 1;
                }
            }
            if ($pos2 < $min && $pos3 >= 0) {
                $pos2 = $pos3;
            }
        }
        if ($pos2 <= $max && $pos2 >= $min) {
            $pos = $pos2;
        }
    } else if ((ord($string[$pos]) >= 0x80) || (ord($string[$pos]) < 0xC0)) {
        $pos = _jamul_find_1stbyte($string, $pos, $max);
    }
    return $pos;
}

function _jamul_truncate($string, $byte) {
    $len = strlen($string);
    if ($len <= $byte)
        return $string;
    $byte = _jamul_find_1stbyte_reverse($string, $byte);
    return substr($string, 0, $byte);
}

// Add with priority=5 to ensure that it gets executed before wp_trim_excerpt
// in default filters.
add_filter('get_the_excerpt', array('SearchExcerpt', 'the_excerpt'), 5);



/*
#  Shows post attachment list.
*/
function show_post_attachment($id) {
  $args = array(
  	'post_type' => 'attachment',
  	'numberposts' => -1,
  	'post_status' => null,
  	'post_parent' => $id,
  	); 
  $attachments = get_posts($args);
  if ($attachments) {
  ?>
    <dl style="border: solid 1px #ccc; padding: 10px;">
      <dt>Files for this post</dt>
  <?php
  	foreach ($attachments as $attachment) {
  ?>
  		<dd><?php the_attachment_link($attachment->ID, false); ?></dd>
  <?php
  	}
  ?>
    </dl>
  <?php
  }
}



function theme_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>" class="single-comment">
      <div class="comment-author vcard">
         <?php echo get_avatar($comment,$size='80' ); ?>

         <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
         
         <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>" class="comment-link"><?php printf(__('%1$s'), get_comment_date(),  get_comment_time()) ?></a>
         <?php edit_comment_link(__('(Edit)'),'  ','') ?>
      </div>
      
      <div class="comment-content">
        <?php comment_text() ?>
        
        <?php if ($comment->comment_approved == '0') : ?>
          <div class="comment-meta commentmetadata">
            <em><?php _e('Your comment is awaiting moderation.') ?></em>
          </div>
        <?php endif; ?>

        <div class="reply">
           <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </div>
      </div>
     </div>
  <?php
}






/*
#  Custom Gravatar.
*/
function ak_addgravatar( $avatar_defaults ) {
  $myavatar = get_bloginfo('template_directory') . '/images/gravatar.png';
  $avatar_defaults[$myavatar] = 'Ak Custom Gravatar';
  return $avatar_defaults;
}

add_filter( 'avatar_defaults', 'ak_addgravatar' );





function add_button($context) {
	global $post_ID, $temp_ID;

	$image_btn = get_option('siteurl').'/wp-content/themes/'.get_option('template').'/admin/images/media-button-pdf.gif';
	$image_title = 'Pdf';
	
	$uploading_iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);

	$media_upload_iframe_src = "media-upload.php?post_id=$uploading_iframe_ID";
	$pdf_upload_iframe_src = apply_filters('image_upload_iframe_src', "$media_upload_iframe_src&amp;type=image&tab=library&post_mime_type=application/pdf");

	$out = '<a href="'.$pdf_upload_iframe_src.'&amp;TB_iframe=true" id="add_pdf" class="thickbox" title="'.$image_title.'"><img src="'.$image_btn.'" alt="'.$image_title.'" /></a>';
	return $context.$out;
}

add_filter('media_buttons_context', 'add_button');

function modify_post_mime_types($post_mime_types) {
    $post_mime_types['application/pdf'] = array(__('Pdfs'), __('Manage Pdfs'), __ngettext_noop('Pdf (%s)', 'Pdfs (%s)'));
    return $post_mime_types;
}

add_filter('post_mime_types', 'modify_post_mime_types');













?>