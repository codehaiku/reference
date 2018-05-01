<?php
/**
 * This class is loads all the dependencies needed by the Reference plugin.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Loader
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */

namespace DSC\Reference;

if (! defined('ABSPATH')) {
    return;
}
/**
 * This class is loads all the dependencies needed by the Reference plugin.
 *
 * @category Reference\Loader
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 */
final class Loader
{
    /**
     * The loader is the one who regesters the handles the hooks of the plugin
     *
     * @since  1.0.0
     * @access protected
     * @var    AddFiltersActions    $loader    Handles and registers all hooks
     *                                         for the plugin.
     */
    protected $loader;

    /**
     * This is the unique indentifier of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $reference    The string the plugin uses to identify
     *                                 the plugin.
     */
    protected $reference;

    /**
     * The current version of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * This method is used to set the value of the properties and initialize
     * the methods listed below.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->reference = 'reference';
        $this->version = '1.0.0';

        $this->loadDependencies();
        $this->setLocale();
        $this->setAdminHooks();
        $this->setPublicHooks();
    }
    /**
     * This method is used to load all the dependencies needed by the Reference
     * plugin.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function loadDependencies()
    {
        /**
         * This class that handles the arrangement of the actions and filters
         * of the core class of the plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
                     'classes/reference-add-action-filter.php';
        /**
         * This class handles the localization functionality of the plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
                     'classes/reference-i18n.php';
        /**
         * This class handles all the defined actions in the dashboard.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
                     'classes/reference-admin.php';
        /**
         * This class handles the sanitation of the of the Reference Settings
         * before displayed.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
                     'classes/reference-options.php';
        /**
         * This class handles all the defined ations and filters in the
         * frontend.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
                     'classes/reference-public.php';
        /**
         * This class handles the registration of post_type and taxonomies.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
                     'classes/reference-post-type.php';
        /**
         * This class handles the registration of the plugins metaboxes.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
                     'classes/reference-metabox.php';
        /**
         * This class handles the structure of the Reference Breadcrumbs.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
                     'classes/reference-breadcrumb.php';
        /**
         * This class handles the registration of the Reference Shortcodes.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
                     'classes/reference-shortcodes.php';
        /**
         * This class handles the registration of the Reference Widgets.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
                     'classes/reference-widgets.php';
        /**
         * This class handles the Reference hooks.
         */
        include_once plugin_dir_path(dirname(__FILE__)) .
                     'classes/reference-action-hooks.php';

        $this->loader = new AddFiltersActions();

        new ActionHooks();

        new Options();

        new Metabox();

        new KnowledgebaseShortcodes();

        new KnowledgebaseWidgets();
    }
    /**
     * This method is used to load the localization file of the Reference plugin.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function setLocale()
    {
    }
    /**
     * This method is used to load all the actions and filters hooks in the
     * WordPress backend.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function setAdminHooks()
    {
        $post_type = new \DSC\Reference\PostType(
            $this->getName(),
            $this->getVersion(),
            $this->getLoader()
        );
        $plugin_admin = new \DSC\Reference\Admin(
            $this->getName(),
            $this->getVersion(),
            $this->getLoader()
        );
        $this->loader->addAction(
            'admin_enqueue_scripts',
            $plugin_admin,
            'enqueueScripts'
        );
    }
    /**
     * This method is used to load all the actions and filters hooks in the
     * frontend.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function setPublicHooks()
    {
        $plugin_public = new \DSC\Reference\PublicPages(
            $this->getName(),
            $this->getVersion(),
            $this->getLoader()
        );
        $this->loader->addAction(
            'wp_enqueue_scripts',
            $plugin_public,
            'setEnqueueStyles'
        );
        $this->loader->addAction(
            'wp_enqueue_scripts',
            $plugin_public,
            'setEnqueueScripts'
        );
    }
    /**
     * Run the loader to execute all of in the hooks plugin to WordPress.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function runner()
    {
        $this->loader->runner();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since  1.0.0
     * @access public
     * @return string reference The name of the plugin.
     */
    public function getName()
    {
        return $this->reference;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since  1.0.0
     * @access public
     * @return string loader    Orchestrates the hooks of the plugin.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since  1.0.0
     * @access public
     * @return string version The version number of the plugin.
     */
    public function getVersion()
    {
        return $this->version;
    }
}
