<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\asset;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('sage/vendor.js', asset('scripts/vendor.js')->uri(), ['jquery'], null, true);
    wp_enqueue_script('sage/app.js', asset('scripts/app.js')->uri(), ['sage/vendor.js', 'wp-element'], null, true);

    wp_add_inline_script('sage/vendor.js', asset('scripts/manifest.js')->contents(), 'before');

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_style('sage/app.css', asset('styles/app.css')->uri(), false, null);
}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    if ($manifest = asset('scripts/manifest.asset.php')->get()) {
        wp_enqueue_script('sage/vendor.js', asset('scripts/vendor.js')->uri(), ...array_values($manifest));
        wp_enqueue_script('sage/editor.js', asset('scripts/editor.js')->uri(), ['sage/vendor.js'], null, true);

        wp_add_inline_script('sage/vendor.js', asset('scripts/manifest.js')->contents(), 'before');
    }

    wp_enqueue_style('sage/editor.css', asset('styles/editor.css')->uri(), false, null);
}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
// add_action('after_setup_theme', function () {
//     /**
//      * Enable features from the Soil plugin if activated.
//      * @link https://roots.io/plugins/soil/
//      */
//     add_theme_support('soil', [
//         'clean-up',
//         'nav-walker',
//         'nice-search',
//         'relative-urls'
//     ]);

//     /**
//      * Register the navigation menus.
//      * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
//      */
//     // register_nav_menus([
//     //     'primary_navigation' => __('Primary Navigation', 'sage')
//     // ]);

//     /**
//      * Register the editor color palette.
//      * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
//      */
//     add_theme_support('editor-color-palette', []);

//     /**
//      * Register the editor color gradient presets.
//      * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-gradient-presets
//      */
//     add_theme_support('editor-gradient-presets', []);

//     /**
//      * Register the editor font sizes.
//      * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-font-sizes
//      */
//     add_theme_support('editor-font-sizes', []);

//     /**
//      * Register relative length units in the editor.
//      * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#support-custom-units
//      */
//     add_theme_support('custom-units');

//     /**
//      * Enable support for custom line heights in the editor.
//      * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#supporting-custom-line-heights
//      */
//     add_theme_support('custom-line-height');

//     /**
//      * Enable support for custom block spacing control in the editor.
//      * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#spacing-control
//      */
//     add_theme_support('custom-spacing');

//     /**
//      * Disable custom colors in the editor.
//      * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
//      */
//     add_theme_support('disable-custom-colors');

//     /**
//      * Disable custom color gradients in the editor.
//      * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-gradients
//      */
//     add_theme_support('disable-custom-gradients');

//     /**
//      * Disable custom font sizes in the editor.
//      * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-font-sizes
//      */
//     add_theme_support('disable-custom-font-sizes');

//     /**
//      * Disable the default block patterns.
//      * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
//      */
//     remove_theme_support('core-block-patterns');

//     /**
//      * Enable plugins to manage the document title.
//      * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
//      */
//     add_theme_support('title-tag');

//     /**
//      * Enable post thumbnail support.
//      * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
//      */
//     add_theme_support('post-thumbnails');

//     /**
//      * Enable wide alignment support.
//      * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#wide-alignment
//      */
//     add_theme_support('align-wide');

//     /**
//      * Enable responsive embed support.
//      * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
//      */
//     add_theme_support('responsive-embeds');

//     /**
//      * Enable HTML5 markup support.
//      * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
//      */
//     add_theme_support('html5', [
//         'caption',
//         'comment-form',
//         'comment-list',
//         'gallery',
//         'search-form',
//         'script',
//         'style'
//     ]);

//     /**
//      * Enable selective refresh for widgets in customizer.
//      * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
//      */
//     add_theme_support('customize-selective-refresh-widgets');
// }, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {

    register_sidebar(
        [
            'name' => __('Header', 'sage'),
            'id' => 'header',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="d-none">',
            'after_title' => '</h3>'
        ] 
    );
    // register_sidebar(
    //     [
    //         'name' => __('CopyRight', 'sage'),
    //         'id' => 'copyright',
    //         'before_widget' => '<small>',
    //         'after_widget' => '</small>',
    //         'before_title' => '<h3 class="d-none">',
    //         'after_title' => '</h3>'
    //     ]
    // );
    register_sidebar(
        [
            'name' => __('Footer', 'sage'),
            'id' => 'footer',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="d-none">',
            'after_title' => '</h3>'
        ] 
    );
});

add_action('after_setup_theme', function () {
    load_theme_textdomain('sage', get_template_directory() . '/resources/lang');
});
