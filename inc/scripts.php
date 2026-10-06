<?php
/**
 * Enqueue scripts and styles.
 */
function bellaworks_scripts() {
	// "ver" is stripped from asset URLs in functions.php, so bust the cache with the file time instead.
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	// The stylesheet is printed inline so the page can paint without waiting on a second request.
	wp_register_style( 'bellaworks-style', false );
	wp_enqueue_style( 'bellaworks-style' );
	wp_add_inline_style( 'bellaworks-style', bellaworks_inline_stylesheet() );

	// Scripts are deferred so they don't block the first paint. WordPress falls back to a normal
	// (blocking) tag on any page where a plugin script that depends on jQuery can't be deferred.
	$head_defer   = array( 'in_footer' => false, 'strategy' => 'defer' );
	$footer_defer = array( 'in_footer' => true, 'strategy' => 'defer' );

  wp_deregister_script('jquery');
  // wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', false, '3.4.1', false);
  wp_register_script('jquery', get_stylesheet_directory_uri() . '/assets/js/jquery.min.js', false, '3.6.3', $head_defer);
  wp_enqueue_script('jquery');

	

	wp_enqueue_script( 
			'bellaworks-blocks', 
			$theme_uri . '/assets/js/vendors.min.js?v=' . filemtime( $theme_dir . '/assets/js/vendors.min.js' ), 
			array(), '20120206', 
			$footer_defer 
		);

	// Swiper is only used by the testimonials slider on practice area pages.
	if ( is_singular( 'practice-areas' ) ) {
		wp_enqueue_script( 
			'bellaworks-swiper', 
			$theme_uri . '/assets/js/swiper.min.js?v=' . filemtime( $theme_dir . '/assets/js/swiper.min.js' ), 
			array(), '5.4.2', 
			$footer_defer 
		);
	}

	wp_enqueue_script( 
			'bellaworks-custom', 
			$theme_uri . '/assets/js/custom.min.js?v=' . filemtime( $theme_dir . '/assets/js/custom.min.js' ), 
			array(), '20120206', 
			$footer_defer 
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
  Returns style.min.css for inline output, with its
  relative image paths pointed back at the theme folder.
---------------------------------------*/
function bellaworks_inline_stylesheet() {
	$css = file_get_contents( get_template_directory() . '/style.min.css' );
	if ( ! $css ) {
		return '';
	}
	return str_replace( 'url("images/', 'url("' . get_template_directory_uri() . '/images/', $css );
}

/*-------------------------------------
  The translator plugin's scripts depend on jQuery, so they
  have to be deferred too or jQuery can't be.
---------------------------------------*/
function bellaworks_defer_plugin_scripts() {
	foreach ( array( 'scripts', 'scripts-google' ) as $handle ) {
		if ( wp_script_is( $handle, 'registered' ) ) {
			wp_script_add_data( $handle, 'strategy', 'defer' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'bellaworks_defer_plugin_scripts', 100 );

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
