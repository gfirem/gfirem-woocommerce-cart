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

class GFireMWooCartAction extends FrmFormAction
{
    private $checkout_handler;

    public function __construct()
    {
        try {
            require_once 'class-gfirem-woo-cart-handler.php';
            $this->checkout_handler = GFireMWooCartHandler::get_instance();
            add_action('admin_head', array($this, 'admin_style'));
            add_action('frm_trigger_gfirem-woo-cart_create_action', array($this, 'onCreate'), 10, 3);
            $action_ops = array(
                'classes' => 'dashicons dashicons-admin-page dashicons-cart gfirem-woo-cart-icon',
                'limit' => 99,
                'active' => true,
                'priority' => 999,
                'event' => array('create'),
            );
            $this->FrmFormAction('gfirem-woo-cart', __('GFireM WooCommerce Cart', 'gfirem-woo-cart'), $action_ops);
        } catch (Exception $ex) {
            FormidableEntriesDuplicatorLog::log(array(
                'action' => 'loading_dependency',
                'object_type' => FormidableEntriesDuplicator::getSlug(),
                'object_subtype' => static::class,
                'object_name' => $ex->getMessage(),
            ));
        }
    }

    /**
     * Add styles to action
     */
    public function admin_style()
    {
        $current_screen = get_current_screen();
        if ($current_screen->id === 'toplevel_page_formidable') {
            wp_enqueue_style('gfirem-woo-cart', GFireMWooCart::$assets . 'css/gfirem-woocommerce-cart.css', array(), GFireMWooCart::getVersion());
            wp_register_script('gfirem-woo-cart', GFireMWooCart::$assets . 'js/gfirem-woocommerce-cart.js', array('jquery'), GFireMWooCart::getVersion(), true);
            wp_enqueue_script('gfirem-woo-cart');
        }
    }

    /**
     * Formidable create action
     */
    public function onCreate($action, $entry, $form)
    {
        $this->checkout_handler->add_product_to_cart($action, $entry, $form);
        GFireMWooCartLog::log(array(
            'action' => 'onCreate',
            'object_type' => GFireMWooCart::getSlug(),
            'object_subtype' => static::class,
            'object_name' => sprintf(__('Action trigger by Entry (%s) Created in the Form %s, by the action {s}', 'gfirem-woo-cart'), $entry->id, $form->id, $action->ID),
        ));
    }

    /**
     * Get the HTML for your action
     *
     * @param array $form_action
     * @param array $args
     *
     * @return string|void
     */
    public function form($form_action, $args = array())
    {
        try {
            extract($args);
            $form = $args['form'];
            $fields = $args['values']['fields'];
            $action_control = $this;
            $products = wc_get_products(array());

            $checkout_fields = GFireMWooCartHandler::get_checkout_fields();

            if ($form->status === 'published') {
                require GFireMWooCart::$view . 'form.php';
            } else {
                _e('The form need to published.', 'gfirem-woo-cart');
            }
        } catch (Exception $ex) {
            FormidableEntriesDuplicatorLog::log(array(
                'action' => 'form',
                'object_type' => FormidableEntriesDuplicator::getSlug(),
                'object_subtype' => static::class,
                'object_name' => $ex->getMessage(),
            ));
        }
    }

    public function get_defaults()
    {
        $result = array(
            'form_id' => $this->get_field_name('form_id'),
            'product_id' => '',
            'is_checkout_redirect_enabled' => '',
            'billing_name' => '',
        );

        foreach (GFireMWooCartHandler::get_checkout_fields() as $field_set_key => $field_set) {
            foreach ($field_set as $key => $field) {
                $result[$key] = '';
            }
        }
        if ($this->form_id !== null) {
            $result['form_id'] = $this->form_id;
        }

        return $result;
    }
}
