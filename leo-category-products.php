<?php
/* 
Plugin Name: Leo Category Products
Plugin URI: https://example.com/plugin
Description: Display all products of current category
Version: 1.0.0
Author: Raiyan Noory Rady
Author URI: https://sparketech.agency
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: leo-category-products
*/

/* Basic Reset */
function lcp_assets_loader(){
    //Enqueue Bootstrap CSS File
     wp_enqueue_style('bootstrap-style','//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
     // Enqueue CSS file
     wp_enqueue_style('lcp-style', plugin_dir_url(__FILE__) . 'style.css');
     
     //Enqueue Bootstrap Js
     wp_enqueue_script('bootstrap-script','https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
     // Enqueue JavaScript file
     wp_enqueue_script('lcp-script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'lcp_assets_loader');
function lcp_display_category_products(){
    ?>
    <div class="lcp-container">
        <h2 class="text-danger">Hello Test</h2>
    </div>
    <?php
}

function lcp_register_shortcode(){
    add_shortcode('lcp_products_display','lcp_display_category_products');
}
add_action('init','lcp_register_shortcode');