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
    wp_enqueue_style('google-font-preconnect', '//fonts.googleapis.com');
    wp_enqueue_style('gstatic-preconnect', '//fonts.gstatic.com');
    wp_enqueue_style('font-style', '//fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
    //Enqueue Bootstrap CSS File
    wp_enqueue_style('bootstrap-style', '//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_enqueue_style('grid-style',plugin_dir_url(__FILE__) . 'grid.css');
    // Enqueue CSS file
    wp_enqueue_style('lcp-style', plugin_dir_url(__FILE__) . 'style.css');

    //Enqueue Bootstrap Js
    wp_enqueue_script('bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
    // Enqueue JavaScript file
    wp_enqueue_script('lcp-script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'lcp_assets_loader');

function lcp_get_products_from_subcategory() {
    // Get the current URL path
    $current_url = $_SERVER['REQUEST_URI'];

    // Remove the base 'product-category' from the URL to get the subcategory part
    $base = 'product-category/';
    $url_without_base = str_replace('/' . $base, '', $current_url);

    // Split the URL by slashes to get the subcategory (last part)
    $url_parts = explode('/', trim($url_without_base, '/'));

    // The last part is the subcategory slug (e.g., 'american-university')
    $subcategory_slug = end($url_parts);
    
    // Get the term object by slug
    $term = get_term_by('slug', $subcategory_slug, 'product_cat');

    // Debugging: Check if term is returned
    if ($term) {
        // Query products by the term's term_id
        $args = array(
            'post_type' => 'product',  // Your custom post type for products
            'posts_per_page' => -1,    // Get all products
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',  // Your taxonomy for product categories
                    'field'    => 'term_id',
                    'terms'    => $term->term_id, // Use the term ID
                    'operator' => 'IN',
                ),
            ),
        );

         // Execute the query
         $query = new WP_Query($args);

         // Return the query result
         if ($query->have_posts()) {
             $products_data = array(); // Array to store product details
 
             while ($query->have_posts()) {
                 $query->the_post();
 
                 // Collect product data
                 $products_data[] = array(
                     'title'           => get_the_title(), // Product title
                     'regular_price'   => get_post_meta(get_the_ID(), '_regular_price', true), // Regular price
                     'sale_price'      => get_post_meta(get_the_ID(), '_sale_price', true), // Sale price
                     'featured_image'  => get_the_post_thumbnail_url(get_the_ID(), 'full'), // Featured image
                     'short_description' => get_the_excerpt(), // Short description
                 );
             }
 
             return $products_data; // Return the array of product data
         } else {
             return null; // No products found
         }
     } else {
         return null; // Term not found
     }
}

function lcp_display_category_products()
{
    $lcp_products=lcp_get_products_from_subcategory();
    ?>
    <div class="lcp-container mx-auto container-md">
        <div class="lcp-header">
            <div class="row d-flex flex-row justify-content-center align-items-center mx-auto">
                <div class="lcp-left-toggler col-10 col-md-5 d-flex flex-row justify-content-md-end align-items-center">
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
                <div class="lcp-right-btn col-10 col-md-5 d-flex flex-row justify-content-md-start align-items-center">
                    <button class="btn-leo">Save 10% with 3 month prepay</button>
                </div>
            </div>
        </div>
        <div class="lcp-main">
            <div class="row">
                <?php foreach($lcp_products as $lcp_product){ ?>
                <div class="col-10 col-sm-5 col-lg-3 col-xl-2">
                    <div class="lcp-product">
                        <h4 class="lcp-product-title fw-bold text-center"><?php echo $lcp_product['title']; ?></h4>
                        <div class="lcp-product-box card h-100 py-4 px-2 rounded-4">
                            <div class="card-title align-items-center justify-content-center">
                                <div class="lcp-price d-flex flex-col justify-content-center">
                                    <div class="lcp-base-price fw-bold fs-4 text-strikethrough"><?php echo $lcp_product['regular_price']; ?></div>
                                    <div class="lcp-sale-price fw-bold fs-4"><?php echo $lcp_product['sale_price']; ?></div>
                                </div>
                                <p class="lcp-per-item text-center fw-bold">Per Item Monthly</p>
                                <div class="lcp-featured-image text-center">
                                    <img src="<?php echo esc_url($lcp_product['featured_image']); ?>"
                                        alt="">
                                </div>
                            </div>
                            <div class="lcp-product-description card-body px-3 py-0 text-center fs-5">
                                <?php echo $lcp_product['short_description']; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
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