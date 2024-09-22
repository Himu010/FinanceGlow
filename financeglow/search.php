<?php get_header(); ?>

<div class="container mt-5">
    <!-- Search Form -->
    <?php get_search_form(); // Use get_search_form() instead of hardcoding the form ?>

    <h1><?php printf(esc_html__('Search Results for: %s', 'financeglow'), esc_html(get_search_query())); ?></h1>

    <?php if (have_posts()): ?>

    <!-- Loop through posts -->
    <div class="row">
        <?php while (have_posts()):
                the_post(); ?>
        <div class="col-md-4 post-card <?php post_class(); ?>">

            <?php if (has_post_thumbnail()): ?>
            <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                class="post-thumbnail">
            <?php endif; ?>
            <div class="post-content">
                <h2 class="post-title">
                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
                </h2>

                <div class="post-meta">
                    <?php if (get_option('show_date', 1)): ?>
                    <span class="post-meta-item"><?php echo esc_html(get_the_date()); ?></span>
                    <?php endif; ?>
                    <?php if (get_option('show_author', 1)): ?>
                    <span class="post-meta-item"><?php echo esc_html(get_the_author()); ?></span>
                    <?php endif; ?>
                    <?php if (get_option('show_category', 1)): ?>
                    <span class="post-meta-item post-category"><?php echo esc_html(the_category(', ')); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php
                // Add a row break after every 3 posts
                if ($wp_query->current_post % 3 == 2) {
                    echo '</div><div class="row">';
                }
            endwhile; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php
            global $wp_query;
            $big = 999999999; // Need an unlikely integer
        
            $pagination_links = paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $wp_query->max_num_pages,
                'type' => 'array',
                'prev_text' => esc_html__('« Previous', 'financeglow'), // Escaped text
                'next_text' => esc_html__('Next »', 'financeglow'), // Escaped text
            ));

            if ($pagination_links) {
                echo '<div class="pagination-wrapper">';
                echo '<ul class="pagination">';
                foreach ($pagination_links as $link) {
                    echo "<li class='page-item'>$link</li>";
                }
                echo '</ul>';

                // Add the jump box
                echo '<div class="pagination-jump">';
                echo '<form id="jump-form" action="" method="get">';
                echo '<label for="page-number">' . esc_html__('Jump to page:', 'financeglow') . ' </label>';
                echo '<input type="number" id="page-number" name="paged" min="1" max="' . esc_attr($wp_query->max_num_pages) . '" required>';
                echo '<button type="submit" class="btn btn-primary">' . esc_html__('Go', 'financeglow') . '</button>';
                echo '</form>';
                echo '</div>';

                echo '</div>'; // Close pagination-wrapper
            }
        ?>
    </div>

    <?php else: ?>
    <!-- No results found -->
    <div class="no-results-card text-center">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/search-no-found.jpeg"
            alt="<?php esc_attr_e('No Results Found', 'financeglow'); ?>" class="no-results-img">
        <h2 class="no-results-text">
            <?php printf(esc_html__('Oops! No results found for "%s"', 'financeglow'), esc_html(get_search_query())); ?>
        </h2>
        <p class="no-results-subtext">
            <?php esc_html_e('We couldn\'t find anything matching your search. Try searching with different keywords.', 'financeglow'); ?>
        </p>
        <a href="<?php echo esc_url(home_url()); ?>"
            class="try-again-button mt-3"><?php esc_html_e('Return to Home', 'financeglow'); ?></a>
    </div>

    <?php endif; ?>
</div>

<?php get_footer(); ?>
