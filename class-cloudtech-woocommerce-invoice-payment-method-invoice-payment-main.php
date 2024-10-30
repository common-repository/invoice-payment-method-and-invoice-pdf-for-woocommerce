<?php
/**
 * Plugin Name:       Invoice Payment Method And Invoice PDF
 * Plugin URI:        https://cloudtechnologies.store/Invoice-payment-method-and-invoice-pdf
 * Description:       Allow your customers to select invoice payment method during checkout.
 * Version:           1.0.5
 * Author:            cloud Technologies
 * Developed By:      cloud Technologies
 * Author URI:        https://cloudtechnologies.store/
 * Support:           https://cloudtechnologies.store/
 * Domain Path:       /languages
 * TextDomain : cloudtech_wipo
 * WC requires at least: 3.0.9
 * WC tested up to: 8.*.*
 * Woo: 8518169:0d361fc1719d9e4fea2389399f7f6b5c
 *
/**
 * Define class.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class start.
 */
class Cloudtech_Invoice_Method_Option_Invoice_Payment_Main {

	public function __construct() {
		$this->cloudtech_wipoap_global_constents_vars();

		add_action( 'plugins_loaded', array( $this, 'cloudtech_wipo_init' ) );
		add_action( 'init', array( $this, 'cloudtech_wipo_init_callback' ) );
	}
	public function cloudtech_wipo_init() {

			// Check the installation of WooCommerce module if it is not a multi site.
		if ( ! is_multisite() && ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {

			add_action( 'admin_notices', array( $this, 'cloudtech_wipo_check_wocommerce' ) );
		}
	}
	public function cloudtech_wipo_check_wocommerce() {
			// Deactivate the plugin.
		deactivate_plugins( __FILE__ );
		?>
		<div id="message" class="error">
			<p>
				<strong>
					<?php esc_html_e( 'Invoice Payment Option And Invoice PDF plugin is inactive. WooCommerce plugin must be active in order to activate it.', 'cloudtech_wipo' ); ?>
				</strong>
			</p>
		</div>
		<?php
	}

	public function cloudtech_wipo_init_callback() {

		if ( defined( 'WC_PLUGIN_FILE' ) ) {

			$this->cloudtech_wipoap_register_custom_post();
			add_filter( 'woocommerce_payment_gateways', array( $this, 'cloudtech_wipoap_creat_object_gateway' ), 999999 );
			add_filter( 'woocommerce_available_payment_gateways', array( $this, 'cloudtech_wipoap_woocs_filter_payment_gateways' ), 999999 );
			add_action( 'wp_loaded', array( $this, 'ct_if_include_gateway_class' ), 999999 );
			add_action( 'wp_loaded', array( $this, 'cloudtech_wipoap_lang_load' ) );

			add_action( 'before_woocommerce_init', array( $this, 'cloudtech_wipoap_HOPS_Compatibility' ) );

			if ( is_admin() ) {
				include_once CLOUDTECH_WIPOAP_PLUGIN_DIR . 'class-cloudtech-wipoap-admin.php';
			}
			include_once CLOUDTECH_WIPOAP_PLUGIN_DIR . 'include/class-cloudtech-wipoap-shipping-virtual.php';
			include_once CLOUDTECH_WIPOAP_PLUGIN_DIR . 'include/class-cloudtech-wipoap-cart-items-check.php';
			include_once CLOUDTECH_WIPOAP_PLUGIN_DIR . 'include/class-cloudtech-wipoap-location-check.php';

		}
	}

	/**
	 * High Performance orders compatibility
	 *
	 * @return void
	 */
	public function cloudtech_wipoap_HOPS_Compatibility() {

		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}


	public function cloudtech_wipoap_register_custom_post() {
		$labels = array(
			'name'           => __( 'Invoice Payment Option', 'cloudtech_wipo' ),
			'singular_name'  => __( 'Invoice Payment Option', 'cloudtech_wipo' ),
			'menu_name'      => __( 'Invoice Payment Option', 'cloudtech_wipo' ),
			'name_admin_bar' => __( 'Invoice Payment Option', 'cloudtech_wipo' ),
			'add_new'        => __( 'Add New', 'cloudtech_wipo' ),
			'add_new_item'   => __( 'Add New Rule', 'cloudtech_wipo' ),
			'new_item'       => __( 'New Rule', 'cloudtech_wipo' ),
			'edit_item'      => __( 'Edit Rule', 'cloudtech_wipo' ),
			'view_item'      => __( 'View Rule', 'cloudtech_wipo' ),
			'all_items'      => __( 'Invoice Payment Method and Invoice PDF', 'cloudtech_wipo' ),
			'search_items'   => __( 'Search Rules', 'cloudtech_wipo' ),
			'not_found'      => __( 'No Rule created.', 'cloudtech_wipo' ),
		);
		$args   = array(
			'supports'            => array( 'title' ),
			'labels'              => $labels,
			'public'              => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'payment_gateway' ),
			'has_archive'         => true,
			'hierarchical'        => false,
			'menu_icon'           => plugins_url( 'include/images/addifylogo.png', __FILE__ ),
			'show_ui'             => true,
			'can_export'          => true,
			'exclude_from_search' => false,
			'show_in_menu'        => 'woocommerce',
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
		register_post_type( 'payment_gateway', $args );
	}

	public function ct_if_include_gateway_class() {
		include_once CLOUDTECH_WIPOAP_PLUGIN_DIR . 'class-cloudtech-wipoap-invoice-payment-gateway.php';
	}

	public function cloudtech_wipoap_woocs_filter_payment_gateways( $gateway_list ) {
		if ( ! is_checkout() ) {
			return $gateway_list;
		}
		if ( isset( $_POST['woocommerce-process-checkout-nonce'] ) ) {

			return $gateway_list;
		}

		if ( isset( $_POST['security'] ) ) {
			check_ajax_referer( 'update-order-review', 'security' );
		}

		$gateways         = WC()->payment_gateways->payment_gateways();
		$enabled_gateways = array();
		$flag             = false;

		if ( $gateways ) {
			foreach ( $gateways as $gateway ) {

				if ( 'yes' == $gateway->enabled ) {
					if (
						'Invoice Payments' == $gateway->method_title ) {
						$flag = true;

					}
				}
			}
		}

		if ( false == $flag ) {

			$form_data    = $_POST;
			$af_check_res = new Cloudtech_Wipoap_Shipping_Virtual();
			$payment_rule = $af_check_res->get_py_ig_all_rules( $form_data );
			if ( ! $payment_rule ) {
				unset( $gateway_list['invoice'] );
				return $gateway_list;
			} else {
				if ( ! isset( $gateway_list['invoice'] ) ) {
					$gateway_list['invoice'] = new Cloudtech_Wipoap_Inovice_Pyament_Gateway();
				}
				return $gateway_list;
			}
		} else {
			return $gateway_list;
		}
	}
	public function cloudtech_wipoap_creat_object_gateway( $methods ) {

		$methods[] = 'Cloudtech_Wipoap_Inovice_Pyament_Gateway';
		return $methods;
	}

	public function cloudtech_wipoap_global_constents_vars() {
		if ( ! defined( 'CLOUDTECH_WIPOAP_URL' ) ) {
			define( 'CLOUDTECH_WIPOAP_URL', plugin_dir_url( __FILE__ ) );
		}
		if ( ! defined( 'CLOUDTECH_WIPOAP_BASENAME' ) ) {
			define( 'CLOUDTECH_WIPOAP_BASENAME', plugin_basename( __FILE__ ) );
		}
		if ( ! defined( 'CLOUDTECH_WIPOAP_PLUGIN_DIR' ) ) {
			define( 'CLOUDTECH_WIPOAP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}
	}
	public function cloudtech_wipoap_lang_load() {
		if ( function_exists( 'load_plugin_textdomain' ) ) {
			load_plugin_textdomain( 'cloudtech_wipo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}
	}
}

if ( class_exists( 'Cloudtech_Invoice_Method_Option_Invoice_Payment_Main' ) ) {
	new Cloudtech_Invoice_Method_Option_Invoice_Payment_Main();
}
