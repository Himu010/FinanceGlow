<?php get_header(); ?>

<div class="container mt-5">
    <div class="row">
        <!-- Left Side: 70% width for main post content -->
        <div class="col-md-8 post-section">
            <?php if (have_posts()):
                while (have_posts()):
                    the_post(); ?>
            <article class="post <?php post_class(); ?>">
                <!-- Post Title -->
                <h1 class="post-title"><?php the_title(); ?></h1>

                <!-- Author Name -->
                <p class="post-author">By: <?php echo esc_html(get_the_author()); ?></p>

                <!-- Published Date and Social Share -->
                <div class="post-meta row">
                    <div class="col-md-6 post-date">
                        Published on: <?php echo esc_html(get_the_date()); ?>
                    </div>
                    <div class="col-md-6 post-share text-right">
                        <div class="social-share-icons" style="position: relative;">
                            <!-- Facebook Share -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink()); ?>"
                                target="_blank" class="social-icon" title="Share on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>

                            <!-- Twitter Share -->
                            <a href="https://twitter.com/intent/tweet?url=<?php echo esc_url(get_permalink()); ?>&text=<?php echo esc_html(get_the_title()); ?>"
                                target="_blank" class="social-icon" title="Share on Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>

                            <!-- LinkedIn Share -->
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url(get_permalink()); ?>&title=<?php echo esc_html(get_the_title()); ?>"
                                target="_blank" class="social-icon" title="Share on LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>

                            <!-- Pinterest Share -->
                            <a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&media=<?php echo esc_url(get_the_post_thumbnail_url()); ?>&description=<?php echo esc_html(get_the_title()); ?>"
                                target="_blank" class="social-icon" title="Pin on Pinterest">
                                <i class="fab fa-pinterest"></i>
                            </a>

                            <!-- WhatsApp Share (only works on mobile or WhatsApp Web) -->
                            <a href="https://api.whatsapp.com/send?text=<?php echo esc_html(get_the_title() . ' ' . get_permalink()); ?>"
                                target="_blank" class="social-icon" title="Share on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Border -->
                <hr class="post-separator">

                <!-- Post Content -->
                <div class="post-content">
                    <?php the_content(); ?>
                </div>

                <!-- Category Section with Margin and Borders -->
                <div class="post-category"
                    style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; margin-top: 20px; padding: 10px 0;">
                    Category: <?php echo esc_html(the_category(', ')); ?>
                </div>

                <!-- Display Post Tags -->
                <div class="post-tags">
                    <?php 
                    if (has_tag()) {
                        echo '<p class="tags">' . esc_html__('Tags: ', 'financeglow') . get_the_tag_list('', ', ') . '</p>'; 
                    }
                    ?>
                </div>

                <!-- Display Approved Comments Section -->
                <?php if (have_comments()) : ?>
                    <div class="approved-comments mt-4"
                        style="background-color: #f8f9fa; border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                        <h3><?php esc_html_e('Comments', 'financeglow'); ?></h3>
                        <ul class="comment-list">
                            <?php
                            wp_list_comments([
                                'style' => 'ul',
                                'short_ping' => true,
                                'avatar_size' => 50,
                            ]);
                            ?>
                        </ul>

                        <!-- Comment Pagination -->
                        <div class="comment-pagination">
                            <?php
                            // Display comment pagination
                            paginate_comments_links([
                                'prev_text' => __('« Previous', 'financeglow'),
                                'next_text' => __('Next »', 'financeglow'),
                            ]);
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Comments Box Styled as Card -->
                <div class="post-comments mt-4"
                    style="background-color: #f8f9fa; border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                    <?php comments_template(); ?>
                </div>

                <!-- Most Recent Posts Section Styled as Flex Row -->
                <div class="most-recent-posts">
                    <h3><?php esc_html_e('Recent Posts', 'financeglow'); ?></h3>
                    <div class="d-flex flex-row flex-wrap justify-content-between">
                        <?php
                        // Get 5 most recent posts
                        $recent_posts = new WP_Query([
                            'posts_per_page' => 5,
                            'post_status' => 'publish',
                        ]);

                        if ($recent_posts->have_posts()):
                            while ($recent_posts->have_posts()):
                                $recent_posts->the_post(); ?>
                        <div class="recent-post-box mb-3" style="width: 18%; text-align: center;">
                            <a href="<?php echo esc_url(get_permalink()); ?>" style="display: block;">
                                <div class="recent-post-thumbnail"
                                    style="height: 100px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('thumbnail', ['class' => 'img-fluid', 'style' => 'max-height: 100%; max-width: 100%;']); ?>
                                    <?php endif; ?>
                                </div>
                                <p class="recent-post-title" style="font-size: 14px; margin-top: 10px;">
                                    <?php echo esc_html(get_the_title()); ?></p>
                            </a>
                        </div>
                        <?php endwhile;
                            wp_reset_postdata();
                        endif; ?>
                    </div>
                </div>
            </article>
            <?php endwhile; endif; ?>
        </div>

        <!-- Right Side: Most Popular Posts Styled as a Column -->
        <div class="col-md-4 popular-posts-section">
            <h3><?php esc_html_e('Most Popular', 'financeglow'); ?></h3>
            <div class="d-flex flex-column">
                <?php
                // Query for the 6 most viewed posts
                $popular_posts = new WP_Query([
                    'meta_key' => 'post_views_count',
                    'orderby' => 'meta_value_num',
                    'posts_per_page' => 6,
                    'post_status' => 'publish',
                ]);

                if ($popular_posts->have_posts()):
                    while ($popular_posts->have_posts()):
                        $popular_posts->the_post(); ?>
                <div class="popular-post-box mb-3" style="text-align: center;">
                    <a href="<?php echo esc_url(get_permalink()); ?>" style="display: block;">
                        <div class="popular-post-thumbnail"
                            style="height: 100px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('thumbnail', ['class' => 'img-fluid', 'style' => 'max-height: 100%; max-width: 100%;']); ?>
                            <?php endif; ?>
                        </div>
                        <p class="popular-post-title" style="font-size: 14px; margin-top: 10px;"><?php echo esc_html(get_the_title()); ?>
                        </p>
                    </a>
                </div>
                <?php endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
