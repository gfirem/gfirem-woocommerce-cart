<?php
/**
 *  @package           GFireMWooCart
 *
 * @wordpress-plugin
 *
 * Plugin Name:       GFireM WooCommerce Cart
 * Description:       Integrate Formidable Forms to send product to the Woo Cart and Checkout.
 * Version:           1.0.0
 * Author:            GFireM Dev Team
 * License:           Apache License 2.0
 * License URI:       http://www.apache.org/licenses/
 * Text Domain: gfirem-woo-cart
 * Domain Path: /languages
 *
 *****************************************************************************
 * WC requires at least: 3.5.0
 * WC tested up to: 3.5.2
 *****************************************************************************
 */
if (! defined('WPINC')) {
    die;
}

if (! class_exists('GFireMWooCart')) {
    class GFireMWooCart
    {
        public static $assets;

        public static $view;

        public static $classes;

        public static $slug = 'gfirem-woo-cart';

        public static $version = '1.0.0';

        /**
         * Instance of this class.
         *
         * @var object
         */
        protected static $instance = null;

        /**
         * Initialize the plugin.
         */
        private function __construct()
        {
            $this->load_plugin_textdomain();
            self::$assets = plugin_dir_url(__FILE__) . 'assets/';
            self::$view = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;
	        if ( ! class_exists( 'GFireMWooCartDependencies' ) ) {
		        require_once 'classes/class-gfirem-woo-cart-dependencies.php';
	        }
	        if ( ! class_exists( 'GFireMWooCartLog' ) ) {
		        require_once 'classes' . DIRECTORY_SEPARATOR . 'class-gfirem-woo-cart-log.php';
	        }
            new GFireMWooCartLog();
            try {
                if (class_exists('FrmAppHelper') && method_exists('FrmAppHelper', 'pro_is_installed')
                && FrmAppHelper::pro_is_installed() && GFireMWooCartDependencies::woocommerce_active_check()) {
                	//TODO add check for Woocommerce
                    add_action('frm_registered_form_actions', array($this, 'register_action'));
                    require_once 'classes' . DIRECTORY_SEPARATOR . 'class-gfirem-woo-cart-admin.php';
                    new GFireMWooCartAdmin();
                    require_once 'classes' . DIRECTORY_SEPARATOR . 'class-gfirem-woo-cart-action.php';
                    new GFireMWooCartAction();
                    require_once 'classes' . DIRECTORY_SEPARATOR . 'class-gfirem-woo-cart-handler.php';
                    new GFireMWooCartHandler();
                } else {
                    add_action('admin_notices', array($this, 'requirements_error_notice'));
                }
            } catch (Exception $ex) {
                GFireMWooCartLog::log(array(
                    'action' => 'loading_dependency',
                    'object_type' => self::getSlug(),
                    'object_subtype' => static::class,
                    'object_name' => $ex->getMessage(),
                ));
            }
        }

        /**
         * Register action
         *
         * @return mixed
         */
        public function register_action($actions)
        {
            $actions['gfirem-woo-cart'] = 'GFireMWooCartAction';
            include_once 'classes/class-gfirem-woo-cart-action.php';

            return $actions;
        }

        public function requirements_error_notice()
        {
            require self::$view . 'requirement_notice.php';
        }

        /**
         * Get plugin version.
         *
         * @return string
         */
        public static function getVersion()
        {
            return self::$version;
        }

        /**
         * Get plugins slug.
         *
         * @return string
         */
        public static function getSlug()
        {
            return self::$slug;
        }

        /**
         * Return an instance of this class.
         *
         * @return object a single instance of this class
         */
        public static function get_instance()
        {
            // If the single instance hasn't been set, set it now.
            if (self::$instance === null) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Load the plugin text domain for translation.
         */
        public function load_plugin_textdomain()
        {
            load_plugin_textdomain('gfirem-woo-cart', false, basename(dirname(__FILE__)) . '/languages');
        }
    }

    add_action('plugins_loaded', array('GFireMWooCart', 'get_instance'));
}
