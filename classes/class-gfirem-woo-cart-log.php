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

class GFireMWooCartLog {
	function __construct() {
		add_filter( 'aal_init_roles', array( $this, 'aal_init_roles' ) );
		add_filter( 'aal_init_caps', array( $this, 'aal_init_caps' ) );
	}

	public function aal_init_roles( $roles ) {
		$roles_existing          = $roles['manage_options'];
		$roles['manage_options'] = array_merge( $roles_existing, array( GFireMWooCart::getSlug() ) );

		return $roles;
	}

	public function aal_init_caps( $caps ) {
		$caps['administrator'][] = 'subscriber';
		$caps['editor'][]        = 'subscriber';
		$caps['author'][]        = 'subscriber';
		$caps['subscriber']      = array( 'subscriber', 'guest' );

		return $caps;
	}

	public static function log( $args ) {
		if ( function_exists( "aal_insert_log" ) ) {
			aal_insert_log( $args );
		}
	}
}