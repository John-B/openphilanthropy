<?php
	/**
	 * Template Name: Basic Text Template
	 */

	the_post();

	get_header();

	$footnotes = get_field( 'footnotes' );
?>

<?php get_template_part( 'part/page', 'header' ); ?>

<div class="content-basic-text">
	<div class="wrap">
		<div class="content-basic-text__main">
			<?php the_content(); ?>

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
	</div>
</div>

<?php
	$call_to_action_button = get_field( 'call_to_action_button' );
?>

<?php if ( ! empty( $call_to_action_button ) ) : ?>
<div class="cta-button" id="button">
	<div class="wrap">
		<div class="cta-button__content">
			<div class="button-group">
					<?php foreach ( $call_to_action_button as $button ) : ?>
						<a class="button" href="<?php if(isset($button['link']['url'])) echo $button['link']['url']; ?>"><?php if(isset($button['link']['title'])) echo $button['link']['title']; ?></a>
					<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php get_footer(); ?>
