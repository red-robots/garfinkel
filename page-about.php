<?php
/**
 * Template Name: About
 */

get_header(); 
$header_image = get_field("hero_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
global $post;
$slug = $post->post_name;
$rectangle = THEMEURI . 'images/rectangle.png';
?>

<div id="primary" class="content-area aboutpage default cf <?php echo $has_header_image ?>">
	<?php while ( have_posts() ) : the_post(); ?>
		
		<?php if (empty($header_image)) { ?>
		<header class="entry-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header>
		<?php } ?>

		<?php 
		$row1 = get_field("row1"); 
		$row1_text1 = ( isset($row1['col1_content']) && $row1['col1_content'] ) ? $row1['col1_content'] : '';
		$row1_text2 = ( isset($row1['col2_content']) && $row1['col2_content'] ) ? $row1['col2_content'] : '';
		$row1_btnLabel = ( isset($row1['col2_button_name']) && $row1['col2_button_name'] ) ? $row1['col2_button_name'] : '';
		$row1_btnLink = ( isset($row1['col2_button_link']) && $row1['col2_button_link'] ) ? $row1['col2_button_link'] : '';
		$row1_class = ($row1_text1 && $row1_text2) ? 'twoccol':'onecol';
		?>
		<?php if ( $row1_text1 || $row1_text2 ) { ?>
		<section class="contentrow arow1 <?php echo $row1_class ?>">
			<div class="wrapper-narrow">
				<div class="flexwrap">
					<?php if ($row1_text1) { ?>
					<div class="col col1">
						<?php echo $row1_text1 ?>
					</div>	
					<?php } ?>
					<?php if ($row1_text2) { ?>
					<div class="col col2">
						<?php echo $row1_text2 ?>
						<?php if ($row1_btnLabel && $row1_btnLink) { ?>
						<div class="button">
							<a href="<?php echo $row1_btnLink ?>" class="btnbg"><?php echo $row1_btnLabel ?></a>
						</div>	
						<?php } ?>
					</div>	
					<?php } ?>
				</div>
			</div>
		</section>	
		<?php } ?>


		<?php 
		$row2 = get_field("row2"); 
		$row2_title1 = ( isset($row2['col1_title1']) && $row2['col1_title1'] ) ? $row2['col1_title1'] : '';
		$row2_title2 = ( isset($row2['col1_title2']) && $row2['col1_title2'] ) ? $row2['col1_title2'] : '';
		$row2_text1 = ( isset($row2['col1_content']) && $row2['col1_content'] ) ? $row2['col1_content'] : '';
		$row2_col2title = ( isset($row2['col2_title']) && $row2['col2_title'] ) ? $row2['col2_title'] : '';
		$row2_text2 = ( isset($row2['col2_content']) && $row2['col2_content'] ) ? $row2['col2_content'] : '';
		$row2_class = ($row2_text1 && $row2_text2) ? 'twoccol':'onecol';
		?>

		<?php if ( $row2_text1 || $row2_text2 ) { ?>
		<section class="contentrow arow2 <?php echo $row2_class ?>">
			<div class="wrapper">
				<div class="flexwrap">
					<?php if ($row2_text1) { ?>
					<div class="col col1">
						<?php if ($row2_title1) { ?>
						<h3 class="title-small"><?php echo $row2_title1 ?></h3>	
						<?php } ?>
						<?php if ($row2_title2) { ?>
						<h3 class="title-big"><?php echo $row2_title2 ?></h3>	
						<?php } ?>
						<div class="text"><?php echo $row2_text1 ?></div>
					</div>	
					<?php } ?>
					<?php if ($row2_text2) { ?>
					<div class="col col2 darkblue">
						<div class="text">
							<?php if ($row2_col2title) { ?>
							<h3 class="sub"><?php echo $row2_col2title ?></h3>	
							<?php } ?>
							<?php echo $row2_text2 ?>
						</div>
					</div>	
					<?php } ?>
				</div>
			</div>
		</section>	
		<?php } ?>


		<?php 
		$row3_image = get_field("row3_image");
		$row3_title1 = get_field("row3_title1");
		$row3_title2 = get_field("row3_title2");
		$row3_text = get_field("row3_text");
		if( ($row3_title1 || $row3_title2) ||  $row3_text || $row3_image ) { ?>
		<section class="contentrow arow3">
			<div class="wrapper-narrow">
				<div class="flexwrap">
					<?php if ($row3_image) { ?>
					<div class="r3col imagecol">
						<div class="image" style="background-image:url('<?php echo $row3_image['url'] ?>')">
							<img src="<?php echo $rectangle ?>" alt="" aria-hidden="true" class="placeholder">
						</div>
					</div>
					<?php } ?>

					<?php if ($row3_text) { ?>
					<div class="r3col textcol">
						<?php if ($row3_title1) { ?>
						<h3 class="title-small"><?php echo $row3_title1 ?></h3>	
						<?php } ?>
						<?php if ($row3_title2) { ?>
						<h3 class="title-big"><?php echo $row3_title2 ?></h3>	
						<?php } ?>
						<?php echo $row3_text ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</section>
		<?php } ?>


		<?php 
		$row4_title1 = get_field("row4_title1");
		$row4_title2 = get_field("row4_title2");
		$row4_text = get_field("row4_text");
		if( ($row4_title1 || $row4_title2) ||  $row4_text ) { ?>
		<section class="contentrow arow4">
			<div class="wrapper-narrow">
				<div class="flexwrap">
					<?php if ($row4_text) { ?>
					<div class="r3col textcol">
						<?php if ($row4_title1) { ?>
						<h3 class="title-small"><?php echo $row4_title1 ?></h3>	
						<?php } ?>
						<?php if ($row4_title2) { ?>
						<h3 class="title-big"><?php echo $row4_title2 ?></h3>	
						<?php } ?>
						<div class="text"><?php echo $row4_text ?></div>
					</div>
					<?php } ?>
				</div>
			</div>
		</section>
		<?php } ?>


		<?php
		$row5_title = get_field("row5_title");
		$row5_text = get_field("row5_text");
		$row5_button_name = get_field("row5_button_name");
		$row5_button_link = get_field("row5_button_link");
		if( $row5_title || $row5_text ) { ?>
		<section class="section-contact gray fw">
			<div class="wrapper text-center fadeIn wow">
				<div class="middle-line"></div>
				<?php if ($row5_title) { ?>
					<h2 class="sectiontitle"><?php echo $row5_title ?></h2>	
				<?php } ?>
				<?php if ($row5_text) { ?>
					<div class="sectiontext"><?php echo $row5_text ?></div>	
				<?php } ?>
				<?php if ($row5_button_name && $row5_button_link) { ?>
				<div class="button"><span class="btnspan"><a href="<?php echo $row5_button_link ?>" class="btnbg"><?php echo $row5_button_name ?></a></span></div>
				<?php } ?>	
			</div>
		</section>
		<?php } ?>
		
	
	<?php endwhile; ?><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
