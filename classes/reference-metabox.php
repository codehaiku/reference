<?php
/**
 * This class is used to register metabox, sanitized metabox value and
 * update metabox value.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Metabox
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
 * This class is used to register metabox, sanitized metabox value and
 * update metabox value.
 *
 * @category Reference\Metabox
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 */
final class Metabox
{

    /**
     * Registers and update metabox with its intended method below.
     *
     * @return void
     */
    public function __construct()
    {
        add_action(
            'add_meta_boxes',
            array(
                $this,
                'referenceAddCustomBox'
            )
        );
        add_action(
            'save_post',
            array(
                $this,
                'referenceSavePostdata'
            )
        );
    }

    /**
     * Add meta box
     *
     * @link   https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_
     *       boxes
     * @return void
     */
    public function referenceAddCustomBox()
    {
        $post_type = 'knowledgebase';

        add_meta_box(
            'knowledgebase_menu_field',
            esc_html__('Table of Content Menu', 'reference'),
            array( $this, 'referenceToCMenuMetabox'),
            $post_type,
            'side',
            'low'
        );
        add_meta_box(
            'knowledgebase_feedback_field',
            esc_html__('Comment Feedback', 'reference'),
            array( $this, 'referenceCommentFeedbackMetabox'),
            $post_type,
            'side',
            'low'
        );
        add_meta_box(
            'knowledgebase_breadcrumbs_field',
            esc_html__('Breadcrumbs', 'reference'),
            array( $this, 'referenceBreadcrumbsMetabox'),
            $post_type,
            'side',
            'low'
        );
    }
    /**
     * This method displays the Reference Table Of Content Metabox.
     *
     * @param object $post Contains data from the current post.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function referenceToCMenuMetabox($post)
    {
        $reference_menus = Helper::getNavMenu();

        // Make sure the form request comes from WordPress
        wp_nonce_field(
            basename(__FILE__),
            'knowledgebase_toc_menu_nonce'
        );

        $value = get_post_meta(
            $post->ID,
            '_knowledgebase_toc_menu_meta_key',
            true
        );

        ?>
        <label class="screen-reader-text" for="knowledgebase_toc_menu">
            <?php esc_html_e(
                'Select menu for knowledgebase',
                'reference'
            ); ?>
        </label>

        <select
            name="knowledgebase_toc_menu"
            id="knowledgebase_toc_menu"
            class="postbox"
        >

            <option value="">
                <?php esc_html_e(
                    '— None —',
                    'reference'
                ); ?>
            </option>

            <?php foreach ($reference_menus as $reference_menu) : ?>
                <option
                    value="
                        <?php
                            esc_attr_e(
                                $reference_menu->name
                            );
                        ?>
                   "
                    <?php selected(
                        $value,
                        $reference_menu->name
                    ); ?>
                >
                    <?php esc_html_e(
                        $reference_menu->name
                    ); ?>
                </option>
            <?php endforeach; ?>

        </select>

        <p class="howto">
            <?php esc_html_e(
                'Select menu for knowledgebase',
                'reference'
            ); ?>
        </p>

        <?php
    }
    /**
     * This method displays the Reference Comment Feedback Metabox.
     *
     * @param object $post Contains data from the current post.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function referenceCommentFeedbackMetabox($post)
    {

        $option = new Helper;
        $comment_feedback_option = Options::getCommentFeedback();
        $value = get_post_meta(
            $post->ID,
            '_knowledgebase_comment_feedback_meta_key',
            true
        );

        // Make sure the form request comes from WordPress
        wp_nonce_field(
            basename(__FILE__),
            'knowledgebase_comment_feedback_nonce'
        );

        if (empty($value)) {
            $value = $option->isOptionTrue($comment_feedback_option);
        }

        ?>
        <select name="knowledgebase_comment_feedback"
        id="knowledgebase_comment_feedback" class="postbox">

            <option
                value="enable"
                <?php selected(
                    $value,
                    'enable'
                ); ?>
            >
                <?php esc_html_e(
                    'Enable',
                    'reference'
                ); ?>
            </option>

            <option
                value="disable"
                <?php selected(
                    $value,
                    'disable'
                ); ?>
            >
                <?php esc_html_e(
                    'Disable',
                    'reference'
                ); ?>
            </option>

        </select>

        <p class="howto">
            <?php esc_html_e(
                'Enable or disable Comment Feedback',
                'reference'
            ); ?>
        </p>

        <?php
    }
    /**
     * This method displays the Reference Breadcrumbs Metabox.
     *
     * @param object $post Contains data from the current post.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function referenceBreadcrumbsMetabox($post)
    {

        $option = new Helper;
        $breadcrumbs_option = Options::getBreadcrumbs();
        $value = get_post_meta(
            $post->ID,
            '_knowledgebase_breadcrumbs_meta_key',
            true
        );

        // Make sure the form request comes from WordPress
        wp_nonce_field(
            basename(__FILE__),
            'knowledgebase_breadcrumbs_nonce'
        );

        if (empty($value)) {
            $value = $option->isOptionTrue($breadcrumbs_option);
        }

        ?>
        <select name="knowledgebase_breadcrumbs"
        id="knowledgebase_breadcrumbs" class="postbox">

            <option
                value="enable"
                <?php selected(
                    $value,
                    'enable'
                ); ?>
            >
                <?php esc_html_e(
                    'Enable',
                    'reference'
                ); ?>
            </option>

            <option
                value="disable"
                <?php selected(
                    $value,
                    'disable'
                ); ?>
            >
                <?php esc_html_e(
                    'Disable',
                    'reference'
                ); ?>
            </option>

        </select>

        <p class="howto">
            <?php esc_html_e(
                'Enable or disable Breadcrumbs',
                'reference'
            ); ?>
        </p>

        <?php
    }
    /**
     * This method verify if nonce is valid then updates a post_meta.
     *
     * @param integer $post_id Contains ID of the current post.
     *
     * @since  1.0.0
     * @access public
     * @return boolean false Returns false if nonce is not valid.
     */
    public function referenceSavePostdata($post_id)
    {
        $sanitized_knowledgebase_toc_menu_nonce = filter_input(
            INPUT_POST,
            'knowledgebase_toc_menu_nonce',
            FILTER_SANITIZE_STRING
        );
        $sanitized_knowledgebase_toc_menu = filter_input(
            INPUT_POST,
            'knowledgebase_toc_menu',
            FILTER_SANITIZE_STRING
        );
        $is_valid_toc_menu_nonce = self::isNonceValid(
            $sanitized_knowledgebase_toc_menu_nonce
        );

        $sanitized_knowledgebase_comment_feedback_nonce = filter_input(
            INPUT_POST,
            'knowledgebase_comment_feedback_nonce',
            FILTER_SANITIZE_STRING
        );
        $sanitized_knowledgebase_comment_feedback = filter_input(
            INPUT_POST,
            'knowledgebase_comment_feedback',
            FILTER_SANITIZE_STRING
        );
        $is_valid_comment_feedback_nonce = self::isNonceValid(
            $sanitized_knowledgebase_comment_feedback_nonce
        );

        $sanitized_knowledgebase_breadcrumbs_nonce = filter_input(
            INPUT_POST,
            'knowledgebase_breadcrumbs_nonce',
            FILTER_SANITIZE_STRING
        );
        $sanitized_knowledgebase_breadcrumbs = filter_input(
            INPUT_POST,
            'knowledgebase_breadcrumbs',
            FILTER_SANITIZE_STRING
        );
        $is_valid_breadcrumbs_nonce = self::isNonceValid(
            $sanitized_knowledgebase_breadcrumbs_nonce
        );

        // verify taxonomies meta box nonce
        if (false === $is_valid_toc_menu_nonce) {
            return;
        }
        if (array_key_exists('knowledgebase_toc_menu', $_POST)) {
            update_post_meta(
                $post_id,
                '_knowledgebase_toc_menu_meta_key',
                $sanitized_knowledgebase_toc_menu
            );
        }

        if (false === $is_valid_comment_feedback_nonce) {
            return;
        }
        if (array_key_exists('knowledgebase_comment_feedback', $_POST)) {
            update_post_meta(
                $post_id,
                '_knowledgebase_comment_feedback_meta_key',
                $sanitized_knowledgebase_comment_feedback
            );
        }

        if (false === $is_valid_breadcrumbs_nonce) {
            return;
        }
        if (array_key_exists('knowledgebase_breadcrumbs', $_POST)) {
            update_post_meta(
                $post_id,
                '_knowledgebase_breadcrumbs_meta_key',
                $sanitized_knowledgebase_breadcrumbs
            );
        }
        return;
    }
    /**
     * This method verify if nonce is valid.
     *
     * @param mixed $nonce the name of a metabox nonce.
     *
     * @since  1.0.0
     * @access public
     * @return boolean true Returns true if nonce is valid.
     */
    public function isNonceValid($nonce)
    {
        if (!isset($nonce) || !wp_verify_nonce($nonce, basename(__FILE__))) {
            return;
        }
        return true;
    }
}
