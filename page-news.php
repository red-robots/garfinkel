<?php
/**
 * Template Name: News
 */

get_header(); 
$header_image = get_field("hero_image"); 
$has_header_image = ($header_image) ? 'has-header-image':'no-header-image';
global $post;
$slug = $post->post_name;
?>

<div id="primary" class="content-area default cf <?php echo $has_header_image ?>">
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

		<?php endwhile; ?>

		<?php /* NEWS FEEDS */ ?>
		<div class="news-section-wrapper cf">
			<div class="news-inner cf">

				<?php  
				$posts_per_page = 9;
				$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
				$post_type = 'post';
				$posts = array();
				$total = 0;
				$total_text = '';
				$is_filtered = false;

				$args = array(
					'posts_per_page'=> $posts_per_page,
					'post_type'		=> $post_type,
					'post_status'	=> 'publish',
					'paged'			=> $paged,
					'orderby'       => 'date',       
				  	'order'         => 'DESC'
				);

				$all_args = array(
					'posts_per_page'=> -1,
					'post_type'		=> $post_type,
					'post_status'	=> 'publish',
				);

				$posts = get_posts($args);
				$all = get_posts($all_args);
				$total = count($all);

				if ( $posts ) {  ?>
				<div class="news-results">
					<?php if ($is_filtered) { ?>
					<div id="totalItems"><?php echo $total_text ?></div>	
					<?php } ?>
					<div id="newsContent">
						<div id="newsInner" class="flexwrap">
						<?php foreach($posts as $item) {
							$id = $item->ID;
							$content = strip_tags( $item->post_content );
							$content = ($content) ? shortenText($content,100,' ') : '';
							$thumbID = get_post_thumbnail_id($id);
							$img = ($thumbID) ? wp_get_attachment_image_src($thumbID,'large') : '';
							$imgAlt = ($img) ? get_the_title($thumbID) : '';
							?>
							<div class="fcol news animated fadeIn">
								<div class="inside">
									<?php if ( $img ) { ?>
									<div class="feat-image"><img src="<?php echo $img[0] ?>" alt="<?php echo $imgAlt ?>"></div>	
									<?php } else { ?>
									<div class="feat-image na"><img src="<?php echo $rectangle ?>" alt="" aria-hidden="true" class="placeholder"></div>
									<?php } ?>
									<div class="textwrap">
										<div class="postdate"><?php echo get_the_date('m/d/Y',$id) ?></div>
										<h3 class="posttitle"><a href="<?php echo get_permalink($id); ?>"><?php echo get_the_title($id); ?></a></h3>
										<div class="excerpt"><?php echo $content; ?></div>
									</div>
									<div class="button"><a href="<?php echo get_permalink($id); ?>" class="btnlink">Read More</a></div>
								</div>
							</div>
						<?php } wp_reset_postdata(); ?>
						</div>

						<?php 
						$total_pages = ceil($total / $posts_per_page);
						if($paged!=$total_pages) { ?>
						<div class="morediv text-center"><a href="#" id="loadmore" data-maxpagenum="<?php echo $total_pages ?>" data-nextpage="<?php echo $paged ?>" class="btngold">Load More Articles</a></div>
						<?php } else { ?>
						<!-- <div class="morediv text-center endpage"><span class="end">No more posts to load.</span></div> -->
						<?php } ?>

						<?php if ($total_pages > 1){ ?>
						<div id="pagination" class="pagination" style="display:none;">
				            <?php
				                $pagination = array(
				                    'base' => @add_query_arg('pg','%#%'),
				                    'format' => '?paged=%#%',
				                    'current' => $paged,
				                    'total' => $total_pages,
				                    'prev_text' => __( '&laquo;', 'red_partners' ),
				                    'next_text' => __( '&raquo;', 'red_partners' ),
				                    'type' => 'plain'
				                );
				                echo paginate_links($pagination);
				            ?>
				        </div>
						<?php } ?>

						
					</div>
				</div>
				<?php } else { ?>
					<div class="news-results notfound">
						<p><strong class="red">No record found.</strong></p>
					</div>
				<?php } ?>

			</div>
		</div>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
