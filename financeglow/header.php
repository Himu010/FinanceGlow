<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Description (Tagline) -->
    <meta name="title" content="<?php bloginfo('name'); // Outputs the site title ?>">
    <meta name="description" content="<?php bloginfo('description'); ?>">



    <?php
    // Important for plugins to add meta data, scripts, etc.
    wp_head(); 
    ?>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); // Required for proper theme functionality ?>
    <?php get_template_part('header-links'); ?>

    <header class="site-header">
        <div class="header-container">
            <!-- Hamburger Menu for Mobile View -->
            <div class="mobile-menu-toggle">
                <span class="menu-icon">&#9776;</span> <!-- Hamburger icon -->
            </div>

            <!-- Site Logo (Left) -->
            <div class="site-logo">
                <?php
               $default_logo = esc_url(home_url('/wp-content/themes/FinanceGlow/assets/images/FinanceGlow-Logo.png')); // Default logo URL
$financeglow_logo = get_option('financeglow_logo', $default_logo); // Use default if not set

                
                if ($financeglow_logo):
                    ?>
                    <a href="<?php echo esc_url(home_url()); ?>">
                        <img src="<?php echo esc_url($financeglow_logo); ?>" alt="<?php bloginfo('name'); ?> Logo"
                            class="site-logo-img" />
                    </a>
                <?php endif; ?>
            </div>

            <!-- Navigation Menu (Center) -->
            <nav class="nav-menu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'menu-list',
                ));
                ?>
            </nav>

            <!-- Search Box (Right) -->
            <div class="search-box">
                <?php get_search_form(); ?>
            </div>
        </div>

        <!-- Mobile Navigation Menu (Hidden by default, shown on click) -->
        <div class="mobile-nav-menu">
            <span class="mobile-nav-close">&times;</span> <!-- Close button -->
            <nav>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'mobile-menu-list',
                ));
                ?>
            </nav>
        </div>
    </header>