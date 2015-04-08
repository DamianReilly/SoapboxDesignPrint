<?php get_header(); ?>
<section class="page">
	<main>
		<?php if ( is_active_sidebar( 'content-top-widget-area' ) ) : ?>
			<div class="content-top-widget-container" role="complementary">
				<?php dynamic_sidebar( 'content-top-widget-area' ); ?>
			</div><!-- #primary-sidebar -->
		<?php endif; ?>
		
		<section class="header">
			<h1 class="entry-title"><?php 
			if ( is_day() ) { printf( __( 'Daily Archives: %s', 'blankslate' ), get_the_time( get_option( 'date_format' ) ) ); }
			elseif ( is_month() ) { printf( __( 'Monthly Archives: %s', 'blankslate' ), get_the_time( 'F Y' ) ); }
			elseif ( is_year() ) { printf( __( 'Yearly Archives: %s', 'blankslate' ), get_the_time( 'Y' ) ); }
			else { _e( 'Archives', 'blankslate' ); }
			?></h1>
		</section>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'entry' ); ?>
		<?php endwhile; endif; ?>
		<?php get_template_part( 'nav', 'below' ); ?>

		<?php if ( is_active_sidebar( 'content-bottom-widget-area' ) ) : ?>
			<div class="content-bottom-widget-container" role="complementary">
				<?php dynamic_sidebar( 'content-bottom-widget-area' ); ?>
			</div><!-- #primary-sidebar -->
		<?php endif; ?>
	</main>
	<?php get_sidebar(); ?>
</section>

<?php get_footer(); ?>