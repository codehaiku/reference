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
        add_action('add_meta_boxes', array( $this, 'knowledgebase_add_custom_box'));
        add_action('save_post', array( $this, 'knowledgebase_save_postdata'));
	}

    /**
     * Add meta box
     *
     * @param post $post The post object
     * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
     */
    public function knowledgebase_add_custom_box()
    {
        $post_type = 'knowledgebase';

        add_meta_box(
            'knowledgebase_menu',
            esc_html__('Table of Content Menu', 'reference'),
            array( $this, 'knowledgebase_toc_menu_metabox_panel'),
            $post_type,
            'side',
            'low'
        );
    }

    public function knowledgebase_toc_menu_metabox_panel($post)
    {
        $reference_menus = \DSC\Reference\Helper::get_nav_menu();

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

    public function knowledgebase_save_postdata($post_id)
    {
        $sanitized_knowledgebase_toc_menu_nonce = filter_input(INPUT_POST, 'knowledgebase_toc_menu_nonce', FILTER_SANITIZE_STRING);
        $sanitized_knowledgebase_toc_menu = filter_input(INPUT_POST, 'knowledgebase_toc_menu', FILTER_SANITIZE_STRING);

        // verify taxonomies meta box nonce
    	if ( !isset( $sanitized_knowledgebase_toc_menu_nonce ) || !wp_verify_nonce( $sanitized_knowledgebase_toc_menu_nonce, basename( __FILE__ ) ) ){
    		return;
    	}

        if (array_key_exists('knowledgebase_toc_menu', $_POST)) {
            update_post_meta($post_id, '_knowledgebase_toc_menu_meta_key', $sanitized_knowledgebase_toc_menu);
        }
    }
}
