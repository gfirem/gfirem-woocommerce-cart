<?php
/**
 * @package WordPress
 * @subpackage Formidable, GFireMWooCart
 * @author GFireM Dev Team
 * @copyright 2018
 * @link http://www.gfirem.com
 * @license http://www.apache.org/licenses/
 */

if (! defined('ABSPATH')) {
    exit;
}

class GFireMWooCartHandler
{
    /**
     * Instance of this class.
     *
     * @var object
     */
    protected static $instance = null;

    protected $cart_item_id;

    public function __construct()
    {
        add_filter('woocommerce_checkout_get_value', array($this, 'post_checkout_field_values'), 10, 2);
    }

    public function add_product_to_cart($action, $entry, $form)
    {
        if (! WC()->cart->is_empty()) {
            return;
        }

        $product_id = isset($action->post_content['product_id']) ? $action->post_content['product_id'] : 0;

        if (empty($product_id)) {
            return;
        }
        $this->cart_item_id = WC()->cart->add_to_cart($product_id, 1, 0, array(), array('action' => $action, 'entry' => $entry, 'form' => $form));
    }

    public function post_checkout_field_values($value, $input)
    {
        $cart_content = WC()->cart->get_cart_contents();

        if (! empty($cart_content)) {
            foreach ($cart_content as $item) {
                if (isset($item['action']) && isset($item['entry']) && isset($item['form'])) {
                    $product_id = isset($item['action']->post_content['product_id']) ? $item['action']->post_content['product_id'] : 0;
                    if (intval($product_id) === $item['product_id']) {
                        if (! empty($item['action']->post_content[$input])) {
                            $short_codes = FrmFieldsHelper::get_shortcodes($item['action']->post_content[$input], $item['form']->id);
                            return do_shortcode(GFireMWooCart::replace_short_code($item['action']->post_content[$input], $item['form'], $item['entry'], $short_codes));
                        }
                    }
                }
            }
        }
        return $value;
    }

    public static function get_checkout_fields()
    {
        $fields = array(
            'billing' => WC()->countries->get_address_fields(
                '',
                'billing_'
            ),
            'shipping' => WC()->countries->get_address_fields(
                '',
                'shipping_'
            ),
            'account' => array(),
            'order' => array(
                'order_comments' => array(
                    'type' => 'textarea',
                    'class' => array('notes'),
                    'label' => __('Order notes', 'woocommerce'),
                    'placeholder' => esc_attr__(
                        'Notes about your order, e.g. special notes for delivery.',
                        'woocommerce'
                    ),
                ),
            ),
        );

        if (get_option('woocommerce_registration_generate_username') === 'no') {
            $fields['account']['account_username'] = array(
                'type' => 'text',
                'label' => __('Account username', 'woocommerce'),
                'required' => true,
                'placeholder' => esc_attr__('Username', 'woocommerce'),
            );
        }

        if (get_option('woocommerce_registration_generate_password') === 'no') {
            $fields['account']['account_password'] = array(
                'type' => 'password',
                'label' => __('Create account password', 'woocommerce'),
                'required' => true,
                'placeholder' => esc_attr__('Password', 'woocommerce'),
            );
        }

        foreach (array_keys($fields) as $field_type) {
            // Sort each of the checkout field sections based on priority.
            uasort($fields[$field_type], 'wc_checkout_fields_uasort_comparison');
        }

        return $fields;
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
}
