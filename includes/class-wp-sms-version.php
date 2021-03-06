<?php
/**
 * WP SMS version class
 * 
 * @category   class
 * @package    WP_SMS
 */

class WP_SMS_Version {
	public $options;

	public function __construct() {
		global $wpsms_option;
		$this->options = $wpsms_option;

		// Check pro pack is enabled
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( !is_plugin_active( 'wp-sms-pro/wp-sms-pro.php' ) ) {
			add_filter('plugin_row_meta', array(&$this, 'pro_meta_links'), 10, 2);
			add_action('wp_sms_settings_page', array(&$this, 'pro_pack_message'));
			add_action('admin_enqueue_scripts', array(&$this, 'pro_pack_admin_assets'));
		}
	}

	public function pro_meta_links($links, $file) {
		if( $file == 'wp-sms/wp-sms.php' ) {
			$links[] = '<b><a href="http://wp-sms.ir/purchases" target="_blank" class="wpsms-plugin-meta-link" title="'. __('Get professional package!', 'wp-sms') .'">'. __('Get professional package!', 'wp-sms') .'</a></b>';
		}
		
		return $links;
	}

	public function pro_pack_message() {
		echo sprintf(__('<div class="update-nag">All features in this page enabled by Professional package. <a href="%s" target="_blank">Buy pro pack</a></div>', 'wp-sms'), WP_SMS_SITE . '/purchase');
	}

	public function pro_pack_admin_assets() {
		wp_enqueue_script('wpsms-pro-admin-js', WP_SMS_DIR_PLUGIN . 'assets/js/pro-pack.js', true, '1.0.0');
	}
}

new WP_SMS_Version();