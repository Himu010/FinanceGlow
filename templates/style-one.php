<?php
// Always ensure this file is run within WordPress
defined('ABSPATH') || exit;

// Load the header
get_header();

// Custom hero section
get_template_part('content', 'herosec');

// Start the main content area
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
                <!-- Added post_class() here -->
                <div class="post-content">
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <!-- Excerpt limited to one line with ellipsis -->
                    <p class="post-excerpt">
                        <?php the_excerpt(); ?>
                    </p>
                    <!-- Post meta section -->
                    <div class="post-meta">
                        <div class="post-meta-row">
                            <?php if (get_option('show_date', 1)): ?>
                            <span class="post-meta-item">📅 <?php the_date(); ?></span>
                            <?php endif; ?>
                            <?php if (get_option('show_author', 1)): ?>
                            <span class="post-meta-item">✍️ <?php the_author(); ?></span>
                            <?php endif; ?>
                            <?php if (get_option('show_category', 1)): ?>
                            <span class="post-meta-item post-category">🏷️ <?php echo esc_html(the_category(', ')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.', 'financeglow'); ?></p>
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
                    'prev_text' => '<i class="fa fa-chevron-left"></i> ' . __('', 'financeglow'),
                    'next_text' => __('', 'financeglow') . ' <i class="fa fa-chevron-right"></i>',
                ));

                if ($pagination_links) {
                    echo '<div class="pagination-wrapper"><ul class="pagination">';
                    foreach ($pagination_links as $link) {
                        echo "<li class='page-item'>$link</li>";
                    }
                    echo '</ul></div>';
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
                        echo '<li style="margin-bottom: 10px;">
                                <a href="' . get_category_link($category->term_id) . '" style="text-decoration: none; color: #0073aa;">
                                    <i class="fa fa-folder" style="margin-right: 8px;"></i>' .
                            $category->name . ' (' . $post_count . ')
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
// Load the footer
get_footer();
?>