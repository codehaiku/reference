<?php
/**
 * This class is executes during plugin activation.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Metabox
 * @package  Reference WordPress Knowledgebase
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference-wordpress-knowledgebase
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 * @since    1.0
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
        $this->dsc_knb = 'reference';
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/reference-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/reference-post-type.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/reference-metabox.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/reference-breadcrumb.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/reference-shortcodes.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/reference-action-hooks.php';

		$this->loader = new \DSC\Reference\AddFiltersActions();

        new \DSC\Reference\KnowledgebaseShortcodes();

        new \DSC\Reference\Metabox();

        new \DSC\Reference\ActionHooks();

    }
    private function set_locale()
    {
        # code...
    }
    private function define_admin_hooks()
    {

        $functions = new \DSC\Reference\PostType( $this->get_dscKnB(), $this->get_version(), $this->get_loader() );

        $plugin_admin = new \DSC\Reference\Admin( $this->get_dscKnB(), $this->get_version(), $this->get_loader() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

    }
    private function define_public_hooks()
    {
        $plugin_public = new \DSC\Reference\PublicPages( $this->get_dscKnB(), $this->get_version(), $this->get_loader() );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
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
