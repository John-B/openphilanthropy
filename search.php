<?php
	$post_type = $_GET['post_type'];

	get_header();

	get_template_part( 'part/page', 'header-search' );

	if ( $post_type ) {
		$post_type = get_post_type_object( $post_type );
	}
?>

<div class="content-search-results">
	<div class="wrap">
		<div class="content-search-results__main">
			<?php if ( have_posts() ) : ?>
				<div class="search-results">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							if ( has_excerpt() ) {
								$search_excerpt_source = get_the_excerpt();
							} else {
								$search_excerpt_source = get_post_field( 'post_content' );
							}

							$search_excerpt = array(
								'append' => '...',
								'limit' => 28,
								'limitby' => 'word',
								'source' => $search_excerpt_source
							);

							$search_description = excerpt( $search_excerpt );
						?>

						<article id="post--<?php the_ID(); ?>">
							<h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>

							<p><?php echo $search_description; ?></p>

							<div class="search-results__link">
								<a href="<?php the_permalink(); ?>">Read More</a>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>

			<?php if ( $post_type ) : ?>
				<div class="search-results__back">
					<a href="/<?php echo $post_type->name; ?>"><span aria-hidden="true">&larr; </span>Back to <?php echo $post_type->label; ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>