<?php

// Theme setup
add_action( 'after_setup_theme', 'jessica_setup' );

function jessica_setup() {

	// Automatic feed
	add_theme_support( 'automatic-feed-links' );

	// Custom background
	// add_theme_support( 'custom-background' );

	// Post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'post-image', 676, 9999 );

	// Post formats
	add_theme_support( 'post-formats', array( 'video', 'aside', 'quote' ) );

	// Custom header
	$args = array(
		'width'         => 1280,
		'height'        => 550,
		'default-image' => get_template_directory_uri() . '/images/header.jpg',
		'uploads'       => true,
		'header-text'  	=> false

	);
	add_theme_support( 'custom-header', $args );

	// Add nav menu
	register_nav_menu( 'primary', 'Primary Menu' );

	// Make the theme translation ready
	load_theme_textdomain('jessica', get_template_directory() . '/languages');

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable($locale_file) )
	  require_once($locale_file);

}

// Enqueue Javascript files
function jessica_load_javascript_files() {

	if ( !is_admin() )
		wp_register_script( 'jessica_global', get_template_directory_uri().'/js/global.js', array('jquery'), '', true );

		wp_enqueue_script( 'jessica_global' );
}

add_action( 'wp_enqueue_scripts', 'jessica_load_javascript_files' );


// Enqueue styles
function jessica_load_style() {
	if ( !is_admin() )
	    wp_register_style('jessica_googleFonts',  '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' );
		wp_register_style('jessica_style', get_stylesheet_uri() );

	    wp_enqueue_style( 'jessica_googleFonts' );
	    wp_enqueue_style( 'jessica_style' );
}

add_action('wp_print_styles', 'jessica_load_style');


// Add editor styles
function jessica_add_editor_styles() {
    add_editor_style( 'jessica-editor-style.css' );
    $font_url = '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic';
    add_editor_style( str_replace( ',', '%2C', $font_url ) );
}
add_action( 'init', 'jessica_add_editor_styles' );


// Add footer widget areas
add_action( 'widgets_init', 'jessica_sidebar_reg' );

function jessica_sidebar_reg() {

	register_sidebar(array(
	  'name' => __( 'Footer A', 'jessica' ),
	  'id' => 'footer-a',
	  'description' => __( 'Widgets in this area will be shown in the left column in the footer.', 'jessica' ),
	  'before_title' => '<h3 class="widget-title">',
	  'after_title' => '</h3>',
	  'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
	  'after_widget' => '</div><div class="clear"></div></div>'
	));
	register_sidebar(array(
	  'name' => __( 'Footer B', 'jessica' ),
	  'id' => 'footer-b',
	  'description' => __( 'Widgets in this area will be shown in the middle column in the footer.', 'jessica' ),
	  'before_title' => '<h3 class="widget-title">',
	  'after_title' => '</h3>',
	  'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
	  'after_widget' => '</div><div class="clear"></div></div>'
	));
	register_sidebar(array(
	  'name' => __( 'Footer C', 'jessica' ),
	  'id' => 'footer-c',
	  'description' => __( 'Widgets in this area will be shown in the right column in the footer.', 'jessica' ),
	  'before_title' => '<h3 class="widget-title">',
	  'after_title' => '</h3>',
	  'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
	  'after_widget' => '</div><div class="clear"></div></div>'
	));
	register_sidebar(array(
	  'name' => __( 'Sidebar', 'jessica' ),
	  'id' => 'sidebar',
	  'description' => __( 'Widgets in this area will be shown in the sidebar.', 'jessica' ),
	  'before_title' => '<h3 class="widget-title">',
	  'after_title' => '</h3>',
	  'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
	  'after_widget' => '</div><div class="clear"></div></div>'
	));

	register_sidebar(array(
	  'name' => __( 'Footer Menu', 'jessica' ),
	  'id' => 'footer-menu',
	  'description' => __( 'Widgets in this area will be shown above the columns in the footer.', 'jessica' ),
	  'before_title' => '<h3 class="widget-title">',
	  'after_title' => '</h3>',
	  'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
	  'after_widget' => '</div><div class="clear"></div></div>'
	));
}

// Add theme widgets
require_once (get_template_directory() . "/widgets/video-widget.php");


// Set content-width
if ( ! isset( $content_width ) ) $content_width = 676;


// Custom title function
function jessica_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'jessica' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'jessica_wp_title', 10, 2 );
add_filter('widget_text', 'do_shortcode');

// Add classes to next_posts_link and previous_posts_link
add_filter('next_posts_link_attributes', 'jessica_posts_link_attributes_1');
add_filter('previous_posts_link_attributes', 'jessica_posts_link_attributes_2');

function jessica_posts_link_attributes_1() {
    return 'class="post-nav-older"';
}
function jessica_posts_link_attributes_2() {
    return 'class="post-nav-newer"';
}


// Menu walker adding "has-children" class to menu li's with children menu items
class jessica_nav_walker extends Walker_Nav_Menu {
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( !empty( $children_elements[ $element->$id_field ] ) ) {
            $element->classes[] = 'has-children';
        }
        Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}


// Add class to body if the post/page has a featured image
add_action('body_class', 'jessica_if_featured_image_class' );

function jessica_if_featured_image_class($classes) {
     global $post;
     if ( isset( $post ) && has_post_thumbnail() ) {
             $classes[] = 'has-featured-image';
     }
     return $classes;
}


// Custom more-link text
add_filter( 'the_content_more_link', 'jessica_custom_more_link', 10, 2 );

function jessica_custom_more_link( $more_link, $more_link_text ) {
	return str_replace( $more_link_text, __('Weiterlesen', 'jessica'), $more_link );
}


// Remove inline styling of attachment
add_shortcode('wp_caption', 'jessica_fixed_img_caption_shortcode');
add_shortcode('caption', 'jessica_fixed_img_caption_shortcode');

function jessica_fixed_img_caption_shortcode($attr, $content = null) {
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}

	$output = apply_filters('img_caption_shortcode', '', $attr, $content);

	if ( $output != '' ) return $output;
	extract(shortcode_atts(array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
	return $content;
	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" >'
	. do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}

// Style the admin area
function jessica_custom_colors() {
   echo '<style type="text/css">

#postimagediv #set-post-thumbnail img {
	max-width: 100%;
	height: auto;
}

         </style>';
}

add_action('admin_head', 'jessica_custom_colors');


// jessica comment function
if ( ! function_exists( 'jessica_comment' ) ) :
function jessica_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>

	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

		<?php __( 'Pingback:', 'jessica' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'jessica' ), '<span class="edit-link">', '</span>' ); ?>

	</li>
	<?php
			break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

		<div id="comment-<?php comment_ID(); ?>" class="comment">

			<div class="comment-meta comment-author vcard">

				<?php echo get_avatar( $comment, 120 ); ?>

				<div class="comment-meta-content">

					<?php printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						( $comment->user_id === $post->post_author ) ? '<span class="post-author"> ' . __( '(Post author)', 'jessica' ) . '</span>' : ''
					); ?>

					<p><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php echo get_comment_date() . ' at ' . get_comment_time() ?></a></p>

				</div> <!-- /comment-meta-content -->

			</div> <!-- /comment-meta -->

			<div class="comment-content post-content">

				<?php if ( '0' == $comment->comment_approved ) : ?>

					<p class="comment-awaiting-moderation"><?php _e( 'Awaiting moderation', 'jessica' ); ?></p>

				<?php endif; ?>

				<?php comment_text(); ?>

				<div class="comment-actions">

					<?php edit_comment_link( __( 'Edit', 'jessica' ), '', '' ); ?>

					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'jessica' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

					<div class="clear"></div>

				</div> <!-- /comment-actions -->

			</div><!-- /comment-content -->

		</div><!-- /comment-## -->
	<?php
		break;
	endswitch;
}
endif;

// Add and save meta boxes for post links
add_action( 'add_meta_boxes', 'cd_meta_box_add' );
function cd_meta_box_add() {
	add_meta_box( 'postvideo-box', __('Video URL (video post format)', 'jessica'), 'cd_meta_box_cc', 'post', 'side', 'high' );
}

function cd_meta_box_cc( $post ) {
	$values = get_post_custom( $post->ID );
	$text_videourl = isset( $values['videourl'] ) ? esc_attr( $values['videourl'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
		<p>
			<input type="text" name="videourl" id="videourl" value="<?php echo $text_videourl; ?>" />
		</p>
	<?php
}

add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id ) {
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;

	// now we can actually save the data
	$allowed = array(
		'a' => array( // on allow a tags
			'href' => array() // and those anchords can only have href attribute
		)
	);

	// Probably a good idea to make sure the data is set
	if( isset( $_POST['videourl'] ) )
		update_post_meta( $post_id, 'videourl', wp_kses( $_POST['videourl'], $allowed ) );

}


// jessica theme options

class jessica_Customize {

   public static function register ( $wp_customize ) {

      //1. Define a new section (if desired) to the Theme Customizer
      $wp_customize->add_section( 'jessica_options',
         array(
            'title' => __( 'jessica Options', 'jessica' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to customize some settings for jessica.', 'jessica'), //Descriptive tooltip
         )
      );
      $wp_customize->add_section( 'jessica_footer_bg_section' , array(
		    'title'       => __( 'Footer Hintergrund', 'jessica' ),
		    'priority'    => 65,
		    'description' => __('Hintergrundbild für den Footer','jessica'),
			) );

      //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'accent_color', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#B22056', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         )
      );

      $wp_customize->add_setting( 'second_color', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#e81b52', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         )
      );

      $wp_customize->add_setting( 'third_color', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#ffa556', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         )
      );
      $wp_customize->add_setting( 'fourth_color', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#a8cc4d', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         )
      );
      $wp_customize->add_setting( 'fifths_color', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#89bc21', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         )
      );


      $wp_customize->add_setting( 'jessica_logo' );

			$wp_customize->add_setting( 'jessica_footer_bg' );

      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'jessica_accent_color', //Set a unique ID for the control
         array(
            'label' => __( 'Primary Color', 'jessica' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'accent_color', //Which setting to load and manipulate (serialized is okay)
         )
      ) );
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'jessica_second_color', //Set a unique ID for the control
         array(
            'label' => __( 'Second Color', 'jessica_2' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'second_color', //Which setting to load and manipulate (serialized is okay)
         )
      ) );
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'jessica_third_color', //Set a unique ID for the control
         array(
            'label' => __( 'Third Color', 'jessica_3' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'third_color', //Which setting to load and manipulate (serialized is okay)
         )
      ) );
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'jessica_fourth_color', //Set a unique ID for the control
         array(
            'label' => __( 'Fourth Color', 'jessica_4' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'fourth_color', //Which setting to load and manipulate (serialized is okay)
         )
      ) );
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'jessica_fifth_color', //Set a unique ID for the control
         array(
            'label' => __( 'Fifth Color', 'jessica_5' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'fifths_color', //Which setting to load and manipulate (serialized is okay)
         )
      ) );

      $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'jessica_logo', array(
		    'label'    => __( 'Logo', 'jessica' ),
		    'section'  => 'title_tagline',
		    'settings' => 'jessica_logo',
		) ) );


	    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'jessica_footer_bg', array(
		    'label'    => __( 'Footer Hintergrund', 'jessica' ),
		    'section'  => 'jessica_footer_bg_section',
		    'settings' => 'jessica_footer_bg',
		) ) );

      //4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
      $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
      $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
   }

   public static function header_output() {
      ?>

	      <!--Customizer CSS-->

	      <style type="text/css">
	           <?php self::generate_css('body::selection', 'background', 'accent_color'); ?>
	           <?php self::generate_css('body a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('body a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.blog-title a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.blog-menu a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.blog-search #searchsubmit', 'background-color', 'accent_color'); ?>
	           <?php self::generate_css('.blog-search #searchsubmit', 'border-color', 'accent_color'); ?>
	           <?php self::generate_css('.blog-search #searchsubmit:hover', 'background-color', 'accent_color'); ?>
	           <?php self::generate_css('.blog-search #searchsubmit:hover', 'border-color', 'accent_color'); ?>
	           <?php self::generate_css('.featured-media .sticky-post', 'background-color', 'accent_color'); ?>
	           <?php self::generate_css('.post-title a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.post-meta a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.post-content a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.post-content a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.blog .format-quote blockquote cite a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.post-content a.more-link:hover', 'background-color', 'accent_color'); ?>
	           <?php self::generate_css('.post-content input[type="submit"]:hover', 'background-color', 'accent_color'); ?>
	           <?php self::generate_css('.post-content input[type="reset"]:hover', 'background-color', 'accent_color'); ?>
	           <?php self::generate_css('.post-content input[type="button"]:hover', 'background-color', 'accent_color'); ?>
	           <?php self::generate_css('.post-content fieldset legend', 'background-color', 'accent_color'); ?>
	           <?php self::generate_css('.post-content .searchform #searchsubmit', 'background', 'accent_color'); ?>
	           <?php self::generate_css('.post-content .searchform #searchsubmit', 'border-color', 'accent_color'); ?>
	           <?php self::generate_css('.post-content .searchform #searchsubmit:hover', 'background', 'accent_color'); ?>
	           <?php self::generate_css('.post-content .searchform #searchsubmit:hover', 'border-color', 'accent_color'); ?>
	           <?php self::generate_css('.post-categories a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.post-categories a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.post-tags a:hover', 'background', 'accent_color'); ?>
	           <?php self::generate_css('.post-tags a:hover:after', 'border-right-color', 'accent_color'); ?>
	           <?php self::generate_css('.post-nav a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.archive-nav a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.logged-in-as a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.logged-in-as a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.content #respond input[type="submit"]:hover', 'background-color', 'accent_color'); ?>
	           <?php self::generate_css('.comment-meta-content cite a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.comment-meta-content p a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.comment-actions a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('#cancel-comment-reply-link', 'color', 'accent_color'); ?>
	           <?php self::generate_css('#cancel-comment-reply-link:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.comment-nav-below a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget-title a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget-title a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_text a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_text a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_rss a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_rss a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_archive a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_archive a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_meta a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_meta a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_recent_comments a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_recent_comments a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_pages a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_pages a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_links a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_links a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_recent_entries a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_recent_entries a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_categories a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_categories a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_search #searchsubmit', 'background', 'accent_color'); ?>
	           <?php self::generate_css('.widget_search #searchsubmit', 'border-color', 'accent_color'); ?>
	           <?php self::generate_css('.widget_search #searchsubmit:hover', 'background', 'accent_color'); ?>
	           <?php self::generate_css('.widget_search #searchsubmit:hover', 'border-color', 'accent_color'); ?>
	           <?php self::generate_css('#wp-calendar a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('#wp-calendar a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('#wp-calendar tfoot a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.dribbble-shot:hover', 'background', 'accent_color'); ?>
	           <?php self::generate_css('.widgetmore a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.widgetmore a:hover', 'color', 'accent_color'); ?>
	           <?php self::generate_css('.sidebar .tagcloud a:hover', 'background', 'accent_color'); ?>
	           <?php self::generate_css('.footer .tagcloud a:hover', 'background', 'accent_color'); ?>
	           <?php self::generate_css('.credits a:hover', 'color', 'accent_color'); ?>

	           <?php self::generate_css('body#tinymce.wp-editor a', 'color', 'accent_color'); ?>
	           <?php self::generate_css('body#tinymce.wp-editor a:hover', 'color', 'accent_color'); ?>
	      </style>

	      <!--/Customizer CSS-->

      <?php
   }

   public static function live_preview() {
      wp_enqueue_script(
           'jessica-themecustomizer', // Give the script a unique ID
           get_template_directory_uri() . '/js/theme-customizer.js', // Define the path to the JS file
           array(  'jquery', 'customize-preview' ), // Define dependencies
           '', // Define a version (optional)
           true // Specify whether to put in footer (leave this true)
      );
   }

   public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
      return $return;
    }
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'jessica_Customize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'jessica_Customize' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'jessica_Customize' , 'live_preview' ) );

?>
