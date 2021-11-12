<?php
	/**
	 * Template Name: Basic Text Template
	 */

	the_post();

	get_header();

	$content_sections = get_field( 'content_sections' );
	$footnotes = get_field( 'footnotes' );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<div class="content-table-of-contents">
	<div class="wrap">
		<div class="content-table-of-contents__main">
			<?php if ( $content_sections ) : ?>

				<?php
					$pagenav_sections = [];

					foreach ( $content_sections as $k => $i ) {
						$section_array = array(
							'title' => $i['section_title'],
							'sub_sections' => []
						);

						if ( isset( $i['content'] ) ) {
							foreach ( $i['content'] as $c ) {
								if ( $c['section_number'] ) {
									array_push( $section_array['sub_sections'], $c['title'] );
								}
							}
						}

						array_push( $pagenav_sections, $section_array );
					}
				?>
			<?php endif; ?>

			<?php if ( $content_sections ) : ?>
				<div class="content-table-of-contents__entry pagenav-content pagenav-content--fullwidth">
					<?php foreach ( $content_sections as $k => $i ) : ?>
						<?php if ( $i['content'] && $i['section_title'] ) : $k = $k + 1; $sub_sections = []; $o = 0; $p = 0; ?>
							<div class="content-table-of-contents__section">
								<div class="section-title">
									<h2 id="section-<?php echo $k; ?>"><?php echo $k . '. ' . $i['section_title']; ?></h2>
								</div>

								<?php
									foreach ( $i['content'] as $n => $c ) {
										if ( $c['section_number'] ) {
											$o++;

											array_push( $sub_sections, $k . '.' . $o );
										}
									}
								?>

								<?php foreach ( $i['content'] as $n => $c ) : ?>

									<?php
										$sub_section_id = '';

										if ( $c['section_number'] ) {
											$p++;

											$sub_section_id = 'content-' . $k . '-' . $p;
										}
									?>

									<div class="section-content">
										<?php if ( isset( $c['title'] ) && $c['title'] != '' ) : $n = $n + 1; ?>
											<h4 id="<?php echo $sub_section_id; ?>"><?php if ( $c['section_number'] ) { echo $sub_sections[ $p - 1 ] . ' ' . $c['title']; } else { echo $c['title']; }; ?></h4>
										<?php endif; ?>

										<div class="section-content__entry">
											<?php echo $c['entry']; ?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>

					<?php if ( $footnotes ) : ?>
						<div class="content-footnotes">
							<div class="footnotes">
								<?php echo $footnotes; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

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