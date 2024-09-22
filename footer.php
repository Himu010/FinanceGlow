<footer class="bg-dark text-white mt-5">
    <!-- New Section -->
    <div class="bg-black text-white py-4">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Left Column (Footer Menu) -->
                <div class="col-md-4">
                    <h5 class="footer-header">Important Links</h5>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container' => false,
                        'menu_class' => 'list-unstyled important-links',
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'fallback_cb' => false,
                    ));
                    ?>
                </div>

                <!-- Middle Column -->
                <div class="col-md-4">
                    <h5 class="footer-header">Most Viewed Articles</h5>
                    <ul class="list-unstyled popular-articles">
                        <?php
                        $args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 5,
                            'meta_key' => 'post_views_count',
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC'
                        );
                        $popular_posts = new WP_Query($args);

                        if ($popular_posts->have_posts()) {
                            while ($popular_posts->have_posts()) {
                                $popular_posts->the_post();
                                echo '<li><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></li>';
                            }
                            wp_reset_postdata();
                        } else {
                            echo '<li>No articles available.</li>';
                        }
                        ?>
                    </ul>
                </div>

                <!-- Right Column -->
                <div class="col-md-4">
                    <h5 class="footer-header">About Us</h5>
                    <p><?php echo esc_html(get_option('site_description', 'Default description text here.')); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Text Section -->
    <div class="bg-blue text-center py-3 position-relative">
        <div class="container">
            <p class="mb-0">
                <?php
                $footer_text = get_option('footer_text', 'FinanceGlow.Net');
                $current_year = date('Y');
                echo esc_html($footer_text ? $footer_text . ' ' . $current_year : 'FinanceGlow.Net ' . $current_year);
                ?>
            </p>
        </div>
        <!-- Back to Top Button -->
        <a href="#" id="back-to-top" class="btn btn-primary">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>
</footer>

<?php wp_footer(); // Required for plugin compatibility ?>

