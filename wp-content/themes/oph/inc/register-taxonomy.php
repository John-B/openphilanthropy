<?php
/**
 * Taxonomy: Blog Category
 */
function taxonomy_blog_category() {
    $labels = array(
        'name'              => _x( 'Category', 'taxonomy general name', 'oph' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name', 'oph' ),
        'add_new_item'      => __( 'Add New Category', 'oph' ),
        'all_items'         => __( 'All Categories', 'oph' ),
        'edit_item'         => __( 'Edit Category', 'oph' ),
        'menu_name'         => __( 'Category', 'oph' ),
        'new_item_name'     => __( 'New Category Name', 'oph' ),
        'parent_item'       => __( 'Parent Category', 'oph' ),
        'parent_item_colon' => __( 'Parent Category:', 'oph' ),
        'search_items'      => __( 'Search Categories', 'oph' ),
        'update_item'       => __( 'Update Category', 'oph' )
    );

    $args = array(
        'labels'             => $labels,
        'hierarchical'       => true,
        'meta_box_cb'        => 'post_categories_meta_box',
        'public'             => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'blog-category' ),
        'show_in_quick_edit' => true,
        'show_ui'            => true,
        'show_admin_column'  => true
    );

    register_taxonomy( 'blog-category', 'blog', $args );
}

add_action( 'init', 'taxonomy_blog_category' );

/**
 * Taxonomy: Content Type
 */
function taxonomy_content_type() {
    $labels = array(
        'name'              => _x( 'Content Type', 'taxonomy general name', 'oph' ),
        'singular_name'     => _x( 'Content Type', 'taxonomy singular name', 'oph' ),
        'add_new_item'      => __( 'Add New Content Type', 'oph' ),
        'all_items'         => __( 'All Content Types', 'oph' ),
        'edit_item'         => __( 'Edit Content Type', 'oph' ),
        'menu_name'         => __( 'Content Type', 'oph' ),
        'new_item_name'     => __( 'New Content Type Name', 'oph' ),
        'parent_item'       => __( 'Parent Content Type', 'oph' ),
        'parent_item_colon' => __( 'Parent Content Type:', 'oph' ),
        'search_items'      => __( 'Search Content Types', 'oph' ),
        'update_item'       => __( 'Update Content Type', 'oph' )
    );

    $args = array(
        'labels'             => $labels,
        'hierarchical'       => true,
        'meta_box_cb'        => 'post_categories_meta_box',
        'public'             => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'content-type' ),
        'show_in_quick_edit' => true,
        'show_ui'            => true,
        'show_admin_column'  => true
    );

    register_taxonomy( 'content-type', 'research', $args );
}

add_action( 'init', 'taxonomy_content_type' );

/**
 * Taxonomy: Focus Area
 */
function taxonomy_focus_area() {
    $labels = array(
        'name'              => _x( 'Focus Area', 'taxonomy general name', 'oph' ),
        'singular_name'     => _x( 'Focus Area', 'taxonomy singular name', 'oph' ),
        'add_new_item'      => __( 'Add New Focus Area', 'oph' ),
        'all_items'         => __( 'All Focus Areas', 'oph' ),
        'edit_item'         => __( 'Edit Focus Area', 'oph' ),
        'menu_name'         => __( 'Focus Area', 'oph' ),
        'new_item_name'     => __( 'New Focus Area Name', 'oph' ),
        'parent_item'       => __( 'Parent Focus Area', 'oph' ),
        'parent_item_colon' => __( 'Parent Focus Area:', 'oph' ),
        'search_items'      => __( 'Search Focus Areas', 'oph' ),
        'update_item'       => __( 'Update Focus Area', 'oph' )
    );

    $args = array(
        'labels'             => $labels,
        'hierarchical'       => true,
        'meta_box_cb'        => 'post_categories_meta_box',
        'public'             => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'focus-area' ),
        'show_in_quick_edit' => true,
        'show_ui'            => true,
        'show_admin_column'  => true
    );

    register_taxonomy( 'focus-area', ['grants', 'research'], $args );
}

add_action( 'init', 'taxonomy_focus_area' );

/**
 * Taxonomy: Funding Type
 */
function taxonomy_funding_type() {
    $labels = array(
        'name'              => _x( 'Funding Type', 'taxonomy general name', 'oph' ),
        'singular_name'     => _x( 'Funding Type', 'taxonomy singular name', 'oph' ),
        'add_new_item'      => __( 'Add New Funding Type', 'oph' ),
        'all_items'         => __( 'All Funding Types', 'oph' ),
        'edit_item'         => __( 'Edit Funding Type', 'oph' ),
        'menu_name'         => __( 'Funding Type', 'oph' ),
        'new_item_name'     => __( 'New Funding Type Name', 'oph' ),
        'parent_item'       => __( 'Parent Funding Type', 'oph' ),
        'parent_item_colon' => __( 'Parent Funding Type:', 'oph' ),
        'search_items'      => __( 'Search Funding Types', 'oph' ),
        'update_item'       => __( 'Update Funding Type', 'oph' )
    );

    $args = array(
        'labels'             => $labels,
        'hierarchical'       => true,
        'meta_box_cb'        => 'post_categories_meta_box',
        'public'             => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'funding-type' ),
        'show_in_quick_edit' => true,
        'show_ui'            => true,
        'show_admin_column'  => true
    );

    register_taxonomy( 'funding-type', 'grants', $args );
}

add_action( 'init', 'taxonomy_funding_type' );

/**
 * Taxonomy: Organization Name
 */
function taxonomy_organization_name() {
    $labels = array(
        'name'              => _x( 'Organization Name', 'taxonomy general name', 'oph' ),
        'singular_name'     => _x( 'Organization Name', 'taxonomy singular name', 'oph' ),
        'add_new_item'      => __( 'Add New Organization Name', 'oph' ),
        'all_items'         => __( 'All Organization Names', 'oph' ),
        'edit_item'         => __( 'Edit Organization Name', 'oph' ),
        'menu_name'         => __( 'Organization Name', 'oph' ),
        'new_item_name'     => __( 'New Organization Name Name', 'oph' ),
        'parent_item'       => __( 'Parent Organization Name', 'oph' ),
        'parent_item_colon' => __( 'Parent Organization Name:', 'oph' ),
        'search_items'      => __( 'Search Organization Names', 'oph' ),
        'update_item'       => __( 'Update Organization Name', 'oph' )
    );

    $args = array(
        'labels'             => $labels,
        'hierarchical'       => true,
        'meta_box_cb'        => 'post_categories_meta_box',
        'public'             => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'organization-name' ),
        'show_in_quick_edit' => true,
        'show_ui'            => true,
        'show_admin_column'  => true
    );

    register_taxonomy( 'organization-name', 'grants', $args );
}

add_action( 'init', 'taxonomy_organization_name' );

/**
 * Taxonomy: Teams
 */
function taxonomy_teams() {
    $labels = array(
        'name'              => _x( 'Team Membership (check only one)', 'taxonomy general name', 'oph' ),
        'singular_name'     => _x( 'Team', 'taxonomy singular name', 'oph' ),
        'add_new_item'      => __( 'Add New Team', 'oph' ),
        'all_items'         => __( 'All Teams', 'oph' ),
        'edit_item'         => __( 'Edit Team', 'oph' ),
        'menu_name'         => __( 'Teams', 'oph' ),
        'new_item_name'     => __( 'New Focus Team', 'oph' ),
        'parent_item'       => __( 'Parent Team', 'oph' ),
        'parent_item_colon' => __( 'Parent Team:', 'oph' ),
        'search_items'      => __( 'Search Teamss', 'oph' ),
        'update_item'       => __( 'Update Team', 'oph' )
    );

    $args = array(
        'labels'             => $labels,
        'hierarchical'       => true,
        'meta_box_cb'        => 'post_categories_meta_box',
        'public'             => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'teams' ),
        'show_in_quick_edit' => true,
        'show_ui'            => true,
        'show_admin_column'  => true
    );

    register_taxonomy( 'teams', ['team'], $args );
}

add_action( 'init', 'taxonomy_teams' );


/**
 * Prevent Teams metabox from losing hierarchy when an item is selected.
 */
function ya_disable_popular_ontop($args) {
   //If this is your required taxonomy then disable the popular on top.
    if($args['taxonomy'] == 'teams'){
        $args['checked_ontop'] = false;
    }
    return $args;
}
add_filter('wp_terms_checklist_args','ya_disable_popular_ontop');

/**
 * Removes custom category "teams" to be selectable as a primary term.
 *
 * @param array  $taxonomies     The current taxonomies that can be used as a primary term.
 * @param string $post_type      The current post type.
 * @param array  $all_taxonomies All registered taxonomies.
 *
 * @return mixed The taxonomies that can be used as primary terms.
 */
function remove_primary_term_taxonomies( $taxonomies, $post_type, $all_taxonomies ) {
    if ( isset( $taxonomies['teams'] ) ) {
        unset( $taxonomies['teams'] );
    }

    return $taxonomies;
}

add_filter( 'wpseo_primary_term_taxonomies', 'remove_primary_term_taxonomies', 11, 3 );
