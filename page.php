<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

get_header(); 
$header_image = get_field("hero_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
global $post;
$slug = $post->post_name;
?>

<div id="primary" class="content-area defaultTemplate cf <?php echo $has_header_image ?>">
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

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
