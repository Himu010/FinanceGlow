<?php
/*
Template Name: Custom Design
*/

// Always ensure this file is run within WordPress
defined('ABSPATH') || exit;

get_header(); ?>

<div class="container mt-5">
    <div class="full-width-content" style="width: 100%;">
        <?php if (have_posts()):
            while (have_posts()):
                the_post(); ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?> style="margin-top: 15px;">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; else: ?>
            <p><?php _e('Sorry, no content found.', 'financeglow'); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>