<?php
// functions.php
function custom_theme_enqueue_styles() {
    // Enqueue Bootstrap CSS (bundled with the theme)
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '6.6.2');

    // Enqueue FontAwesome (bundled with the theme)
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '6.6.0');

    // Enqueue your main stylesheet
    wp_enqueue_style('main-style', get_stylesheet_uri());

    // Enqueue jQuery (WordPress includes it by default)
    wp_enqueue_script('jquery');

    // Enqueue Popper.js for Bootstrap tooltips and popovers (bundled with the theme)
    wp_enqueue_script('popper', get_template_directory_uri() . '/assets/js/popper.min.js', array('jquery'), '1.16.0', true);

    // Enqueue Bootstrap JS (bundled with the theme)
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery', 'popper'), '4.5.2', true);

    // Path to the script file in your theme directory
    $script_path = get_template_directory() . '/assets/js/script.js';

    // Enqueue the script, using filemtime() for cache busting (version)
    wp_enqueue_script(
        'custom-js', // Handle name
        get_template_directory_uri() . '/assets/js/script.js', // Script URL
        array('jquery'), // Dependencies (e.g., jQuery)
        filemtime($script_path), // Cache busting version based on file modification time
        true // Load in footer
    );

    // Back to Top Button Script
    wp_add_inline_script('custom-js', '
        document.getElementById("back-to-top").addEventListener("click", function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    ');

    // Localize the max pages variable
    wp_localize_script('custom-js', 'maxPages', array('value' => (int) $GLOBALS['wp_query']->max_num_pages));
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_styles');


// Enqueue additional styles for templates
function theme_enqueue_styles()
{
    // Enqueue additional styles if a selected template exists
    if (get_option('selected_template')) {
        $selected_template = get_option('selected_template');
        wp_enqueue_style('template-style', esc_url(get_template_directory_uri() . '/templates/' . $selected_template));
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

// Theme setup
function custom_theme_setup()
{
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'financeglow'), // Ensure consistent text domain
    ));

    // Add support for title tag
    add_theme_support('title-tag');

    // Add support for automatic feed links
    add_theme_support('automatic-feed-links');

    // Add support for HTML5 markup
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'caption', 'style', 'script'));

    // Add support for custom logo
    add_theme_support('custom-logo');

    // Add support for custom background
    add_theme_support('custom-background');

    // Add support for custom header
    add_theme_support('custom-header');
    
    //add wp_block style
     add_theme_support('wp-block-styles');
     
     //add responsive embed
     add_theme_support( 'responsive-embeds' );
     
     //support align wide
     add_theme_support( 'align-wide' );
     
     // Add support for title tag
     add_theme_support('title-tag');
     
     //add fav icon
     add_theme_support('site-icon');

     
     
    add_editor_style( 'assets/css/editor-style.css' ); // Adjust the path as necessary
    // Other theme supports...

}
add_action('after_setup_theme', 'custom_theme_setup');

// Enqueue comment-reply script if comments are open
function financeglow_enqueue_comment_reply() {
    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'financeglow_enqueue_comment_reply');


// Create default primary menu after switching theme
function financeglow_create_default_primary_menu() {
    // Create a new menu named "Primary Menu" (or any name you'd like)
    $menu_name = 'Primary Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    // Create the menu if it doesn't exist
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // Assign the new menu to the primary location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);

        // Optionally, create default pages (Home, About, Contact) if they don't exist
        $default_pages = array(
            'Home'    => esc_url(home_url('/')),
            'About'   => esc_url(home_url('/about')),
            'Contact' => esc_url(home_url('/contact'))
        );

        // Add default links to the newly created menu
        foreach ($default_pages as $page_title => $page_url) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'   => $page_title,
                'menu-item-url'     => $page_url, // Link to a URL
                'menu-item-status'  => 'publish'  // Ensure the menu item is published
            ));
        }
    } else {
        // If the menu exists, assign it to the primary location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_exists->term_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_switch_theme', 'financeglow_create_default_primary_menu');


// Ensure theme supports post categories and tags
function add_category_and_tag_support()
{
    register_taxonomy_for_object_type('category', 'post'); // Add categories to posts
    register_taxonomy_for_object_type('post_tag', 'post'); // Add tags to posts
}
add_action('init', 'add_category_and_tag_support');

// Register sidebar widgets
function custom_theme_widgets_init()
{
    register_sidebar(array(
        'name' => __('Main Sidebar', 'financeglow'), // Ensure consistent text domain
        'id' => 'main-sidebar',
        'description' => __('Widgets in this area will be shown in the sidebar.', 'financeglow'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    // Additional Widget Areas
    register_sidebar(array(
        'name' => __('Home Sidebar Widget 1', 'financeglow'),
        'id' => 'bottom-widget-1',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Home Sidebar Widget 2', 'financeglow'),
        'id' => 'bottom-widget-2',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'custom_theme_widgets_init');









// Create FinanceGlow Settings Page
function financeglow_add_admin_menu()
{
    add_menu_page(
        'FinanceGlow Settings',
        'FinanceGlow',
        'manage_options',
        'financeglow-settings',
        'financeglow_settings_page',
        'dashicons-admin-generic',
        20
    );
}
add_action('admin_menu', 'financeglow_add_admin_menu');

// FinanceGlow Settings Page Content
function financeglow_settings_page()
{
    ?>
<div class="wrap">
    <h1><?php esc_html_e('FinanceGlow Settings', 'financeglow'); ?></h1>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php
                settings_fields('financeglow_settings_group');
                do_settings_sections('financeglow-settings');
                submit_button();
                ?>
    </form>
</div>
<?php
}

// Register FinanceGlow Settings
function financeglow_settings_init()
{
    register_setting('financeglow_settings_group', 'financeglow_logo');
    register_setting('financeglow_settings_group', 'show_author');
    register_setting('financeglow_settings_group', 'show_date');
    register_setting('financeglow_settings_group', 'show_category');
    register_setting('financeglow_settings_group', 'financeglow_social_links');
    register_setting('financeglow_settings_group', 'site_description');
    register_setting('financeglow_settings_group', 'footer_text'); // New field for footer text

    add_settings_section(
        'financeglow_settings_section',
        esc_html__('Display Settings', 'financeglow'),
        'financeglow_settings_section_callback',
        'financeglow-settings'
    );

    add_settings_field(
        'financeglow_logo',
        esc_html__('Upload Logo', 'financeglow'),
        'financeglow_logo_callback',
        'financeglow-settings',
        'financeglow_settings_section'
    );

    add_settings_field(
        'show_author',
        esc_html__('Show Author', 'financeglow'),
        'financeglow_show_author_callback',
        'financeglow-settings',
        'financeglow_settings_section'
    );

    add_settings_field(
        'show_date',
        esc_html__('Show Published Date', 'financeglow'),
        'financeglow_show_date_callback',
        'financeglow-settings',
        'financeglow_settings_section'
    );

    add_settings_field(
        'show_category',
        esc_html__('Show Category', 'financeglow'),
        'financeglow_show_category_callback',
        'financeglow-settings',
        'financeglow_settings_section'
    );

    add_settings_field(
        'financeglow_social_links',
        esc_html__('Social Media Links', 'financeglow'),
        'financeglow_social_links_callback',
        'financeglow-settings',
        'financeglow_settings_section'
    );

    add_settings_field(
        'site_description',
        esc_html__('Site Description', 'financeglow'),
        'financeglow_site_description_callback',
        'financeglow-settings',
        'financeglow_settings_section'
    );

    add_settings_field(
        'footer_text', // New field for footer text
        esc_html__('Footer Text', 'financeglow'),
        'financeglow_footer_text_callback',
        'financeglow-settings',
        'financeglow_settings_section'
    );
}
add_action('admin_init', 'financeglow_settings_init');

// Callbacks for the settings
function financeglow_settings_section_callback()
{
    echo esc_html__('Configure your display settings below.', 'financeglow');
}

function financeglow_logo_callback() {
    // Use home_url() to construct the full URL for the default logo
    $default_logo = home_url('/wp-content/themes/FinanceGlow/assets/images/FinanceGlow-Logo.png');
    $logo = get_option('financeglow_logo', $default_logo);
    ?>
    <input type="hidden" id="financeglow_logo" name="financeglow_logo" value="<?php echo esc_attr($logo); ?>" />
    <input type="button" class="button button-secondary" value="<?php esc_attr_e('Upload Logo', 'financeglow'); ?>" id="upload_logo_button" />
    <div>
        <?php if ($logo): ?>
            <img src="<?php echo esc_url($logo); ?>" style="max-width: 200px; display: block; margin-top: 10px;" />
        <?php endif; ?>
    </div>
    <?php
}


function financeglow_show_author_callback()
{
    $checked = get_option('show_author', 1) ? 'checked' : '';
    echo '<input type="checkbox" id="show_author" name="show_author" value="1" ' . $checked . ' /> ' . esc_html__('Show Author', 'financeglow');
}

function financeglow_show_date_callback()
{
    $checked = get_option('show_date', 1) ? 'checked' : '';
    echo '<input type="checkbox" id="show_date" name="show_date" value="1" ' . $checked . ' /> ' . esc_html__('Show Published Date', 'financeglow');
}

function financeglow_show_category_callback()
{
    $checked = get_option('show_category', 1) ? 'checked' : '';
    echo '<input type="checkbox" id="show_category" name="show_category" value="1" ' . $checked . ' /> ' . esc_html__('Show Category', 'financeglow');
}

function financeglow_social_links_callback()
{
    $social_links = get_option('financeglow_social_links', []);
    $platforms = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'];
    foreach ($platforms as $platform) {
        $url = esc_url($social_links[$platform] ?? '');
        echo '<input type="text" name="financeglow_social_links[' . esc_attr($platform) . ']" value="' . $url . '" placeholder="' . esc_attr(ucfirst($platform)) . ' URL" /><br />';
    }
}

function financeglow_site_description_callback()
{
    $site_description = get_option('site_description', '');
    ?>
<textarea id="site_description" name="site_description" rows="5" cols="50"
    maxlength="300"><?php echo esc_textarea($site_description); ?></textarea>
<p class="description"><?php esc_html_e('Max 300 characters.', 'financeglow'); ?></p>
<?php
}

function financeglow_footer_text_callback()
{
    $footer_text = get_option('footer_text', '');
    ?>
<input type="text" id="footer_text" name="footer_text" value="<?php echo esc_attr($footer_text); ?>" maxlength="255" />
<p class="description"><?php esc_html_e('Text to display in the footer.', 'financeglow'); ?></p>
<?php
}

// Enqueue Media Uploader
function financeglow_enqueue_media_uploader()
{
    wp_enqueue_media();
    wp_enqueue_script('financeglow-media-uploader', get_template_directory_uri() . '/assets/js/financeglow-media-uploader.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'financeglow_enqueue_media_uploader');




// Set custom web-safe fonts globally
function custom_theme_additional_css()
{
    ?>
<style>
body {
    font-family: 'Verdana', sans-serif;
    font-size: 16px;
}

.site-logo img {
    max-width: 150px;
    height: auto;
}

.nav-menu {
    font-family: 'Verdana', sans-serif;
    font-size: 16px;
}

.links-section {
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: black;
    color: white;
    flex-wrap: wrap;
}

.left-section,
.right-section {
    display: flex;
    align-items: center;
    flex-wrap:wrap;
}


.social-icon {
    color: white;
    text-decoration: none;
    padding: 0 10px;
}

.social-icon:hover {
    opacity: 0.8;
}

@media (max-width: 768px) {
    .links-section {
        flex-direction: column;
        align-items: center;
        padding: 20px;
    }

    .left-section,
    .right-section {
        width: 100%;
        justify-content: center;
        margin-bottom: 10px;
    }

    .right-section {
        margin-bottom: 0;
    }

    .col-md-6 {
        text-align: center;
    }

    .social-icon {
        padding: 0 5px;
    }

    .text-right {
        margin-top: 15px;
        margin-left: 50px;
    }
}
</style>
<?php
}
add_action('wp_head', 'custom_theme_additional_css');

// Track post views
function set_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count === '') {
        $count = 0;
        add_post_meta($postID, $count_key, '1', true);
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function track_post_views($post_id)
{
    if (!is_single())
        return;
    if (empty($post_id))
        $post_id = get_the_ID();
    set_post_views($post_id);
}
add_action('wp_head', 'track_post_views');

function exclude_admin_from_post_views($exclude)
{
    if (current_user_can('manage_options'))
        return true;
    return $exclude;
}
add_filter('wpb_exclude_post_views', 'exclude_admin_from_post_views');

// Add featured box when post
function add_featured_meta_box()
{
    add_meta_box(
        'featured_meta_box',
        esc_html__('Featured Post', 'financeglow'),
        'featured_meta_box_callback',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'add_featured_meta_box');

function featured_meta_box_callback($post)
{
    wp_nonce_field('save_featured_meta_box', 'featured_meta_box_nonce');
    $is_featured = get_post_meta($post->ID, '_is_featured', true);
    ?>
<label for="featured_post_checkbox">
    <input type="checkbox" id="featured_post_checkbox" name="featured_post_checkbox" value="1"
        <?php checked($is_featured, '1'); ?> />
    <?php esc_html_e('Mark this post as Featured', 'financeglow'); ?>
</label>
<?php
}

function save_featured_meta_box_data($post_id)
{
    if (!isset($_POST['featured_meta_box_nonce']) || !wp_verify_nonce($_POST['featured_meta_box_nonce'], 'save_featured_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['featured_post_checkbox'])) {
        update_post_meta($post_id, '_is_featured', '1');
    } else {
        delete_post_meta($post_id, '_is_featured');
    }
}
add_action('save_post', 'save_featured_meta_box_data');

// Register sidebar
function financeglow_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar', 'financeglow'),
        'id' => 'sidebar-1',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'financeglow_widgets_init');

// Add header links
function add_header_links()
{
    get_template_part('links/header-links');
}
add_action('wp_head', 'add_header_links');

function register_footer_menu()
{
    register_nav_menu('footer', __('Footer Menu', 'financeglow'));
}
add_action('init', 'register_footer_menu');

// Automatically create "Filter Archive" page with custom template upon theme activation
function create_filter_archive_page()
{
    if (!get_page_by_path('filter-archive')) {
        $page_data = array(
            'post_title' => 'Filter Archive (Do not Delete)',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'filter-archive',
        );

        $page_id = wp_insert_post($page_data);
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'filter-archive-template.php');
        }
    }
}
add_action('after_switch_theme', 'create_filter_archive_page');

// Recreate the "Filter Archive" page if it's deleted
function recreate_filter_archive_page()
{
    if (!get_page_by_title('Filter Archive')) {
        create_filter_archive_page();
    }
}
add_action('wp', 'recreate_filter_archive_page');





// Add arrow to menu items with submenu
function add_arrow_to_menu_items_with_submenu($items, $args)
{
    foreach ($items as &$item) {
        if (in_array('menu-item-has-children', $item->classes, true)) {
            // Add Font Awesome chevron down icon to items with submenus
            $item->title .= ' <span class="submenu-arrow"><i class="fas fa-chevron-down"></i></span>';
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'add_arrow_to_menu_items_with_submenu', 10, 2);

// Extra theme templates
function financeglow_theme_options_page()
{
    add_menu_page(
        __('Theme Templates', 'financeglow'),
        __('Theme Templates', 'financeglow'),
        'manage_options',
        'financeglow-options',
        'financeglow_options_page_html',
        '',
        100
    );
}
add_action('admin_menu', 'financeglow_theme_options_page');

function financeglow_options_page_html()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    // Check if the user has submitted the settings
    if (isset($_POST['financeglow_template_option'])) {
        update_option('financeglow_template_option', sanitize_text_field($_POST['financeglow_template_option']));
        echo '<div class="updated"><p>' . esc_html__('Settings saved!', 'financeglow') . '</p></div>';
    }

    $current_option = get_option('financeglow_template_option', 'style-one');
    $templates = [
        'default' => [
            'name' => __('Default Theme', 'financeglow'),
            'image' => esc_url(get_template_directory_uri() . '/assets/images/default-theme.png')
        ],
        'style-one' => [
            'name' => __('Style One', 'financeglow'),
            'image' => esc_url(get_template_directory_uri() . '/assets/images/style-one.png')
        ],
        'style-two' => [
            'name' => __('Style Two', 'financeglow'),
            'image' => esc_url(get_template_directory_uri() . '/assets/images/style-two.png')
        ],
        'style-three' => [
            'name' => __('Style Three', 'financeglow'),
            'image' => esc_url(get_template_directory_uri() . '/assets/images/style-three.png')
        ],
    ];

    ?>
<div class="wrap">
    <h1><?php esc_html_e('Theme Templates', 'financeglow'); ?></h1>
    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <?php foreach ($templates as $key => $template): ?>
        <div style="border: 1px solid #ccc; border-radius: 8px; padding: 10px; width: 200px; text-align: center;">
            <img src="<?php echo esc_url($template['image']); ?>" alt="<?php echo esc_attr($template['name']); ?>"
                style="width: 100%; border-radius: 5px;">
            <h3><?php echo esc_html($template['name']); ?></h3>
            <form method="POST" style="margin-top: 10px;">
                <input type="hidden" name="financeglow_template_option" value="<?php echo esc_attr($key); ?>">
                <input type="submit" value="<?php esc_attr_e('Activate', 'financeglow'); ?>"
                    class="button button-primary">
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<style>
.wrap h1 {
    text-align: center;
}

img {
    border-radius: 5px;
    max-height: 150px;
    object-fit: cover;
}
</style>
<?php
}




// Security headers
function add_security_headers($headers)
{
    $headers['X-Content-Type-Options'] = 'nosniff';
    $headers['X-XSS-Protection'] = '1; mode=block';
    $headers['X-Frame-Options'] = 'DENY';
    return $headers;
}
add_filter('wp_headers', 'add_security_headers');

// Documentation
function financeglow_add_readme_link()
{
    add_menu_page(
        __('Documentation', 'financeglow'), // Page title
        __('Documentation', 'financeglow'), // Menu title
        'manage_options',                    // Capability
        'financeglow-readme',                // Menu slug
        'financeglow_display_readme',        // Function to display content
        'dashicons-media-text',              // Icon
        100                                   // Position in menu
    );
}
add_action('admin_menu', 'financeglow_add_readme_link');

function financeglow_display_readme()
{
    $readme_path = get_template_directory() . '/README.md'; // Path to README file
    if (file_exists($readme_path)) {
        $readme_content = file_get_contents($readme_path);
        echo '<div class="wrap"><h1>' . esc_html__('FinanceGlow Theme Documentation', 'financeglow') . '</h1>';
        echo '<pre>' . esc_html($readme_content) . '</pre></div>';
    } else {
        echo '<div class="wrap"><h1>' . esc_html__('Documentation not found', 'financeglow') . '</h1></div>';
    }
}

//register blcok style

function financeglow_enqueue_block_styles() {
    // Enqueue the style for both frontend and editor
    wp_enqueue_style('financeglow-block-styles', get_template_directory_uri() . '/assets/css/block-styles.css', [], '1.0');
}
add_action('enqueue_block_assets', 'financeglow_enqueue_block_styles');


// Register custom block styles for paragraphs, buttons, and images
function financeglow_register_block_styles() {
    // Custom Paragraph Block Style
    register_block_style(
        'core/paragraph',
        [
            'name'  => 'custom-paragraph-style',
            'label' => __('Custom Paragraph Style', 'financeglow'),
        ]
    );
    
    // Custom Button Block Style
    register_block_style(
        'core/button',
        [
            'name'  => 'custom-button-style',
            'label' => __('Custom Button Style', 'financeglow'),
        ]
    );

    // Custom Image Block Style
    register_block_style(
        'core/image',
        [
            'name'  => 'custom-image-style',
            'label' => __('Custom Image Style', 'financeglow'),
        ]
    );
}
add_action('init', 'financeglow_register_block_styles');

// register block pattern
// Include the block patterns file
require get_template_directory() . '/block-patterns.php';





?>
