<?php get_header(); ?>

<!-- Tag Article List -->
<div class="container mt-5 article-list">
    <h1>Tag: <?php single_tag_title(); ?></h1>
    <div class="row">
        <?php if (have_posts()):
            $post_count = 0;
            while (have_posts()):
                the_post();
                $post_count++; ?>
        <div class="col-md-4 post-card <?php post_class(); ?>">

            <?php if (has_post_thumbnail()): ?>
            <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php the_title(); ?>"
                class="post-thumbnail">
            <?php endif; ?>
            <div class="post-content">
                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>

                <div class="post-meta">
                    <?php if (get_option('show_date', 1)): ?>
                    <span class="post-meta-item"><i class="fa fa-calendar"></i>
                        <?php echo esc_html(get_the_date()); ?></span>
                    <?php endif; ?>
                    <?php if (get_option('show_author', 1)): ?>
                    <span class="post-meta-item"><i class="fa fa-user"></i>
                        <?php echo esc_html(get_the_author()); ?></span>
                    <?php endif; ?>
                    <?php if (get_option('show_category', 1)): ?>
                    <span class="post-meta-item post-category">
                        <i class="fa fa-tags"></i> <?php echo esc_html(the_category(', ')); ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php
                // Add a row break after every 3 posts
                if ($post_count % 3 == 0) {
                    echo '</div><div class="row">';
                }
            endwhile;
        else: ?>
        <div class="no-results-card text-center">
            <h2><?php _e('Oops! No posts found for this tag.', 'financeglow'); ?></h2> <!-- Added text domain -->
            <p><?php _e('It seems there are no posts associated with this tag.', 'financeglow'); ?></p>
            <!-- Added text domain -->

            <!-- Search Box -->
            <?php get_search_form(); // Use get_search_form() instead of hardcoding the form ?>
        </div>
        <?php endif; ?>
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
            'prev_text' => '<i class="fa fa-chevron-left"></i>',
            'next_text' => '<i class="fa fa-chevron-right"></i>',
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

    <!-- Go to Home Button -->
    <div class="text-center mt-4">
        <a href="<?php echo esc_url(home_url()); ?>"
            class="btn btn-secondary"><?php esc_html_e('Go to Home', 'financeglow'); ?></a>
    </div>
</div>

<?php get_footer(); ?>