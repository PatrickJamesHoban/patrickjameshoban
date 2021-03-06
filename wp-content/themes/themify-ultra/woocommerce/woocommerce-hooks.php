<?php
/**
 * WooCommerce Custom Hook
 * woocommerce-hooks.php
 */

// include plugin functions
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/* Single product actions */
add_action( 'themify_single_product_price', 'woocommerce_template_single_price', 10);
add_action( 'template_redirect', 'themify_single_product_related_products', 12);
add_action( 'template_redirect', 'themify_hide_shop_features', 12);
add_filter( 'woocommerce_product_tabs', 'themify_single_product_reviews' );

/* Single product on lightbox actions */
add_action( 'themify_single_product_image_ajax', 'woocommerce_show_product_sale_flash', 20);
add_action( 'themify_single_product_image_ajax', 'woocommerce_show_product_images', 20);
add_action( 'themify_single_product_ajax_content', 'woocommerce_template_single_add_to_cart', 10);
if(isset($_GET['ajax']) && $_GET['ajax']) {
	add_filter('woocommerce_single_product_image_html', 'themify_product_image_ajax', 10, 2);
	add_filter('woocommerce_single_product_image_thumbnail_html', create_function('', "return '';"));
}
add_filter('woocommerce_single_product_image_html', 'themify_product_image_single', 10, 2);

/* Sorting menu */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', 'themify_catalog_ordering', 8 );

// Remove breadcrumb for later insertion within Themify wrapper
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// Remove dock item hooks
add_action( 'init', 'themify_update_cart_action');

/* Content Wrapper */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action( 'woocommerce_before_main_content', 'themify_before_shop_content', 20);
add_action( 'woocommerce_after_main_content', 'themify_after_shop_content', 20);

/* Sidebar */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
add_action('template_redirect', 'themify_woocommerce_sidebar_layout', 12);

// Add product variations
add_action('woocommerce_before_add_to_cart_form', 'themify_available_variations');

// Show excerpt or content in product archive pages
add_action('woocommerce_after_shop_loop_item', 'themify_after_shop_loop_item');
// Set WC image sizes
add_action( 'switch_theme', 'themify_theme_delete_image_sizes_flag' );

// Add to cart link
add_filter('woocommerce_loop_add_to_cart_link', 'themify_loop_add_to_cart_link', 10, 3);
// No product title in product archive pages
add_filter('the_title', 'themify_no_product_title');
// No product price in product archive pages
add_filter('woocommerce_get_price_html', 'themify_no_price');
// Set number of products shown in product archive pages
add_filter('loop_shop_per_page', 'themify_products_per_page');
// Alter or remove success message after adding to cart with ajax.
add_filter( 'wc_add_to_cart_message', 'themify_theme_wc_add_to_cart_message' );
add_filter( 'woocommerce_notice_types', 'themify_theme_wc_add_to_cart_message' );

/**
 * Fragments
 * Adding cart total and shopdock markup to the fragments
 */
add_filter( 'add_to_cart_fragments', 'themify_theme_add_to_cart_fragments' );

/**
 * Theme delete cart hook
 * Note: for Add to cart using default WC function
 */
add_action( 'wp_ajax_theme_delete_cart', 'themify_theme_woocommerce_delete_cart' );
add_action( 'wp_ajax_nopriv_theme_delete_cart', 'themify_theme_woocommerce_delete_cart' );

/**
 * Theme adding cart hook
 * Adding cart ajax on single product page
 */
add_action( 'wp_ajax_theme_add_to_cart', 'themify_theme_woocommerce_add_to_cart' );
add_action( 'wp_ajax_nopriv_theme_add_to_cart', 'themify_theme_woocommerce_add_to_cart' );

/**
 * WC Plugins compliance 
 */
// Dynamic Gallery Plugin
if ( is_plugin_active( 'woocommerce-dynamic-gallery/wc_dynamic_gallery_woocommerce.php' ) ) {
	remove_action( 'themify_single_product_image', 'woocommerce_show_product_images', 20);
	remove_action( 'themify_single_product_image', 'woocommerce_show_product_thumbnails', 20);
}
