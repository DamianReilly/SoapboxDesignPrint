<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>


<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<section class="inner-content">

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<main>

	<div class="summary entry-summary">
		<?php woocommerce_template_single_excerpt();?>
	</div><!-- .summary -->

	<div class="price-advice">
		
		<?php woocommerce_template_single_price(); ?>

		<p><i class="fa fa-arrow-down"></i> Get a price for your <?php the_title(); ?> right now.</p> 

			<?php woocommerce_template_single_add_to_cart(); ?>

	</div>
	<?php // woocommerce_show_product_images();?>
	<?php woocommerce_output_related_products();?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

	<?php do_action( 'woocommerce_after_single_product' ); ?>

	</main>

	<?php // get_sidebar(); ?>

</section>

<div class="clearfloat"></div>
