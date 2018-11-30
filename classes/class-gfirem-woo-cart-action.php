<?php
/**
 * @package WordPress
 * @subpackage Formidable, GFireMWooCart
 * @author GFireM Dev Team
 * @copyright 2018
 * @link http://www.gfirem.com
 * @license http://www.apache.org/licenses/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GFireMWooCartAction extends FrmFormAction{
	public function __construct() {
		try {
			add_action( 'admin_head', array( $this, 'admin_style' ) );
			add_action( 'frm_trigger_formidable_entries_duplicator_create_action', array( $this, 'onCreate' ), 10, 3 );
			$action_ops = array(
				'classes'  => 'dashicons dashicons-admin-page dashicons-controls-repeat gfirem-woo-cart-icon',
				'limit'    => 99,
				'active'   => true,
				'priority' => 999,
				'event'    => array( 'create' ),
			);
			$this->FrmFormAction( 'gfirem-woo-cart', __( 'GFireM WooCommerce Cart', 'gfirem-woo-cart' ), $action_ops );

		} catch ( Exception $ex ) {
			FormidableEntriesDuplicatorLog::log( array(
				'action'         => 'loading_dependency',
				'object_type'    => FormidableEntriesDuplicator::getSlug(),
				'object_subtype' => get_class( $this ),
				'object_name'    => $ex->getMessage(),
			) );
		}
	}

	/**
	 * Add styles to action
	 */
	public function admin_style() {
		$current_screen = get_current_screen();
		if ( $current_screen->id === 'toplevel_page_formidable' ) {
			wp_enqueue_style( 'gfirem-woo-cart', GFireMWooCart::$assets . 'css/gfirem-woo-cart.css' );
		}
	}

	/**
	 * Formidable create action
	 *
	 * @param $action
	 * @param $entry
	 * @param $form
	 */
	public function onCreate( $action, $entry, $form ) {
		GFireMWooCartLog::log( array(
			'action'         => 'onCreate',
			'object_type'    => GFireMWooCart::getSlug(),
			'object_subtype' => get_class( $this ),
			'object_name'    => sprintf( 'Action trigger by Entry (%s) Created in the Form %s, by the action {s}', $entry->id, $form->id, $action->ID ),
		) );
	}

	function get_defaults() {
		$result = array(
			'form_id'                      => $this->get_field_name( 'form_id' ),
			'product_id'                   => '',
			'is_checkout_redirect_enabled' => '',
		);
		if ( $this->form_id != null ) {
			$result['form_id'] = $this->form_id;
		}

		return $result;
	}
}