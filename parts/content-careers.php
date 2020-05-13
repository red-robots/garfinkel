<?php
$posts_per_page = -1;
$post_type = 'careers';
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
$args = array(
	'posts_per_page'=> $posts_per_page,
	'post_type'		=> $post_type,
	'post_status'	=> 'publish'
);
$allCareers = get_posts($args);
$exclude = array();
$careersList = array();
if($allCareers) {
	foreach($allCareers as $a) {
		$id = $a->ID;
		$responsibilities = get_field("responsibilities",$id);
		$requirements = get_field("requirements",$id); 
		$has_content = ($responsibilities || $requirements) ? true:false;
		if($has_content) {
			$careersList[] = $a;
		} else {
			$exclude[] = $id;
		}
	}
}
if($exclude) {
	$args['post__not_in'] = $exclude;
}
$careers = new WP_Query($args);
if ( $careers->have_posts() ) {  ?>
<section class="section-careers fw">
	<div class="section-title">Available Positions</div>
	<?php while ( $careers->have_posts() ) : $careers->the_post();  ?>
		<?php 
		$responsibilities = get_field("responsibilities");
		$requirements = get_field("requirements"); 
		?>
		<div class="career-info">
			<h2 class="jobtitle"><?php echo get_the_title(); ?> <span class="arrow"></span></h2>
			<div class="jobdescription">
				<?php if ($responsibilities) { ?>
				<div class="jobinfo responsibilities">
					<h2 class="sub">Responsibilities</h2>
					<div class="wrap"><?php echo email_obfuscator($responsibilities); ?></div>
				</div>	
				<?php } ?>

				<?php if ($requirements) { ?>
				<div class="jobinfo requirements">
					<h2 class="sub">Requirements</h2>
					<div class="wrap"><?php echo email_obfuscator($requirements); ?></div>
				</div>	
				<?php } ?>
			</div>
		</div>
	<?php endwhile; wp_reset_postdata(); ?>
</section>
<?php } ?>