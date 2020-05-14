<?php
/**
 * Template Name: About
 */

get_header(); 
$header_image = get_field("hero_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
global $post;
$slug = $post->post_name;
?>

<div id="primary" class="content-area contactpage default cf <?php echo $has_header_image ?>">
	<?php while ( have_posts() ) : the_post(); ?>
		
		<?php if (empty($header_image)) { ?>
		<header class="entry-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header>
		<?php } ?>

		<?php $row1 = get_field("row1"); ?>
		
	
	<?php endwhile; ?><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
