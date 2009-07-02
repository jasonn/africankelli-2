<form method="get" id="searchform" action="<?php get_option('home') ?>/" >
  <div class="form-field">
    <label class="hidden" for="s">Search</label>
    <input type="text" value="<?=attribute_escape(apply_filters('the_search_query', get_search_query())) ?>" name="s" id="s" class="text" />
    <input type="submit" id="searchsubmit" value="<?=attribute_escape(__('Search')) ?>" class="submit" />
  </div>
</form>