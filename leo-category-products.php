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
function lcp_assets_loader()
{
    //Enqueue Google font
    wp_enqueue_style('google-font-preconnect','//fonts.googleapis.com');
    wp_enqueue_style('gstatic-preconnect','//fonts.gstatic.com');
    wp_enqueue_style('font-style','//fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
    //Enqueue Bootstrap CSS File
    wp_enqueue_style('bootstrap-style', '//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    // Enqueue CSS file
    wp_enqueue_style('lcp-style', plugin_dir_url(__FILE__) . 'style.css');

    //Enqueue Bootstrap Js
    wp_enqueue_script('bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
    // Enqueue JavaScript file
    wp_enqueue_script('lcp-script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'lcp_assets_loader');
function lcp_display_category_products()
{
    ?>

    <div class="lcp-container container">
        <div class="lcp-header">
            <div class="row">
                <div class="col col-12 col-md-6 d-flex flex-row justify-content-center align-items-center">
                    <div class="prepay">
                        <h4>Prepay</h4>
                        <p>3 months</p>
                        <p class="lcp-discount">10% off</p>
                    </div>
                    <h1 class="form-switch form-switch-toggle">
                        <input id="pricingType" class="form-check-input" type="checkbox" role="switch">
                    </h1>
                    <div class="monthly">
                        <h4>Monthly</h4>
                        <p>3 month min</p>
                    </div>
                </div>
                <div class="col col-12 col-md-6 d-flex flex-column justify-content-center align-items-center">
                    <button>Save 10% with 3 month prepay</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function lcp_register_shortcode()
{
    add_shortcode('lcp_products_display', 'lcp_display_category_products');
}
add_action('init', 'lcp_register_shortcode');