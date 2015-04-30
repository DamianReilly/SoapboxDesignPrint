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

	
		<?php 
    		global $product, $post;
            $variations = $product->get_available_variations();
            foreach ($variations as $key => $value) {
        ?>
        <form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>"method="post" enctype='multipart/form-data'>
            <input type="hidden" name="variation_id" value="<?php echo $value['variation_id']?>" />
            <input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
            <?php
            if(!empty($value['attributes'])){
                foreach ($value['attributes'] as $attr_key => $attr_value) {
                ?>
                <input type="hidden" name="<?php echo $attr_key?>" value="<?php echo $attr_value?>">
                <?php
                }
            }
            ?>
            <table class="layout display responsive-table">
                <tbody>
                    <tr>
                        <td>
                            <b><?php
                            $value['attributes'] = array_map('ucwords', $value['attributes']);    
                            $value['attributes'] = str_replace('-', ' ', $value['attributes']);


                            echo implode(' ', $value['attributes'])

                            ;?></b>
                        </td>
                        <td>
                            <b><?php the_title();?></b>
                        </td>
                        <td>
                             <?php echo $value['price_html'];?>
                        </td>
                        <td>
                            <button type="submit" class="single_add_to_cart_button button alt"><?php echo apply_filters('single_add_to_cart_text', __( 'Add to cart', 'woocommerce' ), $product->product_type); ?></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        <?php
        }; ?>


	<?php // woocommerce_show_product_images();?>
	<?php woocommerce_output_related_products();?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

	<?php do_action( 'woocommerce_after_single_product' ); ?>

	</main>

	<?php // get_sidebar(); ?>

</section>

<div class="clearfloat"></div>
