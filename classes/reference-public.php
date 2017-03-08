<?php
/**
 * This class is executes during plugin activation.
 *
 * (c) Joseph Gabito <joseph@useissuestabinstead.com>
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

        add_filter( 'body_class', array($this,'body_class') );
        add_filter( 'template_include', array($this,'display') );
        add_filter( 'get_the_archive_title', array($this,'get_the_archive_categories_title') );

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
            wp_enqueue_style( $this->name, plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference-twentyseventeen.css', array(), $this->version, 'all' );
        }
        if ('twentysixteen' === $theme->template) {
            wp_enqueue_style( $this->name, plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference-twentysixteen.css', array(), $this->version, 'all' );
        }
        if ('twentyfifteen' === $theme->template) {
            wp_enqueue_style( $this->name, plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference-twentyfifteen.css', array('twentyfifteen-style'), $this->version, 'all' );
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

     }

    public function body_class($classes)
    {
    	$classes[] = 'knowledgebase';

        return $classes;
    }

    public function display($template)
    {
        // global $wp_query;

        if ( is_tax('categories') ) {

            $template = REFERENCE_DIR_PATH . '/templates/archive-categories.php';

            if ( $theme_template = locate_template( array( 'knowledgebase/templates/archive-categories.php' ) ) ) {

                $template = $theme_template;

            }

        }
        if( is_singular( 'knowledgebase' ) ) {
        }
        if ( is_tax('categories') ) {
        }

        // $post_type = get_query_var('post_type');
        // if( $wp_query->is_search && $post_type == 'knowledgebase' ) {
        //
        //     $template = REFERENCE_DIR_PATH . '/templates/archive-search.php';
        //
        //     if ( $theme_template = locate_template( array( 'knowledgebase/templates/archive-search.php' ) ) ) {
        //
        //         $template = $theme_template;
        //
        //     }
        // }

        return $template;
	}

    public function get_the_archive_categories_title($title)
    {
        if ( is_tax( 'categories' ) ) {
            $title = single_cat_title( '', false );
        }
        return $title;
    }

}
