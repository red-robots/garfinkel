<?php
/**
 * Template Name: Contact
 */

get_header(); 
$header_image = get_field("hero_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
global $post;
$slug = $post->post_name;
?>

<div id="primary" class="content-area contactpage default cf <?php echo $has_header_image ?>">
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
		
		<?php  
		$contact_form = get_field("contact_form");
		$column1 = get_field("column1");
		$shortcodes = array( "[company_name]", "[address]", "[email]", "[phone]", "[toll]", "[fax]" );
		if( $column1 ) {
			foreach($shortcodes as $a) {
				if (strpos($column1, $a) !== false) {
				    $fieldName = substr($a, 1, -1);
				    $fieldVal = get_field($fieldName,"option");
				    if($fieldVal) {
				    	$fieldVal = trim($fieldVal);
				    	if($fieldName=='email') {
				    		$element = '<span class="phnum">Email: <a href="mailto:'.antispambot($fieldVal,1).'" class="'.$fieldName.'">'.antispambot($fieldVal).'</a></span>';
				    	} 
				    	else if( $fieldName=='phone' ) {
				    		$element = '<span class="phnum '.$fieldName.'">Phone: <a href="tel:'.format_phone_number($fieldVal).'">'.$fieldVal.'</a></span>';
				    	} 
				    	else if( $fieldName=='fax' ) {
				    		$element = '<span class="phnum '.$fieldName.'">Fax: <a href="tel:'.format_phone_number($fieldVal).'">'.$fieldVal.'</a></span>';
				    	}  
				    	else if( $fieldName=='toll' ) {
				    		$element = '<span class="phnum '.$fieldName.'">Toll Free: <a href="tel:'.format_phone_number($fieldVal).'">'.$fieldVal.'</a></span>';
				    	} else {
				    		$element = '<span class="'.$fieldName.'">'.$fieldVal.'</span>';
				    	}
				    	$column1 = str_replace($a,$element,$column1);
				    } else {
				    	$column1 = str_replace($a,"",$column1);
				    }
				} else {

				}
			}
		}

		?>
		<?php $sectionClass = ($column1 && $contact_form) ? 'twocol':'full'; ?>
		<section class="contact-section fw <?php echo $sectionClass ?>">
			<div class="wrapper cf">
				<?php if ($column1) { ?>
				<div class="contactCol col1">
					<?php echo $column1 ?>
				</div>	
				<?php } ?>

				<?php if ($contact_form) { ?>
				<div class="contactCol col2 formCol">
					<?php echo $contact_form ?>
				</div>	
				<?php } ?>
			</div>
			<div class="diagonalStripes"></div>
		</section>
	
	<?php endwhile; ?><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
