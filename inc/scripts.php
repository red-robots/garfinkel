<?php
/**
 * Enqueue scripts and styles.
 */
function bellaworks_scripts() {
	// "ver" is stripped from asset URLs in functions.php, so bust the cache with the file time instead.
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	wp_enqueue_style( 
		'bellaworks-style', 
		$theme_uri . '/style.min.css?v=' . filemtime( $theme_dir . '/style.min.css' ), 
	);

  wp_deregister_script('jquery');
  // wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', false, '3.4.1', false);
  wp_register_script('jquery', get_stylesheet_directory_uri() . '/assets/js/jquery.min.js', false, '3.6.3', false);
  wp_enqueue_script('jquery');

	

	wp_enqueue_script( 
			'bellaworks-blocks', 
			$theme_uri . '/assets/js/vendors.min.js?v=' . filemtime( $theme_dir . '/assets/js/vendors.min.js' ), 
			array(), '20120206', 
			true 
		);

	wp_enqueue_script( 
			'bellaworks-custom', 
			$theme_uri . '/assets/js/custom.min.js?v=' . filemtime( $theme_dir . '/assets/js/custom.min.js' ), 
			array(), '20120206', 
			true 
		);

	// Pages are built in the classic editor, only load the block styles where blocks are actually used.
	if ( is_singular() && ! has_blocks() ) {
		wp_dequeue_style( 'wp-block-library' );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bellaworks_scripts' );

/*-------------------------------------
  Load stylesheets that only style content below the fold
  (the translator toolbar in the footer) without blocking render.
---------------------------------------*/
function bellaworks_non_blocking_styles( $tag, $handle ) {
	$handles = array( 'google-language-translator', 'glt-toolbar-styles' );
	if ( is_admin() || ! in_array( $handle, $handles, true ) ) {
		return $tag;
	}
	$async = preg_replace( "/media=(['\"]).*?\\1/", 'media="print" onload="this.media=\'all\'"', $tag, 1 );
	return $async . '<noscript>' . trim( $tag ) . '</noscript>' . "\n";
}
add_filter( 'style_loader_tag', 'bellaworks_non_blocking_styles', 10, 2 );

/*-------------------------------------
  Preload the banner image so the browser can start on it
  before the stylesheet is parsed. Sources match parts/banner.php.
---------------------------------------*/
function bellaworks_preload_banner() {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}
	$sources = bellaworks_banner_sources( get_field( 'hero_image' ) );
	if ( ! $sources ) {
		return;
	} ?>
	<link rel="preload" as="image" href="<?php echo esc_url( $sources['mobile'] ); ?>" media="(max-width: 820px)" fetchpriority="high">
	<link rel="preload" as="image" href="<?php echo esc_url( $sources['desktop'] ); ?>" media="(min-width: 821px)" fetchpriority="high">
	<?php
}
add_action( 'wp_head', 'bellaworks_preload_banner', 1 );
