<?php $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 3, 'post__not_in' => array($post->ID), 'orderby' => 'rand' ) );
		if( $related ) foreach( $related as $post ) { setup_postdata($post); ?>
			<h3 class="related-title">RELATED ARTICLES</h3>
	<?php }
wp_reset_postdata(); ?>

<?php $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 3, 'post__not_in' => array($post->ID), 'orderby' => 'rand' ) );
		if( $related ) foreach( $related as $post ) { setup_postdata($post); ?>
			<div class="news-loop-left">
		<?php if ( has_post_thumbnail() ) :?>
			<div class="thumbcenter"><?php the_post_thumbnail( 'thumbnail' ); ?></div><br>
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
	<?php }
wp_reset_postdata(); ?>