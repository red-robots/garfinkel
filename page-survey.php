<?php
/**
 * Template Name: Survey
 *
 */

get_header(); 
$header_image = get_field("hero_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
global $post;
$slug = $post->post_name;
?>

<div id="primary" class="content-area defaultTemplate cf <?php echo $has_header_image ?>">
	<main id="main" class="site-main cf wrapper" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php if (empty($header_image)) { ?>
			<header class="entry-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>
			<?php } ?>
			
			<?php
			$mainText = strip_tags(get_the_content());
			$mainText = preg_replace('/\s+/', '', $mainText);
			if (strpos($mainText, 'string(0)') !== false) {
			    $mainText = '';
			}
			?>
			<?php if ( $mainText ) { ?>
			<div class="entry-content cf">
				<?php the_content(); ?>
			</div>
			<?php } ?>

			<div class="survey-section">
				<script>(function(t,e,s,n){var o,a,c;t.SMCX=t.SMCX||[],e.getElementById(n)||(o=e.getElementsByTagName(s),a=o[o.length-1],c=e.createElement(s),c.type="text/javascript",c.async=!0,c.id=n,c.src="https://widget.surveymonkey.com/collect/website/js/tRaiETqnLgj758hTBazgdykkhU3oOfyoFlS7l5HmoRjA1WBkcjarTdPrqUMNUeue.js",a.parentNode.insertBefore(c,a))})(window,document,"script","smcx-sdk");</script>
				<!-- <script type="text/javascript" async="" id="smcx-sdk" src="https://widget.surveymonkey.com/collect/website/js/tRaiETqnLgj758hTBazgd_2Fh8Asn2222oTY9aiHhA71JuJmWalQkb56y90LzK_2F7uL.js"></script> -->
			</div>




		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->


<?php
get_footer();
