<aside>

	<!-- FORM -->
	<?php if(!is_singular('portfolio')) : ?>
		<div id="inner-form">
		    <?php if( is_page('contact-us') ) : ?>
		    	<h3>CONTACT US</h3>
		    <?php else : ?>
		    	<h3>ASK THE EXPERTS</h3>
		   	<?php endif ; ?>
		        <?php echo do_shortcode( '[contact-form-7 id="20" title="Contact form 1"]' ); ?>
		</div>
	<?php endif; ?>

	<!-- PORTFOLIO SERVICES -->
	<?php if(is_singular('portfolio')) : ?>
		<div class="portfolio-services wow fadeInRight">	
	    <h3>SERVICES</h3>
		    <ul>
		    	<li><?php echo the_field('service_item_1'); ?></li>
		    	<li><?php echo the_field('service_item_2'); ?></li>
		    	<li><?php echo the_field('service_item_3'); ?></li>
		    </ul>
		    <a href="<?php echo the_field('site_url'); ?>" target="_blank" class="launch-site">VIEW THE SITE LIVE &#8594;</a>
	    </div>
	<?php endif; ?>


	<!-- TOP PICKS -->
	<?php global $post;

	$currentID = get_the_ID();
	$slug = get_permalink( $post->post_parent ); ?>

	<?php query_posts(array('category_name' => $slug, 'posts_per_page' => 3, 'orderby' => 'rand', 'post__not_in' => array($currentID))); ?>
	<?php if ( have_posts() ) : ?>
		<div class="top-picks">
 
		<h3>TOP PICKS</h3>
			<div class="divider-line aligncenter"></div>
		<br>
	<?php endif;?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h2><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
			<p><a href="<?php echo the_permalink(); ?>">READ MORE &#8594;</a></p>
		<div class="clearfloat"></div>
		<br>
	</div>
	<?php endwhile; endif; ?>
	<?php wp_reset_query(); ?>

</aside>


