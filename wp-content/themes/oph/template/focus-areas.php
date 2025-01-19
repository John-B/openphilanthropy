<?php
	/**
	 * Template Name: Focus Areas
	 */

	the_post();

	get_header();

	$about_focus_areas_content = get_field( 'about_focus_areas_content' );
	$about_focus_areas_highlights = get_field( 'about_focus_areas_highlights' );

	$focus_areas = get_field( 'focus_areas' );
	$focus_areas_content = get_field( 'focus_areas_content' );
	$focus_areas_title = get_field( 'focus_areas_title' );

	$other_links = get_field( 'other_links' );
	$other_links_title = get_field( 'other_links_title' );
	$past_grantmaking = get_field( 'past_grantmaking' );
	$past_grantmaking_title = get_field( 'past_grantmaking_title' );

?>

<?php get_template_part( 'part/page', 'header' ); ?>

<div id="about-focus-areas">
	<div class="wrap">
		<?php if ( $about_focus_areas_content ) : ?>
			<div class="about-focus-areas__content">
				<?php echo $about_focus_areas_content; ?>
			</div>
		<?php endif; ?>

		<?php if ( $about_focus_areas_highlights ) : ?>
			<ul id="about-focus-areas-list">
				<?php foreach ( $about_focus_areas_highlights as $i ) : ?>
					<?php if ( $i['title'] ) : ?>
						<li>
							<h3><?php echo $i['title']; ?></h3>

							<?php if ( $i['content'] ) : ?>
								<?php echo $i['content']; ?>
							<?php endif; ?>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</div>

<?php if ( $focus_areas ) : ?>
	<div id="focus-areas">
		<div class="wrap">
			<div class="focus-areas-content">
				<?php if ( $focus_areas_content ) : ?>
					<div class="focus-areas-content__main">
						<div class="entry-content">
							<?php echo $focus_areas_content; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $focus_areas_title ) : ?> 
					<div class="line-heading"> 
						<h2><?php echo $focus_areas_title; ?></h2> 
					</div> 
				<?php endif; ?> 

				<ul class="list-4-col" data-arrows-small="true">
					<?php foreach ( $focus_areas as $i ) : ?>

						<?php
							$bucket_content = $i['content'];
							$bucket_image = $i['image'];
							$bucket_link = $i['link'];
							$bucket_title = $i['title'];

							$bucket_image_path = '';
							$bucket_link_url = '';

							if ( $bucket_image ) {
								$bucket_image_path = $bucket_image['sizes']['md'];
							}

							if ( $bucket_link ) {
								$bucket_link_url = $i['link']['url'];
							}
						?>

						<?php if ( $bucket_title && $bucket_link_url ) : ?>
							<li>
								<a href="<?php echo $bucket_link_url; ?>">
									<?php if ( $bucket_image_path ) : ?>
										<div aria-hidden="true" class="bucket-image">
											<img src="<?php echo $bucket_image_path; ?>" alt="">
										</div>
									<?php else : ?>
										<div aria-hidden="true" class="bucket-image"></div>
									<?php endif; ?>

									<h4><?php echo $bucket_title; ?></h4>

									<?php if ( $bucket_content ) : ?>
										<div class="bucket-description">
											<?php echo $bucket_content; ?>
										</div>
									<?php endif; ?>
								</a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>

				<?php if ( $other_links ) : ?>
					<div class="other-links">
						<div class="wrap">
							<?php if ( $other_links_title ) : ?>
								<div class="line-heading">
									<h2><?php echo $other_links_title; ?></h2>
								</div>

								<ul>
									<?php foreach ( $other_links as $link ) : ?>
										<?php if ( isset($link['link']['url']) ) : ?>
											<li>
												<a href="<?php echo $link['link']['url']; ?>">
													<h4><?php echo $link['link']['title']; ?></h4>

													<div aria-hidden="true" class="other-links__icon">
														<svg viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M26.55 1L34 8.5 26.55 16M0 8.5h34" stroke="#6e7ca0" stroke-width="2"/></svg>
													</div>
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $past_grantmaking ) : ?>
					<div class="other-links">
						<div class="wrap">
							<?php if ( $past_grantmaking_title ) : ?>
								<div class="line-heading">
									<h2><?php echo $past_grantmaking_title; ?></h2>
								</div>

								<ul>
									<?php foreach ( $past_grantmaking as $link ) : ?>
										<?php if ( isset($link['link']['url']) ) : ?>
											<li>
												<a href="<?php echo $link['link']['url']; ?>">
													<h4><?php echo $link['link']['title']; ?></h4>

													<div aria-hidden="true" class="other-links__icon">
														<svg viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M26.55 1L34 8.5 26.55 16M0 8.5h34" stroke="#6e7ca0" stroke-width="2"/></svg>
													</div>
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php get_template_part( 'part/cta', 'button' ); ?>

<?php get_footer(); ?>
