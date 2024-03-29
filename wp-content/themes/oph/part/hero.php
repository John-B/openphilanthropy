<?php
	$hero_button = get_field( 'hero_button' );
	$hero_entry = get_field( 'hero_entry' );
	$hero_heading = get_field( 'hero_heading' );
	$hero_image = get_field( 'hero_image' );
        // Comment out the following two lines to revert to a mutli-slide slideshow,
        // Uncomment them to choose one random slide.
        // Multi-slide version will only work if more than one image is uploaded
        // the the "Hero" field.
       // $random_image[] = $hero_image[array_rand($hero_image)];
       // $hero_image = $random_image;
?>

<div class="hero">
	<?php if ( $hero_image ) : ?>
		<div class="hero-image-wrap">
			<div class="hero-image<?php if ( count( $hero_image ) > 0 ) { echo ' hero-image-slider'; } ?>">
				<?php foreach ( $hero_image as $i ) : ?>
					<div class="hero-slider__image">
						<img data-lazy="<?php echo $i['image']['sizes']['xl']; ?>" alt="">
					</div>
				<?php endforeach; ?>
			</div>

			<div class="hero-dots-wrap">
				<div class="hero-dots"></div>
			</div>
		</div>
	<?php endif; ?>

	<div class="hero-wrap">
		<div class="hero__content">
			<div class="hero__content-main">
				<?php if ( $hero_heading ) : ?>
					<h1><?php echo $hero_heading; ?></h1>
				<?php endif; ?>

				<?php if ( $hero_entry ) : ?>
					<div class="entry-content">
						<?php echo $hero_entry; ?>
					</div>
				<?php endif; ?>

				<?php if ( $hero_button && is_array($hero_button)) : ?>
					<div class="button-group">
						<?php foreach ( $hero_button as $i ) : ?>
							<?php if ( is_array($i) && isset($i['link']['url']) ) : ?>
								<a class="button" href="<?php echo $i['link']['url']; ?>"<?php if ( $i['link']['target'] == '_blank' ) { echo ' target="_blank"'; } ?>><?php echo $i['link']['title']; ?></a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $hero_image ) : ?>
				<div class="hero__content-caption<?php if ( count( $hero_image ) > 0 ) { echo ' hero-caption-slider'; } ?>">
					<?php foreach ( $hero_image as $i ) : ?>
						<p>
							<?php echo $i['caption']; ?>
						</p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $hero_image ) : ?>
			<div class="hero-photo-credit <?php if ( count( $hero_image ) > 0 ) { echo ' hero-photo-credit-slider'; } ?>">
				<?php foreach ( $hero_image as $i ) : ?>
					<h6><?php echo $i['credit']; ?></h6>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</div>

<script>
	function movePhotoCreditSliderMobile() {
		var photoCreditSlider = jQuery('.hero-photo-credit-slider');

		if (window.matchMedia('(min-width: 1340px)').matches) {
			jQuery('.hero__content').append(photoCreditSlider);
		} else {
			jQuery('.hero-dots').append(photoCreditSlider);
		}
	}

	jQuery(document).ready(function() {
		movePhotoCreditSliderMobile();
	});

	jQuery(window).on('resize', function() {
		setTimeout(movePhotoCreditSliderMobile(), 300);
	});

	jQuery('.hero-image-slider').on('init', function() {
		movePhotoCreditSliderMobile();
	});
</script>
