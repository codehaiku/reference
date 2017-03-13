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
 * @category Reference\Reference\PublicPages
 * @package  Reference WordPress Knowledgebase
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference-wordpress-knowledgebase
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 */

namespace DSC\Reference;

 if ( ! defined( 'ABSPATH' ) ) {
     return;
 }

/**
 * This class handles the frontend funtionality.
 *
 * @category Reference\Public\ReferencePublic
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 * @since    1.0
 */
class PublicPages
{

    /**
     * The loader is the one who regesters the handles the hooks of the plugin
     *
     * @since    1.0.0
     * @access   protected
     * @var      AddFiltersActions    $loader    Handles and registers all hooks for the plugin.
     */
    private $loader;

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $name    The ID of this plugin.
     */
    private $name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @var      string    $name       The name of the plugin.
     * @var      string    $version    The version of this plugin.
     */
    public function __construct( $name, $version, $loader ) {

        $this->loader = $loader;
        $this->name = $name;
        $this->version = $version;

        add_filter( 'body_class', array($this, 'body_class') );
        add_filter( 'post_class', array($this, 'post_class_callback') );
        add_filter( 'get_the_archive_title', array($this, 'get_the_archive_categories_title') );
        add_action( 'pre_get_posts', array($this,'search_filter'));

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
     public function enqueue_styles() {

        $theme = wp_get_theme(); // gets the current theme

        wp_enqueue_style( $this->name, plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference.css', array(), $this->version, 'all' );

        if ('twentyseventeen' === $theme->template) {
            wp_enqueue_style( 'reference-twentyseventeen', plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference-twentyseventeen.css', array(), $this->version, 'all' );
        }
        if ('twentysixteen' === $theme->template) {
            wp_enqueue_style( 'reference-twentysixteen', plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference-twentysixteen.css', array(), $this->version, 'all' );
        }
        if ('twentyfifteen' === $theme->template) {
            wp_enqueue_style( 'reference-twentyfifteen', plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference-twentyfifteen.css', array(), $this->version, 'all' );
        }

        return;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
     public function enqueue_scripts()
     {
         wp_enqueue_script( 'sticky-kit', plugin_dir_url( dirname(__FILE__) ) . 'assets/js/sticky-kit.js', array('jquery'), $this->version, FALSE );
         wp_enqueue_script( $this->name, plugin_dir_url( dirname(__FILE__) ) . 'assets/js/reference.js', array('jquery'), $this->version, FALSE );
     }

    public function body_class($classes)
    {
    	$classes[] = 'knowledgebase';

        return $classes;
    }

    public function post_class_callback( $classes ) {

        if (is_singular( 'knowledgebase' )) {
    		$classes[] = 'single-knowledgebase';
    	}
    	return $classes;
    }

    public function search_filter( $query ) {
        if (!is_admin() && $query->is_main_query()) {
            if ($query->is_search) {
                if (is_post_type_archive('knowledgebase') || is_singular( 'knowledgebase' ) || is_tax('knb-categories')) {
                    $query->set( 'post_type', array( 'knowledgebase') );
                }
            }
        }
    }

    public function display($template)
    {
	}

    public function get_the_archive_categories_title($title)
    {
        if (is_tax('knb-categories')) {
            $title = single_cat_title('', false);
        }
        return $title;
    }

}
