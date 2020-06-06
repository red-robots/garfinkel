<?php
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

<div id="primary" class="content-area contentTwoCol default cf <?php echo $has_header_image ?>">
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
		$details = get_field("details");
		$infotitle = get_field("infotitle");
		// $testimonial = get_field("testimonial");
		// $testimonial_name = get_field("testimonial_name");
		$testimonials = get_field("testimonials");
		$text_large = get_field("text_large");
		$text_small = get_field("text_small");
		$colClass = ( ($text_large || $text_small) &&  $testimonials ) ? 'twocol':'onecol';
		?>
		<div class="top-content-wrap <?php echo $colClass ?>">
			<?php if (empty($header_image)) { ?>
			<header class="entry-header fw">
				<div class="wrapper"><h1 class="page-title"><?php echo get_the_title($post_id); ?></h1></div>
			</header>
			<?php } ?>

			<?php if ( ($text_large || $text_small) || $details ) { ?>
			<div class="leftcol">
				<div class="entry-content cf">
					<?php if ($text_large) { ?>
					<div class="text-large"><?php echo email_obfuscator($text_large); ?></div>	
					<?php } ?>
					<?php if ($text_small) { ?>
					<div class="text-small"><?php echo email_obfuscator($text_small); ?></div>	
					<?php } ?>

					<?php if ($details) { ?>
					<div class="accordion-content details">
						<?php if ($infotitle) { ?>
						<div class="infolabel"><?php echo $infotitle ?></div>	
						<?php } ?>

						<div class="infowrap">
						<?php foreach ($details as $d) { 
							$title = $d['title'];
							$text = $d['text'];
							if($title) { ?>
							<div class="accordion">
								<div class="atitle"><?php echo $title; ?> <span class="arrow"></span></div>
								<?php if ($text) { ?>
								<div class="atext"><?php echo $text; ?></div>
								<?php } ?>
							</div>	
							<?php } ?>
						<?php } ?>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php } ?>

			
			<?php if ( $testimonials ) { 
				$max = 3;
				$count = count($testimonials);
				$slideId = ($count>1) ? 'testimonials-slider':'testimonials-static';
			?>
			<div class="rightcol">
				<div id="<?php echo $slideId ?>" class="swiper-container testimonials">
					<div class="swiper-wrapper">
						<?php $i=1; foreach ($testimonials as $e) { 
							$t_text = $e['testimonial'];
							$t_name = $e['name'];
							if($t_text) { ?>
								<?php if ($i<=3) { ?>
									<div class="swiper-slide">
										<div class="testimonial">
											<div class="quote"><span><i>&quot;</i></span></div>
											<?php echo $t_text; ?>
											<?php if ($t_name) { ?>
											<div class="author">- <?php echo $t_name ?></div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
							<?php $i++; } ?>
						<?php } ?>
					</div>
					<!-- Add Pagination -->
					<div class="testimonial-pagination"></div>
					<!-- Add Arrows -->
					<div class="testimonial-button-next swiper-button-next swiper-button-white"></div>
					<div class="testimonial-button-prev swiper-button-prev swiper-button-white"></div>
				</div>

				
			</div>
			<?php } ?>
		</div>
		<?php endwhile; ?>
	</main><!-- #main -->
</div><!-- #primary -->

<?php /* Contact Garfinkel */ ?>
<?php
$b_title = get_field("contact_title");
$b_text = get_field("services_contact_text");
$b_btntext = get_field("services_contact_button");
$b_btnlink = get_field("services_contact_button_link");
if( $b_title || $b_text ) { ?>
<section class="section-contact gray fw">
	<div class="wrapper text-center fadeIn wow">
		<div class="middle-line"></div>
		<?php if ($b_title) { ?>
			<h2 class="sectiontitle"><?php echo $b_title ?></h2>	
		<?php } ?>
		<?php if ($b_text) { ?>
			<div class="sectiontext"><?php echo $b_text ?></div>	
		<?php } ?>
		<?php if ($b_btntext && $b_btnlink) { ?>
		<div class="button"><span class="btnspan"><a href="<?php echo $b_btnlink ?>" class="btnbg"><?php echo $b_btntext ?></a></span></div>
		<?php } ?>	
	</div>
</section>
<?php } ?>

<script>
jQuery(document).ready(function($){
	$(".atitle").on("click",function(){
		var parent = $(this).parents(".accordion");
		parent.toggleClass('open');
		parent.find(".atext").slideToggle();
	});

	if( $("#testimonials-slider").length > 0 ) {
		var swiper_testimonials = new Swiper('#testimonials-slider', {
			autoplay: {
				delay: 10000,
			},
			loop: true,
			spaceBetween: 30,
			effect: 'fade',
			pagination: {
				el: '.testimonial-pagination',
				clickable: true,
			},
			navigation: {
				nextEl: '.testimonial-button-next',
				prevEl: '.testimonial-button-prev',
			},
		});
	}
});
</script>
<?php
get_footer();