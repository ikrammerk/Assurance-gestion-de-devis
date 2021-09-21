<?php
/**
 * Displays header cart button
 * @since Business Gravity 1.0.0
 */
?>

<?php if( class_exists( 'WooCommerce' ) ): ?>
	<span class="cart-icon">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
			<span class="kfi kfi-cart-alt"></span>
			<span class="count">
				<?php echo absint( WC()->cart->get_cart_contents_count() ); ?>
			</span>
		</a>
	</span>
<?php endif; ?>