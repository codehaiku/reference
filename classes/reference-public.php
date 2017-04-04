<?php
/**
 * This class executes in the Loader class to enqueue scripts and initialize
 * hooks for the frontend of the Referene plugin.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\PublicPages
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference
 * @link     github.com/codehaiku/reference
 */

namespace DSC\Reference;

if (! defined('ABSPATH')) {
    return;
}

/**
 * This class handles the frontend funtionality.
 *
 * @category Reference\PublicPages
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */
class PublicPages
{

    /**
     * The loader is the one who regesters the handles the hooks of the plugin
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $loader    Handles and registers all
     *                                         hooks for the plugin.
     */
    private $loader;

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $name    The ID of this plugin.
     */
    private $name;

    /**
     * The current version of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $version    The current version of the plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string  $name    The name of the plugin.
     * @param integer $version The version of this plugin.
     * @param string  $loader  The version of this plugin.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function __construct($name, $version, $loader)
    {

        $this->loader = $loader;
        $this->name = $name;
        $this->version = $version;

        add_action('init', array($this, 'referenceCommentFeedbackAjaxInit'));
        add_filter('body_class', array($this, 'setBodyClass'));
        add_filter('post_class', array($this, 'setPostClassCallback'));
        add_filter('get_the_archive_title', array($this, 'getCategoryArchiveTitle'));
        add_action('pre_get_posts', array($this,'setSearchfilter'));
        add_filter('template_include', array($this, 'setSearchTemplate'));
        add_action('pre_get_posts', array($this, 'setPostsPerPage'));
    }

    /**
     * This method enqueue the CSS filess for the frontend of the Reference plugin.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function setEnqueueStyles()
    {

        $highlighting_style = Helper::getSyntaxHighlightingStyleFile();
        $theme = wp_get_theme(); // gets the current theme

        if (self::isKnowledgebase(
            'knowledgebase',
            'knowledgebase',
            'knb-categories',
            'reference_loop'
        )
            || is_search()
            || !have_posts()
        ) {
            wp_enqueue_style(
                $this->name,
                plugin_dir_url(dirname(__FILE__)) . 'assets/css/reference.css',
                array(),
                $this->version,
                'all'
            );

            if ('thrive' === $theme->template) {
                wp_enqueue_style(
                    'reference-thrive',
                    plugin_dir_url(dirname(__FILE__)) .
                    'assets/css/reference-thrive.css',
                    array(),
                    $this->version,
                    'all'
                );
            }
            if ('twentyseventeen' === $theme->template) {
                wp_enqueue_style(
                    'reference-twentyseventeen',
                    plugin_dir_url(dirname(__FILE__)) .
                    'assets/css/reference-twentyseventeen.css',
                    array(),
                    $this->version,
                    'all'
                );
            }
            if ('twentysixteen' === $theme->template) {
                wp_enqueue_style(
                    'reference-twentysixteen',
                    plugin_dir_url(dirname(__FILE__)) .
                    'assets/css/reference-twentysixteen.css',
                    array(),
                    $this->version,
                    'all'
                );
            }
            if ('twentyfifteen' === $theme->template) {
                wp_enqueue_style(
                    'reference-twentyfifteen',
                    plugin_dir_url(dirname(__FILE__)) .
                    'assets/css/reference-twentyfifteen.css',
                    array(),
                    $this->version,
                    'all'
                );
            }
        }

        if (self::isKnowledgebase($shortcode = 'reference_highlighter')
            && true === self::isOptionTrue('reference_knb_syntax_highlighting')
        ) {
            if (empty($highlighting_style)) {
                $highlighting_style = 'dark';
            }

            wp_enqueue_style(
                'highlighter-style',
                plugin_dir_url(dirname(__FILE__)) .
                'assets/css/styles/' . $highlighting_style . '.css',
                array(),
                $this->version,
                'all'
            );
        }
        return;
    }

    /**
     * This method enqueue the JS files for the frontend of the Reference plugin.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function setEnqueueScripts()
    {
        $post = Helper::globalPost();
        $breadcrumbs_separator_option = Options::getBreadcrumbsSeparator();
        $sticky_kit_option = Options::getStickyKit();

        if (empty($breadcrumbs_separator_option)) {
            $breadcrumbs_separator_option = "/";
        }

        if (!isset($post)) {
            return;
        }

        wp_register_script(
            $this->name,
            plugin_dir_url(dirname(__FILE__)) . 'assets/js/reference.js',
            array('jquery'),
            $this->version,
            false
        );

        if (self::isKnowledgebase($singular = 'knowledgebase')) {
            wp_enqueue_script(
                'reference-sticky-kit',
                plugin_dir_url(dirname(__FILE__)) . 'assets/js/sticky-kit.js',
                array('jquery'),
                $this->version,
                false
            );

            wp_localize_script(
                'reference-sticky-kit',
                'reference_sticky_kit_object',
                array(
                    'sticky_kit' => ' ' . $sticky_kit_option . ' ',
                )
            );

            wp_enqueue_script($this->name);

            wp_localize_script(
                $this->name,
                'reference_breadcrumb_separator_object',
                array(
                    'separator' => ' ' . $breadcrumbs_separator_option . ' ',
                )
            );
        }
        if (self::isKnowledgebase($shortcode = 'reference_highlighter')
            && true === self::isOptionTrue('reference_knb_syntax_highlighting')
        ) {
            wp_enqueue_script($this->name);
            wp_enqueue_script(
                'reference-highlight',
                plugin_dir_url(dirname(__FILE__)) . 'assets/js/highlight.js',
                array('jquery'),
                $this->version,
                false
            );
        }
        return;
    }
    /**
     * This method initialize the referenceCommentFeedbackAjax() to the
     * init() and registers to the WordPress AJAX.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function referenceCommentFeedbackAjaxInit()
    {
        wp_register_script(
            'reference-feedback-ajax-script',
            plugin_dir_url(dirname(__FILE__)) . 'assets/js/reference-ajax.js',
            array('jquery'),
            $this->version,
            false
        );

        wp_enqueue_script('reference-feedback-ajax-script');

        wp_localize_script(
            'reference-feedback-ajax-script',
            'reference_feedback_object',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'yes' => 'yes',
                'no' => 'no',
                'loading' => '<span class="loading"></span>',
            )
        );

        add_action(
            'wp_ajax_referenceCommentFeedbackAjax',
            array(
                $this,
                'referenceCommentFeedbackAjax'
            )
        );
        add_action(
            'wp_ajax_nopriv_referenceCommentFeedbackAjax',
            array(
                $this,
                'referenceCommentFeedbackAjax'
            )
        );
    }
    /**
     * This method sets sanitized and collects the IP addresses of visitors
     * who voted.
     * Collect and updates the number of votes who thinks that the knowledgebase
     * is useful and who thinks that the knowledgebase is irrelevant using AJAX.
     * Updates the Feedback meta settings using ajax.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function referenceCommentFeedbackAjax()
    {

        header('Content-Type: application/json');

        check_ajax_referer(
            'reference-feedback-ajax-nonce',
            'reference-feedback-security'
        );

        $reference_id = filter_input(
            INPUT_POST,
            'reference-id',
            FILTER_SANITIZE_NUMBER_INT
        );
        $reference_confirmed = filter_input(
            INPUT_POST,
            'reference-confirm',
            FILTER_SANITIZE_STRING
        );
        $reference_declined = filter_input(
            INPUT_POST,
            'reference-decline',
            FILTER_SANITIZE_STRING
        );

        $ip = Helper::getIpAddress();
        $ip_addresses = (array) get_post_meta(
            $reference_id,
            '_knowledgebase_feedback_ip_meta_key',
            true
        );

        $ip_array = array();

        $confirmed_value = get_post_meta(
            $reference_id,
            '_knowledgebase_feedback_confirm_meta_key',
            true
        );
        $declined_value = get_post_meta(
            $reference_id,
            '_knowledgebase_feedback_decline_meta_key',
            true
        );

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
            update_post_meta(
                $reference_id,
                '_knowledgebase_feedback_confirm_meta_key',
                $confirmed_amount
            );
        }

        if ('no' === $reference_declined && !in_array($ip, $ip_addresses)) {
            update_post_meta(
                $reference_id,
                '_knowledgebase_feedback_decline_meta_key',
                $declined_amount
            );
        }

        if (!in_array($ip, $ip_addresses)) {
            update_post_meta(
                $reference_id,
                '_knowledgebase_feedback_ip_meta_key',
                $ip_array
            );
        }

        if ('yes' === $reference_confirmed
            || 'no' === $reference_declined
            && !in_array(
                $ip,
                $ip_addresses
            )
        ) {
            echo wp_json_encode(
                array(
                    'status' => 202,
                    'confirmed_amount' => $confirmed_amount,
                    'declined_amount' => $declined_amount,
                    'message' => esc_html__(
                        'Thank you for voting.',
                        'reference'
                    ),
                )
            );
        }

        die();
    }
    /**
     * This method sets the number of knowledgebase to be display in a page based
     *  on posts per page setting of the 'Reference Settings' page.
     *
     * @param object $query Holds the query string that was passed to the
     *                      $wp_query object by WP class.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function setPostsPerPage($query)
    {
        $posts_per_page_option = Options::getPostsPerPage();

        if ($query->is_main_query()) {
            $query->set('posts_per_page', absint($posts_per_page_option));
        }
        return;
    }
    /**
     * This method sets the body_class for knowledgebase post type.
     *
     * @param string|array $classes One or more classes to add to the class
     *                              attribute, separated by a single space.
     *
     * @since  1.0.0
     * @access public
     * @return string|array $classes Returns the $classes and set the body_class
     *                               for knowledgebase pages.
     */
    public function setBodyClass($classes)
    {
        $classes[] = 'knowledgebase';

        return $classes;
    }
    /**
     * This method sets the body_class for the single knowledgebase pages.
     *
     * @param string|array $classes One or more classes to add to the class
     *                              attribute, separated by a single space.
     *
     * @since  1.0.0
     * @access public
     * @return string|array $classes Returns the $classes and set the body_class
     *                               for single knowledgebase pages.
     */
    public function setPostClassCallback($classes)
    {
        if (is_singular('knowledgebase')) {
            $classes[] = 'single-knowledgebase';
        }
        return $classes;
    }
    /**
     * This method filters the search to display only knowledgebase post type
     * and taxonomies.
     *
     * @param object $query Holds the query string that was passed to the
     *                      $wp_query object by WP class.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function setSearchfilter($query)
    {
        if (!is_admin() && $query->is_main_query()) {
            if ($query->is_search) {
                if (self::isKnowledgebase(
                    'knowledgebase',
                    'knowledgebase',
                    'knb-categories',
                    ''
                )
                ) {
                    $query->set('post_type', array( 'knowledgebase'));
                }
            }
        }
        return;
    }
    /**
     * This method includes the Reference search template in the $template.
     *
     * @param mixed $template The list of template
     *
     * @since  1.0.0
     * @access public
     * @return mixed $template Returns the tempalte including the
     *                         Reference search template.
     */
    public function setSearchTemplate($template)
    {
        $wp_query = Helper::globalWpQuery();

        $post_types = get_query_var('post_type');

        if (is_array($post_types)) {
            foreach ($post_types as $post_type) {
                if ($wp_query->is_search && $post_type == 'knowledgebase') {
                    return locate_template('knowledgebase-search.php');
                }
            }
        }

        return $template;
    }
    /**
     * This method returns the condition required to check a page.
     *
     * @param string Optional $archive   The name of post type to check the
     *                                   archive page.
     * @param string Optional $singular  The name of post type to check the
     *                                   single page.
     * @param string Optional $tax       The name of taxonomy to check the
     *                                   archive page.
     * @param string Optional $shortcode The name of shortcode to check the
     *                        archive page.
     *
     * @since  1.0.0
     * @access public
     * @return string $condition Returns the condition required to check a page.
     */
    public function isKnowledgebase(
        $archive = '',
        $singular = '',
        $tax = '',
        $shortcode = ''
    ) {
        $post = Helper::globalPost();

        if (!isset($post)) {
            return;
        }

        $condition = is_post_type_archive($archive) ||
                     is_singular($singular) ||
                     is_tax($tax) ||
                     has_shortcode($post->post_content, $shortcode);

        return $condition;
    }
    /**
     * This method checks if an option is enabled.
     *
     * @param string $option The name of the option to be check.
     *
     * @since  1.0.0
     * @access public
     * @return boolean true Returns true if an option is enabled.
     */
    public function isOptionTrue($option = '')
    {
        if (!empty($option)) {
            if ((bool)get_option($option) === true) {
                return true;
            }
        }
        return;
    }
    /**
     * This method retrieves page title for Reference category archive.
     *
     * @param string $title The archive title.
     *
     * @since  1.0.0
     * @access public
     * @return string $title Returns the Reference category title.
     */
    public function getCategoryArchiveTitle($title)
    {
        if (is_tax('knb-categories')) {
            $title = single_cat_title('', false);
        }
        return $title;
    }
}
