<?php
/*
Plugin Name: WooCommerce Shipping Zones List
Description: Displays a list of WooCommerce shipping zones and their costs using a shortcode.
Version: 0.1
Author: Striding Co
Author URI: https://www.striding.co
License: GPLv2 or later
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Check if WooCommerce is active
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    // Register the shortcode
    add_shortcode('wc_shipping_zones_list', 'wc_shipping_zones_list_shortcode');

    // Shortcode function
    function wc_shipping_zones_list_shortcode() {
        // Get shipping zones
        $shipping_zones = WC_Shipping_Zones::get_zones();

        // Start output buffer
        ob_start();

        // Display shipping zones and costs
        echo '<ul class="wc-shipping-zones-list">';
        foreach ($shipping_zones as $zone) {
            echo '<li><strong>' . esc_html($zone['zone_name']) . '</strong><ul>';

            $shipping_methods = $zone['shipping_methods'];
            foreach ($shipping_methods as $method) {
                echo '<li>' . esc_html($method->title) . ': ';

                if ($method->cost) {
                    echo wc_price($method->cost);
                } else {
                    echo __('Free', 'woocommerce');
                }
                echo '</li>';
            }
            echo '</ul></li>';
        }
        echo '</ul>';

        // Return output buffer contents
        return ob_get_clean();
    }
}
