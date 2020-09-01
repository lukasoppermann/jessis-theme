<?php
/*
Template Name: Categories template
*/
?>

<?php get_header(); ?>

<div class="wrapper section-inner">

	<div class="content full-width">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div class="post-content">

				<?php the_content(); ?>

					<?php if ( current_user_can( 'manage_options' ) ) {

						echo "<p>".edit_post_link( __('Edit', 'jessica') )."</p>";

						}
					?>

				<div class="clear"></div>

			</div> <!-- /post-content -->
		<?php endwhile; endif; ?>

		<div class="categories">

			<?php
				$categories = get_categories();
				foreach ($categories as $cat)
				{
					$args = array( 'numberposts' => '1', 'category' => $cat->cat_ID );
					$recentPost = wp_get_recent_posts( $args, ARRAY_A );
					$thumb = wp_get_attachment_url( get_post_thumbnail_id($recentPost[0]['ID'], 'medium') );
					if ( $thumb == '') {
						$thumb = get_bloginfo('url').'/wp-content/themes/jessica/images/fallback-thumb.png';
					}
					echo "<a class='category-card card' href='".get_category_link( $cat->cat_ID )."'>";
							echo "<div class='category-image card-image' style='background-image:url(".$thumb.");'></div>";
						echo "<h3>".$cat->cat_name.' ('.$cat->category_count.")</h3>";
						if ($cat->category_description != '') {
							echo '<p>'.$cat->category_description.' <span class="read-more color-primary"><span class="text">Artikel anzeigen</span></span></p>';
						}
					echo "</a>";
				}
			?>

		</div> <!-- /posts -->

	</div> <!-- /content -->

	<div class="clear"></div>

</div> <!-- /wrapper section-inner -->

<?php get_footer(); ?>
