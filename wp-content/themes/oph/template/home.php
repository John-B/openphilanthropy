<?php

/**
 * Template Name: Home
 */

the_post();

get_header();

$about_button = get_field('about_button');
$about_content = get_field('about_content');
$about_title = get_field('about_title');

$homepage_grants = get_field('homepage_grants');
$homepage_grants_button = get_field('homepage_grants_button');
$homepage_grants_title = get_field('homepage_grants_title');

$homepage_research = get_field('homepage_research');
$homepage_research_button = get_field('homepage_research_button');
$homepage_research_title = get_field('homepage_research_title');
?>

<?php get_template_part('part/hero'); ?>

<?php if ($homepage_grants) : ?>
	<div id="highlighted-grants">
		<div class="wrap">
			<?php if ($homepage_grants_title) : ?>
				<div class="line-heading">
					<h2>Highlighted Grants</h2>
				</div>
			<?php endif; ?>

			<ul class="list-3-col" id="highlighted-grants-list">
				<?php foreach ($homepage_grants as $grant) : ?>

					<?php
					$grant_post = $grant['grant'][0];

					if ($grant_post) {
						$focus_area = get_the_terms($grant_post->ID, 'focus-area');

						$grant_image = '';

						// Get category image
						if (!empty($focus_area) && $focus_area[0]->term_id) {
							$grant_image = get_field('category_focus_areas_image', 'focus-area_' . $focus_area[0]->term_id)['sizes']['thumbnail'];
						}

						// If category image found get url
						else  if (isset($grant_image['sizes']['lg'])) {
							$grant_image = $grant_image['sizes']['lg'];
						}

						$grant_link = get_permalink($grant_post->ID);
						$grant_title = get_the_title($grant_post->ID);

						$grant_excerpt_source = get_the_excerpt($grant_post->ID);

						$grant_excerpt = array(
							'append' => '...',
							'limit' => 28,
							'limitby' => 'word',
							'source' => $grant_excerpt_source
						);

						$grant_description = excerpt($grant_excerpt);
					} else {

			  		  if ($grant['description']) {
						$grant_description = $grant['description'];
					  }

					  if ($grant['image']) {
						$grant_image = $grant['image']['sizes']['lg'];
					  }

					  if ($grant['link']) {
						$grant_link = $grant['link']['url'];
					  }

					  if ($grant['title']) {
						$grant_title = $grant['title'];
					  }
					}
					if(is_array($grant_image)) {
					  $grant_image = $grant_image[0];
					}
					?>

					<?php if ($grant_title) : ?>
						<li>
							<a href="<?php echo $grant_link; ?>">
								<?php if (isset($grant_image)) : ?>
									<div class="bucket-image">
										<div class="bucket-image__bg">
											<img src="<?php echo $grant_image; ?>" alt="<?php echo $focus_area; ?>">
										</div>
									</div>
								<?php endif; ?>

								<h4><?php echo $grant_title; ?></h4>

								<div class="bucket-description">
									<?php echo $grant_description; ?>
								</div>
							</a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>

			<?php if ($homepage_grants_button) : ?>
				<div class="button-group">
					<?php foreach ($homepage_grants_button as $i) : ?>
						<?php if ( is_array($i) && isset($i['link']['url']) ) : ?>
							<a class="button" href="<?php echo $i['link']['url']; ?>" <?php if ($i['link']['target'] == '_blank') {
																							echo ' target="_blank"';
																						} ?>><?php echo $i['link']['title']; ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

<div id="about">
	<div class="wrap">
		<?php if ($about_title) : ?>
			<div class="line-heading">
				<h2><?php echo $about_title; ?></h2>
			</div>
		<?php endif; ?>

		<div class="about-content">
			<?php if ($about_content) : ?>
				<?php echo $about_content; ?>
			<?php endif; ?>

			<?php if ($about_button) : ?>
				<div class="button-group">
					<?php foreach ($about_button as $i) : ?>
						<?php if ( is_array($i) && isset($i['link']['url']) ) : ?>
							<a class="button" href="<?php echo $i['link']['url']; ?>" <?php if ($i['link']['target'] == '_blank') {
																							echo ' target="_blank"';
																						} ?>><?php echo $i['link']['title']; ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php if ($homepage_research) : ?>
	<div id="research-preview">
		<div class="wrap">
			<?php if ($homepage_research_title) : ?>
				<div class="line-heading">
					<h2><?php echo $homepage_research_title; ?></h2>
				</div>
			<?php endif; ?>

			<div class="research-preview-content">
				<ul class="list-related-posts list-3-col" id="research-preview-list">
					<?php foreach ($homepage_research as $i) : ?>

						<?php
						$research_post = $i['post'][0];

						if ($research_post) {
							$research_content_type = get_the_terms($research_post->ID, 'content-type');

							$linkExternally = get_field('externally_link', $research_post->ID);
							if ($linkExternally) {
								$research_link = get_field('external_url', $research_post->ID);
							} else {
								$research_link = get_permalink($research_post->ID);
							}

							$research_title = get_the_title($research_post->ID);

							$research_excerpt_source = get_the_excerpt($research_post->ID);

							$research_excerpt = array(
								'append' => '...',
								'limit' => 38,
								'limitby' => 'word',
								'source' => $research_excerpt_source
							);

							$research_description = excerpt($research_excerpt);
						}

						if ($research_content_type) {
							$first_parent_term = get_term_top_most_parent($research_content_type[0], 'content-type');
							$research_eyebrow_copy = $first_parent_term->name;
							$research_eyebrow_link = get_term_link($first_parent_term);

							// Top level content types uses document root, remove the standard content-type path
							$research_eyebrow_link = str_replace("content-type/", '', $research_eyebrow_link);
						}

						if ($i['description']) {
							$research_description = $i['description'];
						}

						if ($i['eyebrow_copy']) {
							$research_eyebrow_copy = $i['eyebrow_copy'];
						}

						if ($i['eyebrow_link']) {
							$research_eyebrow_copy = $i['eyebrow_link'];
						}

						if ( isset($i['image']) ) {
							$research_image = $i['image']['sizes']['lg'];
						}

						if ( isset($i['link']['url']) ) {
							$research_link = $i['link']['url'];
						}

						if ( isset($i['title']) ) {
							$research_title = $i['title'];
						}
						?>

						<li<?php if (!$research_eyebrow_copy) {
								echo ' class="has-no-eyebrow-copy"';
							} ?>>
							<h5><?php if ($research_eyebrow_link) {
									echo '<a href="' . $research_eyebrow_link . '">';
								}
								echo $research_eyebrow_copy;
								if ($research_eyebrow_link) {
									echo '</a>';
								} ?></h5>

							<h4>
								<a href="<?php echo $research_link; ?>"><?php echo $research_title; ?></a>
							</h4>

							<?php if ($research_description) : ?>
								<div class="single-related-posts__description">
									<?php echo $research_description; ?>
								</div>
							<?php endif; ?>

							<div class="single-related-posts__link">
								<a href="<?php echo $research_link; ?>">
									Read More <svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2" />
									</svg>
								</a>
							</div>
							</li>
						<?php endforeach; ?>
				</ul>

				<div class="button-group">
					<a class="button" href="/research">View All Research &amp; Updates</a>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
