	</div><!-- #content -->
	
	<?php  
	$footlogo = get_field("footlogo","option");
	$address = get_field("address","option");
	$phone = get_field("phone","option");
	$toll = get_field("toll","option");
	$email = get_field("email","option");
	$contacts = array($address,$phone,$fax,$email);
	$other_info = get_field("other_info","option");
	$social_media = get_field("social_links","option");
	$social_icons = social_icons();
	$subscribe_text = get_field("subscribe_text","option");
	$subscribe_link = get_field("subscribe_link","option");
	?>
	<footer id="footer" class="site-footer fw" role="contentinfo">
		<div class="footer-content wrapper">
			<div class="footcol fcol1">
				<div class="footlogodiv">
					<?php if ($footlogo) { ?>
					<img src="<?php echo $footlogo['url'] ?>" alt="<?php echo $footlogo['title'] ?>" class="footlogo">	
					<?php } ?>
				</div>
			</div>

			<div class="footcol fcol2">
				<div class="footnavs">
					<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu','container_class'=>'footer-menu-wrap' ) ); ?>
				</div>
				<div class="contact-info">
				<?php if ($contacts && array_filter($contacts)) { ?>
					<?php if ($address) { ?>
					<div class="info address"><?php echo $address ?></div>
					<?php } ?>

					<?php if ($phone) { ?>
					<div class="info phone"><span>Phone:</span> <?php echo $phone ?></div>
					<?php } ?>
					<?php if ($toll) { ?>
					<div class="info toll"><span>Toll Free</span><?php echo $toll ?></div>
					<?php } ?>
					<?php if ($email) { ?>
					<div class="info email"><a href="mailto:<?php echo antispambot($email,1) ?>"><?php echo antispambot($email) ?></a></div>
					<?php } ?>
				<?php } ?>
				</div>
			</div>
		</div><!-- wrapper -->

		<div class="social-media-section fw">			
			<div class="wrapper">
				<div class="rightcol">
					<?php if ($subscribe_text && $subscribe_link) { ?>
						<span class="subscribetext info">
							<a href="<?php echo $subscribe_link ?>"><?php echo $subscribe_text ?></a>
						</span>
					<?php } ?>
					<?php if ($social_media) { ?>
						<span class="social-links info">
						<?php foreach ($social_media as $s) { 
							$socialLink = $s['link'];
							$socialIcon = '';
	                		$socialName = '';
	                		if($socialLink) { 
	                			$parts = parse_url($socialLink);
	                			$host = ( isset($parts['host']) && $parts['host'] ) ? str_replace('www.','',$parts['host']):'';
	                			$hostArrs = ($host) ? explode('.',$host):'';
	                			$domain = trim(strtolower($hostArrs[0]));
	                			if( array_key_exists($domain, $social_icons) ) {
	                				$socialIcon = $social_icons[$domain];
	                			}
	                			if($socialIcon) { ?>
	                			<a href="<?php echo $socialLink ?>" target="_blank"><i class="<?php echo $socialIcon ?>"></i><span class="sr"><?php echo $domain ?></span></a>
	                			<?php } ?>
							<?php } ?>
						<?php } ?>
						</span>
					<?php } ?>
				</div>
			</div>
			<span class="footstripes"></span>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
