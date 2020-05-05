<?php 
$post_id = get_the_ID();
$jobtitle = get_field("title",$post_id);
$photo = get_field("image",$post_id);
get_header(); 
?>

<?php if ($photo) { ?>
<div class="teamPicWrap">
	<div class="wrapper" style="background-image:url('<?php echo $photo['url'] ?>')">
		<img src="<?php echo $photo['url'] ?>" alt="<?php echo $photo['title'] ?>" class="teamPic" />
	</div>
</div>		
<?php } ?>

<header class="single-header fw">
	<div class="wrapper">
		<div class="titlediv">
			<h1 class="page-title"><?php echo get_the_title(); ?></h1>
			<?php if ($jobtitle) { ?>
			<div class="jobtitle"><?php echo $jobtitle ?></div>	
			<?php } ?>
		</div>
	</div>
</header>

<main id="main" class="site-main fw" role="main">

	<div class="wrapper medium-large">
	<?php while ( have_posts() ) : the_post(); 
		$photo = get_field("image");
		$style_photo = ($photo) ? ' style="background-image:url('.$photo['url'].')"':'';
		$photo_class = ($photo) ? 'haspic':'nopic';
		$first = ($i==1) ? ' first':'';
		$square = THEMEURI . 'images/square.png';

		$phone = get_field("phone");
		$fax = get_field("fax");
		$email = get_field("email_address");
		$bio = get_field("bio");
		?>

		<div class="leftcol">

			<div class="topinfo">
				<?php if($phone) { ?>
				<div class="contactinfo">
					<div class="t1">Phone:</div>
					<div class="t2"><a href="tel:<?php echo format_phone_number($phone); ?>"><?php echo $phone ?></a></div>
				</div>
				<?php } ?>
				<?php if($fax) { ?>
				<div class="contactinfo">
					<div class="t1">Fax:</div>
					<div class="t2"><a href="tel:<?php echo format_phone_number($fax); ?>"><?php echo $fax ?></a></div>
				</div>
				<?php } ?>
				<?php if($email) { ?>
				<div class="contactinfo">
					<div class="t1">Email:</div>
					<div class="t2"><a href="mailto:<?php echo antispambot($email,1); ?>"><?php echo antispambot($email); ?></a></div>
				</div>
				<?php } ?>
			</div>

			<?php if($bio) { ?>
			<div class="bio">
				<?php echo $bio ?>
			</div>
			<?php } ?>
		</div>

	<?php endwhile; ?>
	</div>
</main><!-- #main -->

<?php
get_footer();
