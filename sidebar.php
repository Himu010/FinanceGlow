<?php
// Start the sidebar section
?>

<div id="sidebar" style="padding: 20px; background: #f4f4f4;">

    <!-- Search Box -->
    <div class="search-box" style="margin-bottom: 20px;">
        <?php get_search_form(); ?>
    </div>

    <!-- Recent Posts -->
    <div class="recent-posts" style="margin-bottom: 20px;">
        <h3 style="margin-bottom: 10px;"><?php esc_html_e('Recent Posts', 'financeglow'); ?></h3>
        <?php
        $recent_posts = new WP_Query(array(
            'posts_per_page' => 5,
            'post_status' => 'publish'
        ));

        if ($recent_posts->have_posts()):
            while ($recent_posts->have_posts()):
                $recent_posts->the_post();
                ?>
                <div class="recent-post" style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
                    <a href="<?php echo esc_url(get_permalink()); ?>" style="text-decoration: none; color: #0073aa;">
                        <h4 style="margin: 0;"><?php echo esc_html(get_the_title()); ?></h4>
                    </a>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else:
            echo '<p>' . esc_html__('No recent posts available.', 'financeglow') . '</p>';
        endif;
        ?>
    </div>

    <!-- Categories -->
    <div class="categories" style="margin-bottom: 20px;">
        <h3 style="margin-bottom: 10px;"><?php esc_html_e('Categories', 'financeglow'); ?></h3>
        <ul style="list-style: none; padding: 0;">
            <?php
            $categories = get_categories();
            $i = 0;
            foreach ($categories as $category):
                $class = ($i % 2 == 0) ? 'even' : 'odd';
                $i++;
                ?>
                <li style="background: <?php echo ($class == 'even') ? '#f9f9f9' : '#e9e9e9'; ?>; padding: 10px; border-bottom: 1px solid #ddd;">
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                        style="text-decoration: none; color: #0073aa;">
                        <?php echo esc_html($category->name); ?>
                    </a>
                </li>
                <?php
            endforeach;
            ?>
        </ul>
    </div>

    <!-- Archives -->
    <div class="archives" style="margin-bottom: 20px;">
        <h3 style="margin-bottom: 10px;"><?php esc_html_e('Archives', 'financeglow'); ?></h3>
        <ul style="list-style: none; padding: 0;">
            <?php
            $archives = wp_get_archives(array(
                'type' => 'monthly',
                'limit' => 12,
                'show_post_count' => true,
                'echo' => 0
            ));
            if ($archives) {
                echo wp_kses_post($archives); // Escape the archives output
            } else {
                echo '<li>' . esc_html__('No archives available.', 'financeglow') . '</li>';
            }
            ?>
        </ul>
    </div>

</div>
