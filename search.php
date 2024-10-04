<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package bellaworks
 */

get_header(); 

$rectangle = THEMEURI . 'images/rectangle.png';
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main cf wrapper" role="main">

			<header class="entry-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'bellaworks' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<div class="news-section-wrapper cf">
				<div class="search">
					<?php get_search_form(); ?>
				</div>
				<div class="news-inner cf">
					<div class="news-results">
						<div id="newsContent">
							<div id="newsInner" class="flexwrap">
							<?php
							$taxonomy = 'category';
							if ( have_posts() ) : ?>

								

								<?php
								/* Start the Loop */
								while ( have_posts() ) : the_post(); 
									$id = get_the_ID();
									$content = strip_tags( $post->post_content );
									$content = ($content) ? shortenText($content,100,' ') : '';
									$thumbID = get_post_thumbnail_id($id);
									$img = ($thumbID) ? wp_get_attachment_image_src($thumbID,'large') : '';
									$imgAlt = ($img) ? get_the_title($thumbID) : '';
									$post_terms = get_the_terms($id,$taxonomy);
									?>

									<div class="fcol news animated fadeIn">
										<div class="inside">
											<?php if ( $img ) { ?>
											<div class="feat-image" style="background-image:url('<?php echo $img[0] ?>');"><img src="<?php echo $rectangle ?>" alt="" aria-hidden="true"/></div>	
											<?php } else { ?>
											<div class="feat-image na"><img src="<?php echo $rectangle ?>" alt="" aria-hidden="true" class="placeholder"></div>
											<?php } ?>
											<div class="textwrap">
												<div class="postdate"><?php echo $post_date_text; ?></div>
												<h3 class="posttitle"><a href="<?php echo get_permalink($id); ?>"><?php echo get_the_title($id); ?></a></h3>
												<div class="excerpt"><?php echo $content; ?></div>
											</div>
											<div class="button"><a href="<?php echo get_permalink($id); ?>" class="btnlink">Read More</a></div>
										</div>
									</div>

								<?php endwhile; ?>
								<div class="clear"></div>

								<?php 

							else :

								get_template_part( 'template-parts/content', 'none' );

							endif; ?>
							</div>
						</div>
					</div>
					<?php the_posts_navigation(); ?>
				</div>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
