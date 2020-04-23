<?php 
get_header(); 
?>
<div id="primary" class="content-area fw">
	<?php while ( have_posts() ) : the_post(); ?>
		
		<?php if ( get_the_content() ) { ?>
		<section class="maintext fw">
			<div class="wrapper fadeIn wow">
				<?php echo the_content(); ?>
			</div>
		</section>
		<?php } ?>

	<?php endwhile; ?>

	<?php
	/* PRACTICE AREAS */
	$args = array(
		'posts_per_page'=> -1,
		'post_type'		=> 'practice-areas',
		'post_status'	=> 'publish',
	);
	$areas = new WP_Query($args);
	$section_2_title = get_field("section_2_title");
	$section_2_subline = get_field("section_2_subline");

	if ( $areas->have_posts() ) {  ?>
	<section class="practice-areas fw">
		<div class="innerwrap fw">
			<div class="wrapper">
				<?php if ($section_2_title || $section_2_subline) { ?>
					<div class="heading fadeInLeft wow">
					<?php if ($section_2_title) { ?>
						<h2 class="stitle"><span><?php echo $section_2_title; ?></span></h2>
					<?php } ?>
					<?php if ($section_2_subline) { ?>
						<div class="stext"><?php echo $section_2_subline; ?></div>
					<?php } ?>
					</div>
				<?php } ?>
				<div class="posts fw">
					<div class="flexwrap">
						<?php $i=1; 
						while ( $areas->have_posts() ) : $areas->the_post();  
							$title = get_the_title();
							$excerpt = get_field("excerpt");
							$pagelink = get_permalink();
							$delay = $i+2;
							?>
						<div class="fbox fadeInUp wow" data-wow-delay=".<?php echo $delay?>s">
							<div class="inner">
								<h3 class="title"><?php echo $title; ?></h3>
								<div class="text"><?php echo $excerpt ?></div>
								<div class="button"><a href="<?php echo $pagelink ?>" class="morebtn">Read More</a></div>
							</div>
						</div>
						<?php $i++; endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php } ?>
	
</div><!-- #primary -->
<?php
get_footer();
