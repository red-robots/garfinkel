<?php
get_header(); 
$header_image = get_field("hero_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
global $post;
$slug = $post->post_name;
$post_type = $post->post_type;
?>

<div id="primary" class="content-area defaultTemplate cf">
	
	<?php if ( $post_type=='post' ) { 

		get_template_part( 'parts/content', 'news' );
		
	} else { ?>
	<main id="main" class="site-main cf" role="main">
		<div class="wrapper">

			<?php while ( have_posts() ) : the_post(); ?>
			<header class="entry-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>
			<div class="entry-content cf">
				<?php the_content(); ?>
			</div>
			<?php endwhile; ?>

		</div>
	</main><!-- #main -->

	<?php } ?>

</div><!-- #primary -->

<?php
get_footer();
