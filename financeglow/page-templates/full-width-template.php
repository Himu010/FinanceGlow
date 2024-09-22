<?php
/*
Template Name: Full Width Template
*/

// Always ensure this file is run within WordPress
defined('ABSPATH') || exit;

get_header(); ?>

<div class="container mt-5">
    <div class="full-width-content" style="width: 100%;">
        <?php if (have_posts()):
            while (have_posts()):
                the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>
                    style="border: 1px solid #ddd; padding: 20px; background-color: #fff;">
                    <!-- Page Title -->
                    <h1 class="page-title" style="color: #333;"><?php echo esc_html (the_title()); ?></h1>

                    <!-- Page Content -->
                    <div class="page-content" style="margin-top: 15px;">
                        <?php the_content(); ?>
                    </div>

                    <!-- Page Metadata (Optional) -->
                    <div class="page-meta">
                        <p class="page-date">Published on: <?php echo esc_html(get_the_date()); ?></p>
                    </div>

                    <!-- Page Navigation (Optional) -->
                    <div class="page-navigation">
                        <?php
                        // Display previous and next page links
                        wp_link_pages(array(
                            'before' => '<div class="page-links">Pages: ',
                            'after' => '</div>',
                        ));
                        ?>
                    </div>
                </article>
            <?php endwhile; else: ?>
            <p><?php _e('Sorry, no content found.', 'financeglow'); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>