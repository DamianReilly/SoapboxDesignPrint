<section class="inner-content">
  

  <main>

    <?php wordpress_breadcrumbs(); ?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<section class="entry-content wow fadeInLeft">
				<?php the_content(); ?>
			</section>
		</article>
	<?php endwhile; endif; ?>

	<?php global $post;
	$slug = get_permalink( $post->post_parent ); ?>

	<?php query_posts(array('category_name' => $slug, 'posts_per_page' => 3)); ?>
	
	<?php if ( have_posts() ) : ?>
		<h3 class="related-title">RELATED ARTICLES</h3>
	<?php endif;?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
   		<div class="news-loop-left">
		<?php if ( has_post_thumbnail() ) :?>
			<div class="thumbcenter"><?php the_post_thumbnail( 'thumbnail' ); ?></div><br>
		<?php else :?>
			<img class="aligncenter" src="<?php bloginfo('template_url'); ?>/images/thumb.jpg" /><br>
		<?php endif;?>
		</div>
		<div class="news-loop-right">	
			<h2><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
			<p><a href="<?php echo the_permalink(); ?>">READ MORE &#8594;</a></p>
		</div>
		<div class="clearfloat"></div>
		<br>
	<?php endwhile; endif; ?>

	<?php wp_reset_query(); ?>

  	</main>
      
  <?php get_sidebar(); ?>

</section>

<div class="clearfloat"></div>