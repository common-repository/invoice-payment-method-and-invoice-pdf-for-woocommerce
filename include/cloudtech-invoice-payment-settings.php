<?php
add_settings_section(
	'cloudtech_invoice_api_key_setting',
	__( 'Invoice Settings', 'cloudtech_wipo' ),
	'ha_gpt_general_callback',
	'cloudtech_invoice_admin_file_setting_section'
);
function ha_gpt_general_callback() { }
add_settings_field(
	'cloudtect_invoice_logo_url',
	__( 'Invoice Logo', 'cloudtech_wipo' ),
	'cloudtech_invoice_invoice_logo_callback',
	'cloudtech_invoice_admin_file_setting_section',
	'cloudtech_invoice_api_key_setting'
);
register_setting(
	'cloudtech_invoice_admin_file_setting_field',
	'cloudtect_invoice_logo_url'
);

function cloudtech_invoice_invoice_logo_callback() {
	$value = get_option( 'cloudtect_invoice_logo_url' );
	?>
	<input type="hidden" name="cloudtect_invoice_logo_url" id="cloudtect_invoice_logo_url" value="<?php echo esc_attr( $value ); ?>">
	<div class="flex">
		<?php
		if(!empty($value)):
			?>
			<p>
				<img src="<?php echo $value; ?>" name="img-url" height="100" width="100">
			</p>
			<?php
		endif;
		?>
		<button type="button" id="ka_gw_upload_gift_wrapper_img">
			Upload Image
		</button>
	</div>
	<?php
}