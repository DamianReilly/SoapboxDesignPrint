<?php get_header(); ?>

<section class="page">
    <main>
      <?php if ( is_active_sidebar( 'content-top-widget-area' ) ) : ?>
      <div class="content-top-widget-container" role="complementary">
      <?php dynamic_sidebar( 'content-top-widget-area' ); ?>
      </div><!-- #primary-sidebar -->
      <?php endif; ?>

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php get_template_part( 'entry' ); ?>
      <?php comments_template(); ?>
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