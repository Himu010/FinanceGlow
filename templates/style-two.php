<?php
// Always ensure this file is run within WordPress
defined('ABSPATH') || exit;

get_header(); // Include the header

get_template_part('content', 'herosec'); ?>

<style>
    .flex-row {
        display: flex;
        flex-wrap: wrap;
    }

    .post-card {
        box-sizing: border-box;
        /* Ensure padding/margins are included in width */
        margin: 10px;
        /* Adjust margin as needed */
        flex: 1 1 calc(33.333% - 20px);
        /* Three columns on larger screens */
    }

    @media (max-width: 768px) {
        .post-card {
            flex: 1 1 100% !important;
            /* Full width on mobile, using !important */
        }
    }
</style>

<div class="container mt-5">
    <div class="content-wrapper">
        <!-- Article List -->
        <div class="article-list">
            <h1>Articles</h1>
            <div class="flex-row">
                <?php if (have_posts()):
                    while (have_posts()):
                        the_post(); ?>
                        <div class="post-card <?php post_class(); ?>">
                            <!-- Add post_class() here -->
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="post-thumbnail">
                            <?php endif; ?>
                            <div class="post-content">
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <!-- Post meta section -->
                                <div class="post-meta">
                                    <div class="post-meta-row">
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
    </div>
</div>

<?php get_footer(); // Include the footer ?>