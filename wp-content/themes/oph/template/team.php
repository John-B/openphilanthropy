<?php
	/**
	 * Template Name: Team
	 */

	the_post();

	get_header();

	// Custom order to sort by team's last name
	add_filter( 'posts_orderby' , 'posts_orderby_lastname' );
	function posts_orderby_lastname ($orderby_statement) {
    	$orderby_statement = "RIGHT(post_title, LOCATE(' ', CONCAT(REVERSE(post_title), ' ')) - 1) ASC";
    	return $orderby_statement;
	}

	$team = new WP_Query( array(
		'post_type' => 'team',
		'posts_per_page' => -1,
		'meta_query' => array(
		  'relation' => 'OR',
                  array(
                    'key'     => 'teampage_exclusion',
                    'compare' => 'NOT EXISTS',
                  ),
                  array(
                    'key'     => 'teampage_exclusion',
                    'value'   => '1',
		    'compare' => '!=',
                  ),
		),
	) );

	// Clean up as to not affect other posts
	remove_filter( 'posts_orderby' , 'posts_orderby_lastname' );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<div class="content-team" id="team">
	<div class="wrap">
		<div class="content-team__main">
			<?php if ( $team->have_posts() ) : ?>
				<div class="team-grid" id="team-grid">
					<?php while ( $team->have_posts() ) : $team->the_post(); ?>

						<?php
							$team_title = get_field( 'team_title' );
							$team_content = get_the_content();
							$team_image = get_the_post_thumbnail();

						?>

						<article class="team-item">
								<div class="team-item-header">
								<?php if ( isset($team_image) ) : ?>
									<?php // echo $team_image; ?>
								<?php endif; ?>
								<h4><a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a></h4>
								<?php if ( isset($team_title) ) : ?>
								<h6><?php echo $team_title; ?></h6>
								<?php endif; ?>
								</div>
								<?php if ( isset($team_content) ) : ?>
									<details><summary> </summary><p><?php echo $team_content; ?></p></details>	
								<?php endif; ?>
 						</article>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="content-team__copy">
			<?php the_content(); ?> 
		</div>
	</div>
</div>

<?php get_template_part( 'part/cta-button' ); ?>

<?php get_footer(); ?>
