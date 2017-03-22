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

final class Metabox
{

    /**
     * Reference metabox class constructor
     */
    public function __construct()
    {
        add_action('add_meta_boxes', array( $this, 'referenceAddCustomBox'));
        add_action('save_post', array( $this, 'referenceSavePostdata'));
	}

    /**
     * Add meta box
     *
     * @param post $post The post object
     * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
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
            array( $this, 'referenceFeedbackMetabox'),
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

    public function referenceToCMenuMetabox($post)
    {
        $reference_menus = Helper::get_nav_menu();

        // Make sure the form request comes from WordPress
        wp_nonce_field( basename( __FILE__ ), 'knowledgebase_toc_menu_nonce' );

        $value = get_post_meta($post->ID, '_knowledgebase_toc_menu_meta_key', true);

        ?>
        <label class="screen-reader-text" for="knowledgebase_toc_menu"><?php esc_html_e('Select menu for knowledgebase', 'reference'); ?></label>

        <select name="knowledgebase_toc_menu" id="knowledgebase_toc_menu" class="postbox">

            <option value=""><?php esc_html_e('— None —', 'reference'); ?></option>

            <?php foreach ($reference_menus as $reference_menu): ?>
                <option value="<?php esc_attr_e($reference_menu->name); ?>" <?php selected($value, $reference_menu->name); ?>><?php esc_html_e($reference_menu->name); ?></option>
            <?php endforeach; ?>

        </select>

        <p class="howto"><?php esc_html_e('Select menu for knowledgebase', 'reference'); ?></p>

        <?php

    }
    public function referenceFeedbackMetabox($post)
    {

        $option = new Helper;
        $value = get_post_meta($post->ID, '_knowledgebase_comment_feedback_meta_key', true);

        // Make sure the form request comes from WordPress
        wp_nonce_field( basename( __FILE__ ), 'knowledgebase_comment_feedback_nonce' );

        if (empty($value)) {
            $value = $option->isOptionTrue(get_option('reference_knb_comment_feedback'));
        }

        ?>
        <select name="knowledgebase_comment_feedback" id="knowledgebase_comment_feedback" class="postbox">

            <option value="enable" <?php selected($value, 'enable'); ?>><?php esc_html_e('Enable', 'reference'); ?></option>
            <option value="disable" <?php selected($value, 'disable'); ?>><?php esc_html_e('Disable', 'reference'); ?></option>

        </select>

        <p class="howto"><?php esc_html_e('Enable or disable Comment Feedback', 'reference'); ?></p>

        <?php

    }
    public function referenceBreadcrumbsMetabox($post)
    {

        $option = new Helper;
        $value = get_post_meta($post->ID, '_knowledgebase_breadcrumbs_meta_key', true);

        // Make sure the form request comes from WordPress
        wp_nonce_field( basename( __FILE__ ), 'knowledgebase_breadcrumbs_nonce' );

        if (empty($value)) {
            $value = $option->isOptionTrue(get_option('reference_knb_breadcrumbs'));
        }

        ?>
        <select name="knowledgebase_breadcrumbs" id="knowledgebase_breadcrumbs" class="postbox">

            <option value="enable" <?php selected($value, 'enable'); ?>><?php esc_html_e('Enable', 'reference'); ?></option>
            <option value="disable" <?php selected($value, 'disable'); ?>><?php esc_html_e('Disable', 'reference'); ?></option>

        </select>

        <p class="howto"><?php esc_html_e('Enable or disable Breadcrumbs', 'reference'); ?></p>

        <?php

    }

    public function referenceSavePostdata($post_id)
    {
        $sanitized_knowledgebase_toc_menu_nonce = filter_input(INPUT_POST, 'knowledgebase_toc_menu_nonce', FILTER_SANITIZE_STRING);
        $sanitized_knowledgebase_toc_menu = filter_input(INPUT_POST, 'knowledgebase_toc_menu', FILTER_SANITIZE_STRING);

        $sanitized_knowledgebase_comment_feedback_nonce = filter_input(INPUT_POST, 'knowledgebase_comment_feedback_nonce', FILTER_SANITIZE_STRING);
        $sanitized_knowledgebase_comment_feedback = filter_input(INPUT_POST, 'knowledgebase_comment_feedback', FILTER_SANITIZE_STRING);

        $sanitized_knowledgebase_breadcrumbs_nonce = filter_input(INPUT_POST, 'knowledgebase_breadcrumbs_nonce', FILTER_SANITIZE_STRING);
        $sanitized_knowledgebase_breadcrumbs = filter_input(INPUT_POST, 'knowledgebase_breadcrumbs', FILTER_SANITIZE_STRING);

        // verify taxonomies meta box nonce
    	if ( !isset( $sanitized_knowledgebase_toc_menu_nonce ) || !wp_verify_nonce( $sanitized_knowledgebase_toc_menu_nonce, basename( __FILE__ ) ) ){
    		return;
    	}
        if (array_key_exists('knowledgebase_toc_menu', $_POST)) {
            update_post_meta($post_id, '_knowledgebase_toc_menu_meta_key', $sanitized_knowledgebase_toc_menu);
        }

    	if ( !isset( $sanitized_knowledgebase_comment_feedback_nonce ) || !wp_verify_nonce( $sanitized_knowledgebase_comment_feedback_nonce, basename( __FILE__ ) ) ){
    		return;
    	}
        if (array_key_exists('knowledgebase_comment_feedback', $_POST)) {
            update_post_meta($post_id, '_knowledgebase_comment_feedback_meta_key', $sanitized_knowledgebase_comment_feedback);
        }

    	if ( !isset( $sanitized_knowledgebase_breadcrumbs_nonce ) || !wp_verify_nonce( $sanitized_knowledgebase_breadcrumbs_nonce, basename( __FILE__ ) ) ){
    		return;
    	}
        if (array_key_exists('knowledgebase_breadcrumbs', $_POST)) {
            update_post_meta($post_id, '_knowledgebase_breadcrumbs_meta_key', $sanitized_knowledgebase_breadcrumbs);
        }
    }
}
