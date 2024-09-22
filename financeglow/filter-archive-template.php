<?php
/* Template Name: Filter Archive */
get_header();

// Check if a date is selected
if (isset($_GET['filter-date'])) {
    $selected_date = sanitize_text_field($_GET['filter-date']);

    // Setup pagination
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $posts_per_page = 6; // Set the number of posts per page

    // Query posts by the selected date
    $args = array(
        'date_query' => array(
            array(
                'year' => date('Y', strtotime($selected_date)),
                'month' => date('m', strtotime($selected_date)),
                'day' => date('d', strtotime($selected_date)),
            ),
        ),
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
    );

    $filtered_posts = new WP_Query($args);

    // Display the filtered posts
    if ($filtered_posts->have_posts()) {
        echo '<h2>Posts from ' . date('F j, Y', strtotime($selected_date)) . ':</h2>';
        echo '<div class="row">';

        while ($filtered_posts->have_posts()):
            $filtered_posts->the_post(); ?>
            <div class="col-md-4 post-card mb-4 <?php post_class(); ?>">
                <div class="card h-100">
                    <?php if (has_post_thumbnail()): ?>
                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="card-img-top" style="max-height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h5>
                    </div>
                    <div class="card-footer text-muted">
                        <span><i class="fa fa-calendar"></i> <?php the_time('F j, Y'); ?></span> |
                        <span><i class="fa fa-user"></i> <?php the_author(); ?></span> |
                        <span><i class="fa fa-tags"></i> <?php the_category(', '); ?></span>
                    </div>
                </div>
            </div>
            <?php
        endwhile;

        echo '</div>'; // End row

        // Pagination links
        echo '<div class="pagination-wrapper">';
        $big = 999999999; // An unlikely integer
        $pagination_links = paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $filtered_posts->max_num_pages,
            'prev_text' => '<i class="fa fa-chevron-left"></i>', // Matching other pages' pagination
            'next_text' => '<i class="fa fa-chevron-right"></i>', // Matching other pages' pagination
            'type' => 'array',
        ));

        if ($pagination_links) {
            echo '<ul class="pagination">';
            foreach ($pagination_links as $link) {
                echo "<li class='page-item'>$link</li>";
            }
            echo '</ul>';
        }
        echo '</div>'; // End pagination-wrapper

    } else {
        // No posts found for the selected date
        echo '<h2>No posts found for ' . date('F j, Y', strtotime($selected_date)) . '.</h2>';
    }

    // Reset post data
    wp_reset_postdata();

} else {
    echo '<h2>No date selected. Please select a date to filter posts.</h2>';
}
?>

<!-- Date Filter Form -->
<div class="date-filter mt-4">
    <h3>Filter Posts by Date:</h3>
    <form method="get" action="">
        <label for="filter-date">Select a date:</label>
        <input type="date" id="filter-date" name="filter-date" required>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

<!-- Link to go back to Home page -->
<div class="back-link mt-4">
    <a href="<?php echo esc_url(home_url()); ?>" class="btn btn-secondary">Back to Home</a>
</div>

<?php get_footer(); ?>
