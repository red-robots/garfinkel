<?php
/**
 * Template Name: Sitemap
 */

get_header(); 
$header_image = get_field("hero_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
global $post;
$slug = $post->post_name;
?>

<div id="primary" class="content-area pagesitemap defaultTemplate cf <?php echo $has_header_image ?>">
	<main id="main" class="site-main cf wrapper medium" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php if (empty($header_image)) { ?>
			<header class="entry-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>
			<?php } ?>
			
			<?php
			$mainText = strip_tags(get_the_content());
			$mainText = preg_replace('/\s+/', '', $mainText);
			if (strpos($mainText, 'string(0)') !== false) {
			    $mainText = '';
			}
			?>
			<?php if ( $mainText ) { ?>
			<div class="entry-content cf">
				<?php the_content(); ?>
			</div>
			<?php } ?>

			<?php get_template_part('parts/content','sitemap'); ?>

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
