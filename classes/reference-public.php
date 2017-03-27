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

        add_action( 'init', array($this, 'reference_feedback_ajax_init') );
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
     public function enqueue_styles()
     {

        $highlighting_style = Helper::get_highlighting_style_file();

        $theme = wp_get_theme(); // gets the current theme

        if (self::is_knowledgebase('knowledgebase', 'knowledgebase', 'knb-categories', 'reference_loop')) {

            wp_enqueue_style( $this->name, plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference.css', array(), $this->version, 'all' );

            if ('thrive' === $theme->template) {
                wp_enqueue_style( 'reference-thrive', plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference-thrive.css', array(), $this->version, 'all' );
            }
            if ('twentyseventeen' === $theme->template) {
                wp_enqueue_style( 'reference-twentyseventeen', plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference-twentyseventeen.css', array(), $this->version, 'all' );
            }
            if ('twentysixteen' === $theme->template) {
                wp_enqueue_style( 'reference-twentysixteen', plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference-twentysixteen.css', array(), $this->version, 'all' );
            }
            if ('twentyfifteen' === $theme->template) {
                wp_enqueue_style( 'reference-twentyfifteen', plugin_dir_url( dirname(__FILE__) ) . 'assets/css/reference-twentyfifteen.css', array(), $this->version, 'all' );
            }
        }

        if (self::is_knowledgebase($shortcode = 'reference_highlighter') && self::is_option_true('reference_knb_syntax_highlighting') === true) {

            if(empty($highlighting_style)) {
                $highlighting_style = 'dark';
            }

            wp_enqueue_style( 'highlighter-style', plugin_dir_url( dirname(__FILE__) ) . 'assets/css/styles/' . $highlighting_style . '.css', array(), $this->version, 'all' );
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
        $post = Helper::global_post();
        $breadcrumbs_separator = wp_strip_all_tags(get_option('reference_knb_breadcrumbs_separator'));

        if (empty($breadcrumbs_separator)) {
            $breadcrumbs_separator = "/";
        }

        if ( !isset( $post ) ) {
            return;
        }

        wp_register_script($this->name, plugin_dir_url( dirname(__FILE__) ) . 'assets/js/reference.js', array('jquery'), $this->version, FALSE );

        if (self::is_knowledgebase($singular = 'knowledgebase')){

            wp_enqueue_script( 'reference-sticky-kit', plugin_dir_url( dirname(__FILE__) ) . 'assets/js/sticky-kit.js', array('jquery'), $this->version, FALSE );

            wp_localize_script('reference-sticky-kit', 'reference_sticky_kit_object', array(
                'sticky_kit' => ' ' . get_option('reference_knb_sticky_kit') . ' ',
            ));

            wp_enqueue_script($this->name);

            wp_localize_script($this->name, 'reference_breadcrumb_separator_object', array(
                'separator' => ' ' . $breadcrumbs_separator . ' ',
            ));

        }
        if (self::is_knowledgebase($shortcode = 'reference_highlighter') && self::is_option_true('reference_knb_syntax_highlighting') === true) {
            wp_enqueue_script($this->name);
            wp_enqueue_script( 'reference-highlight', plugin_dir_url( dirname(__FILE__) ) . 'assets/js/highlight.js', array('jquery'), $this->version, FALSE );
        }
    }
    public function reference_feedback_ajax_init()
    {
        wp_register_script('reference-feedback-ajax-script', plugin_dir_url( dirname(__FILE__) ) . 'assets/js/reference-ajax.js', array('jquery'), $this->version, FALSE );

        wp_enqueue_script('reference-feedback-ajax-script');

        wp_localize_script('reference-feedback-ajax-script', 'reference_feedback_object', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'yes' => 'yes',
            'no' => 'no',
            'loading' => '<span class="loading"></span>',
        ));

        add_action('wp_ajax_reference_feedback_ajax', array($this, 'reference_feedback_ajax'));
        add_action('wp_ajax_nopriv_reference_feedback_ajax', array($this, 'reference_feedback_ajax'));
    }

    public function reference_feedback_ajax()
    {

        header('Content-Type: application/json');

        check_ajax_referer('reference-feedback-ajax-nonce', 'reference-feedback-security');

        $reference_id = filter_input(INPUT_POST, 'reference-id', FILTER_SANITIZE_NUMBER_INT);
        $reference_confirmed = filter_input(INPUT_POST, 'reference-confirm', FILTER_SANITIZE_STRING);
        $reference_declined = filter_input(INPUT_POST, 'reference-decline', FILTER_SANITIZE_STRING);

        $ip = Helper::get_ip();
        $ip_addresses = (array) get_post_meta($reference_id, '_knowledgebase_feedback_ip_meta_key', true);
        $ip_array = array();

        $confirmed_value = get_post_meta($reference_id, '_knowledgebase_feedback_confirm_meta_key', true);
        $declined_value = get_post_meta($reference_id, '_knowledgebase_feedback_decline_meta_key', true);

        $confirmed_amount = $confirmed_value;
        $declined_amount = $declined_value;

        if ('yes' === $reference_confirmed && !in_array($ip, $ip_addresses)) {
            $confirmed_amount++;
        }

        if ('no' === $reference_declined && !in_array($ip, $ip_addresses)) {
            $declined_amount++;
        }

        if (!in_array($ip, $ip_array)) {
            $ip_array[] = $ip;
        }

        foreach ($ip_addresses as $ip_address) {
            if (!in_array($ip_address, $ip_array) && !empty($ip_address)) {
                $ip_array[] = $ip_address;
            }
        }

        if ('yes' === $reference_confirmed && !in_array($ip, $ip_addresses)) {
            update_post_meta($reference_id, '_knowledgebase_feedback_confirm_meta_key', $confirmed_amount);
        }

        if ('no' === $reference_declined && !in_array($ip, $ip_addresses)) {
            update_post_meta($reference_id, '_knowledgebase_feedback_decline_meta_key', $declined_amount);
        }

        if (!in_array($ip, $ip_addresses)) {
            update_post_meta($reference_id, '_knowledgebase_feedback_ip_meta_key', $ip_array);
        }

        if ('yes' === $reference_confirmed || 'no' === $reference_declined && !in_array($ip, $ip_addresses)) {
            echo wp_json_encode(
                array(
                    'status' => 202,
                    'confirmed_amount' => $confirmed_amount,
                    'declined_amount' => $declined_amount,
                    'message' => esc_html__('Thank you for voting.', 'reference'),
                )
            );
        }

        die();
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

    public function is_knowledgebase($archive = '', $singular = '', $tax = '', $shortcode = '')
    {
        $post = Helper::global_post();

        if ( !isset( $post ) ) {
            return;
        }

        $condition = is_post_type_archive($archive) || is_singular($singular) || is_tax($tax) || has_shortcode( $post->post_content, $shortcode);

        return $condition;
	}

    public function is_option_true($option = '')
    {
        if (!empty($option)) {
            if ((bool)get_option($option) === true) {
                return true;
            }
        }
        return false;
    }

    public function get_the_archive_categories_title($title)
    {
        if (is_tax('knb-categories')) {
            $title = single_cat_title('', false);
        }
        return $title;
    }

}
