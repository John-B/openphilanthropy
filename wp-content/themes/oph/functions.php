<?php
/**
 * Create constant to define theme versions.
 * This was added becuase the constant is used in inc/customizer.php, following the code of the _S starter theme.
 *  With the constant undeinfed it was triggering an error. 
 * It may be useful to keep it.
 */
if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'oph_setup' ) ) {
	function oph_setup() {
		load_theme_textdomain( 'oph', get_template_directory() . '/languages' );

		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );

		add_theme_support( 'html5', array(
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'search-form'
		) );

                add_filter( 'feed_links_show_comments_feed', '__return_false' );

                register_nav_menus( array(
			'accessory' => esc_html__( 'Accessory', 'oph' ),
			'footer' => esc_html__( 'Footer', 'oph' ),
			'primary' => esc_html__( 'Primary', 'oph' ),
			'secondary' => esc_html__( 'Secondary', 'oph' )
		) );
	}
}

add_action( 'after_setup_theme', 'oph_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function oph_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'oph_content_width', 1140 );
}

add_action( 'after_setup_theme', 'oph_content_width', 0 );

require get_template_directory() . '/inc/help-text.php';
require get_template_directory() . '/inc/private-function.php';
require get_template_directory() . '/inc/template-function.php';
require get_template_directory() . '/inc/asset.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/acf-customize.php';
require get_template_directory() . '/inc/acf-option.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/register-post-type.php';
require get_template_directory() . '/inc/register-taxonomy.php';
require get_template_directory() . '/inc/shortcode.php';
require get_template_directory() . '/inc/sanitize-functions.php';
require get_template_directory() . '/inc/metabox.php';
require get_template_directory() . '/inc/helper-functions.php';
// require get_template_directory() . '/inc/grants_db.php';
require get_template_directory() . '/inc/generate-grants.php';

// Used for data migration
include get_template_directory() . '/inc/onetime-script.php';

function custom_search_template( $template ) {
  global $wp_query;
  $post_type = get_query_var( 'post_type' );
  $page_name = get_query_var( 'pagename' );

  if ( $wp_query->is_search && $post_type == 'grants' ) {
    return locate_template( 'search-grants.php' );
  } elseif ( $wp_query->is_search && $post_type == 'research' ) {
  	return locate_template( 'search-research.php' );
  } elseif ( $wp_query->is_search && $page_name == 'team' ) {
  	return locate_template( 'team.php' );
  }

  return $template;   
}

add_filter( 'template_include', 'custom_search_template' );



/**
 * Jump to the first error after submission
 *
 * @param $form
 * @return mixed
 */
add_filter("gform_confirmation_anchor", "gform_confirmation_anchor");
function gform_confirmation_anchor() {
  return true;
}

/**
 * Disable xmlrpc.
 */
add_filter('xmlrpc_enabled', '__return_false');


/**
 * Allow use of core custom fields alongside ACF.
 */
// add_filter('acf/settings/remove_wp_meta_box', '__return_false');


/**
 * Add a little JS to team edit pages.
 */
function team_javascript() {
    $screen = get_current_screen();
    $post_type = $screen->post_type ?? "not set";
       if ( is_admin() && ($post_type == 'team') ) {
        ?>
<script>
window.addEventListener('load', function() {
  var checkbox = document.querySelector("#teamschecklist li input");
  var leadership_panel = document.querySelector("#leadership_panel").parentElement.parentElement;
  if (typeof checkbox !== 'undefined' && typeof checkbox !== null && typeof leadership_panel !== 'undefined' && typeof leadership_panel !== null ) {
      if (checkbox.checked === true) {
        leadership_panel.style.display = "block";
      } else if (checkbox.checked === false) {
        leadership_panel.style.display = "none";
      }
  }
    checkbox.addEventListener('change', function(e) {
      if (this.checked === true) {
        leadership_panel.style.display = "block";
        e.stopPropagation();
       } else if (this.checked === false) {
        leadership_panel.style.display = "none";
        e.stopPropagation();
      }
    });
});
</script>
        <?php
      }
}
add_action('admin_head', 'team_javascript');
