<?php


class Try_on_sck {

	// El loader se encarga de mantener y registrar todos los hooks que hacen parte del plugin 
	protected $loader;

	// Identificador del plugin
	protected $plugin_name;

	// Versión
	protected $version;

	/**
	 * Define la funcionalidad principal del complemento
	 *
	 * Establece nombre y version del plugin
	 * Carga las dependencias, hooks tanto para admin como para public
	 * the public-facing side of the site.
	 */
	public function __construct() {
		if ( defined( 'HOCKNAS' ) ) {
			$this->version = HOCKNAS;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'Try_on_sck';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Carga las dependencias requeridas por el plugin
	 *
	 * Incluye:
	 * - Try_on_sck_Loader. Manjea los hooks del plugin
	 * - Try_on_sck_i18n. Define la funcionalidad de internacionalizacion
	 * - Try_on_sck_Admin. Define los hooks para el area de admin
	 * - Try_on_sck_Public. Define los hooks del lado del publico
	 */
	private function load_dependencies() {

        // Maneja las acciones principales del plugin
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/try_on_sck-loader.php'; 

		// Maneja la internacionalizacion del complemento 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/try_on_sck-i18n.php';

		// Maneja el area de administrador
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/try_on_sck-admin.php';

		// Maneja la parte que sera publica
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/try_on_sck-public.php';

		$this->loader = new Try_on_sck_Loader();

	}

	// Define la configuración local de internacionalización
	private function set_locale() {

		$plugin_i18n = new Try_on_sck_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	// Registra todos los hooks del area de administracion
	private function define_admin_hooks() {

		$plugin_admin = new Try_on_sck_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu');

	}

	// Registra todos los hooks del area publica
	private function define_public_hooks() {

		$plugin_public = new Try_on_sck_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_libs' );
        $this->loader->add_action( 'init', $plugin_public, 'start' );

	}

	// Inicia el Loader con todos los hooks
	public function run() {
		$this->loader->run();
	}

    // Obtiene el nombre del plugin
	public function get_plugin_name() {
		return $this->plugin_name;
	}

     // Obtiene el loader del plugin
	public function get_loader() {
		return $this->loader;
	}

	 // Obtiene la version del plugin
	public function get_version() {
		return $this->version;
	}

}
