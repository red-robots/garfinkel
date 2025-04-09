<?php
/**
 * Template Name: Careers
 */

get_header(); 
$header_image = get_field("hero_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
global $post;
$post_id = $post->ID;
$slug = $post->post_name;
$taxonomy = 'category';
$post_type = 'post';
$currentPage = get_permalink($post_id);
?>

<div id="primary" class="content-area careerspage default cf <?php echo $has_header_image ?>">
	<main id="main" class="site-main cf wrapper" role="main">
		
		
		<?php while ( have_posts() ) : the_post(); ?>

		<?php
			$bottombox = get_field("bottombox");
			$benefits = get_field("benefits");
			$main_content = get_the_content();
			$mainText = strip_tags($main_content);
			$mainText = preg_replace('/\s+/', '', $mainText);
			if (strpos($mainText, 'string(0)') !== false) {
			    $mainText = '';
			}
			$colClass = ($benefits) ? 'twocol':'onecol';
		?>

		<div class="top-content-wrap <?php echo $colClass ?>">
		
			<?php if (empty($header_image)) { ?>
			<header class="entry-header fw">
				<div class="wrapper"><h1 class="page-title"><?php echo get_the_title($post_id); ?></h1></div>
			</header>
			<?php } ?>
			
			<div id="career-left" class="leftcol">
				
				<?php if ( $mainText ) { ?>
				<div class="entry-content cf">
					<?php echo email_obfuscator($main_content); ?>
				</div>
				<?php } ?>
				
				<?php get_template_part("parts/content","careers"); ?>
			</div>
			
			<div id="career-right" class="rightcol">
				<?php if ( $benefits ) { ?>
				<div class="benefits">
					<?php echo $benefits; ?>
				</div>
				<?php } ?>
				<?php echo do_shortcode('[styled_btn link="https://garfinkelimmigration.isolvedhire.com" text="View job opportunities" target="_blank"]'); ?>
			</div>


			<?php if ($bottombox) { ?>
			<div class="bottomBlueBox">
				<div class="wrap"><?php echo $bottombox ?></div>
			</div>	
			<?php } ?>

		</div>
		<?php endwhile; ?>

		<div id="mobile-sidebar" class="fw"></div>

	</main><!-- #main -->
</div><!-- #primary -->

<script>
jQuery(document).ready(function($){
	$(".jobtitle").on("click",function(){
		var parent = $(this).parents(".career-info");
		parent.toggleClass('open');
		parent.find(".jobdescription").slideToggle();
	});
	// var screenWidth = $(window).width();
	// if( screenWidth < 800 ) {
	// 	$("#career-right .benefits").appendTo('#mobile-sidebar');
	// } else {

	// }
});
</script>
<?php
get_footer();
