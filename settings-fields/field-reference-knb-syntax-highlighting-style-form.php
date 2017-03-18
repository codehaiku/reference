<?php
/**
 * This file is part of the Reference WordPress Knowledgebase Plugin Package.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Reference
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
/**
 * Callback function for 'reference_knb_archive_column' setting
 *
 * @return void
 */
function reference_knb_syntax_highlighting_style_form() {

    $styles = reference_highlighting_style();

    echo '<select name="reference_knb_syntax_highlighting_style" class="reference_select" id="reference_knb_syntax_highlighting_style">';
        foreach ($styles as $style) {
            echo '<option value="' . $style . '" ' . selected( esc_attr( get_option( 'reference_knb_syntax_highlighting_style' ) ), $style) . '>' . ucfirst($style) . '</option>';
        }
    echo '</select>';

    esc_html_e('Select the highlightning style for displayed codes.', 'reference');

    echo '<p class="description">' . esc_html__('This option allows you to change the style for displaying your codes your [reference_highlighter] shortcode.', 'reference') . ' </p>';

	return;
}
