<?php
/**
 * @package WordPress
 * @subpackage Ak_Theme
 */
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('This page is used to load the comments, please do not load this page directly.');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php comments_number('No Responses', 'One Response', '% Responses' );?></h3>
	
	<div class="nav comments-nav">
		<?php paginate_comments_links(); ?>
	</div>

	<ol class="commentlist">
	  <?php wp_list_comments('type=comment&callback=theme_comments'); ?>
	</ol>

	<div class="nav comments-nav">
		<?php paginate_comments_links(); ?>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
    <p class="nocomments">There are no comments yet, bet the first.</p>
    
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments for this post are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<div id="respond">

<h3><?php comment_form_title( 'Leave a Comment:' ); ?></h3>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
  <fieldset>
    <p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
    
    <?php if ( $user_ID ) : ?>
      <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
    <?php else : ?>
      <p>
        <label for="author">Name <span><?php if ($req) echo "(required)"; ?></span></label>
        <input type="text" class="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
      </p>

      <p>
        <label for="email">Mail <span>(will not be published) <?php if ($req) echo "(required)"; ?></span></label>
        <input type="text" class="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
      </p>

      <p>
        <label for="url">Website</label>
        <input type="text" class="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />    
      </p>
    <?php endif; ?>

    <p>
      <input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
      <?php comment_id_fields(); ?>
    </p>
    <?php do_action('comment_form', $post->ID); ?>
 </fieldset>
</form>

<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // do not delete ?>