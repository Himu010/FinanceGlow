<?php
// Check if the post is password protected
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            printf(
                esc_html__('Comments (%1$s)', 'financeglow'),
                number_format_i18n(get_comments_number())
            );
            ?>
        </h2>

        <ul class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ul',
                'short_ping' => true,
            ));
            ?>
        </ul>

        <div class="comment-pagination">
            <?php
            // Add comment pagination
            the_comments_navigation(array(
                'prev_text' => '<span class="screen-reader-text">' . esc_html__('Previous', 'financeglow') . '</span>',
                'next_text' => '<span class="screen-reader-text">' . esc_html__('Next', 'financeglow') . '</span>',
            ));
            ?>
        </div>

    <?php else : ?>
        <p><?php esc_html_e('No comments yet.', 'financeglow'); ?></p>
    <?php endif; ?>

    <!-- Comment Form -->
    <?php comment_form(); ?>
</div>
