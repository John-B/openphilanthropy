<?php
	/**
	 * Template Name: Focus Area Detail
	 */

	the_post();

	get_header();

	$focus_area = get_field( 'focus_area' );

	$focus_area_color = '';
	$focus_area_color_parent = '';
	$focus_area_image = '';
	$focus_area_image_parent = '';

	if ( $focus_area && $focus_area->term_id ) {
		$focus_area_color = get_field( 'category_color', 'focus-area_' . $focus_area->term_id );
		$focus_area_image = get_field( 'category_focus_areas_image', 'focus-area_' . $focus_area->term_id );

		$focus_area_parent_id = get_ancestors( $focus_area->term_id, 'focus-area' )[0];

		if ( $focus_area_parent_id ) {
			$focus_area_color_parent = get_field( 'category_color', 'focus-area_' . $focus_area_parent_id );
			$focus_area_image_parent = get_field( 'category_focus_areas_image', 'focus-area_' . $focus_area_parent_id );
		}
	}

	$color_theme = '';
	$focus_area_color_light = '';

	if ( $focus_area_color ) {
		$color_theme = $focus_area_color;
	} elseif ( $focus_area_color_parent ) {
		$color_theme = $focus_area_color_parent;
	}

	if ( $color_theme == 'blue' ) {
		$focus_area_color = '#4281a4';
		$focus_area_color_light = '#d9e6ed';
	} elseif ( $color_theme == 'green' ) {
		$focus_area_color = '#75b1ab';
		$focus_area_color_light = '#e3efee';
	} elseif ( $color_theme == 'pink' ) {
		$focus_area_color = '#ad7a99';
		$focus_area_color_light = '#efe4eb';
	}

	if ( ! $focus_area_color ) {
		$focus_area_color = '#4281a4';
	}

	if ( ! $focus_area_color_light ) {
		$focus_area_color_light = '#d9e6ed';
	}

	$page_header_focus_area_button = get_field( 'page_header_focus_area_button' );
	$page_header_focus_area_content = get_field( 'page_header_focus_area_content' );
	$page_header_focus_area_image = get_field( 'page_header_focus_area_image' );
	$page_header_focus_area_title = get_field( 'page_header_focus_area_title' );

	/**
	 * If no page header image, use category image,
	 * or category parent image if child.
	 */
	if ( ! $page_header_focus_area_image ) {
		if ( $focus_area_image ) {
			$page_header_focus_area_image = $focus_area_image;
		} elseif ( $focus_area_image_parent ) {
			$page_header_focus_area_image = $focus_area_image_parent;
		}
	}

	if ( ! $page_header_focus_area_title ) {
		$page_header_focus_area_title = get_the_title();
	}
?>

<div class="content-focus-area-detail<?php if ( $color_theme ) { echo ' color-theme--' . $color_theme; } ?>">
	<div class="page-header page-header--focus-area-detail">
		<div class="wrap">
			<div class="page-header__content">
				<?php if ( $page_header_focus_area_image ) : ?>
					<div class="page-header__image">
						<img src="<?php echo $page_header_focus_area_image['sizes']['lg']; ?>" alt="">
					</div>
				<?php endif; ?>

				<div class="page-header__main">
					<h1><?php echo $page_header_focus_area_title; ?></h1>

					<?php if ( $page_header_focus_area_content ) : ?>
						<div class="entry-content">
							<?php echo $page_header_focus_area_content; ?>
						</div>
					<?php endif; ?>

					<?php if ( $page_header_focus_area_button ) : ?>
						<div class="button-group">
							<?php foreach ( $page_header_focus_area_button as $i ) : ?>
								<?php if ( $i['link']['url'] ) : ?>
									<a class="button" href="<?php echo $i['link']['url']; ?>"<?php if ( $i['link']['target'] == '_blank' ) { echo ' target="_blank"'; } ?>><?php echo $i['link']['title']; ?></a>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<?php if ( have_rows( 'focus_area_detail_content' ) ) : ?>
		<div class="content-flexible">
			<?php while ( have_rows( 'focus_area_detail_content' ) ) : the_row(); ?>
				<?php if ( get_row_layout() == 'call_to_action_button' ) : ?>

					<?php
						$button = get_sub_field( 'button' );
					?>

					<div class="content-focus-area-detail-cta-button">
						<div class="wrap">
							<div class="button-group">
								<?php foreach ( $button as $i ) : ?>
									<a class="button" href="<?php if(isset($button['link']['url'])) echo $i['link']['url']; ?>"><?php if(isset($button['link']['title'])) echo $i['link']['title']; ?></a>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php elseif ( get_row_layout() == 'grants_preview' ) : ?>

					<?php
						$button_text = get_sub_field( 'button_text' );
						$grants_preview = get_sub_field( 'grants_preview' );
						$heading = get_sub_field( 'heading' );

						if ( ! $button_text ) {
							$button_text = 'See All Grants In This Area';
						}

						$grants_preview_id = [];

						// User opted for manual selection
						if ( $grants_preview ) {
							foreach ( $grants_preview as $i ) {
								array_push( $grants_preview_id, $i->ID );
							}
						} 

						$related_query = new WP_Query( array(
							'post_type'      => 'grants',
							'posts_per_page' => 3,
							'order'          => 'desc',
							'orderby'        => 'meta_value',
							'meta_key'       => 'award_date',
							'meta_type'      => 'DATE',
							// 'post__in'       => $grants_preview_id,
							'tax_query'      => array(
								array(
									'taxonomy' => $focus_area->taxonomy,
									'field'    => 'slug',
									'terms'    => $focus_area->slug
								)
							)
						) );

						$related_query_posts = $related_query->posts;

						if ( ! empty( $grants_preview ) ) {
							array_merge( $grants_preview, $related_query_posts );
						} else {
							$grants_preview = [];
						}

						if ( count( $grants_preview ) < 3 ) {
							$grants_preview = array_merge( $grants_preview, $related_query_posts );
							$grants_preview = array_slice( $grants_preview, 0, 3 );
						}
					?>
					<?php if ( $grants_preview ) : ?>
						<div class="content-focus-area-detail-grants-preview">
							<div class="wrap">
								<?php if ( $heading ) : ?>
									<div class="line-heading">
										<h2><?php echo $heading; ?></h2>
									</div>
								<?php endif; ?>

								<ul class="list-related-posts list-related-posts--no-eyebrow list-3-col<?php if ( count( $grants_preview ) > 3 ) { echo ' has-4-posts'; } ?>" id="related-posts-list">
									<?php foreach ( $grants_preview as $related ) : ?>

										<?php render('part/content', 'related-grant', array('related' => $related)); ?>
									
									<?php endforeach; ?>
								</ul>

								<div class="button-group">
									<a class="button" href="/grants?focus-area=<?php echo $focus_area->slug; ?>"><?php echo $button_text; ?></a>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php elseif ( get_row_layout() == 'icon_grid' ) : ?>

					<?php
						$heading = get_sub_field( 'heading' );
						$icon_grid = get_sub_field( 'icon_grid' );
					?>

					<div class="content-focus-area-detail-icon-grid" id="<?php echo sanitize_title_with_dashes( $heading ); ?>">
						<div class="wrap">
							<?php if ( $heading ) : ?>
								<div class="line-heading">
									<h2><?php echo $heading; ?></h2>
								</div>
							<?php endif; ?>

							<?php if ( $icon_grid ) : ?>
								<ul class="list-icon-grid" id="<?php echo sanitize_title_with_dashes( $heading ); ?>-list">
									<?php foreach ( $icon_grid as $icon ) : ?>
										<?php if ( $icon['link'] && $icon['image'] ) : ?>
											<li>
												<a href="<?php echo $icon['link']['url']; ?>">
													<img src="<?php echo $icon['image']['sizes']['lg']; ?>" alt="<?php echo $icon['image']['alt']; ?>">

													<h4><?php echo $icon['link']['title']; ?></h4>

													<div class="icon-grid__link">
														<svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>
													</div>
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					</div>
				<?php elseif ( get_row_layout() == 'images' ) : ?>

					<?php
						$images = get_sub_field( 'images' );
					?>

					<?php if ( ! empty( $images ) ) : ?>
						<div class="content-focus-area-detail-images<?php if ( count( $images ) > 3 ) { echo ' has-4-images'; } ?>">

							<?php foreach ( $images as $image ) : ?>
								<div class="content-focus-area-detail-images__image">
									<img src="<?php echo $image['image']['sizes']['lg']; ?>" alt="<?php echo $image['image']['sizes']['alt']; ?>">
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				<?php elseif ( get_row_layout() == 'research_preview' ) : ?>

					<?php
						$button_text = get_sub_field( 'button_text' );
						$research_preview = get_sub_field( 'research_preview' );
						$heading = get_sub_field( 'heading' );

						if ( ! $button_text ) {
							$button_text = 'See All Research & Updates In This Area';
						}

						$research_preview_id = [];

						if ( ! empty( $research_preview ) ) {
							foreach ( $research_preview as $i ) {
								array_push( $research_preview_id, $i->ID );
							}
						}

						$tax_query = [];

						if ( $focus_area && $focus_area->slug && $focus_area->taxonomy ) {
							$tax_query = array(
								array(
									'taxonomy' => $focus_area->taxonomy,
									'field' => 'slug',
									'terms' => $focus_area->slug
								)
							);
						}

						$research_preview_query = new WP_Query( array(
							'post_type' => 'research',
							'posts_per_page' => 3,
							'order' => 'desc',
							'orderby' => 'date',
							// 'post__in' => $research_preview_id,
							'tax_query' => $tax_query
						) );

						$research_preview_query_posts = $research_preview_query->posts;

						if ( ! empty( $research_preview ) ) {
							array_merge( $research_preview, $research_preview_query_posts );
						} else {
							$research_preview = [];
						}

						if ( count( $research_preview ) < 3 ) {
							$research_preview = array_merge( $research_preview, $research_preview_query_posts );
							$research_preview = array_slice( $research_preview, 0, 3 );
						}
					?>

					<div class="content-focus-area-detail-research-preview">
						<div class="wrap">
							<?php if ( $heading ) : ?>
								<div class="line-heading">
									<h2><?php echo $heading; ?></h2>
								</div>
							<?php endif; ?>

							<?php if ( $research_preview ) : ?>
								<ul class="list-related-posts list-3-col<?php if ( count( $research_preview ) > 3 ) { echo ' has-4-posts'; } ?>" id="related-posts-list">
									<?php foreach ( $research_preview as $related ) : ?>

										<?php render('part/content', 'related-research', array('related' => $related)); ?>
										
									<?php endforeach; ?>
								</ul>

								<div class="button-group">
									<a class="button" href="/research?focus-area=<?php echo $focus_area->slug; ?>"><?php echo $button_text; ?></a>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php elseif ( get_row_layout() == 'split_content' ) : ?>

					<?php
						$aside = get_sub_field( 'aside' );
						$content = get_sub_field( 'content' );
					?>

					<?php if ( $aside || $content ) : ?>
						<div class="content-focus-area-detail-split-content">
							<div class="wrap">
								<div class="content-focus-area-detail-split-content__main">
									<div class="content-focus-area-detail-split-content__entry">
										<div class="entry-content">
											<?php echo $content; ?>
										</div>
									</div>

									<?php if ( have_rows( 'aside' ) ) : ?>
										<div class="content-focus-area-detail-split-content__aside">
											<?php while ( have_rows( 'aside' ) ) : the_row(); ?>
												<?php if ( get_row_layout() == 'content' ) : ?>
													<div>test-content</div>
												<?php elseif ( get_row_layout() == 'image' ) : ?>
													<div>test-image</div>
												<?php elseif ( get_row_layout() == 'short_message' ) : ?>

													<?php
														$content = get_sub_field( 'content' );
														$heading = get_sub_field( 'heading' );
													?>

													<div class="aside-short-message">
														<?php if ( $heading ) : ?>
															<h4><?php echo $heading; ?></h4>
														<?php endif; ?>

														<?php if ( $content ) : ?>
															<div class="entry-content">
																<?php echo $content; ?>
															</div>
														<?php endif; ?>
													</div>
												<?php elseif ( get_row_layout() == 'staff_list' ) : ?>

													<?php
														$message = get_sub_field( 'message' );
														$staff = get_sub_field( 'staff' );
													?>

													<div class="aside-profile-images">
														<?php if ( $message ) : ?>
															<h4><?php echo $message; ?></h4>
														<?php endif; ?>

														<ul class="list-aside-profile-images" id="staff-list">
															<?php foreach ( $staff as $post ) : setup_postdata( $post ); ?>

																<?php
																	$team_image = get_the_post_thumbnail_url( $post->ID, 'large' );
																	$team_title = get_field( 'team_title' );
																?>

																<?php if ( $post && $post->post_title ) : ?>
																	<li>
																		<div class="aside-profile-images__image">
																			<a href="<?php echo get_permalink( $post->ID ); ?>">
																				<img src="<?php echo $team_image; ?>" alt="">
																			</a>
																		</div>

																		<div class="aside-profile-images__info">
																			<h5>
																				<a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo oph_filter($post->post_title, "*"); ?></a>
																			</h5>

																			<?php if ( $team_title ) : ?>
																				<h6><?php echo $team_title; ?></h6>
																			<?php endif; ?>

																			<div class="aside-profile-images__link">
																				<a href="<?php echo get_permalink( $post->ID ); ?>">
																					<svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>
																				</a>
																			</div>
																		</div>
																	</li>
																<?php endif; ?>
															<?php endforeach; wp_reset_postdata(); ?>
														</ul>
													</div>
												<?php endif; ?>
											<?php endwhile; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php elseif ( get_row_layout() == 'statistics' ) : ?>

					<?php
						$heading = get_sub_field( 'heading' );
						$statistics = get_sub_field( 'statistics' );

						$grant_amount_array = [];

						$grants_made_query = new WP_Query( array(
							'post_type' => 'grants',
							'posts_per_page' => -1,
							'order' => 'desc',
							'orderby' => 'date',
							'tax_query' => array(
								array(
									'taxonomy' => $focus_area->taxonomy,
									'field' => 'slug',
									'terms' => $focus_area->slug
								)
							)
						) );

						$grants_made_query_posts = $grants_made_query->posts;

						foreach ( $grants_made_query_posts as $grant ) {
							$grant_amount = get_field( 'grant_amount', $grant->ID );

							if ( is_numeric( $grant_amount ) ) {
								array_push( $grant_amount_array, $grant_amount );
							}
						}

						$grant_amount_total = array_sum( $grant_amount_array );
						$grant_amount_total = $grant_amount_total / 1000 / 1000;
						$grant_amount_total = number_format( $grant_amount_total, 1, '.', '' );

						// Remove leading 0
						$grant_amount_total = ltrim( $grant_amount_total, '0' );

						$grant_terms = get_terms( array(
							'taxonomy' => 'focus-area',
							'parent' => 0,
							'post_type'	=> 'grants'
						) );
					?>

					<?php if ( ! empty( $statistics ) ) : ?>
						<div class="content-focus-area-detail-statistics">
							<div class="wrap">
								<?php if ( $heading ) : ?>
									<div class="line-heading">
										<h2><?php echo $heading; ?></h2>
									</div>
								<?php endif; ?>

								<ul class="list-statistics<?php if ( count( $statistics ) < 3 ) { echo ' has-less-than-3-items'; } ?>">
									<?php foreach ( $statistics as $i ) : ?>

										<?php
											$type = $i['type'];

											$number = '';
											$statistic = '';

											if ( $type == 'auto' ) {
												$statistic = $i['statistic'];

												if ( $statistic == 'grants-made' ) {
													$number = $grants_made_query->post_count;

													$title = 'Grants<br> Made';
												} elseif ( $statistic == 'million-given' ) {
													$number = $grant_amount_total;

													$title = 'Million<br> Given';
												} elseif ( $statistic == 'portfolio-areas' ) {
													$number = count( $grant_terms );

													$title = 'Portfolio Areas';
												}
											} elseif ( $type == 'custom' ) {
												$number = $i['number'];
												$title = $i['title'];
											}
										?>

										<?php if ( $number ) : ?>
											<li class="<?php if ( strlen( $number ) > 4 ) { echo ' is-large-number'; } ?>">
												<h4>
													<span class="header-number">
														<?php if ( $statistic == 'million-given' || strpos($number, '$') !== false) { echo '$';} 
															// Here we have to round down numbers which appear as a strin, and the string may contain a dollar sign.															
															$number = ltrim( $number, '$');
															$number_val = floatval($number);
															if (strpos(strtolower($title), 'grants') !== false && $number_val > 50)
															{
																echo floor($number_val / 10) * 10 . "+";
															}
															else if ($number_val >= 100 && strpos(strtolower($title), "million") !== false) {
																echo floor($number_val / 10) * 10 . "+";
															} else if (strpos(strtolower($title), "million") !== false) {
																echo floor($number_val) . "+";
															} else {
																echo floor($number_val);
															}
														?>
													</span> 
														<?php echo $title; ?> 
												</h4>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
