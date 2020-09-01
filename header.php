<!DOCTYPE html>

<html <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >

		<title><?php wp_title('|', true, 'right'); ?></title>

		<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>

		<?php wp_head(); ?>
		<?php
		// prepare styles
			$footer_image = trim(get_theme_mod('jessica_footer_bg', ''));
			if ($footer_image != ''){
				$footer_bg = 'background-image: url('.$footer_image.'); background-size: cover;';
			}
		?>
		<style>
		.color-primary, .post-content a.more-link{
			color: <?php echo get_theme_mod('accent_color', '#B22056') ?>;
		}
		.post-content a.more-link{
			border-color: <?php echo get_theme_mod('accent_color', '#B22056') ?>;
		}
		.color-bg-one{
			background-color: <?php echo get_theme_mod('accent_color', '#B22056') ?>;
		}
		.color-bg-two{
			background-color: <?php echo get_theme_mod('second_color', '#e81b52') ?>;
		}
		.color-bg-three{
			background-color: <?php echo get_theme_mod('third_color', '#ffa556') ?>;
		}
		.color-bg-four{
			background-color: <?php echo get_theme_mod('fourth_color', '#a8cc4d') ?>;
		}
		.color-bg-five{
			background-color: <?php echo get_theme_mod('fifth_color', '#89b220') ?>;
		}
		@media (min-width: 701px) {
			.footer-bg-image{
				<?php echo $footer_bg ?>
			}
		}

		.menu-item:nth-child(1):after{
			background-color: <?php echo get_theme_mod('accent_color', '#B22056') ?>;
		}
		.menu-item:nth-child(2):after{
			background-color: <?php echo get_theme_mod('second_color', '#e81b52') ?>;
		}
		.menu-item:nth-child(3):after{
			background-color: <?php echo get_theme_mod('third_color', '#ffa556') ?>;
		}
		.menu-item:nth-child(4):after{
			background-color: <?php echo get_theme_mod('fourth_color', '#a8cc4d') ?>;
		}
		.menu-item:nth-child(5):after{
			background-color: <?php echo get_theme_mod('fifths_color', '#89b220') ?>;
		}
		</style>

	</head>

	<body <?php body_class(); ?>>

		<div class="big-wrapper">

			<div class="header-cover section bg-dark-light no-padding">

				<div class="header section" style="background-image: url(<?php if (get_header_image() != '') : ?><?php header_image(); ?><?php else : ?><?php echo get_template_directory_uri() . '/images/header.jpg'; ?><?php endif; ?>);">

					<div class="header-inner section-inner">

						<?php if ( get_theme_mod( 'jessica_logo' ) ) : ?>

							<div class='blog-logo'>

						        <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> &mdash; <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>' rel='home'>
						        	<img src='<?php echo esc_url( get_theme_mod( 'jessica_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>'>
						        </a>

						    </div> <!-- /blog-logo -->

						<?php elseif ( get_bloginfo( 'description' ) || get_bloginfo( 'title' ) ) : ?>

							<div class="blog-info">

								<h1 class="blog-title">
									<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> &mdash; <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" rel="home"><?php echo esc_attr( get_bloginfo( 'title' ) ); ?></a>
								</h1>

								<?php if ( get_bloginfo( 'description' ) ) { ?>

									<h3 class="blog-description"><?php echo esc_attr( get_bloginfo( 'description' ) ); ?></h3>

								<?php } ?>

							</div> <!-- /blog-info -->

						<?php endif; ?>

					</div> <!-- /header-inner -->

				</div> <!-- /header -->

			</div> <!-- /bg-dark -->

			<div class="navigation section no-padding">

				<div class="navigation-inner section-inner">

					<div class="toggle-container hidden">

						<div class="nav-toggle toggle">

							<div class="bars">
								<div class="bar"></div>
								<div class="bar"></div>
								<div class="bar"></div>
							</div>
							<div class="mobile-menu-label">Menu</div>

							<div class="clear"></div>

						</div>

						<div class="search-toggle toggle">

							<div class="metal"></div>
							<div class="glass"></div>
							<div class="handle"></div>

						</div>

						<div class="clear"></div>

					</div> <!-- /toggle-container -->

					<div class="blog-search hidden">

						<?php get_search_form(); ?>

					</div>

					<ul class="blog-menu">

						<?php if ( has_nav_menu( 'primary' ) ) {

							wp_nav_menu( array(

								'container' => '',
								'items_wrap' => '%3$s',
								'theme_location' => 'primary',
								'walker' => new jessica_nav_walker

							) ); } else {

							wp_list_pages( array(

								'container' => '',
								'title_li' => ''

							));

						} ?>

						<div class="clear"></div>

					 </ul>

					 <ul class="mobile-menu">

						<?php if ( has_nav_menu( 'primary' ) ) {

							wp_nav_menu( array(

								'container' => '',
								'items_wrap' => '%3$s',
								'theme_location' => 'primary',
								'walker' => new jessica_nav_walker

							) ); } else {

							wp_list_pages( array(

								'container' => '',
								'title_li' => ''

							));

						} ?>

					 </ul>

				</div> <!-- /navigation-inner -->

			</div> <!-- /navigation -->
