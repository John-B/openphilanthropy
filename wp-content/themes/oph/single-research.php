<?php
the_post();

get_header();

$post_thumbnail = get_the_post_thumbnail_url($post->ID, 'lg');

$primary_term_slug = '';

$tax_query = array(
	'relation' => 'or'
);

$terms_focus_area = get_the_terms(get_the_ID(), 'focus-area');

if ($terms_focus_area && !is_wp_error($terms_focus_area) && isset($terms_focus_area[0])) {
	$primary_term = $terms_focus_area[0];

	if (isset($primary_term->name)) {
		$primary_term_name = $primary_term->name;
	}

	if (isset($primary_term->slug)) {
		$primary_term_slug = $primary_term->slug;
	}

	if ($primary_term_slug) {
		$focus_area_query = array(
			'field' => 'slug',
			'taxonomy' => 'focus-area',
			'terms' => $primary_term_slug
		);

		array_push($tax_query, $focus_area_query);
	}
}

$footnotes = get_field('footnotes');

//Set up array of authors with included Name & URL to profile page
$authors = array();
$author_meta = get_post_meta($post->ID, 'custom_author', true);
$authors_remove_and = str_replace(' and ', ', ', $author_meta);
$authors_remove_and = str_replace(',,', ',', $authors_remove_and);
$authors_array = explode(", ", $authors_remove_and);

foreach ($authors_array as $a) :
	$post_obj = get_page_by_title($a, 'OBJECT', 'team');
	$url = '/about/team/' . $post_obj->post_name;
	$authors[] = array('name' => $a, 'slug' => $url);
endforeach;

$hidePub = get_field('hide_pubDate');
?>

<?php get_template_part('part/page', 'header'); ?>

<?php get_template_part('part/page', 'header-categories-single', array('post_type' => 'research')); ?>

<div class="content-single" id="research-post">
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

				<svg aria-hidden="true" class="aside-post-navigation-icon" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2" />
				</svg>

				<?php if (get_field("social_share") == 'show' || !get_field("social_share")) : ?>
					<div class="post-share">
						<div class="a2a_wrapper">
							<div class="a2a_kit a2a_kit_size_32 a2a_default_style social-media">
								<a class="a2a_button_twitter">
									<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
									</svg>
								</a>

								<a class="a2a_button_facebook">
									<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
										<path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
									</svg>
								</a>

								<a class="a2a_button_linkedin">
									<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
										<path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path>
									</svg>
								</a>

								<a class="a2a_button_print">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
										<path d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z" />
									</svg>
								</a>
							</div>

							<script async src="https://static.addtoany.com/menu/page.js"></script>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="content-single__main pagenav-content">
				<?php if ($post_thumbnail) : ?>
					<img class="post-thumbnail" src="<?php echo $post_thumbnail; ?>" alt="">
				<?php endif; ?>

				<div class="entry-content">
					<div class='author-date-meta'>
						<?php if (!$hidePub) { ?>
							<span class='publish-date'>Published: <?= get_the_date("F d, Y"); ?> </span><?php }
																									if (!$hidePub && !empty($author_meta)) {
																										echo '<span> | </span>';
																									}
																									if (!empty($author_meta)) {
																										$numAuthors = count($authors);
																										$i = 0;
																										echo 'by ';
																										foreach ($authors as $a) {
																											//add and before last author 
																											if (++$i === $numAuthors && $numAuthors > 1) {
																												echo ' and ';
																											}
																											//Display author link, or name only if no page found
																											if ($a['slug']) {
																												echo '<a href="' . $a['slug'] . '">' . $a['name'] . '</a>';
																											} else {
																												echo $a['name'];
																											}
																											//Insert commas, except last
																											if ($i !== $numAuthors && $numAuthors > 2) {
																												echo ', ';
																											}
																										}
																									} ?>
					</div>
					<?php the_content(); ?>
				</div>

				<?php if ($footnotes) : ?>
					<div class="entry-footnotes">
						<a href='javascript:void(0);' id='toggle-footnotes'>
							<span class='expand'>
								Expand Footnotes
								<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M18.1123 9.71249L12.4996 15.2875L6.8877 9.71249" stroke="#445277" stroke-width="1.49661" />
								</svg>
							</span>
							<span class='collapse'>
								Collapse Footnotes <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M6.8877 15.2875L12.5004 9.71248L18.1123 15.2875" stroke="#445277" stroke-width="1.49661" />
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

<?php
$related_posts = get_field('related_items');
if ($related_posts) : ?>
	<div class="single-related-posts" id="related-posts">
		<div class="wrap">
			<div class="single-related-posts__main">
				<div class="line-heading line-heading--keep-mobile">
					<h2>Related Items</h2>
				</div>
			</div>

			<div class="single-related-posts__grid">
				<ul class="list-related-posts" id="related-posts-list">
					<?php foreach ($related_posts as $related) : ?>

						<?php render('part/content', 'related-research', array('related' => $related)); ?>

					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php
$call_to_action_button = get_field('call_to_action_button');
?>

<div class="cta-button" id="button">
	<div class="wrap">
		<div class="cta-button__content">
			<div class="button-group">
				<?php if (!empty($call_to_action_button)) : ?>
					<?php foreach ($call_to_action_button as $button) : ?>
						<a class="button" href="<?php if(isset($button['link']['url']))  echo $button['link']['url']; ?>"><?php if(isset($button['link']['title'])) echo $button['link']['title']; ?></a>
					<?php endforeach; ?>
				<?php else : ?>
					<a class="button" href="/research">Back to Research &amp; Updates</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
