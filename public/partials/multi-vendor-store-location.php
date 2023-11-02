<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://rahulpranami.co
 * @since      1.0.0
 *
 * @package    Multi_Vendor_Store
 * @subpackage Multi_Vendor_Store/public/partials
 */

global $post;

$post_id =  $post->ID;

$store_phone = get_post_meta($post_id, '_store_phone', true);
$store_email = get_post_meta($post_id, '_store_email', true);
$store_description = get_post_meta($post_id, '_store_description', true);
$store_location_fetched = get_post_meta($post_id, '_store_branch_location_fetched', true);
$store_address_line1 = get_post_meta($post_id, '_store_address_line1', true);
$store_address_line2 = get_post_meta($post_id, '_store_address_line2', true);
$store_city = get_post_meta($post_id, '_store_city', true);
$store_state = get_post_meta($post_id, '_store_state', true);
$store_country = get_post_meta($post_id, '_store_country', true);

$store_latitude  = get_post_meta($post_id, '_store_branch_location_latitude', true) ?? 0;
$store_longitude = get_post_meta($post_id, '_store_branch_location_longitude', true) ?? 0;
$store_products = get_post_meta($post_id, '_store_products', true);

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php if (!empty($store_products)) : ?>
    <div id="product-list" class="store-details">
        <h2>Product List</h2>
        <div class="store-info">
            <div class="products">
                <?php foreach ($store_products as $product_id) : ?>
                    <a href="<?php echo get_permalink($product_id); ?>" class="product-link">
                        <?php echo get_the_title($product_id); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($store_phone || $store_email) : ?>
    <div class="store-details">
        <h2>Contact Details</h2>
        <div class="store-info">
            <div class="store-info-item">
                <?php if ($store_phone) : ?>
                    <p> <strong>Phone : </strong> <?php echo $store_phone; ?> </p>
                <?php endif; ?>
                <?php if ($store_email) : ?>
                    <p> <strong>Email : </strong> <?php echo $store_email; ?> </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($store_description) : ?>
    <div class="store-details">
        <h2>Store Description</h2>
        <div class="store-info">
            <div class="store-info-item">
                <p> <?php echo $store_description; ?> </p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($store_location_fetched || $store_address_line1 || $store_address_line2 || $store_city || $store_state || $store_country) : ?>
    <div class="store-details">
        <h2>Location Info</h2>
        <div class="store-info">
            <?php if ($store_location_fetched) : ?>
                <div class="store-info-item">
                    <p> <strong>Location Fetched : </strong> <?php echo $store_location_fetched; ?> </p>
                </div>
            <?php endif; ?>

            <?php if ($store_address_line1 || $store_address_line2) : ?>
                <div class="store-info-item">
                    <?php if ($store_address_line1) : ?>
                        <p> <strong>Address Line 1 : </strong> <?php echo $store_address_line1; ?> </p>
                    <?php endif; ?>

                    <?php if ($store_address_line2) : ?>
                        <p> <strong>Address Line 2 : </strong> <?php echo $store_address_line2; ?> </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($store_city || $store_state) : ?>
                <div class="store-info-item">
                    <?php if ($store_city) : ?>
                        <p> <strong>City : </strong> <?php echo $store_city; ?> </p>
                    <?php endif; ?>

                    <?php if ($store_state) : ?>
                        <p> <strong>State : </strong> <?php echo $store_state; ?> </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($store_country) : ?>
                <div class="store-info-item">
                    <p> <strong>Country : </strong> <?php echo $store_country; ?> </p>
                </div>
            <?php endif; ?>

            <?php if ($store_latitude !== 0 && $store_longitude !== 0) : ?>
                <div class="store-info-item latlong">
                    <p> <strong>Latitude : </strong> <?php echo $store_latitude; ?> </p>
                    <p> <strong>Longitude : </strong> <?php echo $store_longitude; ?> </p>
                </div>
            <?php endif; ?>

        </div>
    </div>
<?php endif; ?>

<?php if ($store_latitude !== 0 && $store_longitude !== 0) : ?>
    <input type="hidden" id="store-latitude" value="<?php echo $store_latitude ?>" />
    <input type="hidden" id="store-longitude" value="<?php echo $store_longitude ?>" />
    <div id="map"></div>
<?php endif;
