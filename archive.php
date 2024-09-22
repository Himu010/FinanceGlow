<?php get_header(); ?>

<!-- Archive Article List -->
<div class="container mt-5 article-list">
    <h1><?php esc_html_e('Archive:', 'financeglow'); ?> <?php the_archive_title(); ?></h1>

    <!-- Date Filter Form -->
    <form action="<?php echo esc_url(get_permalink(get_page_by_path('filter-archive'))); ?>" method="GET"
        class="date-filter-form mb-4">
        <label for="filter-date"><?php esc_html_e('Filter by Date:', 'financeglow'); ?> </label>
        <input type="date" id="filter-date" name="filter-date" required>
        <button type="submit" class="btn btn-primary"><?php esc_html_e('Filter', 'financeglow'); ?></button>
    </form>

    <div class="row">
        <?php if (have_posts()):
            $post_count = 0;
            while (have_posts()):
                the_post();
                $post_count++; ?>
        <div class="col-md-4 post-card <?php post_class(); ?>">
            <div class="post-inner">
                <?php if (has_post_thumbnail()): ?>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php the_title_attribute(); ?>" class="post-thumbnail img-fluid">
                <?php endif; ?>
                <div class="post-content">
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <div class="post-meta">
                        <?php if (get_option('show_date', 1)): ?>
                        <span class="post-meta-item"><i class="fa fa-calendar"></i> <?php echo esc_html(get_the_date()); ?></span>
                        <?php endif; ?>
                        <?php if (get_option('show_author', 1)): ?>
                        <span class="post-meta-item"><i class="fa fa-user"></i> <?php echo esc_html(get_the_author()); ?></span>
                        <?php endif; ?>
                        <?php if (get_option('show_category', 1)): ?>
                        <span class="post-meta-item post-category">
                            <i class="fa fa-tags"></i> <?php the_category(', '); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
                // Add a row break after every 3 posts
                if ($post_count % 3 == 0) {
                    echo '</div><div class="clearfix"></div><div class="row">';
                }
            endwhile;
        else: ?>
        <p><?php esc_html_e('Sorry, no posts were found.', 'financeglow'); ?></p>
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
            'prev_text' => '<i class="fa fa-chevron-left"></i> ' . esc_html__('Previous', 'financeglow'),
            'next_text' => esc_html__('Next', 'financeglow') . ' <i class="fa fa-chevron-right"></i>',
        ));

        if ($pagination_links) {
            echo '<div class="pagination-wrapper">';
            echo '<ul class="pagination">';
            foreach ($pagination_links as $link) {
                echo "<li class='page-item'>$link</li>";
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>
