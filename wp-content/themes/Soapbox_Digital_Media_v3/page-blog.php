<?php
/*
Template Name: News Loop
*/
?>
<?php get_header(); ?>
<?php get_template_part('templates/page', 'innerslider'); ?>
<section class="inner-content">
	<main>
		<?php $loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 10, 'orderby' => 'date' ) ); ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<div class="news-loop-left">
						<?php if ( has_post_thumbnail() ) :?>
							<?php the_post_thumbnail( 'thumbnail' ); ?><br>
						<?php else :?>
							<img class="aligncenter" src="<?php bloginfo('template_url'); ?>/images/thumb.jpg" /><br>
						<?php endif;?>
					</div>
					<div class="news-loop-right">	
						<h2><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
						<p><i class="fa fa-clock-o"></i> Posted on <?php the_time( get_option( 'date_format' ) ); ?> by <?php the_author(); ?></p>
						<p><a href="<?php echo the_permalink(); ?>">READ MORE &#8594;</a></p>
					</div>

					<div class="clearfloat"></div>
				<br>

		<?php endwhile; wp_reset_query(); ?>
	</main>
	<?php get_sidebar(); ?>
</section>

<div class="clearfloat"></div>

<?php get_template_part('templates/page', 'c2a'); ?>
<?php get_template_part('templates/page', 'innerservices'); ?>
<?php get_template_part('templates/page', 'testimonials'); ?>
<?php get_footer(); ?>	