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
			<div class="stripes fadeInRight wow"></div>
		</div>
	</section>
	<?php } ?>


	<?php /* About Garfinkel */ ?>
	<?php  
	$section3_title = get_field("section_3_title");
	$section3_subline = get_field("section_3_subline");
	$short_description = get_field("short_description");
	$section3_image = get_field("image");
	$link_text = get_field("link_text");
	$link_url = get_field("link_url");
	$s3class = ( $section3_image && ($section3_subline || $short_description) ) ? 'twocol':'full';
	if($short_description || $section3_image || $section3_subline) { ?>
	<section class="section-about fw <?php echo $s3class ?>">
		<div class="wrapper">
			<div class="inner">
				<?php if ($section3_image) { ?>
				<div class="imagecol fadeIn wow">
					<img src="<?php echo $section3_image['url'] ?>" alt="<?php echo $section3_image['title'] ?>">
				</div>	
				<?php } ?>
				<?php if ($short_description || $section3_subline) { ?>
				<div class="textcol">
					<?php if ($section3_title || $section3_subline) { ?>
						<div class="toptext fadeInRight wow">
							<?php if ($section3_title) { ?>
							<h3 class="title"><span><?php echo $section3_title ?></span></h3>	
							<?php } ?>
							<?php if ($section3_subline) { ?>
							<div class="text"><?php echo $section3_subline ?></div>	
							<?php } ?>
						</div>
					<?php } ?>
					<?php if ($short_description) { ?>
						<div class="bottomtext fadeInUp wow">
							<div class="bottext"><?php echo $short_description ?></div>
							<?php if ($link_text && $link_url) { ?>
							<div class="button"><span class="btnspan"><a href="<?php echo $link_url ?>" class="btnlink"><?php echo $link_text ?></a></span></div>
							<?php } ?>		
						</div>
					<?php } ?>
				</div>	
				<?php } ?>
			</div>
		</div>
	</section>
	<?php } ?>


	<?php /* Contact Garfinkel */ ?>
	<?php
	$s4_title = get_field("section_title");
	$s4_text = get_field("section_description");
	$s4_btntext = get_field("button_text");
	$s4_btnlink = get_field("button_link");
	if( $s4_title || $s4_text ) { ?>
	<section class="section-contact fw">
		<div class="wrapper text-center fadeIn wow">
			<div class="middle-line"></div>
			<?php if ($s4_title) { ?>
				<h2 class="sectiontitle"><?php echo $s4_title ?></h2>	
			<?php } ?>
			<?php if ($s4_text) { ?>
				<div class="sectiontext"><?php echo $s4_text ?></div>	
			<?php } ?>
			<?php if ($s4_btntext && $s4_btnlink) { ?>
			<div class="button"><span class="btnspan"><a href="<?php echo $s4_btnlink ?>" class="btnbg"><?php echo $s4_btntext ?></a></span></div>
			<?php } ?>	
		</div>
	</section>
	<?php } ?>

</div><!-- #primary -->
<?php
get_footer();
