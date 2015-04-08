<?php get_header(); ?>

<div class="clearfloat"></div>

<section id="portfolio-top">
	<div class="portfolio-inner">
	<img class="portfolio-image aligncenter" src="/wp-content/themes/Soapbox_Digital_Media_v3/images/bunkered-fade.jpg" alt="Bunkered">
			<h1><?php the_title(); ?></h1>
	</div>
</section>



<?php get_template_part('templates/page', 'innercontent'); ?>

<section class="portfolio-inner-slider">

<div class="flexslider">
	  <ul class="slides">
	    <li>
	      <img class="aligncenter" src="/wp-content/themes/Soapbox_Digital_Media_v3/images/bunkered-slide.jpg" alt="Bunkered" />
	    </li>
	    <li>
	      <img class="aligncenter" src="/wp-content/themes/Soapbox_Digital_Media_v3/images/bunkered-laptop-casestudy.jpg" alt="Scottish Wedding Directory" />
	    </li>
	    <li>
	      <img class="aligncenter" src="/wp-content/themes/Soapbox_Digital_Media_v3/images/bunkered-casestudy-ipad.jpg" alt="Scottish Wedding Directory" />
	    </li>
	  </ul>
  </div>

</section>

<section class="inner-content wow fadeInUp">
  
  <main id="portfolio-main">
  	<img class="wow fadeInUp" src="/wp-content/themes/Soapbox_Digital_Media_v3/images/quotemarks.svg" onerror="this.onerror=null; this.src='/wp-content/themes/Soapbox_Digital_Media_v3/images/quotemarks.png'" alt="Testimonial">
  	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ac interdum sem, eget consequat dolor. Donec ac nibh sapien. Maecenas vitae fermentum ante. In sagittis fringilla justo, et cursus sapien dictum non. Donec ullamcorper eleifend nisl a pellentesque. Aliquam in quam leo. Fusce viverra eu ex at luctus. Pellentesque non efficitur tortor.</p>
  	<p><strong>Bryce Ritchie</strong></p>
  </main>
      
  <aside>
		<div class="inner-form">
		    <h3>LET'S WORK TOGETHER</h3>
		        <?php echo do_shortcode( '[contact-form-7 id="20" title="Contact form 1"]' ); ?>
		    <p></p>
		</div>
  </aside>

</section>

<div class="clearfloat"></div>
<?php get_template_part('templates/page', 'c2a'); ?>
<?php get_template_part('templates/page', 'innerservices'); ?>
<?php get_template_part('templates/page', 'testimonials'); ?>
<?php get_footer(); ?>