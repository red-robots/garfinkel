<?php
$homeBanner = ( is_front_page() ) ? 'homepage':'subpage';
$slides = get_field("hero_image");
$count = 0;
if( isset($slides['url']) && $slides['url'] ) {
	$count = 0;
} else {
	$count = ($slides) ? count($slides) : 0; 
}
$slidesId = ($count>1) ? 'slideshow':'static-banner';
$placeholder = THEMEURI . 'images/rectangle.png';

if( is_front_page() ) {
	$tagline = get_field("tagline");
	if( $slides ) {  ?>
		<div id="<?php echo $slidesId ?>" class="swiper-container banner-wrap fw homepage">
			<div class="swiper-wrapper">

				<?php if ( isset($slides['url']) && $slides['url'] ) { ?>

					<div class="swiper-slide slideItem" style="background-image:url('<?php echo $slides['url'] ?>');">
						<?php if ($tagline) { ?>
						<div class="slideCaption">
							<div class="wrapper">
								<div class="text fadeInDown wow"><?php echo $tagline ?></div>
							</div>
						</div>
						<?php } ?>
					</div>

				<?php } else { ?>

					<?php foreach ($slides as $img) { 
							$title = $img['title'];
							$caption = $img['caption'];
						?>
	    				<div class="swiper-slide slideItem" style="background-image:url('<?php echo $img['url'] ?>');">
	    					<?php if ($caption) { ?>
	    					<div class="slideCaption">
		    					<div class="slideInside animated">
		    						<div class="slideMid">
			    						<?php if ($title) { ?>
			    						<h2 class="slideTitle"><?php echo $title; ?></h2><br>
			    						<?php } ?>
			    						<?php if ($caption) { ?>
			    						<div class="slideText"><?php echo $caption; ?></div>	
			    						<?php } ?>
		    						</div>
	    						</div>
	    					</div>
	    					<?php } ?>
	    					<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" />
	    				</div>
	    			<?php } ?>

				<?php } ?>

			</div>

			<?php if ($count>1) { ?>
			    <div class="swiper-pagination"></div>
			    <div class="swiper-button-next"></div>
			    <div class="swiper-button-prev"></div>
			<?php } ?>
		</div>
		<div class="scrollDownDiv">
			<div class="wrapper"><a href="#" id="scrolldown" class="fadeInDown wow" data-wow-delay=".5s"><span class="sr">scroll down</span></a></div>
		</div>
	<?php } ?>

<?php } else { ?>

	<?php  
	$post_type = get_post_type();
	$page_title = get_the_title();
	?>
	
	<?php if( $slides ) {  ?>
	<div id="static-banner" class="banner-wrap fw subpage">
		<div class="banner-image cf fadeIn animated" style="background-image:url('<?php echo $slides['url']; ?>');">
			<div class="wrapper">
				<div class="caption">
					<h1 class="page-title fadeInRight wow"><?php echo $page_title ?></h1>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>

<?php } ?>