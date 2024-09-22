<?php get_header(); ?>

<style>
    @media (max-width: 768px) {
        .left-column,
        .right-column {
            flex: 0 0 100%; /* Full width on mobile */
        }

        .right-column {
            margin-top: 20px; /* Add space between sections on mobile */
        }
    }
</style>

<div class="container mt-5 d-flex flex-column flex-md-row">
    <div class="left-column" style="flex: 0 0 70%; margin-bottom: 20px;">
        <?php if (have_posts()):
            while (have_posts()):
                the_post(); ?>
                <article <?php post_class(); ?> style="border: 1px solid #ddd; padding: 20px; background-color: #fff;">

                    <!-- Page Title -->
                    <h1 class="page-title" style="color: #333;"><?php the_title(); ?></h1>

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
            <?php endwhile; endif; ?>
    </div>

    <div class="right-column" style="flex: 0 0 30%; margin-left:10px;">
        <h2>Most Popular Articles</h2>
        <div class="popular-articles" style="border: 1px solid #ddd; padding: 15px; background-color: #fff;">
            <?php
            // Query for the most popular articles
            $popular_args = array(
                'posts_per_page' => 5,
                'meta_key' => 'post_views_count', // Adjust this according to your views count meta key
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
            );
            $popular_query = new WP_Query($popular_args);
            if ($popular_query->have_posts()):
                while ($popular_query->have_posts()):
                    $popular_query->the_post(); ?>
                    <div class="popular-article" style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
                        <a href="<?php echo esc_url(get_permalink()); ?>" style="color: #007bff; text-decoration: none;"><?php echo esc_html(get_the_title()); ?></a>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else: ?>
                <p><?php esc_html_e('No popular articles found.', 'financeglow'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
