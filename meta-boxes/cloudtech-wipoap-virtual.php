<?php
/**
 * Extra fee
 *
 * Displays the meta box for payment-invoice, virtual products-enable/disbale, shipping methods
 *
 * @package  Cloudtech-invoice-gateway/meta-boxes
 * @version  1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get Post Meta.

$ship_method = (array)( get_post_meta( get_the_ID(), 'cloudtech_wipoap_shipping', true ) );
$ship_method = is_array( $ship_method ) ? $ship_method : array();
?>
<div class="extra-fee">
	<?php wp_nonce_field( 'cloudtech_wipoap_nonce_action', 'cloudtech_wipoap_field_nonce' ); ?>
	<table class="Cloudtech-table-optoin">
		<tr class="Cloudtech-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Select Shipping Methods', 'cloudtech_wipo' ); ?>
					</h3>
				</div>
			</th>
			<td>
			<?php

				$shipping_methods = array();
			foreach ( WC()->shipping()->load_shipping_methods() as $method ) {
				$shipping_methods[ $method->id ] = $method->get_method_title();
			}
			?>
				<div>
				<?php
				foreach ( $shipping_methods as $key => $value ) {
					?>
					<p><input type="checkbox" name="cloudtech_wipoap_shipping[]" value="<?php echo esc_attr( $key ); ?>" <?php echo in_array( (string) $key, $ship_method, true ) ? 'checked' : ''; ?> >
					<?php echo esc_attr( $value ); ?> </p> 
								<?php
				}
				?>
				</div>
				<p><?php echo esc_html__( 'Show Invoice on shipping method bases. Leave empty for all', 'cloudtech_wipo' ); ?></p>
			</td>
		</tr>
		
	</table>
</div>
