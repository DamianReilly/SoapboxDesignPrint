<section id="testimonials">
	<!-- LOOP -->
	<?php $loop = new WP_Query( array( 'post_type' => 'testimonials', 'posts_per_page' => 1, 'orderby' => 'rand' ) ); ?>
  	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
  	<!-- SCHEMA MARK UP -->	
   	<div itemscope itemtype="http://schema.org/Review">
      <!-- RATING -->		  
     <div style="display: none;" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"> 
       <meta itemprop="worstRating" content = "1"/><span itemprop="ratingValue">5</span>/<span itemprop="bestRating">5</span> stars 
     </div>
      <!-- REVIEW TYPE -->	
      <div itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing"><p style="display: none;"><span itemprop="name"><?php echo bloginfo(); ?></span></p>
      </div>
      <!-- TESTIMONIAL -->	
      <img class="aligncenter wow fadeInUp" src="/wp-content/themes/Soapbox_Digital_Media_v3/images/quotemarks.svg" onerror="this.onerror=null; this.src='/wp-content/themes/Soapbox_Digital_Media_v3/images/quotemarks.png'" alt="Testimonial">
      <p class="wow fadeInUp"><span itemprop="reviewBody"><?php echo the_field('testimonials'); ?></span></p><br>
      <!-- AUTHOR -->	
 	  <div itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name"><strong><?php echo the_field('customer_name'); ?></strong></span></div><meta itemprop="datePublished" content = "<?php the_time('l, F jS, Y') ?>">
	  </div>
	  <!-- LOCATION -->	
      <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
       <span itemprop="addressLocality"><?php echo the_field('customer_location'); ?></span>
      </div>
	<?php endwhile; wp_reset_query(); ?>
</section>