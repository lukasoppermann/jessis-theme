<?php
/*
Template Name: List Subpages
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

			<div class="sub-pages">

						<?php
						$my_wp_query = new WP_Query();
						$all_wp_pages = $my_wp_query->query(array('post_type' => 'page'));
						$children = get_page_children( get_the_ID(), $all_wp_pages );

						foreach($children as $child){
							$thumb = get_the_post_thumbnail( $child->ID, 'medium');
							if ( $thumb == '') {
								$thumb = '<img src="'.get_template_directory().'/images/fallback-thumb.png" />';
							}
							echo "<a class='category-card card' href='".get_page_link( $child->ID )."'>";
								$description = get_post_meta( $child->ID, 'description', true );

								if ($description != '') {
									echo "<div class='category-image card-image'>";
									echo $thumb;
									echo "</div>";
								}
								echo "<h3>".$child->post_title."</h3>";
								if ($description != '') {
									echo '<p>'.$description.' <span class="read-more color-primary"><span class="text">Artikel anzeigen</span></span></p>';
								}
							echo "</a>";

							$description = $img = null;

						}



				?>
				<div class="clear"></div>
			</div> <!-- /posts -->

	</div> <!-- /content -->

</div> <!-- /wrapper section-inner -->

<?php get_footer(); ?>
