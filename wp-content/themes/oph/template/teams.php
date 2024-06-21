<?php
	/**
	 * Template Name: Teams
	 */

        the_post();

        get_header();

        get_template_part( 'part/page', 'header' );

        echo '<div class="content-team__copy">';
        echo '</div><div class="content-team" id="team"><div class="wrap">';

        // get the terms, ordered by name
        // https://developer.wordpress.org/reference/functions/get_terms/
        // https://developer.wordpress.org/reference/classes/wp_term_query/__construct/
        $taxonomy = 'teams';
        $tax_terms = get_terms( $taxonomy, array(
          'hide_empty' => 0,
          'orderby' => 'term_order',
          'order' => 'ASC',
          'child_of' => 0,
        ) );

        // Custom order to sort by team's last name
        function posts_orderby_lastname ($orderby_statement) {
        $orderby_statement = "RIGHT(post_title, LOCATE(' ', CONCAT(REVERSE(post_title), ' ')) - 1) ASC";
        return $orderby_statement;
        }

        foreach($tax_terms as $tax_term) { // loop through the terms to set heading then remove terms with children
         if (empty($tax_term->parent) ) { 
            echo '<h2 id=' . $tax_term->slug . '>' . $tax_term->name . '</h2>'; //Print name in h2 if it is top level, otherwise in h4
          } else {
            echo '<h3 id=' . $tax_term->slug . '>' . $tax_term->name . '</h3>'; //Print name in h2 if it is top level, otherwise in h4
          }
          add_filter( 'posts_orderby' , 'posts_orderby_lastname' );
           $term_posts = new WP_Query( // find posts with the correct term
             array(
              'no_found_rows' => true, // for performance
              'ignore_sticky_posts' => true, // for performance
              'post_type' => 'team',
              'posts_per_page' => -1, // return all results
              'tax_query' => array( // https://developer.wordpress.org/reference/classes/wp_tax_query/
                array(
                  'taxonomy' => $taxonomy,
                  'field'    => 'name',
                  'terms'    => array( $tax_term->name )
               )
           ),
           'meta_query' => array(
             'relation' => 'OR',
               array(
                 'key'     => 'teampage_exclusion',
                 'compare' => 'NOT EXISTS'
               ),
               array(
                 'key'     => 'teampage_exclusion',
                 'value'   => '1',
                 'compare' => '!='
               ),
           ),
           'fields' => 'ids', // return the post IDs only
           )
         );
        // Clean up as to not affect other posts
        remove_filter( 'posts_orderby' , 'posts_orderby_lastname' );
  ?>

                <div class="content-team__main collapsed-grid">
                        <?php if ( $term_posts->have_posts() ) : ?>
                                <!-- The following allow class "team-flex" to center incomplete rows, or "team-grid" for a grid layout with 3 columns in desktop.-->
                                <div class="team-grid" id=<?php echo '"' . $tax_term->slug . '-grid"'; ?>>
                                        <?php while ( $term_posts->have_posts() ) : $term_posts->the_post(); ?>
                                                <?php
						     $term = get_the_terms(get_the_ID(), 'teams')[0]; // We only allow one teams term.
                                                     if($tax_term->term_id === $term->term_id) { // Without this we end up printing posts or the term AND its parent term.
                                                        $team_title = get_field( 'team_title' );
                                                        $team_content = get_the_content();
                                                        $team_image = get_the_post_thumbnail();
                                                        // Uncomment to skip lazy loading.
                                                        // $team_image = str_replace('lazy', 'skip-lazy', get_the_post_thumbnail());

                                                ?>

                                                <article class="team-item">
                                                                <div class="team-item-header">
                                                                <h4><a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a></h4>
                                                                <?php if ( isset($team_title) ) : ?>
                                                                <h6><?php echo $team_title; ?></h6>
                                                                <?php endif; ?>
                                                                </div>
                                                                <?php if ( isset($team_content) ) : ?>
                                                                        <details><summary> </summary>
                                                                <?php if ( isset($team_image) ) : ?>
                                                                        <?php echo $team_image; ?>
                                                                <?php endif; ?>
								<p><?php echo $team_content; ?></p></details>      
                                                                <?php endif; ?>
                                                </article>

                                              <?php  } ?>
                                       <?php  endwhile; wp_reset_postdata(); ?>
                                </div>
                        <?php endif; ?>
                </div>
 
<?php 
   }
   the_content(); 
   echo '</div></div>';

   get_template_part( 'part/cta-button' );

   get_footer();

?>
