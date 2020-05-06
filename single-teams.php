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

			<?php 
			// $seminars = get_field("classesseminars");
			// $awards = get_field("honors_and_awards");
			// $works = get_field("published_works");

			$repeaterData['classesseminars'] = 'Classes/Seminars';
			$repeaterData['honors_and_awards'] = 'Honors and Awards';
			$repeaterData['published_works'] = 'Published Works';
			$repeaterData['certified_legal_specialties'] = 'Certified Legal Specialties';
			$repeaterData['bar_admissions'] = 'Bar Admissions';
			$repeaterData['education'] = 'Education';
			$repeaterData['professional_associations_and_memberships'] = 'Professional Associations and Memberships';
			$repeaterData['past_employment_positions'] = 'Past Employment Positions';
			$repeaterData['languages'] = 'Languages';
			$repeaterData['pro_bono_activities'] = 'Pro Bono Activities';
			$repeaterData['areas_of_practice'] = 'Areas of Practice';
			$noMarginBottomLists = array('education','honors_and_awards','professional_associations_and_memberships');
			?>

			

			<?php if ($repeaterData) { ?>
				<?php $ctr=1; foreach ($repeaterData as $fieldName => $tabName) { 
					$values = get_field($fieldName);
					$is_active = ($ctr==1) ? ' active':'';
					$show_content = ($ctr==1) ? ' style="display:block"':'';
					$list_style = ( in_array($fieldName, $noMarginBottomLists) ) ? ' style2':'';
					if($values) { ?>
					<div class="tabItem <?php echo $fieldName.$is_active ?>">
						<h2 class="tabName"><span><?php echo $tabName ?> <i class="arrow"></i></span></h2>

						<?php if($fieldName=='areas_of_practice') { ?>
						<div class="tabContent listinfo"<?php echo $show_content ?>>
							<ul class="list style2">
								<?php $n=1; foreach ($values as $v) { 
								$id = $v->ID;
								$title = $v->post_title;
								$link = get_permalink($id);
								$first = ($n==1) ? ' first':'';
								?>
								<li class="info<?php echo $first ?>">
									<a href="<?php echo $link ?>"><?php echo $title ?></a>
								</li>
								<?php $n++; } ?>
							</ul>
						</div>
						<?php } 


						else if($fieldName=='classesseminars') { ?>
						<div class="tabContent listinfo"<?php echo $show_content ?>>
							<ul class="list">
							<?php $n=1; foreach ($values as $v) { 
								$data = array_values($v);
								$textVal1 = ( isset($data[0]) && $data[0] ) ? $data[0] : '';
								$textVal1 = ($textVal1) ? preg_replace('/\s+/', ' ', $textVal1) : '';
								$boldTxt = '';
								$info = '';
								if($textVal1) {
									$parts = explode(",",$textVal1);
									$boldTxt = $parts[0] . ': ';
									$info = str_replace($parts[0].', ','',$textVal1);
									$first = ($n==1) ? ' first':'';
									?>
									<li class="info<?php echo $first ?>">
										<strong class="gold uppercase"><?php echo $boldTxt ?></strong> <?php echo $info ?>
									</li>
								<?php $n++; } ?>
							<?php } ?>
							</ul>
						</div>
						<?php }

						else { ?>

							<div class="tabContent listinfo"<?php echo $show_content ?>>
								<ul class="list<?php echo $list_style?>">
									<?php $n=1; foreach ($values as $v) { 
										$data = array_values($v);
										$textVal1 = ( isset($data[0]) && $data[0] ) ? $data[0] : '';
										$textVal2 = ( isset($data[1]) && $data[1] ) ? $data[1] : '';
										$first = ($n==1) ? ' first':'';
										$separator = ($textVal1 && $textVal2) ? ' ':'';
										if($fieldName=='education') {
											$textVal2 = '('.$textVal2.')';
										}
										if($textVal1 || $textVal2) { ?>
										<li class="info<?php echo $first ?>">
											<?php if ($textVal1) { ?>
												<span class="val1"><?php echo $textVal1 ?></span>
											<?php } ?>
											<?php echo $separator ?>
											<?php if ($textVal2) { ?>
												<span class="val2"><?php echo $textVal2 ?></span>
											<?php } ?>
										</li>
										<?php $n++; } ?>
									<?php } ?>
								</ul>
							</div>

						<?php } ?>

					</div>
					<?php $ctr++; } ?>
				<?php } ?>
			<?php } ?>
		</div>

	<?php endwhile; ?>
	</div>
</main><!-- #main -->

<script>
jQuery(document).ready(function($){
	$(".tabName").on("click",function(e){
		var parent = $(this).parents(".tabItem");
		parent.find(".tabContent").slideToggle();
		if( parent.hasClass("active") ) {
			parent.removeClass('active');
		} else {
			parent.addClass("active");
		}
	});
});
</script>

<?php get_footer(); ?>
