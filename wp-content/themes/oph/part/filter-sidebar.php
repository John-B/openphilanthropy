<?php
// get post type 
$post_type = '';
if (isset($args['post_type'])) {
	$post_type = $args['post_type'];
}
// get sidebar fields 
$sidebar_filter = get_field('sidebar_filter');
// get URL params for filtering 
$params = get_url_params() ?? []; 

// setup grants posts 
$grants = '';
$grants = new WP_Query(array(
	'post_type' => 'grants',
	'posts_per_page' => -1,
	'order' => 'desc',
	'orderby' => 'date'
));
// setup research posts 
$research = new WP_Query(
	array(
		'post_type' => 'research',
		'posts_per_page' => -1
	)
);

// filter 'Content Type' [research] 
$content_type = get_terms(array(
	'taxonomy' => 'content-type',
	'orderby' => 'parent'
));
// filter 'Focus Area' [research, grants] 
$focus_area = get_terms(array(
	'taxonomy' => 'focus-area',
	'orderby' => 'parent'
));
// filter 'Funding Type' [grants] 
$funding_type = get_terms(array(
	'taxonomy' => 'funding-type'
));
// filter 'Organization Name' [grants] 
$organization_name = get_terms(array(
	'taxonomy' => 'organization-name'
));
// filter 'Year' [research] 
$research_years = [];
if ($research && $research->posts) {
	$research_posts = $research->posts;
	foreach ($research_posts as $i) {
		$post_year = get_the_date('Y', $i->ID);
		array_push($research_years, $post_year);
	}
}
$research_years = array_unique($research_years);
rsort($research_years);
// filter 'Year' [grants] 
$grants_years = [];
if ($grants && $grants->posts) {
	$grants_posts = $grants->posts;
	foreach ($grants_posts as $i) {
		$post_year = get_field('award_date', $i->ID);
		$post_year = substr($post_year, -4);
		array_push($grants_years, $post_year);
	}
}
$grants_years = array_unique($grants_years);
rsort($grants_years);
// filter 'Author' [research] 
$sort_authors = array();
if ($research && $research->posts) {
	$authors_sortable = $research->posts;

	foreach ($authors_sortable as $i) {
		$displayAuthor = get_post_meta($i->ID, 'custom_author', true);
		array_push($sort_authors, $displayAuthor);
	}
}
$sort_authors = array_unique($sort_authors);
sort($sort_authors);

if (isset($params['q'][0])) {
	$search_query = $params['q'][0];
}

$return_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .  $_SERVER['HTTP_HOST'];
$return_url = $return_url . urldecode($_SERVER["REQUEST_URI"]);
$return_url = explode("?", $return_url)[0];
$return_url = explode("page", $return_url)[0];

?>

<div class="sidebar-filter">
	<div class="sidebar-filter__main">
	<!-- the hide button takes up too much height	<div class="sidebar-filter-hide">
			<button class="sidebar-filter-hide-button">
				<span class="sidebar-filter-hide-button-text">Hide Options</span> <span class="sidebar-filter-hide-icon"></span>
			</button>
		</div> -->
		<form method="GET" class="sidebar-filter__content" action="<?php echo $return_url; ?>" autocomplete="off">
			<div class="sidebar-filter__search">
				<!-- search bar -->
				<input class="selection-query" type="search" name="q" placeholder="Search" value="<?php if( isset($search_query) ) { echo $search_query; } ?>">
			</div>
			<div aria-label="Sidebar Filter Options" data-filter-anchor="categories">
				<div class="sidebar-filter__option">
					<!-- filters -->
					<?php foreach ($sidebar_filter as $filter) : ?>
						<?php if ($filter['filter'] == 'amount') : ?>
							<!-- filter: amount -->
							<div id="filter-amount" class="selection-dropdown">
								<div class="selection-prompt">
									<span>Amount</span>
									<span class="indicator">
										<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"></path>
										</svg>
									</span>
								</div>
								<div class="selection-options">
									<!-- <input type="text" class="selection-search" placeholder="Type here to search... " />  -->
									<div class="options-wrapper">
										<label for="less-than-1hundthous" class="selection-label">
											<input type="checkbox" class="selection-input" data-category="less-than-1hundthous" id="less-than-1hundthous" name="amount" value="less-than-1hundthous" <?php  if (isset($params['amount']) && 'less-than-1hundthous' === $params['amount']) {
																																																			echo 'checked';
																																																		} ?> />
											<span class="checked-box"></span>
											Less than $100,000
										</label>
										<label for="between-1hundthous-1mil" class="selection-label">
											<input type="checkbox" class="selection-input" data-category="between-1hundthous-1mil" id="between-1hundthous-1mil" name="amount" value="between-1hundthous-1mil" <?php if (isset($params['amount']) && 'between-1hundthous-1mil' === $params['amount']) {
																																																					echo 'checked';
																																																				} ?> />
											<span class="checked-box"></span>
											Between $100,000 and $1,000,000
										</label>
										<label for="greater-than-1mil" class="selection-label">
											<input type="checkbox" class="selection-input" data-category="greater-than-1mil" id="greater-than-1mil" name="amount" value="greater-than-1mil" <?php if (isset($params['amount']) && 'greater-than-1mil' === $params['amount']) {
																																																echo 'checked';
																																															} ?> />
											<span class="checked-box"></span>
											Greater than $1,000,000
										</label>
									</div>
								</div>
							</div>
						<?php elseif ($filter['filter'] == 'author') : ?>
							<!-- filter: author -->
							<?php if ($sort_authors) { ?>
								<div id="filter-author" class="selection-dropdown">
									<div class="selection-prompt">
										<span>Author</span>
										<span class="indicator">
											<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"></path>
											</svg>
										</span>
									</div>
									<div class="selection-options">
										<input type="text" class="selection-search" placeholder="Type here to search... " />
										<div class="options-wrapper">
											<?php
											generate_filters('author', $sort_authors);
											?>
										</div>
									</div>
								</div>
							<?php } ?>
						<?php elseif ($filter['filter'] == 'content-type') : ?>
							<!-- filter: content type -->
							<?php if ($content_type) : ?>
								<div id="filter-content-type" class="selection-dropdown">
									<div class="selection-prompt">
										<span>Content Type</span>
										<span class="indicator">
											<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"></path>
											</svg>
										</span>
									</div>
									<div class="selection-options">
										<input type="text" class="selection-search" placeholder="Type here to search... " />
										<div class="options-wrapper">
											<?php
											if (is_page('research/research-reports')) {
												$report_contents = array('cause-investigations', 'medium-investigations', 'shallow-investigations');
												generate_filters('content-type', $content_type, true, $report_contents);
											} else {
												generate_filters('content-type', $content_type, true);
											}
											?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php elseif ($filter['filter'] == 'focus-area') : ?>
							<!-- filter: focus area -->
							<?php if ($focus_area) : ?>
								<div id="filter-focus-area" class="selection-dropdown">
									<div class="selection-prompt">
										<span>Focus Area</span>
										<span class="indicator">
											<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"></path>
											</svg>
										</span>
									</div>
									<div class="selection-options">
										<input type="text" class="selection-search" placeholder="Type here to search... " />
										<div class="options-wrapper">
											<?php
											generate_filters('focus-area', $focus_area, true);
											?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php elseif ($filter['filter'] == 'funding-type') : ?>
							<!-- filter: funding type -->
							<?php if ($funding_type) : ?>
								<div id="filter-funding-type" class="selection-dropdown">
									<div class="selection-prompt">
										<span>Funding Type</span>
										<span class="indicator">
											<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"></path>
											</svg>
										</span>
									</div>
									<div class="selection-options">
										<input type="text" class="selection-search" placeholder="Type here to search... " />
										<div class="options-wrapper">
											<?php
											generate_filters('funding-type', $funding_type, true);
											?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php elseif ($filter['filter'] == 'organization-name') : ?>
							<!-- filter: organization name -->
							<?php if ($organization_name) : ?>
							<!-- removed to make more space	
								<div id="filter-organization-name" class="selection-dropdown">
									<div class="selection-prompt">
										<span>Organization Name</span>
										<span class="indicator">
											<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"></path>
											</svg>
										</span>
									</div>
									<div class="selection-options">
										<input type="text" class="selection-search" placeholder="Type here to search... " />
										<div class="options-wrapper">
											<?php
											generate_filters('organization-name', $organization_name, true);
											?>
										</div>
									</div>
								</div> --> 
							<?php endif; ?>
						<?php elseif ($filter['filter'] == 'year') : ?>
							<!-- filter: year -->
							<?php if (is_page('grants') && $grants_years) { ?>
								<div id="filter-year" class="selection-dropdown">
									<div class="selection-prompt">
										<span>Year</span>
										<span class="indicator">
											<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"></path>
											</svg>
										</span>
									</div>
									<div class="selection-options">
										<input type="text" class="selection-search" placeholder="Type here to search... " />
										<div class="options-wrapper">
											<?php
											generate_filters('yr', $grants_years);
											?>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<?php if ($research_years) : ?>
									<div id="filter-year" class="selection-dropdown">
										<div class="selection-prompt">
											<span>Year</span>
											<span class="indicator">
												<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"></path>
												</svg>
											</span>
										</div>
										<div class="selection-options">
											<input type="text" class="selection-search" placeholder="Type here to search... " />
											<div class="options-wrapper">
												<?php
												generate_filters('yr', $research_years);
												?>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php } ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<!-- end filters -->
				</div>

				<div class="sidebar-filter__button">
					<!-- submit button -->
					<input type="submit" value="Submit" class="button sidebar-filter__submit" />
				</div>

				<?php if (is_page('grants')) : ?>
					<!-- download grants csv -->
					<div class="sidebar-filter__button sidebar-filter__download">
						<?php
						$nonce = wp_create_nonce("generate_grants_csv_nonce");
						$link = admin_url('admin-ajax.php?action=generate_grants&nonce=' . $nonce);
						echo '<a class="button" data-nonce="' . $nonce . '" href="' . $link . '">Download Spreadsheet</a>';
						?>
					</div>
				<?php endif; ?>
			</div>
		</form>

		<div class="sidebar-filter-show-button-container">
			<button class="sidebar-filter-show-button">Show Options</button>
		</div>
	</div>
</div>

<div class="sidebar-filter-show-button-container mobile-only">
	<button class="sidebar-filter-show-button">Show Options</button>
</div>
