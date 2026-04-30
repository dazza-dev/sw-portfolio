<?php

/**
 * Plugin Name: SW - Portfolio CPT
 * Plugin URI: https://www.seniors.com.co
 * Description: Custom Post Type "Portfolio" with taxonomies, custom fields, gallery, and optional WPGraphQL support.
 * Version: 1.0.0
 * Author: Seniors
 * Author URI: https://www.seniors.com.co
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sw-portfolio
 * Requires PHP: 7.4
 * Requires at least: 5.8
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('SW_PORTFOLIO_VERSION', '1.0.0');
define('SW_PORTFOLIO_TEXT_DOMAIN', 'sw-portfolio');

// =============================================================================
// 1. CUSTOM POST TYPE: PORTFOLIO
// =============================================================================

function sw_portfolio_register_cpt()
{
    $labels = array(
        'name'                  => _x('Portfolio', 'Post Type General Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'singular_name'         => _x('Project', 'Post Type Singular Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'menu_name'             => __('Portfolio', SW_PORTFOLIO_TEXT_DOMAIN),
        'name_admin_bar'        => __('Project', SW_PORTFOLIO_TEXT_DOMAIN),
        'archives'              => __('Project Archives', SW_PORTFOLIO_TEXT_DOMAIN),
        'attributes'            => __('Project Attributes', SW_PORTFOLIO_TEXT_DOMAIN),
        'all_items'             => __('All Projects', SW_PORTFOLIO_TEXT_DOMAIN),
        'add_new_item'          => __('Add New Project', SW_PORTFOLIO_TEXT_DOMAIN),
        'add_new'               => __('Add New', SW_PORTFOLIO_TEXT_DOMAIN),
        'new_item'              => __('New Project', SW_PORTFOLIO_TEXT_DOMAIN),
        'edit_item'             => __('Edit Project', SW_PORTFOLIO_TEXT_DOMAIN),
        'update_item'           => __('Update Project', SW_PORTFOLIO_TEXT_DOMAIN),
        'view_item'             => __('View Project', SW_PORTFOLIO_TEXT_DOMAIN),
        'view_items'            => __('View Projects', SW_PORTFOLIO_TEXT_DOMAIN),
        'search_items'          => __('Search Project', SW_PORTFOLIO_TEXT_DOMAIN),
        'not_found'             => __('Not found', SW_PORTFOLIO_TEXT_DOMAIN),
        'not_found_in_trash'    => __('Not found in Trash', SW_PORTFOLIO_TEXT_DOMAIN),
    );

    $args = array(
        'label'                 => __('Project', SW_PORTFOLIO_TEXT_DOMAIN),
        'description'           => __('Portfolio projects', SW_PORTFOLIO_TEXT_DOMAIN),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields', 'page-attributes'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    // WPGraphQL support
    if (class_exists('WPGraphQL')) {
        $args['show_in_graphql'] = true;
        $args['graphql_single_name'] = 'swPortfolio';
        $args['graphql_plural_name'] = 'swPortfolios';
    }

    register_post_type('portfolio', $args);
}
add_action('init', 'sw_portfolio_register_cpt', 0);

// =============================================================================
// 2. TAXONOMIES
// =============================================================================

function sw_portfolio_register_taxonomies()
{
    // --- Portfolio Category ---
    $cat_labels = array(
        'name'              => _x('Categories', 'Taxonomy General Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'singular_name'     => _x('Category', 'Taxonomy Singular Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'menu_name'         => __('Categories', SW_PORTFOLIO_TEXT_DOMAIN),
        'all_items'         => __('All Categories', SW_PORTFOLIO_TEXT_DOMAIN),
        'new_item_name'     => __('New Category Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'add_new_item'      => __('Add New Category', SW_PORTFOLIO_TEXT_DOMAIN),
        'edit_item'         => __('Edit Category', SW_PORTFOLIO_TEXT_DOMAIN),
        'update_item'       => __('Update Category', SW_PORTFOLIO_TEXT_DOMAIN),
        'view_item'         => __('View Category', SW_PORTFOLIO_TEXT_DOMAIN),
        'search_items'      => __('Search Categories', SW_PORTFOLIO_TEXT_DOMAIN),
        'not_found'         => __('Not Found', SW_PORTFOLIO_TEXT_DOMAIN),
    );

    register_taxonomy('portfolio_category', array('portfolio'), array(
        'labels'            => $cat_labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'show_in_rest'      => true,
        'show_in_graphql'   => class_exists('WPGraphQL'),
        'graphql_single_name' => 'swPortfolioCategory',
        'graphql_plural_name' => 'swPortfolioCategories',
    ));

    // --- Portfolio Client ---
    $client_labels = array(
        'name'              => _x('Clients', 'Taxonomy General Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'singular_name'     => _x('Client', 'Taxonomy Singular Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'menu_name'         => __('Clients', SW_PORTFOLIO_TEXT_DOMAIN),
        'all_items'         => __('All Clients', SW_PORTFOLIO_TEXT_DOMAIN),
        'new_item_name'     => __('New Client Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'add_new_item'      => __('Add New Client', SW_PORTFOLIO_TEXT_DOMAIN),
        'edit_item'         => __('Edit Client', SW_PORTFOLIO_TEXT_DOMAIN),
        'update_item'       => __('Update Client', SW_PORTFOLIO_TEXT_DOMAIN),
        'view_item'         => __('View Client', SW_PORTFOLIO_TEXT_DOMAIN),
        'search_items'      => __('Search Clients', SW_PORTFOLIO_TEXT_DOMAIN),
        'not_found'         => __('Not Found', SW_PORTFOLIO_TEXT_DOMAIN),
    );

    register_taxonomy('portfolio_client', array('portfolio'), array(
        'labels'            => $client_labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'show_in_rest'      => true,
        'show_in_graphql'   => class_exists('WPGraphQL'),
        'graphql_single_name' => 'swPortfolioClient',
        'graphql_plural_name' => 'swPortfolioClients',
    ));

    // --- Portfolio Sector ---
    $sector_labels = array(
        'name'              => _x('Sectors', 'Taxonomy General Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'singular_name'     => _x('Sector', 'Taxonomy Singular Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'menu_name'         => __('Sectors', SW_PORTFOLIO_TEXT_DOMAIN),
        'all_items'         => __('All Sectors', SW_PORTFOLIO_TEXT_DOMAIN),
        'new_item_name'     => __('New Sector Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'add_new_item'      => __('Add New Sector', SW_PORTFOLIO_TEXT_DOMAIN),
        'edit_item'         => __('Edit Sector', SW_PORTFOLIO_TEXT_DOMAIN),
        'update_item'       => __('Update Sector', SW_PORTFOLIO_TEXT_DOMAIN),
        'view_item'         => __('View Sector', SW_PORTFOLIO_TEXT_DOMAIN),
        'search_items'      => __('Search Sectors', SW_PORTFOLIO_TEXT_DOMAIN),
        'not_found'         => __('Not Found', SW_PORTFOLIO_TEXT_DOMAIN),
    );

    register_taxonomy('portfolio_sector', array('portfolio'), array(
        'labels'            => $sector_labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'show_in_rest'      => true,
        'show_in_graphql'   => class_exists('WPGraphQL'),
        'graphql_single_name' => 'swPortfolioSector',
        'graphql_plural_name' => 'swPortfolioSectors',
    ));

    // --- Portfolio Location ---
    $location_labels = array(
        'name'              => _x('Locations', 'Taxonomy General Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'singular_name'     => _x('Location', 'Taxonomy Singular Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'menu_name'         => __('Locations', SW_PORTFOLIO_TEXT_DOMAIN),
        'all_items'         => __('All Locations', SW_PORTFOLIO_TEXT_DOMAIN),
        'new_item_name'     => __('New Location Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'add_new_item'      => __('Add New Location', SW_PORTFOLIO_TEXT_DOMAIN),
        'edit_item'         => __('Edit Location', SW_PORTFOLIO_TEXT_DOMAIN),
        'update_item'       => __('Update Location', SW_PORTFOLIO_TEXT_DOMAIN),
        'view_item'         => __('View Location', SW_PORTFOLIO_TEXT_DOMAIN),
        'search_items'      => __('Search Locations', SW_PORTFOLIO_TEXT_DOMAIN),
        'not_found'         => __('Not Found', SW_PORTFOLIO_TEXT_DOMAIN),
    );

    register_taxonomy('portfolio_location', array('portfolio'), array(
        'labels'            => $location_labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'show_in_rest'      => true,
        'show_in_graphql'   => class_exists('WPGraphQL'),
        'graphql_single_name' => 'swPortfolioLocation',
        'graphql_plural_name' => 'swPortfolioLocations',
    ));

    // --- Portfolio Tech Stack ---
    $tech_labels = array(
        'name'              => _x('Tech Stack', 'Taxonomy General Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'singular_name'     => _x('Technology', 'Taxonomy Singular Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'menu_name'         => __('Tech Stack', SW_PORTFOLIO_TEXT_DOMAIN),
        'all_items'         => __('All Technologies', SW_PORTFOLIO_TEXT_DOMAIN),
        'new_item_name'     => __('New Technology Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'add_new_item'      => __('Add New Technology', SW_PORTFOLIO_TEXT_DOMAIN),
        'edit_item'         => __('Edit Technology', SW_PORTFOLIO_TEXT_DOMAIN),
        'update_item'       => __('Update Technology', SW_PORTFOLIO_TEXT_DOMAIN),
        'view_item'         => __('View Technology', SW_PORTFOLIO_TEXT_DOMAIN),
        'search_items'      => __('Search Technologies', SW_PORTFOLIO_TEXT_DOMAIN),
        'not_found'         => __('Not Found', SW_PORTFOLIO_TEXT_DOMAIN),
    );

    register_taxonomy('portfolio_tech', array('portfolio'), array(
        'labels'            => $tech_labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => false,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'show_in_rest'      => true,
        'show_in_graphql'   => class_exists('WPGraphQL'),
        'graphql_single_name' => 'swPortfolioTech',
        'graphql_plural_name' => 'swPortfolioTechs',
    ));

    // --- Portfolio Service ---
    $service_labels = array(
        'name'              => _x('Services', 'Taxonomy General Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'singular_name'     => _x('Service', 'Taxonomy Singular Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'menu_name'         => __('Services', SW_PORTFOLIO_TEXT_DOMAIN),
        'all_items'         => __('All Services', SW_PORTFOLIO_TEXT_DOMAIN),
        'new_item_name'     => __('New Service Name', SW_PORTFOLIO_TEXT_DOMAIN),
        'add_new_item'      => __('Add New Service', SW_PORTFOLIO_TEXT_DOMAIN),
        'edit_item'         => __('Edit Service', SW_PORTFOLIO_TEXT_DOMAIN),
        'update_item'       => __('Update Service', SW_PORTFOLIO_TEXT_DOMAIN),
        'view_item'         => __('View Service', SW_PORTFOLIO_TEXT_DOMAIN),
        'search_items'      => __('Search Services', SW_PORTFOLIO_TEXT_DOMAIN),
        'not_found'         => __('Not Found', SW_PORTFOLIO_TEXT_DOMAIN),
    );

    register_taxonomy('portfolio_service', array('portfolio'), array(
        'labels'            => $service_labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => false,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'show_in_rest'      => true,
        'show_in_graphql'   => class_exists('WPGraphQL'),
        'graphql_single_name' => 'swPortfolioService',
        'graphql_plural_name' => 'swPortfolioServices',
    ));
}
add_action('init', 'sw_portfolio_register_taxonomies', 0);

// =============================================================================
// 3. CLIENT TAXONOMY - IMAGE FIELD
// =============================================================================

/**
 * Add image field to Client taxonomy - Add form
 */
function sw_portfolio_client_add_image_field()
{
?>
    <div class="form-field">
        <label><?php _e('Client Image', SW_PORTFOLIO_TEXT_DOMAIN); ?></label>
        <div id="sw-client-image-wrapper">
            <img id="sw-client-image-preview" src="" style="max-width:150px;display:none;" />
        </div>
        <input type="hidden" id="sw-client-image-id" name="client_image_id" value="" />
        <p>
            <button type="button" class="button sw-upload-client-image"><?php _e('Upload Image', SW_PORTFOLIO_TEXT_DOMAIN); ?></button>
            <button type="button" class="button sw-remove-client-image" style="display:none;"><?php _e('Remove Image', SW_PORTFOLIO_TEXT_DOMAIN); ?></button>
        </p>
        <p class="description"><?php _e('Image/logo for this client.', SW_PORTFOLIO_TEXT_DOMAIN); ?></p>
    </div>
<?php
}
add_action('portfolio_client_add_form_fields', 'sw_portfolio_client_add_image_field');

/**
 * Add image field to Client taxonomy - Edit form
 */
function sw_portfolio_client_edit_image_field($term)
{
    $image_id = get_term_meta($term->term_id, 'client_image_id', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';
?>
    <tr class="form-field">
        <th scope="row"><label><?php _e('Client Image', SW_PORTFOLIO_TEXT_DOMAIN); ?></label></th>
        <td>
            <div id="sw-client-image-wrapper">
                <img id="sw-client-image-preview" src="<?php echo esc_url($image_url); ?>" style="max-width:150px;<?php echo $image_id ? '' : 'display:none;'; ?>" />
            </div>
            <input type="hidden" id="sw-client-image-id" name="client_image_id" value="<?php echo esc_attr($image_id); ?>" />
            <p>
                <button type="button" class="button sw-upload-client-image"><?php _e('Upload Image', SW_PORTFOLIO_TEXT_DOMAIN); ?></button>
                <button type="button" class="button sw-remove-client-image" <?php echo $image_id ? '' : 'style="display:none;"'; ?>><?php _e('Remove Image', SW_PORTFOLIO_TEXT_DOMAIN); ?></button>
            </p>
            <p class="description"><?php _e('Image/logo for this client.', SW_PORTFOLIO_TEXT_DOMAIN); ?></p>
        </td>
    </tr>
<?php
}
add_action('portfolio_client_edit_form_fields', 'sw_portfolio_client_edit_image_field');

/**
 * Save Client image on create
 */
function sw_portfolio_client_save_image_create($term_id)
{
    if (isset($_POST['client_image_id'])) {
        update_term_meta($term_id, 'client_image_id', absint($_POST['client_image_id']));
    }
}
add_action('created_portfolio_client', 'sw_portfolio_client_save_image_create');

/**
 * Save Client image on edit
 */
function sw_portfolio_client_save_image_edit($term_id)
{
    if (isset($_POST['client_image_id'])) {
        update_term_meta($term_id, 'client_image_id', absint($_POST['client_image_id']));
    }
}
add_action('edited_portfolio_client', 'sw_portfolio_client_save_image_edit');

/**
 * Show client image in admin columns
 */
function sw_portfolio_client_admin_columns($columns)
{
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key === 'name') {
            $new_columns['client_image'] = __('Image', SW_PORTFOLIO_TEXT_DOMAIN);
        }
        $new_columns[$key] = $value;
    }
    return $new_columns;
}
add_filter('manage_edit-portfolio_client_columns', 'sw_portfolio_client_admin_columns');

function sw_portfolio_client_admin_column_content($content, $column_name, $term_id)
{
    if ($column_name === 'client_image') {
        $image_id = get_term_meta($term_id, 'client_image_id', true);
        if ($image_id) {
            $content = wp_get_attachment_image($image_id, array(40, 40));
        } else {
            $content = '&mdash;';
        }
    }
    return $content;
}
add_filter('manage_portfolio_client_custom_column', 'sw_portfolio_client_admin_column_content', 10, 3);

/**
 * Show tech icon in admin columns
 */
function sw_portfolio_tech_admin_columns($columns)
{
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key === 'name') {
            $new_columns['tech_icon'] = __('Icon', SW_PORTFOLIO_TEXT_DOMAIN);
        }
        $new_columns[$key] = $value;
    }
    return $new_columns;
}
add_filter('manage_edit-portfolio_tech_columns', 'sw_portfolio_tech_admin_columns');

function sw_portfolio_tech_admin_column_content($content, $column_name, $term_id)
{
    if ($column_name === 'tech_icon') {
        $icon_svg = get_term_meta($term_id, 'tech_icon_svg', true);
        if ($icon_svg) {
            $content = '<div style="width:30px;height:30px;overflow:hidden;">' . preg_replace('/<svg/', '<svg style="width:30px;height:30px;max-width:30px;max-height:30px;display:block;"', $icon_svg, 1) . '</div>';
        } else {
            $content = '&mdash;';
        }
    }
    return $content;
}
add_filter('manage_portfolio_tech_custom_column', 'sw_portfolio_tech_admin_column_content', 10, 3);

/**
 * Show location icon in admin columns
 */
function sw_portfolio_location_admin_columns($columns)
{
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key === 'name') {
            $new_columns['location_icon'] = __('Icon', SW_PORTFOLIO_TEXT_DOMAIN);
        }
        $new_columns[$key] = $value;
    }
    return $new_columns;
}
add_filter('manage_edit-portfolio_location_columns', 'sw_portfolio_location_admin_columns');

function sw_portfolio_location_admin_column_content($content, $column_name, $term_id)
{
    if ($column_name === 'location_icon') {
        $icon_svg = get_term_meta($term_id, 'location_icon_svg', true);
        if ($icon_svg) {
            $content = '<div style="width:30px;height:30px;overflow:hidden;">' . preg_replace('/<svg/', '<svg style="width:30px;height:30px;max-width:30px;max-height:30px;display:block;"', $icon_svg, 1) . '</div>';
        } else {
            $content = '&mdash;';
        }
    }
    return $content;
}
add_filter('manage_portfolio_location_custom_column', 'sw_portfolio_location_admin_column_content', 10, 3);

// =============================================================================
// HELPER: Sanitize SVG content
// =============================================================================

/**
 * Sanitize SVG markup allowing safe SVG tags and attributes
 */
function sw_portfolio_sanitize_svg($svg)
{
    $allowed_tags = array(
        'svg'      => array('xmlns' => true, 'viewbox' => true, 'width' => true, 'height' => true, 'fill' => true, 'class' => true, 'style' => true, 'role' => true, 'aria-hidden' => true, 'aria-label' => true, 'focusable' => true),
        'path'     => array('d' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'fill-rule' => true, 'clip-rule' => true, 'opacity' => true, 'class' => true, 'style' => true, 'transform' => true),
        'circle'   => array('cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true, 'class' => true, 'style' => true, 'transform' => true),
        'rect'     => array('x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true, 'class' => true, 'style' => true, 'transform' => true),
        'ellipse'  => array('cx' => true, 'cy' => true, 'rx' => true, 'ry' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true, 'class' => true, 'style' => true, 'transform' => true),
        'line'     => array('x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'opacity' => true, 'class' => true, 'style' => true, 'transform' => true),
        'polygon'  => array('points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true, 'class' => true, 'style' => true, 'transform' => true),
        'polyline' => array('points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true, 'class' => true, 'style' => true, 'transform' => true),
        'g'        => array('fill' => true, 'stroke' => true, 'stroke-width' => true, 'opacity' => true, 'class' => true, 'style' => true, 'transform' => true, 'id' => true),
        'defs'     => array(),
        'clippath' => array('id' => true),
        'mask'     => array('id' => true),
        'use'      => array('href' => true, 'xlink:href' => true, 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'transform' => true),
        'symbol'   => array('id' => true, 'viewbox' => true),
        'title'    => array(),
        'desc'     => array(),
        'lineargradient' => array('id' => true, 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'gradientunits' => true, 'gradienttransform' => true),
        'radialgradient' => array('id' => true, 'cx' => true, 'cy' => true, 'r' => true, 'fx' => true, 'fy' => true, 'gradientunits' => true, 'gradienttransform' => true),
        'stop'     => array('offset' => true, 'stop-color' => true, 'stop-opacity' => true, 'style' => true),
    );

    return wp_kses($svg, $allowed_tags);
}

// =============================================================================
// 3b. TECH TAXONOMY - ICON SVG FIELD
// =============================================================================

/**
 * Add icon SVG field to Tech taxonomy - Add form
 */
function sw_portfolio_tech_add_icon_field()
{
?>
    <div class="form-field">
        <label><?php _e('Icon SVG', SW_PORTFOLIO_TEXT_DOMAIN); ?></label>
        <textarea id="sw-tech-icon-svg" name="tech_icon_svg" rows="5" class="large-text" placeholder="<svg>...</svg>"></textarea>
        <p class="description"><?php _e('Paste the SVG code for this technology icon.', SW_PORTFOLIO_TEXT_DOMAIN); ?></p>
        <div id="sw-tech-icon-preview" style="margin-top:10px;width:40px;height:40px;"></div>
    </div>
<?php
}
add_action('portfolio_tech_add_form_fields', 'sw_portfolio_tech_add_icon_field');

/**
 * Add icon SVG field to Tech taxonomy - Edit form
 */
function sw_portfolio_tech_edit_icon_field($term)
{
    $icon_svg = get_term_meta($term->term_id, 'tech_icon_svg', true);
?>
    <tr class="form-field">
        <th scope="row"><label><?php _e('Icon SVG', SW_PORTFOLIO_TEXT_DOMAIN); ?></label></th>
        <td>
            <textarea id="sw-tech-icon-svg" name="tech_icon_svg" rows="5" class="large-text" placeholder="<svg>...</svg>"><?php echo esc_textarea($icon_svg); ?></textarea>
            <p class="description"><?php _e('Paste the SVG code for this technology icon.', SW_PORTFOLIO_TEXT_DOMAIN); ?></p>
            <?php if ($icon_svg) : ?>
                <div id="sw-tech-icon-preview" style="margin-top:10px;width:40px;height:40px;overflow:hidden;"><?php echo preg_replace('/<svg/', '<svg style="width:40px;height:40px;max-width:40px;max-height:40px;display:block;"', $icon_svg, 1); ?></div>
            <?php endif; ?>
        </td>
    </tr>
<?php
}
add_action('portfolio_tech_edit_form_fields', 'sw_portfolio_tech_edit_icon_field');

/**
 * Save Tech icon SVG on create
 */
function sw_portfolio_tech_save_icon_create($term_id)
{
    if (isset($_POST['tech_icon_svg'])) {
        update_term_meta($term_id, 'tech_icon_svg', sw_portfolio_sanitize_svg($_POST['tech_icon_svg']));
    }
}
add_action('created_portfolio_tech', 'sw_portfolio_tech_save_icon_create');

/**
 * Save Tech icon SVG on edit
 */
function sw_portfolio_tech_save_icon_edit($term_id)
{
    if (isset($_POST['tech_icon_svg'])) {
        update_term_meta($term_id, 'tech_icon_svg', sw_portfolio_sanitize_svg($_POST['tech_icon_svg']));
    }
}
add_action('edited_portfolio_tech', 'sw_portfolio_tech_save_icon_edit');

// =============================================================================
// 3c. LOCATION TAXONOMY - ICON SVG FIELD
// =============================================================================

/**
 * Add icon SVG field to Location taxonomy - Add form
 */
function sw_portfolio_location_add_icon_field()
{
?>
    <div class="form-field">
        <label><?php _e('Icon SVG', SW_PORTFOLIO_TEXT_DOMAIN); ?></label>
        <textarea id="sw-location-icon-svg" name="location_icon_svg" rows="5" class="large-text" placeholder="<svg>...</svg>"></textarea>
        <p class="description"><?php _e('Paste the SVG code for this location icon.', SW_PORTFOLIO_TEXT_DOMAIN); ?></p>
        <div id="sw-location-icon-preview" style="margin-top:10px;width:40px;height:40px;"></div>
    </div>
<?php
}
add_action('portfolio_location_add_form_fields', 'sw_portfolio_location_add_icon_field');

/**
 * Add icon SVG field to Location taxonomy - Edit form
 */
function sw_portfolio_location_edit_icon_field($term)
{
    $icon_svg = get_term_meta($term->term_id, 'location_icon_svg', true);
?>
    <tr class="form-field">
        <th scope="row"><label><?php _e('Icon SVG', SW_PORTFOLIO_TEXT_DOMAIN); ?></label></th>
        <td>
            <textarea id="sw-location-icon-svg" name="location_icon_svg" rows="5" class="large-text" placeholder="<svg>...</svg>"><?php echo esc_textarea($icon_svg); ?></textarea>
            <p class="description"><?php _e('Paste the SVG code for this location icon.', SW_PORTFOLIO_TEXT_DOMAIN); ?></p>
            <?php if ($icon_svg) : ?>
                <div id="sw-location-icon-preview" style="margin-top:10px;width:40px;height:40px;overflow:hidden;"><?php echo preg_replace('/<svg/', '<svg style="width:40px;height:40px;max-width:40px;max-height:40px;display:block;"', $icon_svg, 1); ?></div>
            <?php endif; ?>
        </td>
    </tr>
<?php
}
add_action('portfolio_location_edit_form_fields', 'sw_portfolio_location_edit_icon_field');

/**
 * Save Location icon SVG on create
 */
function sw_portfolio_location_save_icon_create($term_id)
{
    if (isset($_POST['location_icon_svg'])) {
        update_term_meta($term_id, 'location_icon_svg', sw_portfolio_sanitize_svg($_POST['location_icon_svg']));
    }
}
add_action('created_portfolio_location', 'sw_portfolio_location_save_icon_create');

/**
 * Save Location icon SVG on edit
 */
function sw_portfolio_location_save_icon_edit($term_id)
{
    if (isset($_POST['location_icon_svg'])) {
        update_term_meta($term_id, 'location_icon_svg', sw_portfolio_sanitize_svg($_POST['location_icon_svg']));
    }
}
add_action('edited_portfolio_location', 'sw_portfolio_location_save_icon_edit');

// =============================================================================
// 4. META BOXES
// =============================================================================

function sw_portfolio_add_meta_boxes()
{
    // Project Details
    add_meta_box(
        'portfolio_details',
        __('Project Details', SW_PORTFOLIO_TEXT_DOMAIN),
        'sw_portfolio_details_callback',
        'portfolio',
        'normal',
        'high'
    );

    // Project Gallery
    add_meta_box(
        'portfolio_gallery',
        __('Project Gallery', SW_PORTFOLIO_TEXT_DOMAIN),
        'sw_portfolio_gallery_callback',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sw_portfolio_add_meta_boxes');

/**
 * Meta box: Project Details (objective, testimonial, URL)
 */
function sw_portfolio_details_callback($post)
{
    wp_nonce_field('sw_portfolio_save_meta', 'sw_portfolio_meta_nonce');

    $featured    = get_post_meta($post->ID, '_portfolio_featured', true);
    $objective   = get_post_meta($post->ID, '_portfolio_objective', true);
    $testimonial = get_post_meta($post->ID, '_portfolio_testimonial', true);
    $url         = get_post_meta($post->ID, '_portfolio_url', true);
?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="portfolio_featured"><?php _e('Featured', SW_PORTFOLIO_TEXT_DOMAIN); ?></label>
            </th>
            <td>
                <label>
                    <input type="checkbox" id="portfolio_featured" name="portfolio_featured" value="1" <?php checked($featured, '1'); ?> />
                    <?php _e('Show this project on the homepage', SW_PORTFOLIO_TEXT_DOMAIN); ?>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="portfolio_objective"><?php _e('Objective', SW_PORTFOLIO_TEXT_DOMAIN); ?></label>
            </th>
            <td>
                <input type="text" id="portfolio_objective" name="portfolio_objective" value="<?php echo esc_attr($objective); ?>" class="large-text" />
                <p class="description"><?php _e('Main objective of the project.', SW_PORTFOLIO_TEXT_DOMAIN); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="portfolio_testimonial"><?php _e('Client Testimonial', SW_PORTFOLIO_TEXT_DOMAIN); ?></label>
            </th>
            <td>
                <textarea id="portfolio_testimonial" name="portfolio_testimonial" rows="4" class="large-text"><?php echo esc_textarea($testimonial); ?></textarea>
                <p class="description"><?php _e('Client feedback about the project.', SW_PORTFOLIO_TEXT_DOMAIN); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="portfolio_url"><?php _e('Project URL', SW_PORTFOLIO_TEXT_DOMAIN); ?></label>
            </th>
            <td>
                <input type="url" id="portfolio_url" name="portfolio_url" value="<?php echo esc_url($url); ?>" class="large-text" placeholder="https://" />
                <p class="description"><?php _e('Link to the live project/website.', SW_PORTFOLIO_TEXT_DOMAIN); ?></p>
            </td>
        </tr>
    </table>
<?php
}

/**
 * Meta box: Project Gallery
 */
function sw_portfolio_gallery_callback($post)
{
    $gallery_ids = get_post_meta($post->ID, '_portfolio_gallery', true);
    $gallery_ids = is_array($gallery_ids) ? $gallery_ids : array();
?>
    <div id="sw-portfolio-gallery">
        <div id="sw-gallery-images" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:10px;">
            <?php foreach ($gallery_ids as $image_id) :
                $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                if ($image_url) :
            ?>
                    <div class="sw-gallery-item" style="position:relative;">
                        <img src="<?php echo esc_url($image_url); ?>" style="width:120px;height:80px;object-fit:cover;border:1px solid #ddd;border-radius:4px;" />
                        <input type="hidden" name="portfolio_gallery[]" value="<?php echo esc_attr($image_id); ?>" />
                        <button type="button" class="sw-remove-gallery-image" style="position:absolute;top:-5px;right:-5px;background:#dc3232;color:#fff;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:12px;line-height:1;">&times;</button>
                    </div>
            <?php
                endif;
            endforeach; ?>
        </div>
        <button type="button" class="button sw-add-gallery-images"><?php _e('Add Images', SW_PORTFOLIO_TEXT_DOMAIN); ?></button>
        <p class="description"><?php _e('Select multiple screenshots/images of the project.', SW_PORTFOLIO_TEXT_DOMAIN); ?></p>
    </div>
<?php
}

/**
 * Save all meta box data
 */
function sw_portfolio_save_meta($post_id)
{
    if (!isset($_POST['sw_portfolio_meta_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['sw_portfolio_meta_nonce'], 'sw_portfolio_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Featured
    update_post_meta($post_id, '_portfolio_featured', isset($_POST['portfolio_featured']) ? '1' : '0');

    // Project Details
    if (isset($_POST['portfolio_objective'])) {
        update_post_meta($post_id, '_portfolio_objective', sanitize_text_field($_POST['portfolio_objective']));
    }
    if (isset($_POST['portfolio_testimonial'])) {
        update_post_meta($post_id, '_portfolio_testimonial', wp_kses_post($_POST['portfolio_testimonial']));
    }
    if (isset($_POST['portfolio_url'])) {
        update_post_meta($post_id, '_portfolio_url', esc_url_raw($_POST['portfolio_url']));
    }

    // Gallery
    if (isset($_POST['portfolio_gallery'])) {
        $gallery = array_map('absint', (array) $_POST['portfolio_gallery']);
        $gallery = array_filter($gallery);
        update_post_meta($post_id, '_portfolio_gallery', $gallery);
    } else {
        delete_post_meta($post_id, '_portfolio_gallery');
    }
}
add_action('save_post_portfolio', 'sw_portfolio_save_meta');

// =============================================================================
// 5. ADMIN COLUMNS
// =============================================================================

function sw_portfolio_add_admin_columns($columns)
{
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key === 'title') {
            $new_columns['portfolio_thumb'] = __('Image', SW_PORTFOLIO_TEXT_DOMAIN);
        }
        $new_columns[$key] = $value;
    }

    // Remove default taxonomy columns (we re-add the ones we want)
    unset($new_columns['taxonomy-portfolio_category']);
    unset($new_columns['taxonomy-portfolio_client']);
    unset($new_columns['taxonomy-portfolio_sector']);
    unset($new_columns['taxonomy-portfolio_location']);

    // Add custom columns after title
    $final = array();
    foreach ($new_columns as $key => $value) {
        $final[$key] = $value;
        if ($key === 'title') {
            $final['portfolio_featured_col'] = __('Featured', SW_PORTFOLIO_TEXT_DOMAIN);
            $final['portfolio_category_col'] = __('Category', SW_PORTFOLIO_TEXT_DOMAIN);
            $final['portfolio_client_col']   = __('Client', SW_PORTFOLIO_TEXT_DOMAIN);
            $final['portfolio_sector_col']   = __('Sector', SW_PORTFOLIO_TEXT_DOMAIN);
            $final['portfolio_location_col'] = __('Location', SW_PORTFOLIO_TEXT_DOMAIN);
        }
    }

    return $final;
}
add_filter('manage_portfolio_posts_columns', 'sw_portfolio_add_admin_columns');

function sw_portfolio_display_admin_columns($column, $post_id)
{
    switch ($column) {
        case 'portfolio_thumb':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(50, 50), array('style' => 'border-radius:4px;'));
            } else {
                echo '&mdash;';
            }
            break;

        case 'portfolio_featured_col':
            $featured = get_post_meta($post_id, '_portfolio_featured', true);
            echo $featured === '1' ? '<span style="color:#f0b849;font-size:18px;">&#9733;</span>' : '<span style="color:#ccc;font-size:18px;">&#9734;</span>';
            break;

        case 'portfolio_category_col':
        case 'portfolio_client_col':
        case 'portfolio_sector_col':
        case 'portfolio_location_col':
            $tax_map = array(
                'portfolio_category_col' => 'portfolio_category',
                'portfolio_client_col'   => 'portfolio_client',
                'portfolio_sector_col'   => 'portfolio_sector',
                'portfolio_location_col' => 'portfolio_location',
            );
            $taxonomy = $tax_map[$column];
            $terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'names'));
            echo !empty($terms) ? esc_html(implode(', ', $terms)) : '&mdash;';
            break;
    }
}
add_action('manage_portfolio_posts_custom_column', 'sw_portfolio_display_admin_columns', 10, 2);

// =============================================================================
// 6. ADMIN SCRIPTS (Media Uploader for Gallery & Client Image)
// =============================================================================

function sw_portfolio_admin_scripts($hook)
{
    global $post_type, $taxonomy;

    $is_portfolio = ($post_type === 'portfolio' && in_array($hook, array('post.php', 'post-new.php')));
    $allowed_taxonomies = ['portfolio_client', 'portfolio_tech', 'portfolio_location'];
    $is_taxonomy = ($hook === 'edit-tags.php' || $hook === 'term.php') && isset($_GET['taxonomy']) && in_array($_GET['taxonomy'], $allowed_taxonomies);

    if (!$is_portfolio && !$is_taxonomy) {
        return;
    }

    wp_enqueue_media();
    wp_add_inline_script('jquery-core', sw_portfolio_get_admin_js());
}
add_action('admin_enqueue_scripts', 'sw_portfolio_admin_scripts');

function sw_portfolio_get_admin_js()
{
    return <<<'JS'
jQuery(document).ready(function($) {
    // ---- Gallery ----
    var galleryContainer = $('#sw-gallery-images');

    // Add gallery images
    $('.sw-add-gallery-images').on('click', function(e) {
        e.preventDefault();
        var frame = wp.media({
            title: 'Select Gallery Images',
            multiple: true,
            library: { type: 'image' }
        });
        frame.on('select', function() {
            var attachments = frame.state().get('selection').toJSON();
            $.each(attachments, function(i, attachment) {
                var thumbUrl = attachment.sizes && attachment.sizes.thumbnail
                    ? attachment.sizes.thumbnail.url
                    : attachment.url;
                var html = '<div class="sw-gallery-item" style="position:relative;">';
                html += '<img src="' + thumbUrl + '" style="width:120px;height:80px;object-fit:cover;border:1px solid #ddd;border-radius:4px;" />';
                html += '<input type="hidden" name="portfolio_gallery[]" value="' + attachment.id + '" />';
                html += '<button type="button" class="sw-remove-gallery-image" style="position:absolute;top:-5px;right:-5px;background:#dc3232;color:#fff;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:12px;line-height:1;">&times;</button>';
                html += '</div>';
                galleryContainer.append(html);
            });
        });
        frame.open();
    });

    // Remove gallery image
    galleryContainer.on('click', '.sw-remove-gallery-image', function() {
        $(this).closest('.sw-gallery-item').remove();
    });

    // Make gallery sortable
    if ($.fn.sortable) {
        galleryContainer.sortable({ items: '.sw-gallery-item', cursor: 'move' });
    }

    // ---- Client Image ----
    $('.sw-upload-client-image').on('click', function(e) {
        e.preventDefault();
        var frame = wp.media({
            title: 'Select Client Image',
            multiple: false,
            library: { type: 'image' }
        });
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            var thumbUrl = attachment.sizes && attachment.sizes.thumbnail
                ? attachment.sizes.thumbnail.url
                : attachment.url;
            $('#sw-client-image-id').val(attachment.id);
            $('#sw-client-image-preview').attr('src', thumbUrl).show();
            $('.sw-remove-client-image').show();
        });
        frame.open();
    });

    $('.sw-remove-client-image').on('click', function(e) {
        e.preventDefault();
        $('#sw-client-image-id').val('');
        $('#sw-client-image-preview').attr('src', '').hide();
        $(this).hide();
    });
});
JS;
}

// =============================================================================
// 7. WPGRAPHQL SUPPORT
// =============================================================================

function sw_portfolio_register_graphql_fields()
{
    if (!class_exists('WPGraphQL')) {
        return;
    }

    // Register SwPortfolioFields object type
    register_graphql_object_type('SwPortfolioFields', [
        'description' => __('Portfolio project custom fields', SW_PORTFOLIO_TEXT_DOMAIN),
        'fields' => [
            'featured' => [
                'type' => 'Boolean',
                'description' => __('Whether the project is featured', SW_PORTFOLIO_TEXT_DOMAIN),
            ],
            'objective' => [
                'type' => 'String',
                'description' => __('Project objective', SW_PORTFOLIO_TEXT_DOMAIN),
            ],
            'testimonial' => [
                'type' => 'String',
                'description' => __('Client testimonial', SW_PORTFOLIO_TEXT_DOMAIN),
            ],
            'url' => [
                'type' => 'String',
                'description' => __('Project URL', SW_PORTFOLIO_TEXT_DOMAIN),
            ],
            'order' => [
                'type' => 'Integer',
                'description' => __('Display order', SW_PORTFOLIO_TEXT_DOMAIN),
            ],
        ],
    ]);

    // Register field on SwPortfolio post type
    register_graphql_field('SwPortfolio', 'swPortfolioFields', [
        'type' => 'SwPortfolioFields',
        'description' => __('Portfolio custom fields', SW_PORTFOLIO_TEXT_DOMAIN),
        'resolve' => function ($post) {
            $post_object = get_post($post->ID);

            return [
                'featured'    => get_post_meta($post->ID, '_portfolio_featured', true) === '1',
                'objective'   => get_post_meta($post->ID, '_portfolio_objective', true) ?: '',
                'testimonial' => get_post_meta($post->ID, '_portfolio_testimonial', true) ?: '',
                'url'         => get_post_meta($post->ID, '_portfolio_url', true) ?: '',
                'order'       => $post_object ? absint($post_object->menu_order) : 0,
            ];
        },
    ]);

    // Register gallery field (returns MediaItem nodes)
    register_graphql_field('SwPortfolio', 'swPortfolioGallery', [
        'type' => ['list_of' => 'MediaItem'],
        'description' => __('Project gallery images', SW_PORTFOLIO_TEXT_DOMAIN),
        'resolve' => function ($post, $args, $context) {
            $gallery_ids = get_post_meta($post->ID, '_portfolio_gallery', true);
            if (!is_array($gallery_ids) || empty($gallery_ids)) {
                return [];
            }

            $images = [];
            foreach ($gallery_ids as $id) {
                $media_post = get_post($id);
                if ($media_post) {
                    $images[] = $context->get_loader('post')->load_deferred($id);
                }
            }
            return $images;
        },
    ]);

    // Register icon SVG field on the tech taxonomy
    register_graphql_field('SwPortfolioTech', 'iconSvg', [
        'type' => 'String',
        'description' => __('Technology SVG icon', SW_PORTFOLIO_TEXT_DOMAIN),
        'resolve' => function ($term) {
            return get_term_meta($term->term_id, 'tech_icon_svg', true) ?: '';
        },
    ]);

    // Register icon SVG field on the location taxonomy
    register_graphql_field('SwPortfolioLocation', 'iconSvg', [
        'type' => 'String',
        'description' => __('Location SVG icon', SW_PORTFOLIO_TEXT_DOMAIN),
        'resolve' => function ($term) {
            return get_term_meta($term->term_id, 'location_icon_svg', true) ?: '';
        },
    ]);

    // Register client image field on the client taxonomy
    register_graphql_field('SwPortfolioClient', 'clientImage', [
        'type' => 'MediaItem',
        'description' => __('Client image/logo', SW_PORTFOLIO_TEXT_DOMAIN),
        'resolve' => function ($term, $args, $context) {
            $image_id = get_term_meta($term->term_id, 'client_image_id', true);
            if (!$image_id) {
                return null;
            }
            return $context->get_loader('post')->load_deferred($image_id);
        },
    ]);
}
add_action('graphql_register_types', 'sw_portfolio_register_graphql_fields');

/**
 * Register taxonomy filters in WPGraphQL
 */
function sw_portfolio_register_graphql_filters()
{
    if (!class_exists('WPGraphQL')) {
        return;
    }

    // Add custom where args for taxonomy filtering
    add_filter('graphql_input_fields', function ($fields, $type_name) {
        if ($type_name === 'RootQueryToSwPortfolioConnectionWhereArgs') {
            $fields['categorySlug'] = [
                'type' => 'String',
                'description' => __('Filter by portfolio category slug', SW_PORTFOLIO_TEXT_DOMAIN),
            ];
            $fields['clientSlug'] = [
                'type' => 'String',
                'description' => __('Filter by client slug', SW_PORTFOLIO_TEXT_DOMAIN),
            ];
            $fields['sectorSlug'] = [
                'type' => 'String',
                'description' => __('Filter by sector slug', SW_PORTFOLIO_TEXT_DOMAIN),
            ];
            $fields['locationSlug'] = [
                'type' => 'String',
                'description' => __('Filter by location slug', SW_PORTFOLIO_TEXT_DOMAIN),
            ];
            $fields['techSlug'] = [
                'type' => 'String',
                'description' => __('Filter by technology slug', SW_PORTFOLIO_TEXT_DOMAIN),
            ];
            $fields['serviceSlug'] = [
                'type' => 'String',
                'description' => __('Filter by service slug', SW_PORTFOLIO_TEXT_DOMAIN),
            ];
        }
        return $fields;
    }, 10, 2);

    // Apply taxonomy filters to query
    add_filter('graphql_post_object_connection_query_args', function ($query_args, $source, $args, $context, $info) {
        if ($info->fieldName !== 'swPortfolios') {
            return $query_args;
        }

        $filter_map = array(
            'categorySlug' => 'portfolio_category',
            'clientSlug'   => 'portfolio_client',
            'sectorSlug'   => 'portfolio_sector',
            'locationSlug' => 'portfolio_location',
            'techSlug'     => 'portfolio_tech',
            'serviceSlug'  => 'portfolio_service',
        );

        foreach ($filter_map as $arg_key => $taxonomy) {
            if (isset($args['where'][$arg_key])) {
                if (!isset($query_args['tax_query'])) {
                    $query_args['tax_query'] = [];
                }
                $query_args['tax_query'][] = [
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($args['where'][$arg_key]),
                ];
            }
        }

        return $query_args;
    }, 10, 5);
}
add_action('graphql_register_types', 'sw_portfolio_register_graphql_filters');

// =============================================================================
// 8. ACTIVATION / DEACTIVATION
// =============================================================================

function sw_portfolio_activate()
{
    sw_portfolio_register_cpt();
    sw_portfolio_register_taxonomies();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'sw_portfolio_activate');

function sw_portfolio_deactivate()
{
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'sw_portfolio_deactivate');
