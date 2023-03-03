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
		'posts_per_page' => -1
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
								<?php if ( isset($team_image) ) : ?>
									<?php // echo $team_image; ?>
								<?php endif; ?>
								<h4><?php echo the_title(); ?></h4>
								<?php if ( isset($team_title) ) : ?>
									<h6><?php echo $team_title; ?></h6>
								<?php endif; ?>
								<?php if ( isset($team_content) ) : ?>
									<aside><?php echo $team_content; ?></aside>	
								<?php endif; ?>
							<a href="<?php echo get_permalink(); ?>">
								<div aria-hidden="true" class="grid-team__icon"><svg viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M26.55 1L34 8.5 26.55 16M0 8.5h34" stroke="#6e7ca0" stroke-width="2"/></svg></div>
							</a>
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
