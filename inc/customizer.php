<?php
/**
 * jkl Theme Customizer.
 *
 * @package jkl
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function jkl_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
        
        /*
         * Custom Customizer Customizations
         * #1: Settings, #2: Controls
         */
        
        /* Menu Background Color */
        // Menu Color Setting
        $wp_customize->add_setting( 'menu_color', array(
            'default'           => '#dcdcdc',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        ) );
        
        // Menu Color Control
        $wp_customize->add_control( 
                new WP_Customize_Color_Control(
                        $wp_customize,
                        'menu_color', array(
                            'label'         => __( 'Menu Background Color', 'jkl' ),
                            'description'   => __( 'Change the background color of the menu.', 'jkl' ),
                            'section'       => 'colors',
                        )
        ) );
        
        /* Menu Text Color */
        // Menu Text Color Setting
        $wp_customize->add_setting( 'menu_text_color', array(
            'default'           => '#777777',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        ) );
        
        // Menu Text Color Control
        $wp_customize->add_control( 
                new WP_Customize_Color_Control(
                        $wp_customize,
                        'menu_text_color', array(
                            'label'         => __( 'Menu Text Color', 'jkl' ),
                            'description'   => __( 'Change the text color of the menu.', 'jkl' ),
                            'section'       => 'colors',
                        )
        ) );
        
        /* Select Sidebar Layout */
        // Add Sidebar Layout Section
        $wp_customize->add_section( 'jkl-options', array(
            'title'         => __( 'Theme Options', 'jkl' ),
            'capability'    => 'edit_theme_options',
            'description'   => __( 'Change the default display options for the theme.', 'jkl' ),
        ) );
        
        // Sidebar Layout setting
        $wp_customize->add_setting( 'layout_setting',
                array(
                    'default'           => 'no-sidebar',
                    'type'              => 'theme_mod',
                    'sanitize_callback' => 'jkl_sanitize_layout',
                    'transport'         => 'postMessage'
                ) );
        
        // Sidebar Layout Control
        $wp_customize->add_control( 'layout_control',
                array(
                    'settings'          => 'layout_setting',
                    'type'              => 'radio',
                    'label'             => __( 'Sidebar position', 'jkl' ),
                    'choices'           => array(
                            'no-sidebar'    => __( 'No sidebar (default)', 'jkl' ),
                            'sidebar-right' => __( 'Sidebar right', 'jkl' ),
                            'sidebar-left'  => __( 'Sidebar left', 'jkl' ),
                    ),
                    'section'           => 'jkl-options'
                ) );
}
add_action( 'customize_register', 'jkl_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function jkl_customize_preview_js() {
	wp_enqueue_script( 'jkl_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'jkl_customize_preview_js' );

/*
 * Sanitize layout options
 */
function jkl_sanitize_layout ( $value ) {
    if ( !in_array( $value, array( 'no-sidebar', 'sidebar-right', 'sidebar-left' ) ) ) {
        $value = 'no-sidebar';
    }
    return $value;
}

/*
 * Inject Customizer CSS when appropriate
 */
function jkl_customizer_css() {
    $menu_color = get_theme_mod( 'menu_color' );
    $menu_text_color = get_theme_mod( 'menu_text_color' );
    
    ?>
    <style>
        #primary-nav-bar {
            background: <?php echo $menu_color; ?>
        }
        #main-nav-left > li a,
        #main-nav-right > li a {
            color: <?php echo $menu_text_color; ?>
        }
    </style>
    <?php
}
add_action( 'wp_head', 'jkl_customizer_css' );