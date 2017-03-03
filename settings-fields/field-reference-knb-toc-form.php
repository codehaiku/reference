<?php
/**
 * This file is part of the Reference WordPress Knowledgebase Plugin Package.
 *
 * (c) Joseph Gabito <joseph@useissuestabinstead.com>
 * (c) Jasper Jardin <jasper@useissuestabinstead.com>
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
 * Callback function for 'reference_knb_toc' setting
 *
 * @return void
 */
function reference_knb_toc_form() {

    echo '<label for="reference_knb_toc">';
        echo '<input name="reference_knb_toc" id="reference_knb_toc" type="checkbox" class="regular-text code" value="1" ' . checked( 1, intval( esc_attr( get_option( 'reference_knb_toc' ) ) ), false ) . '>';
        esc_html_e('Enable Table of Contents', 'reference');
    echo '</label>';

    echo '<p class="description">' . esc_html__('This option allows you to enable the Table of Contents for your knowledgebase pages.', 'reference') . ' </p>';

	return;
}
