<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?php esc_html_e('Search for:', 'financeglow'); ?></span>
        <input type="search" class="search-field" placeholder="<?php esc_attr_e('Search &hellip;', 'financeglow'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" aria-label="<?php esc_attr_e('Search', 'financeglow'); ?>" />
    </label>
    <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('Search', 'financeglow'); ?>">
        <i class="fas fa-search"></i> <!-- FontAwesome Search Icon -->
    </button>
</form>
