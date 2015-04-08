<?php get_header(); ?>
<section class="page">
	<main>
		<?php if ( is_active_sidebar( 'content-top-widget-area' ) ) : ?>
			<div class="content-top-widget-container" role="complementary">
				<?php dynamic_sidebar( 'content-top-widget-area' ); ?>
			</div><!-- #primary-sidebar -->
		<?php endif; ?>
		
		<section class="header">
			<h1 class="entry-title"><?php _e( 'Category Archives: ', 'blankslate' ); ?><?php single_cat_title(); ?></h1>
			<?php if ( '' != category_description() ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . category_description() . '</div>' ); ?>
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