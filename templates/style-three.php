<?php get_header(); // Include the header

get_template_part('content', 'herosec'); // Include the hero section

// Always ensure this file is run within WordPress
defined('ABSPATH') || exit;
?>

<style>
    .post-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        padding: 15px;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        transition: box-shadow 0.3s ease;
    }

    .post-card:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .post-card-row {
        display: flex;
    }

    .post-thumbnail {
        flex: 1;
        margin-right: 15px;
        overflow: hidden;
        width: auto;
        height: auto;
    }

    .post-thumbnail-img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .post-details {
        flex: 2;
    }

    .post-title {
        margin: 0 0 10px;
    }

    .post-meta {
        font-size: 0.9em;
        color: #666;
    }
    /* Responsive styles */
@media (max-width: 768px) {
    .post-card-row {
        flex-direction: column;
    }

    .post-thumbnail {
        margin-right: 0;
        margin-bottom: 15px;
        height: auto; /* Adjust thumbnail height */
    }

    .post-details {
        flex: none; /* Allow details to take full width */
    }
}
</style>

<div class="container mt-5">
    <div class="content-wrapper">
        <!-- Article List -->
        <div class="article-list">
            <h1>Articles</h1>
            <?php if (have_posts()):
                while (have_posts()):
                    the_post(); ?>
                    <div class="post-card <?php post_class(); ?>" style="cursor: pointer;"
                        onclick="location.href='<?php the_permalink(); ?>';">
                        <div class="post-card-row">
                            <div class="post-thumbnail">
                                <?php if (has_post_thumbnail()): ?>
                                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"
                                        class="post-thumbnail-img">
                                <?php endif; ?>
                            </div>
                            <div class="post-details">
                                <h2 class="post-title">
                                    <?php the_title(); ?>
                                </h2>
                                <div class="post-meta">
                                    <?php if (get_option('show_date', 1)): ?>
                                        <span class="post-meta-item">
                                            📅 <?php the_date(); ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (get_option('show_author', 1)): ?>
                                        <span class="post-meta-item">
                                            ✍️ <?php the_author(); ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (get_option('show_category', 1)): ?>
                                        <span class="post-meta-item post-category">
                                            🏷️ <?php the_category(', '); ?>
                                        </span>
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

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="widget">
                <h2 class="widget-title">Categories</h2>
                <ul class="category-list" style="list-style: none; padding: 0;">
                    <?php
                    $categories = get_categories();
                    foreach ($categories as $category) {
                        $post_count = $category->count;
                        $icon_class = 'fa fa-folder'; // Default icon, customize as needed
                        echo '<li style="margin-bottom: 10px;">
                                <a href="' . get_category_link($category->term_id) . '" style="text-decoration: none; color: #0073aa;">
                                    <i class="' . $icon_class . '" style="margin-right: 8px;"></i>' .
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
                    <div class="widget">
                        <?php dynamic_sidebar('bottom-widget-1'); ?>
                    </div>
                <?php endif; ?>
                <?php if (is_active_sidebar('bottom-widget-2')): ?>
                    <div class="widget">
                        <?php dynamic_sidebar('bottom-widget-2'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</div>

<?php get_footer(); // Include the footer ?>