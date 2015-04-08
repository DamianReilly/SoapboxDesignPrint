<?php get_header(); ?>

<section class="mobile-c2a">
  <a href="#inner-form"class="contact-button">
        NEED AN ENGAGING WEBSITE?<br>
        LET'S GET TOGETHER <i class="fa fa-arrow-down"></i>
  </a>
</section>

<div class="clearfloat"></div>

<section id="portfolio-top">
	<div class="portfolio-inner">
	
		<?php 

			$image = get_field('main_image');

			if( !empty($image) ): ?>

			<img class="portfolio-image aligncenter" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

		<?php endif; ?>
		
		<h1><?php the_title(); ?></h1>
	
	</div>
</section>



<?php get_template_part('templates/page', 'innercontent'); ?>

<section class="portfolio-inner-slider">

<div class="flexslider">
	  <ul class="slides">
	    <li>

		    <?php 

				$slide_image_1 = get_field('slider_image_1');

				if( !empty($slide_image_1) ): ?>

				<img class="aligncenter" src="<?php echo $slide_image_1['url']; ?>" alt="<?php echo $slide_image_1['alt']; ?>" />

			<?php endif; ?>

	    </li>
	    <li>
	      	<?php 

				$slide_image_2 = get_field('slider_image_2');

				if( !empty($slide_image_2) ): ?>

				<img class="aligncenter" src="<?php echo $slide_image_2['url']; ?>" alt="<?php echo $slide_image_2['alt']; ?>" />

			<?php endif; ?>
	    </li>
	    <li>
		
			<?php 

				$slide_image_3 = get_field('slider_image_3');

				if( !empty($slide_image_3) ): ?>

				<img class="aligncenter" src="<?php echo $slide_image_3['url']; ?>" alt="<?php echo $slide_image_3['alt']; ?>" />

			<?php endif; ?>
	    
	    </li>
	  </ul>
  </div>

</section>

<section class="inner-content wow fadeInUp">
  
  <main id="portfolio-main">
  	<img class="wow fadeInUp" src="/wp-content/themes/Soapbox_Digital_Media_v3/images/quotemarks.svg" onerror="this.onerror=null; this.src='/wp-content/themes/Soapbox_Digital_Media_v3/images/quotemarks.png'" alt="Testimonial">
  	<p><?php echo the_field('client_testimonial'); ?></p>
  	<p><strong><?php echo the_field('client_name'); ?></strong></p>
  </main>
      
  <aside>
		<div id="inner-form">
		    <h3>LET'S WORK TOGETHER</h3>
		        <?php echo do_shortcode( '[contact-form-7 id="20" title="Contact form 1"]' ); ?>
		    <p></p>
		</div>
  </aside>

</section>

<div class="clearfloat"></div>

<section class="related">
	<?php

	$currentID = get_the_ID();
	$args = array(
		'post_type' => 'portfolio', 
		'posts_per_page' => 3, 
		'orderby' => 'rand',
		'post__not_in' => array($currentID)
	);
	$portfolio = new WP_Query($args); 
?>

<?php if( $portfolio->have_posts() ) : ?>

	<h2>MORE CASE STUDIES</h2>
	<div class="divider-line aligncenter"></div>

	<ul class="related-cs">

	<?php while ( $portfolio->have_posts() ) : $portfolio->the_post(); ?>
	    <li>
	    	<a href="<?php echo the_permalink(); ?>">
	    	<?php the_post_thumbnail( 'thumbnail' ); ?>
	    	<h4><?php echo the_title(); ?></h4>
	    	<a href="<?php echo the_permalink(); ?>">Read More &#8594;</a>
	    	</a>
	    </li>
	<?php endwhile; wp_reset_query(); ?>

	<?php endif; ?>

	</ul>
</section>

<?php get_template_part('templates/page', 'c2a'); ?>
<?php get_template_part('templates/page', 'innerservices'); ?>
<?php get_template_part('templates/page', 'testimonials'); ?>
<?php get_footer(); ?>