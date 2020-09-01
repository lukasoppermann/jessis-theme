<?php get_header(); ?>
<div class="wrapper section-inner">

	<div class="content left">

    <section id="primary" class="site-content">
    <div id="content" role="main">
			<header class="category-header color-bg-four">
				<h1 class="category-title"><?php single_cat_title( '', true ); ?></h1>
		    <?php
		    // Display optional category description
		    if ( category_description() ) : ?>
		    	<div class="category-description"><?php echo category_description(); ?></div>
		    <?php endif; ?>
		  </header>

			<?php while (have_posts()) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php get_template_part( 'content', get_post_format() ); ?>

				</div> <!-- /post -->

				<?php endwhile; ?>

    <!-- <?php
    // Check if there are any posts to display
    if ( have_posts() ) : ?>

    <header class="archive-header">
    <h1 class="archive-title"><?php single_cat_title( '', true ); ?></h1>


    <?php
    // Display optional category description
     if ( category_description() ) : ?>
    <div class="archive-meta"><?php echo category_description(); ?></div>
    <?php endif; ?>
    </header>

    <?php

    // The Loop
    while ( have_posts() ) : the_post(); ?>
    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
    <small><?php the_time('F jS, Y') ?> by <?php the_author_posts_link() ?></small>

    <div class="entry">
    <?php the_content(); ?>

     <p class="postmetadata"><?php
      comments_popup_link( 'No comments yet', '1 comment', '% comments', 'comments-link', 'Comments closed');
    ?></p>
    </div>

    <?php endwhile;

    else: ?>
    <p>Sorry, no posts matched your criteria.</p>


    <?php endif; ?> -->
    </div>
    </section>

  </div>


	<?php get_sidebar(); ?>

	<div class="clear"></div>

</div> <!-- /wrapper section-inner -->

<?php get_footer(); ?>
