	<div class="footer section large-padding color-bg-four footer-bg-image">
		<div class="footer-inner section-inner">



			<?php if ( is_active_sidebar( 'footer-a' ) ) : ?>

				<div class="column column-1 left footer-widget">

					<div class="widgets">

						<?php dynamic_sidebar( 'footer-a' ); ?>

					</div>

				</div>

			<?php endif; ?> <!-- /footer-a -->

			<?php if ( is_active_sidebar( 'footer-b' ) ) : ?>

				<div class="column column-2 left footer-widget">

					<div class="widgets">

						<?php dynamic_sidebar( 'footer-b' ); ?>

					</div> <!-- /widgets -->

				</div>

			<?php endif; ?> <!-- /footer-b -->

			<?php if ( is_active_sidebar( 'footer-c' ) ) : ?>

				<div class="column column-3 left footer-widget">

					<div class="widgets">

						<?php dynamic_sidebar( 'footer-c' ); ?>

					</div> <!-- /widgets -->

				</div>

			<?php endif; ?> <!-- /footer-c -->

			<div class="clear"></div>

		</div> <!-- /footer-inner -->

	</div> <!-- /footer -->

	<div class="credits section no-padding">

		<div class="credits-inner">
			<div class="credits-left credit-by-field" style="background: <?php echo get_theme_mod('accent_color', '#B22056')?>">

				&copy; <?php echo date("Y") ?> <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>

			</div>

			<?php if ( is_active_sidebar( 'footer-menu' ) ) : ?>

				<div class="right">

					<div class="widgets">

						<?php dynamic_sidebar( 'footer-menu' ); ?>

					</div>

				</div>

			<?php endif; ?> <!-- /footer-full -->

			<div class="clear"></div>

		</div> <!-- /credits-inner -->

	</div> <!-- /credits -->

</div> <!-- /big-wrapper -->

<?php wp_footer(); ?>

</body>
</html>
