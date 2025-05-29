<?php
	/**
	 * Template Name: Table of Contents (old, do not use)
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

				<div class="content-table-of-contents__aside pagenav-aside">
					<h3>Table of Contents</h3>

					<nav aria-label="Content Navigation" id="content-navigation">
						<ul class="list-content-navigation" id="content-navigation-list">
							<?php foreach ( $pagenav_sections as $k => $i ) : $k = $k + 1; ?>
								<li>
									<h4>
										<a data-goto="#section-<?php echo $k; ?>" href="#section-<?php echo $k; ?>" title="<?php echo $i['title']; ?>"><?php echo $k . '. ' . $i['title']; ?></a>

										<?php if ( ! empty( $i['sub_sections'] ) ) : ?>
											<div class="content-navigation-icon">
												<svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg>
											</div>
										<?php endif; ?>
									</h4>

									<?php if ( ! empty( $i['sub_sections'] ) ) : ?>
										<ul>
											<?php foreach ( $i['sub_sections'] as $n => $c ) : $n = $n + 1; ?>
												<li>
													<h5>
														<a data-goto="#content-<?php echo $k . '-' . $n; ?>" href="#content-<?php echo $k . '-' . $n; ?>" title="<?php if( isset($c['title']) ) { echo $c['title']; } ?>"><?php echo $k . '.' . $n . ' ' . $c; ?></a>
													</h5>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</nav>
				</div>
			<?php endif; ?>

			<?php if ( $content_sections ) : ?>
				<div class="content-table-of-contents__entry pagenav-content"> 
					<?php if ( !empty( get_the_content() ) ) { ?>
						<div class="content-table-of-contents__entry_content"> 
							<?php the_content(); ?>
						</div>
					<?php } ?>
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
										$sub_section_class = '';

										if ( $c['section_number'] ) {
											$p++;
											$nested_section_number = 0;
											$sub_section_id = 'content-' . $k . '-' . $p;
											$sub_section_class = ' numbered-section';
										}else if( $c['nested_section'] ){
											$sub_section_class = ' nested-section';
										}
									?>

									<div class="section-content<?= $sub_section_class ?>">
										<?php if ( isset( $c['title'] ) && $c['title'] != '' ) : $n = $n + 1; ?>
											<h4 id="<?php echo $sub_section_id; ?>">

												<?php 
												if ( $c['section_number'] ) { 
													echo $sub_sections[ $p - 1 ] . ' ' . $c['title']; 
												} else if( $c['nested_section'] ){
													echo $sub_sections[ $p - 1 ] . '.' . $nested_section_number . ' ' . $c['title'];
												} else { 
													echo $c['title']; 
												}; ?>

											</h4>
										<?php endif; ?>

										<div class="section-content__entry">
											<?php echo $c['entry']; ?>
										</div>
									</div>
								<?php 
							if( isset($nested_section_number) ) { $nested_section_number++; }
							endforeach; ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>

					<?php if ( $footnotes ) : ?>
										<div class="content-footnotes">
											<a href='javascript:void(0);' id='toggle-footnotes'
											>
												<span class='expand'>
													Expand Footnotes 
													<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M18.1123 9.71249L12.4996 15.2875L6.8877 9.71249" stroke="#445277" stroke-width="1.49661"/></svg>
												</span>
												<span class='collapse'>
													Collapse Footnotes <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
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
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
	$call_to_action_button = get_field( 'call_to_action_button' );
?>

<?php if ( $call_to_action_button ) : ?>
<div class="cta-button" id="button">
	<div class="wrap">
		<div class="cta-button__content">
			<div class="button-group">
			<?php foreach ( $call_to_action_button as $button ) : ?>
				<a class="button" href="<?php if(isset($button['link']['url'])) echo $button['link']['url']; ?>"><?php if(isset($button['link']['title']))  echo $button['link']['title']; ?></a>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php get_footer(); ?>
