<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

get_header(); 
$obj = get_queried_object();
$term_id = $obj->term_id;
$term_name = $obj->name;
$term_description = $obj->description;
$term_description = ( get_field("taxdescription",$obj) ) ? get_field("taxdescription",$obj) : $obj->description;
$taxonomy = $obj->taxonomy;
$page_title = $term_name;
$header_image = '';
if($taxonomy=='team-groups') {
$header_image = get_field("team_header_image","option"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
$page_title = get_field("team_pagetitle","option");
$page_title .= '<br><em>'.$term_name.'</em>';
}
?>
<?php /* BANNER */ ?>
<?php if( $header_image ) {  ?>
<div id="static-banner" class="banner-wrap fw subpage">
	<div class="banner-image cf fadeIn animated" style="background-image:url('<?php echo $header_image['url']; ?>');">
		<div class="wrapper">
			<div class="caption">
				<h1 class="page-title fadeInRight wow"><?php echo $page_title ?></h1>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<div id="primary" class="content-area default cf <?php echo  $taxonomy?>">
	<main id="main" class="site-main cf" role="main">
		
		<?php if ( empty($header_image) ) { ?>
		<header class="entry-header">
			<div class="wrapper">
				<h1 class="page-title"><?php echo $page_title; ?></h1>
			</div>
		</header>
		<?php } ?>

		<?php
		$mainText = '';
		if( $term_description ) {
			$mainText = strip_tags($term_description);
			$mainText = preg_replace('/\s+/', '', $mainText);
			if (strpos($mainText, 'string(0)') !== false) {
			    $mainText = '';
			}
		} 
		?>
		<?php if ( $mainText ) { ?>
		<section class="maintext fw fadeIn wow" data-wow-delay=".3s">
			<div class="wrapper fadeIn wow">
				<?php echo $term_description; ?>
			</div>
		</section>
		<?php } ?>


		<?php if($taxonomy=='team-groups') { ?>
			<?php  
			$args = array(
				'posts_per_page'=> -1,
				'post_type'		=> 'teams',
				'post_status'	=> 'publish',
				'tax_query' => array(
				    array(
					    'taxonomy' => $taxonomy,
					    'field' => 'term_id',
					    'terms' => $term_id
				     )
				  )
			);
			$teams = new WP_Query($args);
			$placeholder = THEMEURI . 'images/square.png';
			if ( $teams->have_posts() ) {  ?>
			<div class="team-lists fw">
				<div class="wrapper">
					<div class="flexwrap fadeIn wow" data-wow-delay=".5s">
					<?php $i=1; while ( $teams->have_posts() ) : $teams->the_post();  
						$photo = get_field("image");
						$jobtitle = get_field("title");
						$teamName = get_the_title();
						$photoBg = ($photo) ? ' style="background-image:url('.$photo['sizes']['medium_large'].')"':'';
						$delay = $i;
						?>
						<div class="team">
							<div class="wrap">
								<div class="photo <?php echo ($photo) ? 'haspic':'nopic'; ?>"<?php echo $photoBg ?>>
									<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
								</div>
								<div class="info">
									<div class="name"><?php echo $teamName ?></div>
									<?php if ($jobtitle) { ?>
									<div class="jobtitle"><?php echo $jobtitle ?></div>	
									<?php } ?>
								</div>
								<div class="button">
									<a href="<?php echo get_permalink(); ?>" class="btnbg-arrow">Read Bio</a>
								</div>
							</div>
						</div>
					<?php $i++; endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
			<?php } ?>
		<?php } ?>
		

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
