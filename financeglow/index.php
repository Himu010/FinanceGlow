<?php
$selected_template = get_option('financeglow_template_option', 'style-one');

if (file_exists(get_template_directory() . "/templates/{$selected_template}.php")) {
    get_template_part("templates/{$selected_template}"); // Use get_template_part instead of include
} else {
    get_header(); // Include the header

    get_template_part('content', 'herosec'); // Include the hero section
    ?>
<div class="container mt-5">
    <div class="content-wrapper">
        <!-- Article List -->
        <div class="article-list">
            <h1>Articles</h1>
            <?php if (have_posts()):
                while (have_posts()):
                    the_post(); ?>
            <div class="post-card <?php post_class(); ?>">
                <?php if (has_post_thumbnail()): ?>
                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="post-thumbnail">
                <?php endif; ?>
                <div class="post-content">
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="post-excerpt"><?php the_excerpt(); ?></p>
                    <div class="post-meta">
                        <div class="post-meta-row">
                            <?php if (get_option('show_date', 1)): ?>
                            <span class="post-meta-item">📅 <?php echo esc_html(get_the_date()); ?></span>
                            <?php endif; ?>
                            <?php if (get_option('show_author', 1)): ?>
                            <span class="post-meta-item">✍️ <?php echo esc_html(get_the_author()); ?></span>
                            <?php endif; ?>
                            <?php if (get_option('show_category', 1)): ?>
                            <span class="post-meta-item post-category">🏷️
                                <?php echo esc_html(the_category(', ')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.', 'financeglow'); ?></p> <!-- Added text domain -->
            <?php endif; ?>


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
                        'prev_text' => '<i class="fa fa-chevron-left"></i> ',
                        'next_text' => ' <i class="fa fa-chevron-right"></i>',
                    ));

                    if ($pagination_links) {
                        echo '<div class="pagination-wrapper">';
                        echo '<ul class="pagination">';
                        foreach ($pagination_links as $link) {
                            echo "<li class='page-item'>$link</li>";
                        }
                        echo '</ul>';
                        echo '<div class="pagination-jump">';
                        echo '<form id="jump-form" action="" method="get">';
                        echo '<label for="page-number">Jump to page: </label>';
                        echo '<input type="number" id="page-number" name="paged" min="1" max="' . esc_attr($wp_query->max_num_pages) . '" required>';
                        echo '<button type="submit" class="btn btn-primary">Go</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>'; // Close pagination-wrapper
                    }
                    ?>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="widget">
                <h2 class="widget-title">Categories</h2>
              <ul class="category-list" style="list-style: none; padding: 0;">
                    <?php
                        $categories = get_categories();
                        foreach ($categories as $category) {
                            $post_count = $category->count;
                            $icon_class = 'fa fa-folder'; // Default icon
                            echo '<li style="margin-bottom: 10px;">
                                <a href="' . esc_url(get_category_link($category->term_id)) . '" style="text-decoration: none; color: #0073aa;">
                                    <i class="' . esc_attr($icon_class) . '" style="margin-right: 8px;"></i>' .
                                esc_html($category->name) . ' (' . esc_html($post_count) . ')
                                </a>
                              </li>';
                        }
                        ?>
                </ul>
            </div>

            <!-- Additional Widget Areas -->
            <div class="widget-area">
                <?php if (is_active_sidebar('bottom-widget-1')): ?>
                <div class="widget"><?php dynamic_sidebar('bottom-widget-1'); ?></div>
                <?php endif; ?>
                <?php if (is_active_sidebar('bottom-widget-2')): ?>
                <div class="widget"><?php dynamic_sidebar('bottom-widget-2'); ?></div>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</div>

<?php
    get_footer(); // Include the footer
}
?>
</body>

</html>