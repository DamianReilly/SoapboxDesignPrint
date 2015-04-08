<section class="mobile-c2a">
  <a href="#inner-form" class="contact-button">
        £500 WEBSITE GRANT AVAILABLE<br>
        APPLY NOW <i class="fa fa-arrow-down"></i>
  </a>
</section>  

<section class="inner-slider">
    <?php if(is_page('web-design') || '152' == $post->post_parent ) : ?>
    	<h1 class="wow bounceInLeft"> <i class="fa fa-desktop"></i> <?php the_title(); ?></h1>
    <?php elseif (is_page('contact-us') )   : ?>
    	<h1 class="wow bounceInLeft"> <i class="fa fa-paper-plane"></i> <?php the_title(); ?></h1>
    <?php elseif (is_page('digital-marketing') || '153' == $post->post_parent )  : ?>
    	<h1 class="wow bounceInLeft"> <i class="fa fa-pie-chart"></i> <?php the_title(); ?></h1>	
    <?php elseif (is_page('social-media-marketing')  || '154' == $post->post_parent)  : ?>
    	<h1 class="wow bounceInLeft"> <i class="fa fa-comments"></i> <?php the_title(); ?></h1>	
    <?php elseif (is_page('about-us'))  : ?>
    	<h1 class="wow bounceInLeft"> <i class="fa fa-users"></i> <?php the_title(); ?></h1>
    <?php elseif (is_page('blog'))  : ?>
    	<h1 class="wow bounceInLeft"> <i class="fa fa-rss"></i> <?php the_title(); ?></h1>
    <?php elseif (is_single())  : ?>
        <h1 class="wow bounceInLeft"> <i class="fa fa-rss"></i> <?php the_title(); ?></h1>  		
    <?php elseif (is_page('thank-you'))  : ?>
    	<h1 class="wow bounceInLeft"> <i class="fa fa-check"></i> <?php the_title(); ?></h1>	
    <?php endif; ?>			
</section>