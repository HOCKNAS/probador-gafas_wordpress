<?php
/**
 *
 * @link              https://www.santiagochacon.dev
 * @since             1.0.0
 * @package           Try_on_sck
 *
 * @wordpress-plugin
 * Plugin Name:       SCK Probador
 * Plugin URI:        https://www.santiagochacon.dev
 * Description:       Probador online gafas
 * Version:           1.0.0
 * Author:            Hocknas
 * Author URI:        https://www.santiagochacon.dev
 * License:           --
 * License URI:       --
 * Text Domain:       try_on_sck
 * Domain Path:       /languages
 */



// Se usa para proteger el acceso no autorizado al plugin
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Version
define( 'HOCKNAS', '1.0.0' );

// Codigo que se ejecuta durante la activacion del plugin
function activate_try_on_sck() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/activate_try_on_sck.php';
	Try_on_sck_Activator::activate();
}

// Codigo que se ejecuta durante la desactivacion del plugin
function deactivate_try_on_sck() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/deactivate_try_on_sck.php';
	Try_on_sck_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_try_on_sck' );
register_deactivation_hook( __FILE__, 'deactivate_try_on_sck' );

// Instancia del core del plugin
require plugin_dir_path( __FILE__ ) . 'includes/main_try_on_sck.php';

// Se inicializa la ejecución del plugin
function run_try_on_sck() {

	$plugin = new Try_on_sck();
	$plugin->run();

}

run_try_on_sck();