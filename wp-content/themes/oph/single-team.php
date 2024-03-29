<?php
	the_post();

	get_header();

	$post_thumbnail = get_the_post_thumbnail_url( $post->ID, 'lg' );

	$team_page = get_page_by_path( 'team' );

	if ( ! $team_page ) {
		$team_page = get_page_by_path( 'about/team' );
	}

	$team_page_id = '';

	if ( $team_page && ! is_wp_error( $team_page ) && $team_page->ID ) {
		$team_page_id = $team_page->ID;

		$team_page_title = get_field( 'page_header_title', $team_page_id );

		if ( ! $team_page_title ) {
			$team_page_title = get_the_title( $team_page_id );
		}
	}

	$team_title = get_field( 'team_title' );
?>

<div class="title-head">
	<div class="wrap">
		<div class="title-head__main">
			<div class="title-head__aside">
				<a href="/team">Back to All Team Members</a>
			</div>

			<div class="title-head__entry">
				<h1><?php echo $team_page_title; ?></h1>
			</div>
		</div>
	</div>
</div>

<div class="content-single-team" id="team-member">
	<div class="wrap">
		<div class="content-single-team__main">
			<?php if ( $post_thumbnail ) : ?>
				<div class="content-single-team__aside">
					<img src="<?php echo $post_thumbnail; ?>" alt="">
				</div>
			<?php endif; ?>

			<div class="content-single-team__entry">
				<div class="team-name-title">
					<h2><?php echo oph_filter(get_the_title(), '*'); ?></h2>

					<?php if ( $team_title ) : ?>
						<h4><?php echo $team_title; ?></h4>
					<?php endif; ?>
				</div>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$call_to_action_button = get_field( 'call_to_action_button' );
	$call_to_action_button_team_fill_single_pages = get_field( 'call_to_action_button_team_fill_single_pages', $team_page_id );

	if ( ! $call_to_action_button && $team_page_id && $call_to_action_button_team_fill_single_pages ) {
		$call_to_action_button = get_field( 'call_to_action_button_team', $team_page_id );
	}
?>

<?php if ( $call_to_action_button ) : ?>
	<div class="cta-button" id="button">
		<div class="wrap">
			<div class="cta-button__content">
				<div class="button-group">
					<?php foreach ( $call_to_action_button as $button ) : ?>
						<a class="button" href="<?php if(isset($button['link']['url'])) echo $button['link']['url']; ?>"><?php if(isset($button['link']['title'])) echo $button['link']['title']; ?></a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
