<?php get_header(); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card text-center p-4" style="
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 1.5rem;
                background-color: #fff;
            ">
                <div class="card-body">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/404-not-found.jpeg'); ?>"
                        alt="No Results Found" class="img-fluid no-results-image mb-3" style="
                        width: 150px;
                        height: 150px;
                        object-fit: cover;
                    ">
                    <h2 class="card-title" style="margin-bottom: 1rem;">Oops! 404 Error.</h2>
                    <p class="card-text" style="margin-bottom: 1.5rem;">We couldn't find the page you're looking for.
                        Try searching for something else.</p>

                    <!-- Use get_search_form() instead of hardcoded search form -->
                    <div class="card">
                        <?php get_search_form(); ?>
                        
                    </div>

                    <a href="<?php echo esc_url(home_url()); ?>"
                        class="btn btn-secondary"><?php esc_html_e('Return to Home', 'financeglow'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>