<section class="inner-content">
  
  <main>
  
  <div id="crumbs">
  	<?php the_post_breadcrumb(); ?>
  </div>	
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'entry' ); ?>
	<?php endwhile; endif; ?>
		<section class="related">
			<?php get_template_part('templates/post', 'related'); ?>
		</section>
  </main>
      
  <?php get_sidebar(); ?>

</section>

<div class="clearfloat"></div>