<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
// validation Visible columns PDF.
$af_imge                               = get_option( 'af_ips_show_product_picture' );
$ips_company_name                      = get_option( 'af_ips_template_content_field' );
$ips_company_detail                    = get_option( 'af_ips_company_details' );
$af_sku                                = get_option( 'af_ips_show_product_sku' );
$af_discrption                         = get_option( 'af_ips_show_short_description' );
$af_quantity                           = get_option( 'af_ips_show_quantity' );
$af_regular_price                      = get_option( 'af_ips_show_regular_price' );
$af_on_sale                            = get_option( 'af_ips_show_onsale_price' );
$af_price                              = get_option( 'af_ips_show_product_price' );
$af_total                              = get_option( 'af_ips_show_product_total' );
$af_tax                                = get_option( 'af_ips_show_tax' );
$af_toatl_inc_taxt                     = get_option( 'af_ips_show_total_inc_tax' );
$af_line_total                         = get_option( 'af_ips_show_line_total' );
$af_discount_pernt                     = get_option( 'af_ips_show_discount_percentage' );
$af_ips_show_note                      = get_option( 'af_ips_show_note' );
$af_ips_show_footer                    = get_option( 'af_ips_show_footer' );
$af_ips_template_bg_color              = get_option( 'af_ips_template_bg_color' );
$af_ips_template_header_color          = get_option( 'af_ips_template_header_color' );
$af_ips_template_header_text_color     = get_option( 'af_ips_template_header_text_color' );
$af_ips_customer_data_back_color       = get_option( 'af_ips_customer_data_back_color' );
$af_ips_table_customer_info_font_color = get_option( 'af_ips_table_customer_info_font_color' );
$af_ips_template_total_section_color   = get_option( 'af_ips_template_total_section_color' );
$af_ips_total_section_font_color       = get_option( 'af_ips_total_section_font_color' );
$af_ips_footer_back_color              = get_option( 'af_ips_footer_back_color' );
$af_ips_footer_font_color              = get_option( 'af_ips_footer_font_color' );
$af_ips_footer_content                 = get_option( 'af_ips_footer_content' );
$af_invoice_number_final               = get_option( 'af_ips_invoice_prefix' );
$invoice_billing_first_name            = $order->get_billing_first_name();
$invoice_shipping_first_name           = $order->get_shipping_first_name();
$customer_id                           = $order->get_customer_id();
$ips_customer                          = new WC_Customer( $customer_id );
$user                                  = $order->get_user();
$ips_username                          = $ips_customer->get_username(); // Get username
$ips_user_email                        = $ips_customer->get_email(); // Get account email
$ips_billing_postcode                  = $ips_customer->get_billing_postcode();
$ips_billing_country                   = $ips_customer->get_billing_country();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>

<style>
		.af-pdf-header{
			background-color: <?php echo esc_attr( $af_ips_template_header_color ); ?> !important;
			color: <?php echo esc_attr( $af_ips_template_header_text_color ); ?> !important;
		}
		.af-pdf-footer {
			background-color: <?php echo esc_attr( $af_ips_customer_data_back_color ); ?> !important;
			color: <?php echo esc_attr( $af_ips_table_customer_info_font_color ); ?> !important;
		}
		.af-subtotal-section {
			background-color: <?php echo esc_attr( $af_ips_template_total_section_color ); ?> !important;
			color: <?php echo esc_attr( $af_ips_total_section_font_color ); ?> !important;
		}
		.af-footer-bar {
			background-color: <?php echo esc_attr( $af_ips_footer_back_color ); ?> !important;
			color: <?php echo esc_attr( $af_ips_footer_font_color ); ?> !important;
		}
		.af-subtotal-section{
			margin-top: 30px !important;
		}
		.af-invoice-info-content {
			margin-top:20px !important;
		}
		.af-subtotal-section{
			margin-top: 30px !important;
		}
</style>

<body>
	<div class="af-pdf-wrapper">
		<section class="af-pdf-header">
			<div class="af-invoice-info">
				<div class="af-pdf-logo">
					<img src="<?php echo esc_url( $af_log_url ); ?>">
				</div>
				<div class="af-invoice-info-content">
					<h1><?php esc_html_e( 'Proforma', 'af_ips_invoices' ); ?></h1>
					<ul>
						<li><p><label><?php esc_html_e( 'Date', 'af_ips_invoices' ); ?></label><span><?php echo esc_attr( $af_invoice_date ); ?></span></p></li>
					</ul>
				</div>
			</div>
		</section>
		<section class="af-pdf-content">
			<table>
				<thead>
					<tr>
						<?php if ( $af_imge ) { ?>
						<th>&nbsp;</th>		 
						<?php } ?>
						<th><?php echo esc_html__( 'Product', 'af_ips_invoices' ); ?></th>
						<?php if ( $af_quantity ) { ?>
						<th><?php echo esc_html__( 'QTY', 'af_ips_invoices' ); ?></th>
						<?php } ?>
						<?php if ( $af_price ) { ?>
						<th><?php echo esc_html__( 'Price', 'af_ips_invoices' ); ?></th>
						<?php } ?>
						<?php if ( $af_regular_price ) { ?>
						<th><?php echo esc_html__( 'Regular Price', 'af_ips_invoices' ); ?></th>
						<?php } ?>
						<?php if ( $af_on_sale ) { ?>
						<th><?php echo esc_html__( 'Sale Price', 'af_ips_invoices' ); ?></th>
						<?php } ?>
						<?php if ( $af_total ) { ?>
						<th><?php echo esc_html__( 'Total', 'af_ips_invoices' ); ?></th>
						<?php } ?>
						<?php if ( $af_tax ) { ?>
						<th><?php echo esc_html__( 'Tax', 'af_ips_invoices' ); ?></th>
						<?php } ?>
						<?php if ( $af_toatl_inc_taxt ) { ?>
						<th><?php echo esc_html__( 'Total inc tax', 'af_ips_invoices' ); ?></th>
						<?php } ?>
						<?php if ( $af_line_total ) { ?>
						<th><?php echo esc_html__( 'line Total', 'af_ips_invoices' ); ?></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $order->get_items() as $item_id => $item ) {
						$product_id     = $item->get_product_id();
						$_product       = wc_get_product( $product_id );
						$product        = $item->get_product();
						$thumbnail      = $product->get_image( array( 100, 100 ) );
						$sku            = $product->get_sku();
						$product_name   = $item->get_name();
						$quantity       = $item->get_quantity();
						$subtotal       = $item->get_subtotal();
						$price_html     = $product->get_price();
						$regular_price  = $_product->get_regular_price();
						$sale_price     = $_product->get_sale_price();
						$price_incl_tax = wc_get_price_including_tax( $_product );
						$price_excl_tax = wc_get_price_excluding_tax( $_product );
						$af_tax1        = $price_incl_tax - $price_excl_tax;
						$tax_percentage = $af_tax1 / 100;
						$total          = $item->get_total();
						$total_inc_taxt = $af_tax1 + $total;
						$discription    = $product->get_short_description();
						?>
						<tr>
							<?php if ( $af_imge ) { ?>
							<td class="af-ip-pro-img">
								<?php echo wp_kses_post( $thumbnail ); ?>
							</td>
							<?php } ?>	
							<td class="product_sku_td"><span><?php echo wp_kses_post( $product_name ); ?></span><br>
							<?php
							if ( $af_sku ) {
								?>
							<small><?php echo wp_kses_post( $sku ); ?></small><br>
									<?php
							}
							?>
							</td>
							<?php if ( $af_quantity ) { ?>
							<td><?php echo wp_kses_post( $quantity ); ?></td>
							<?php } ?>

							<?php if ( $af_price ) { ?>
							<td><?php echo wp_kses_post( wc_price( $price_html ) ); ?></td>
							<?php } ?>
							<?php if ( $af_regular_price ) { ?>
							<td><?php echo wp_kses_post( wc_price( $regular_price ) ); ?></td>
							<?php } ?>
							<?php if ( $af_on_sale ) { ?>
							<td><?php echo wp_kses_post( wc_price( $sale_price ) ); ?></td>
							<?php } ?>
							<?php if ( $af_total ) { ?>
							<td><?php echo wp_kses_post( wc_price( $total ) ); ?></td>
							<?php } ?>
							<?php if ( $af_tax ) { ?>
							<td><?php echo wp_kses_post( wc_price( $af_tax1 ) ); ?></td>
							<?php } ?>
							<?php if ( $af_toatl_inc_taxt ) { ?>
							<td><?php echo wp_kses_post( wc_price( $total_inc_taxt ) ); ?></td>
							<?php } ?>
							<?php if ( $af_line_total ) { ?>
							<td><?php echo wp_kses_post( wc_price( $af_line_total ) ); ?></td>
							<?php } ?>
						</tr>
						<?php
					}//end foreach
					?>
						
				</tbody>
			</table>
		</section>
		<section class="af-pdf-content">
			<div class="af-subtotal-section">
				<table>
					<div class="af-pdf-logo"></div>
					<div class="af-invoice-info-content">
						<ul>
							<li><p><label><?php esc_html_e( 'Subtotal', 'af_ips_invoices' ); ?></label><font><?php echo wp_kses_post( wc_price( $af_subtotal ) ); ?></font></p></li>
							<li><p><label><?php esc_html_e( 'Discount', 'af_ips_invoices' ); ?></label><font><?php echo wp_kses_post( wc_price( $af_discount ) ); ?></font></p></li>
							<?php if ( $order->get_shipping_total() ) { ?>
							<li><p><label><?php echo esc_attr( $order->get_shipping_method() ); ?></label><font><?php echo wp_kses_post( wc_price( $order->get_shipping_total() ) ); ?></font></p></li>
							<?php } ?>
							<li><p class="af-total-label"><label><?php esc_html_e( 'Total', 'af_ips_invoices' ); ?></label><font><?php echo wp_kses_post( wc_price( $af_cart_total ) ); ?></font></p></li>
						</ul>
					</div>
				</table>
			</div>
		</section>	
		<section class="af-pdf-footer">
			<h4><?php echo esc_html__( 'Customer Details', 'af_ips_invoices' ); ?></h4>
			<ul>
				<li><p><label><?php echo esc_html__( 'Customer Name:', 'af_ips_invoices' ); ?></label> <span><?php echo esc_attr( $af_billing_first_name . ' ' . $af_billing_last_name ); ?></span></p></li>
				<li><p><label><?php echo esc_html__( 'Postcode / ZIP:', 'af_ips_invoices' ); ?></label><span><?php echo esc_attr( $ips_billing_postcode ); ?></span></p></li>
				<li><p><label><?php esc_html_e( 'Shipping Country:', 'af_ips_invoices' ); ?></label><span><?php echo esc_attr( $ips_billing_country ); ?></span></p></li>
				<li><p><label><?php esc_html_e( 'E-Mail:', 'af_ips_invoices' ); ?></label><span><?php echo esc_attr( $ips_user_email ); ?></span></p></li>
			</ul>
		</section>
			<?php if ( get_option( 'af_ips_show_note' ) ) { ?>
				<section id="invoice_note">
					<h3><?php echo esc_html__( 'Note:', 'af_ips_invoices' ); ?></h3>
					<p><?php echo esc_attr( get_option( 'af_ips_proforma_invoice_note_text' ) ); ?></p>
				</section>
			<?php	} ?>
			<?php if ( $af_ips_show_footer ) { ?>
				<div class="af-footer-bar">
					<p><?php echo esc_attr( get_option( 'af_ips_footer_content' ) ); ?></p>
				</div> 
			<?php } ?>
	</div>

</body>
</html>
