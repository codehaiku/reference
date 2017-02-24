<?php
/**
 * The file that defines the core plugin class
 *
 * This class includes all the attributes nad methods used throughout the plugins dashboard and frontend.
 *
 * @link       https://wordpress.org/plugins/reference-wordpress-knowledgebase/
 * @since      1.0.0
 *
 * @package    reference-wordpress-knowledgebase
 * @subpackage reference-wordpress-knowledgebase/classes
 */

namespace DSC\Reference;

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

class Loader
{
    /**
	 * The loader is the one who regesters the handles the hooks of the plugin
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      AddFiltersActions    $loader    Handles and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * This is the unique indentifier of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $dscKnB    The string the plugin uses to identify the plugin.
	 */
	protected $dsc_knb;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

    function __construct()
    {
        $this->dsc_knb = 'dsc_knb';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
    }

    private function load_dependencies()
    {
        /**
		 * This class that handles the arrangement of the actions and filters of the core class of the plugin
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/reference-add-action-filter.php';

		/**
		 * This class handles the localization functionality of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/reference-i18n.php';

		/**
         * This class handles all the defined actions in the dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/reference-admin.php';

		/**
         * This class handles all the defined actions in the frontend.
		 */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-dscKnB-public.php';


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/reference-post-type.php';

		$this->loader = new \DSC\Reference\AddFiltersActions();

    }
    private function set_locale()
    {
        # code...
    }
    private function define_admin_hooks()
    {

        $functions = new \DSC\Reference\PostType( $this->get_dscKnB(), $this->get_version(), $this->get_loader() );

        $plugin_admin = new \DSC\Reference\ReferenceAdmin( $this->get_dscKnB(), $this->get_version(), $this->get_loader() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

    }
    private function define_public_hooks()
    {
		// $functions = new \DSC\Reference\PostType( $this->get_dscKnB(), $this->get_version(), $this->get_loader() );
    }

    /**
	 * Run the loader to execute all of in the hooks plugin to WordPress.
	 *
	 * @since    1.0.0
	 */
	public function runner() {
		$this->loader->runner();
	}

    /**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_dscKnB() {
		return $this->dsc_knb;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


}
