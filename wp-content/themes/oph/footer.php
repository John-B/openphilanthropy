			</main>

			<?php
				$url_facebook = get_field( 'url_facebook', 'options' );
				$url_twitter = get_field( 'url_twitter', 'options' );
				$mailing_address = get_field( 'mailing_address', 'options' );
				$footer_email = get_field( 'footer_email', 'options' );
				$media_email = get_field( 'media_email', 'options' );
				$anonymous_feedback = get_field( 'anonymous_feedback', 'options' );
				$mailing_list = get_field( 'mailing_list', 'options' ); 
				$mailing_list_title = $mailing_list['title'] ?? ''; 
				$mailing_list_url = $mailing_list['url'] ?? ''; 
			?>

			<footer id="footer">
				<div class="newsletter-form">
    <form action="https://openphilanthropy.us12.list-manage.com/subscribe/post?u=5f851555ed522f52a8cc7157f&amp;id=204e32798b&amp;f_id=006c0ee9f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_self" novalidate="">
          <label for="mce-EMAIL">Sign up for news about our grants, research, and more:</label>
          <div class="mc-field-group">
            <input type="email" name="EMAIL" class="required email" id="mce-EMAIL" required="" value="">
            <input type="submit" name="subscribe" id="mc-embedded-subscribe" class="newsletter-button" value="Subscribe">
          </div>
          <div id="mce-responses" class="clear">
            <div class="response" id="mce-error-response" style="display: none;"></div>
            <div class="response" id="mce-success-response" style="display: none;"></div>
          </div>
          <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_5f851555ed522f52a8cc7157f_204e32798b" tabindex="-1" value=""></div>
    </form>
				</div>
				<div class="wrap">
					<div class="footer__content">
						<div class="footer-grid">
							<div class="footer-grid__cell footer-cell-logo">
								<div class="logo">
									<a href="/">
										<img src="<?php echo get_template_directory_uri() . '/ui/img/open-philanthropy-footer-logo.svg'; ?>" alt="Open Philanthropy">
									</a>
								</div>

								<div class="logo-mobile">
									<a href="/">
										<img src="<?php echo get_template_directory_uri() . '/ui/img/open-philanthropy-footer-mobile-logo.svg'; ?>" alt="Open Philanthropy">
									</a>
								</div>
							</div>

							<div class="footer-grid__cell footer-cell-menu">

								<?php
									wp_nav_menu( array(
										'container' => 'ul',
										'menu_class' => 'menu',
										'menu_id' => 'footer-menu',
										'link_before' => '<span>',
										'link_after' => '</span><span class="menu-icon"></span>',
										'theme_location' => 'footer'
									) );
								?>
							</div>

							<div class="footer-grid__cell footer-cell-address">
								<h6>Mailing Address</h6>

								<address>
									<?php echo $mailing_address; ?> 
				
				</address>

								<h6>Email</h6>

								<a href="mailto:<?php echo $footer_email; ?>"><?php echo $footer_email; ?></a>

								<h6>Media Inquiries</h6>

								<a href="mailto:<?php echo $media_email; ?>"><?php echo $media_email; ?></a>
								
								<h6>Anonymous Feedback</h6>

								<a href="<?php echo $anonymous_feedback; ?>">Feedback Form</a>
							</div>

							<div class="footer-grid__cell footer-cell-social">
								<?php if ( !empty($mailing_list_url) || !empty($mailing_list_title) ) : ?>
									<h4>Follow Our Work</h4>
	
									<a href="<?php echo $mailing_list_url; ?>" title="<?php echo $mailing_list_title; ?>" class="button"><?php echo $mailing_list_title; ?></a>  
								<?php endif; ?>

								<?php if ( !empty($url_facebook) || !empty($url_twitter) ) : ?>
									<div class="social-media">
										<ul>
											<?php if ( !empty($url_facebook) ) : ?>
												<li>
													<a href="<?php echo $url_facebook; ?>">
														<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
													</a>
												</li>
											<?php endif; ?>

											<?php if ( !empty($url_twitter) ) : ?>
												<li>
													<a href="<?php echo $url_twitter; ?>">
														<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
													</a>
												</li>
											<?php endif; ?>
										</ul>
									</div>
								<?php endif; ?>

								<p class="copyright">
									<span>&copy; Open Philanthropy <?php echo date('Y'); ?></span>
									<span class="br"></span>
									<span><em>Except where otherwise noted, this work is licensed under a <a href="https://creativecommons.org/licenses/by-nc/4.0/" target="_blank">Creative Commons Attribution-Noncommercial 4.0&nbsp;International License.</a></em></span>
									<span class="br"></span>
								</p>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<?php wp_footer(); ?>
	</body>
</html>
