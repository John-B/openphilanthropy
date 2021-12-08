<?php
	the_post();

	get_header();

	$post_thumbnail = ($cover_image_id = get_field('cover_image', $post->ID) ) ? 
						wp_get_attachment_image($cover_image_id, 'lg', false, array('class'	=> 'post-thumbnail')) : false;

	$primary_term_slug = '';

	$tax_query = array(
		'relation' => 'or'
	);

	$terms_focus_area = get_the_terms( $post->ID, 'focus-area' );

	if ( $terms_focus_area && ! is_wp_error( $terms_focus_area ) && isset( $terms_focus_area[0] ) ) {
		$primary_term = $terms_focus_area[0];

		if ( isset( $primary_term->name ) ) {
			$primary_term_name = $primary_term->name;
		}

		if ( isset( $primary_term->slug ) ) {
			$primary_term_slug = $primary_term->slug;
		}

		if ( $primary_term_slug ) {
			$focus_area_query = array(
				'field'    => 'slug',
				'taxonomy' => 'focus-area',
				'terms'    => $primary_term_slug
			);

			array_push( $tax_query, $focus_area_query );
		}
	}

	$related_posts = get_field( 'related_posts' );

	if ( ! $related_posts ) {
		$related_posts = [];
	}

	$related_posts_id = array( get_the_ID() );

	if ( ! empty( $related_posts ) ) {
		foreach ( $related_posts as $i ) {
			array_push( $related_posts_id, $i->ID );
		}

		$related_posts_count = count( $related_posts );
	}

	$related_query_posts = [];

	// Get a list of related posts from the same organization (if any)
	$terms_org_name = get_the_terms( $post->ID, 'organization-name' );
	$related_org_query_posts = [];
	if ( isset($terms_org_name[0]) ) {
		$related_org_query = new WP_Query( array(
			'post_type'      => 'grants',
			'posts_per_page' => 3,
			'order'          => 'desc',
			'orderby'        => 'date',
			'post__not_in'   => $related_posts_id,
			'tax_query'      => array(
				'relation'	=> 'AND',
				array(
					'taxonomy' => 'organization-name',
					'field'    => 'slug',
					'terms'    => $terms_org_name[0]->slug
				),
				array(
					'field'    => 'slug',
					'taxonomy' => 'focus-area',
					'terms'    => $primary_term_slug
				)
			)
		) );

		if ( ! empty( $related_org_query ) && isset( $related_org_query->posts ) ) {
			$related_org_query_posts = $related_org_query->posts;
			
			// Add to ignore list for the next query and update the count
			$related_org_posts_id = wp_list_pluck( $related_org_query_posts, 'ID' );
			$related_posts_id = array_merge($related_posts_id, $related_org_posts_id);
			$related_posts_count = count( $related_posts );
		}
	}
	
	$related_query = new WP_Query( array(
		'post_type'      => 'grants',
		'posts_per_page' => 3,
		'order'          => 'desc',
		'orderby'        => 'date',
		'post__not_in'   => $related_posts_id,
		'tax_query'      => $tax_query
	) );

	if ( ! empty( $related_query ) && isset( $related_query->posts ) ) {
		$related_query_posts = $related_query->posts;
	}

	// The order of merge is important as it retains the priority override order
	$related_posts = array_merge( $related_posts, $related_org_query_posts, $related_query_posts );

	/**
	 * Limit related posts to 3 if back filled.
	 */
	if ( isset( $related_posts_count ) && $related_posts_count > 3 ) {
		$related_posts = array_slice( $related_posts, 0, 4 );
	} else {
		$related_posts = array_slice( $related_posts, 0, 3 );
	}

	$footnotes = get_field( 'footnotes' );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<?php get_template_part( 'part/page', 'header-categories-single', array( 'post_type' => 'grants' ) ); ?>

<div class="content-single" id="grants-post">
	<div class="wrap">
		<div class="content-single__container">
			<div class="content-single__aside pagenav-aside">
				<h3>Table of Contents</h3>

				<nav aria-label="Post Navigation" class="aside-post-navigation" id="nav-post">
					<ul class="list-aside-post-navigation" id="post-navigation-list"></ul>
				</nav>

				<nav aria-label="Mobile Post Navigation" class="aside-post-navigation-mobile" id="nav-post-mobile">
					<select class="goto-select" id="post-navigation-list-mobile"></select>
				</nav>

				<svg aria-hidden="true" class="aside-post-navigation-icon" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>

				<?php if ( get_field("social_share") == 'show' || !get_field("social_share") ) : ?>
				<div class="post-share">
					<div class="a2a_wrapper">
						<div class="a2a_kit a2a_kit_size_32 a2a_default_style social-media">
							<a class="a2a_button_twitter">
								<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
							</a>

							<a class="a2a_button_facebook">
								<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
							</a>

							<a class="a2a_button_linkedin">
								<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>
							</a>
						</div>

						<script async src="https://static.addtoany.com/menu/page.js"></script>
					</div>
				</div>
				<?php endif; ?>
			</div>

			<div class="content-single__main pagenav-content">
				<?php if ( $post_thumbnail ) : 
					echo $post_thumbnail;
				endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>

				<?php if ( $footnotes ) : ?>
					<div class="entry-footnotes">
						<a href='javascript:void(0);' id='toggle-footnotes'
						>
							<span class='expand'>
								Expand Footer 
								<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M18.1123 9.71249L12.4996 15.2875L6.8877 9.71249" stroke="#445277" stroke-width="1.49661"/></svg>
							</span>
							<span class='collapse'>
								Collapse Footer <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M6.8877 15.2875L12.5004 9.71248L18.1123 15.2875" stroke="#445277" stroke-width="1.49661"/>
</svg>
							</span>
						</a>
						<div class="footnotes">
							<?php echo $footnotes; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php if ( $related_posts ) : ?>
	<div class="single-related-posts" id="related-posts">
		<div class="wrap">
			<div class="single-related-posts__main">
				<div class="line-heading line-heading--keep-mobile">
					<h2>Related Items</h2>
				</div>
			</div>

			<div class="single-related-posts__grid">
				<ul class="list-related-posts" id="related-posts-list">
					<?php foreach ( $related_posts as $related ) : ?>

						<?php
							if ( ! isset( $related->ID ) && isset( $related['post'][0] ) ) {
								$related = $related['post'][0];
							}

							$related_eyebrow_copy = $primary_term_name;
							$related_eyebrow_link = '/grants?focus-area=' . $primary_term_slug;
							$related_link = get_permalink( $related->ID );
							$related_post_type = get_post_type( $related->ID );
							$related_title = $related->post_title;

							if ( has_excerpt( $related->ID ) ) {
								$related_excerpt_source = get_the_excerpt( $related->ID );
							} else {
								$related_excerpt_source = get_post_field( 'post_content', $related->ID );
							}

							$related_excerpt = array(
								'append' => '...',
								'limit' => 28,
								'limitby' => 'word',
								'source' => $related_excerpt_source
							);

							$related_description = excerpt( $related_excerpt );
						?>

						<li>
							<h5>
								<a href="<?php echo $related_eyebrow_link; ?>"><?php echo $related_eyebrow_copy; ?></a>
							</h5>

							<h4>
								<a href="<?php echo $related_link; ?>"><?php echo $related_title; ?></a>
							</h4>

							<div class="single-related-posts__description">
								<?php echo $related_description; ?>
							</div>

							<div class="single-related-posts__link">
								<a href="<?php echo $related_link; ?>">
									Read more <svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2"/></svg>
								</a>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php
	$call_to_action_button = get_field( 'call_to_action_button' );
?>

<div class="cta-button" id="button">
	<div class="wrap">
		<div class="cta-button__content">
			<div class="button-group">
				<?php if ( ! empty( $call_to_action_button ) ) : ?>
					<?php foreach ( $call_to_action_button as $button ) : ?>
						<a class="button" href="<?php echo $button['link']['url']; ?>"><?php echo $button['link']['title']; ?></a>
					<?php endforeach; ?>
				<?php else : ?>
					<a class="button" href="/grants">Back to Grants Database</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>