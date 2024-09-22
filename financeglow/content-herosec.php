<?php
// Query for fetching 5 featured posts
$args = array(
    'posts_per_page' => 5, // Limit to 5 posts
    'meta_key' => '_is_featured', // Custom meta key for featured posts
    'meta_value' => '1', // Only fetch posts marked as 'featured'
    'orderby' => 'meta_value_num', // Optional: You can order posts by views
    'order' => 'DESC'
);
$featured_posts = new WP_Query($args);

// Only display the hero section if there are featured posts
if ($featured_posts->have_posts()): ?>
    <div class="hero-section">
        <h2><?php esc_html_e('Featured Stories', 'financeglow'); ?></h2>
        <div class="stories-container">
            <?php
            // Determine if the current view is mobile
            $is_mobile = wp_is_mobile();
            $is_first_post = true; // Flag to show only the first post initially on mobile
        
            // Loop through the posts
            while ($featured_posts->have_posts()):
                $featured_posts->the_post(); ?>
                <div class="story-item <?php echo esc_attr(implode(' ', get_post_class())); ?> <?php echo $is_mobile && !$is_first_post ? 'mobile-hidden' : ''; ?>">
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="story-thumbnail">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="story-title">
                            <h3><?php echo esc_html(get_the_title()); ?></h3>
                        </div>
                    </a>
                    <div class="story-views">
                        <?php esc_html_e('Views:', 'financeglow'); ?> <?php echo esc_html(get_post_meta(get_the_ID(), 'post_views_count', true)); ?>
                    </div>
                </div>
                <?php
                if ($is_mobile && $is_first_post) {
                    $is_first_post = false; // Only show the first post
                }
            endwhile;
            wp_reset_postdata(); ?>
        </div>
    </div>

    <button id="see-more-btn" class="see-more-btn"><?php esc_html_e('See more', 'financeglow'); ?></button>

    <!-- Popup Container -->
    <div id="popup-container" class="popup-container">
        <div class="popup-content">
            <span id="popup-close" class="popup-close">&times;</span>
            <div class="popup-stories">
                <?php
                // Reset the query for showing all featured posts in popup
                $featured_posts = new WP_Query($args);

                if ($featured_posts->have_posts()):
                    while ($featured_posts->have_posts()):
                        $featured_posts->the_post(); ?>
                        <div class="popup-story-item <?php echo esc_attr(implode(' ', get_post_class())); ?>">
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="popup-story-thumbnail">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="popup-story-title">
                                    <h3><?php echo esc_html(get_the_title()); ?></h3>
                                </div>
                            </a>
                            <div class="popup-story-views">
                                <?php esc_html_e('Views:', 'financeglow'); ?> <?php echo esc_html(get_post_meta(get_the_ID(), 'post_views_count', true)); ?>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                else:
                    echo '<p>' . esc_html__('No featured posts found.', 'financeglow') . '</p>';
                endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
