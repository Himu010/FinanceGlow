<?php
/**
 * Register Custom Block Patterns
 */
function financeglow_register_block_patterns() {
    // Define a pattern
    $pattern = array(
        'title'       => __('Custom Content Block', 'financeglow'),
        'description' => _x('A content block with a paragraph and a button', 'Block pattern description', 'financeglow'),
        'content'     => '<!-- wp:paragraph --><p>Your custom content here.</p><!-- /wp:paragraph -->
                         <!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link" href="#">Click Here</a></div><!-- /wp:button -->',
    );

    // Register the pattern
    register_block_pattern('financeglow/custom-content-block', $pattern);
}
add_action('init', 'financeglow_register_block_patterns');
