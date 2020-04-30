<?php
/**
 * Template Name: FAQs
 *
 */

get_header(); 
$header_image = get_field("hero_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
global $post;
$slug = $post->post_name;
?>

<div id="primary" class="content-area faqspage default cf <?php echo $has_header_image ?>">
	<main id="main" class="site-main cf" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php if (empty($header_image)) { ?>
			<header class="entry-header">
				<div class="wrapper">
					<h1 class="page-title"><?php the_title(); ?></h1>
				</div>
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
				<div class="wrapper"><?php the_content(); ?></div>
			</div>
			<?php } ?>

		<?php endwhile; ?>

		<?php  
		$args = array(
			'posts_per_page'=> -1,
			'post_type'		=> 'faq',
			'post_status'	=> 'publish'
		);
		$faqs = new WP_Query($args);
		if ( $faqs->have_posts() ) {  ?>
		<section class="section-faqs fw">
			<div class="wrapper cf">
				<?php while ( $faqs->have_posts() ) : $faqs->the_post();  ?>
					<div class="faq-item">
						<h2 class="question"><?php echo get_the_title(); ?><i class="arrow"></i></h2>
						<div class="answer"><?php the_content(); ?></div>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</section>
		<?php } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
