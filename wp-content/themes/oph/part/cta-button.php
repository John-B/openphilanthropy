<?php
	$call_to_action_button = get_field( 'call_to_action_button' ); 
	$call_to_action_button_team = get_field( 'call_to_action_button_team' ); 
?>

<?php if ( is_page_template( 'template/team.php' || is_page_template( 'template/teams.php' ) ) ) { ?>
	<?php if ( ! empty( $call_to_action_button_team ) ) : ?>
		<div class="cta-button" id="button" style="display: none;">
			<div class="wrap">
				<div class="cta-button__content">
					<div class="button-group">
						<?php foreach ( $call_to_action_button_team as $button ) : ?>
							<a class="button" href="<?php if(isset($button['link']['url'])) echo $button['link']['url']; ?>"><?php if(isset($button['link']['title'])) echo $button['link']['title']; ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php } else { ?>
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
<?php } ?>
